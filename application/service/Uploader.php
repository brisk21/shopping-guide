<?php


namespace app\service;


use app\common\controller\AppCommon;
use OSS\Core\OssException;
use OSS\OssClient;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class Uploader
{
    /**
     * 执行上传
     * @param $fileKey :上传的文件的key
     * @param string $toPath :保存的路径，如/var/www/upload/
     * @param string $returnUrl :返回的链接资源地址,如http://abc.com/upload/
     * @param string $fileName 文件的名称
     * @param int $userType 操作用户类型，1-后台，2-用户
     * @return array
     */
    public static function start_upload($fileKey, $toPath = '', $returnUrl = '', $fileName = '', $userType = 1)
    {
        $conf = ConfigService::get('web');
        if (empty($conf['upload_type'])) {
            //没有在后台配置就默认用配置文件的
            $conf = config('upload');
            if (empty($conf['method'])) {
                return ['code' => -1, 'msg' => '未配置上传'];
            }
            $upload_type = $conf['method'];
        } else {
            $upload_type = $conf['upload_type'];
            $conf['fileSizeLimit'] = $conf['upload_fileSizeLimit'];
            $conf['enable_type'] = array_filter(array_unique(explode(',', $conf['upload_enable_type'])));
            $conf['defaultPath'] = 'bs_shop/';
        }
        if (!isset($_FILES[$fileKey])) {
            return ['code' => -1, 'msg' => '文件未选择'];
        }
        $files = $_FILES[$fileKey];

        $extArray = explode('.', $files['name']);
        //获取扩展名后缀
        $fileExt = $extArray[count($extArray) - 1];
        if (!in_array(strtolower($fileExt), $conf['enable_type'])) {
            return ['code' => -1, 'msg' => '上传的文件类型不支持'];
        }
        if (!$fileName) {
            $fileName = md5(time() . rand(1, 9999999)) . '.' . $fileExt;
        }
        if ((!is_dir($toPath) && !@mkdir($toPath, 0777, true)) || !is_writable($toPath)) {
            return ['code' => 500, 'msg' => '上传目录无权操作'];
        }
        if (is_file($toPath . $fileName) && !is_writeable($toPath . $fileName)) {
            return ['code' => 500, 'msg' => '文件替换失败'];
        }
        if ($files['error'] <> 0 || $files['size'] <= 0 || $files['size'] > $conf['fileSizeLimit']) {
            return ['code' => -1, 'msg' => '文件过大'];
        }
        //todo 优化
        if (!is_uploaded_file($files['tmp_name'])) {
            return ['code' => 500, 'msg' => '临时文件上传失败'];
        }


        if ($upload_type == 'local') {
            if (empty($toPath)) {
                $toPath = $conf['defaultPath'];
            }
            if (move_uploaded_file($files['tmp_name'], $toPath . $fileName)) {
                //成功,返回完整的图片地址
                self::add_log([
                    'name' => $files['name'],
                    'size' => $files['size'],
                    'type' => $files['type'],
                    'upload_type' => 'local',
                    'path' => str_replace(PUBLIC_PATH, '', $toPath . $fileName),
                    'userType' => $userType
                ]);
                return ['code' => 0, 'msg' => '上传成功', 'data' => $returnUrl . $fileName, 'location' => $returnUrl . $fileName];
            }
            return ['code' => 500, 'msg' => '移动到指定路径失败'];

        } elseif ($upload_type == 'qiniu') {
            $toPath = stripos($toPath, 'bs_shop') !== false ? trim($toPath, '/') . '/' . $fileName : ('bs_shop/' . ltrim($toPath, '/') . '/' . $fileName);

            $toPath = str_replace([PUBLIC_PATH, '//'], '', $toPath);


            $res = self::qiniu_upload($files['tmp_name'], $toPath);
            if (empty($res['url'])) {
                return $res;
            }
            //成功,返回完整的图片地址
            self::add_log([
                'name' => $files['name'],
                'size' => $files['size'],
                'type' => $files['type'],
                'upload_type' => 'qiniu',
                'path' => $toPath,
                'userType' => $userType
            ]);
            return ['code' => 0, 'msg' => '上传成功', 'data' => $res['url'] . '?v=' . time(), 'location' => $res['url'] . '?v=' . time()];

        } elseif ($upload_type == 'oss') {
            $toPath = stripos($toPath, 'bs_shop') !== false ? trim($toPath, '/') . '/' . $fileName : ('bs_shop/' . ltrim($toPath, '/') . '/' . $fileName);
            $toPath = str_replace([PUBLIC_PATH, '//'], '', $toPath);
            $res = self::oss_upload($files['tmp_name'], $toPath);
            if (empty($res['url'])) {
                return $res;
            }
            //成功,返回完整的图片地址
            self::add_log([
                'name' => $files['name'],
                'size' => $files['size'],
                'type' => $files['type'],
                'upload_type' => 'oss',
                'path' => $toPath,
                'userType' => $userType
            ]);
            return ['code' => 0, 'msg' => '上传成功', 'data' => $res['url'] . '?v=' . time(), 'location' => $res['url'] . '?v=' . time()];

        } else {
            return ['code' => 500, 'msg' => '未配置其他上传方式'];
        }

    }


    public static function qiniu_upload($file, $toPath)
    {
        $config = ConfigService::get('upload');
        if (empty($config['qiniu'])) {
            return ['code' => -1, 'msg' => '七牛云上传未配置'];
        }
        $accessKey = $config['qiniu']['accessKey'];
        $secretKey = $config['qiniu']['secretKey'];
        $bucket = $config['qiniu']['bucket'];
        $domain = trim($config['qiniu']['domain'], '/') . '/';

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传 Token
        $returnBody = '{"key":"$(key)","hash":"$(etag)","fsize":$(fsize),"bucket":"$(bucket)","name":"$(x:name)"}';
        $policy = array(
            'returnBody' => $returnBody
        );
        $key = str_replace('//', '/', $toPath);
        //$token = $auth->uploadToken($bucket);
        //同名要覆盖旧文件
        $token = $auth->uploadToken($bucket, $key, 3600, $policy, true);

        // 要上传文件的本地路径
        //$filePath = './php-logo.png';
        $filePath = $file;

        // 上传到七牛后保存的文件名
        //$key = 'my-php-logo.png';


        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。

        list($ret, $error) = $uploadMgr->putFile($token, $key, $filePath);
        if (empty($ret['fsize'])) {
            return ['code' => -1, 'msg' => '上传失败:' . $error];
        }

        return ['code' => 0, 'msg' => 'ok', 'url' => $domain . $ret['key'], 'path' => $ret['key'], 'size' => $ret['fsize']];


    }

    /**
     * 阿里云oss
     * @return array
     */
    public static function oss_upload($file, $toPath)
    {
        $config = ConfigService::get('upload');
        if (empty($config['oss'])) {
            return ['code' => -1, 'msg' => 'OSS上传未配置'];
        }
        $accessKeyId = $config['oss']['accessKeyId'];
        $accessKeySecret = $config['oss']['accessKeySecret'];
        $endpoint = $config['oss']['endpoint'];
        $domain = trim($config['oss']['domain'], '/') . '/';
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        } catch (OssException $e) {
            return ['code' => -1, 'msg' => '上传失败:' . $e->getMessage()];
        }

        $bucket = $config['oss']['bucket'];
        // 上传文件到OSS时需要指定包含文件后缀在内的完整路径，例如abc/efg/123.jpg,存在时会替换
        $object = str_replace('//', '/', $toPath);

        $content = file_get_contents($file);


        try {
            $res = $ossClient->putObject($bucket, $object, $content);
        } catch (OssException $e) {
            return ['code' => -1, 'msg' => '上传失败:' . $e->getMessage()];
        }
        if (empty($res['info']['url'])) {
            return ['code' => -1, 'msg' => '上传失败'];
        }
        return ['code' => 0, 'msg' => 'ok', 'url' => $domain . $object, 'path' => $object, 'size' => $res['info']['size_upload']];
    }

    //添加上传记录
    public static function add_log($arg = [])
    {
        if (empty($arg['upload_type'])) {
            return false;
        }
        $data = [
            'name' => !empty($arg['name']) ? trim($arg['name']) : '未知',
            'size' => !empty($arg['size']) ? intval($arg['size']) : '0',
            'type' => !empty($arg['type']) ? trim($arg['type']) : '未知',
            'path' => !empty($arg['path']) ? trim($arg['path']) : '',
            'upload_type' => !empty($arg['upload_type']) ? trim($arg['upload_type']) : '',
            'add_time' => time(),
            'user_type' => $arg['userType'],
        ];
        return AppCommon::data_add('upload_files_log', $data);
    }
}