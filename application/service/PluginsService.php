<?php
/**
 * @email wei@alipay168.cn
 * @author 小韦
 * @link http://blog.alipay168.cn
 * @Date: 2020/3/15 21:14
 */

namespace app\service;


use app\common\controller\AppCommon;
use base\FileUtil;
use think\Db;


class PluginsService
{
    private static $config_json = [];

    private static $tags = [];

    /**
     * 获取所有插件列表
     * @param array $tags 过滤需要查询的应用标识
     * @return array
     */
    public static function get_all_plugin_list($tags = [])
    {
        if ($tags){
            self::$tags = $tags;
        }
        self::getConfigFiles(APP_PATH . 'plugin/controller', 'config.json');
        return self::$config_json;
    }

    /**
     * 获取插件数据
     * @param $params
     * @return array
     */
    public static function get_plugin_data($params)
    {
        $has = AppCommon::data_get('plugins', ['plugin_tag' => $params['plugin_tag']], '*');
        if (!$has) {
            return data_return_arr('应用未安装或已卸载', -1);
        }
        if (empty($has['plugin_data'])) {
            $has['plugin_data'] = [];
        } else {
            $has['plugin_data'] = json_decode($has['plugin_data'], true);
        }
        return data_return_arr('ok', 0, $has);
    }


    /**
     * 查找所有的插件配置
     * @param $dir string 插件目录
     * @param $fileName string 配置文件名称，如config.json
     * @return array
     */
    private static function getConfigFiles($dir, $fileName)
    {
        $dir = rtrim($dir, '/');//先移除
        $scans = scandir($dir);

        if (!empty($scans)) {
            foreach ($scans as $plugin_tag) {
                if ($plugin_tag == ".." || $plugin_tag == ".") {
                    continue;
                }
                if (!empty(self::$tags) && !in_array($plugin_tag,self::$tags)){
                    continue;
                }
                if (file_exists($dir . '/' . $plugin_tag . '/' . $fileName)) {
                    self::$config_json[] = json_decode(file_get_contents($dir . '/' . $plugin_tag . '/' . $fileName), true);
                }

            }
        }
        return self::$config_json;
    }

    /**
     * 获取所有一级目录(插件标识)
     * @param $dir
     * @return array
     */
    public static function get_all_plugin_tags($dir)
    {
        $tags = [];
        $dir = rtrim($dir, '/');//先移除
        $scans = scandir($dir);

        if (!empty($scans)) {
            foreach ($scans as $plugin_tag) {
                if ($plugin_tag == ".." || $plugin_tag == ".") {
                    continue;
                }
                $tags[] = $plugin_tag;
            }
        }
        return $tags;
    }


    /**
     * 多级目录压缩
     * @param $openFile string 打开的目录
     * @param $zipObj object 实例化ZipArchive对象
     * @param $sourcePath string 源目录路径,绝对路径，如/user/bing/xxxx/
     * @param string $newRelat 相对目录的路径名称,如 image
     * @param string|array $whiteList 需要过滤的路径，如/xxx/data/log
     */
    public static function createZip($openFile, $zipObj, $sourcePath, $newRelat = '', $whiteList = '')
    {
        if ($whiteList) {
            if (!is_array($whiteList)) {
                $whiteList = [$whiteList];
            }
        }
        while (($file = readdir($openFile)) != false) {
            if ($file == "." || $file == "..") {
                continue;
            }

            //过滤特殊后缀
            $ext = strtolower(substr($file, strrpos($file, '.') + 1));
            if (in_array($ext, ['log', 'pid'])) {
                continue;
            }
            /*源目录路径(绝对路径)*/
            $sourceTemp = str_replace("\\", '/', $sourcePath . '/' . $file);

            //过滤白名单
            if ($whiteList) {
                $jump = false;
                foreach ($whiteList as $w) {
                    $w = str_replace("\\", '/', $w);
                    if (stripos($sourceTemp, $w) !== false) {
                        $jump = true;
                        break;
                    }
                }
                if ($jump) {
                    continue;
                }
            }

            /*目标目录路径(相对路径)*/
            $newTemp = $newRelat == '' ? $file : $newRelat . '/' . $file;
            if (is_dir($sourceTemp)) {
                $zipObj->addEmptyDir($newTemp);/*这里注意：php只需传递一个文件夹名称路径即可*/
                self::createZip(opendir($sourceTemp), $zipObj, $sourceTemp, $newTemp, $whiteList);
            }
            if (is_file($sourceTemp)) {
                $zipObj->addFile($sourceTemp, $newTemp);
            }
        }
    }

    /**
     * 完全移除应用文件
     * @param $params
     * @return array
     */
    public static function action_delete_app($params)
    {
        //清理数据库安装记录
        AppCommon::data_del('plugins', ['plugin_tag' => $params['plugin_tag']]);
        //检查系统
        $sys_tag = self::action_system_plugin($params['plugin_tag'], 'del');
        if (isset($sys_tag['code'])) {
            return $sys_tag;
        }

        //基本的文件路径
        $controller_path = APP_PATH . 'plugin/controller/';
        $view_path = APP_PATH . 'plugin/view/';
        $static_path = PUBLIC_PATH . 'static/plugins/';
        if (!is_writeable($controller_path) || !is_writeable($view_path) || !is_writeable($static_path)) {
            return data_return_arr('应用相关目录必须设置可写:' . $controller_path . ';' . $view_path . ';' . $static_path, -1);
        }
        if (!is_dir($controller_path . $params['plugin_tag'])) {
            return data_return_arr('应用不存在', -1);
        }
        //先批量给予777权限
        $c = self::list_dir($controller_path . $params['plugin_tag']);
        $v = self::list_dir($controller_path . $params['plugin_tag']);
        $s = self::list_dir($controller_path . $params['plugin_tag']);
        $list = array_merge($c, $v, $s);
        if ($list) {
            foreach ($list as $file) {
                if (is_file($file)) {
                    @chmod($file, 0777);
                }
            }
        }

        //依次移除controller文件、view、static目录的文件
        delete_dir_file($controller_path . $params['plugin_tag']);
        delete_dir_file($view_path . $params['plugin_tag']);
        delete_dir_file($static_path . $params['plugin_tag']);
        return data_return_arr();
    }

    /**
     * 管理系统的插件安装情况，当用户安装时检测是否被系统安装，若没有则系统安装，如有则无需进行系统安装，无需改变tags行为
     * @param $tag string 应用标识
     * @param $type string 操作列表
     * @return bool|array
     */
    private static function action_system_plugin($tag, $type = 'add')
    {
        $sys_tags_file = CONF_PATH . 'system_tags.php';
        //查询当前插件还在使用的用户数目
        $using_count = AppCommon::data_count('plugins', ['plugin_tag' => $tag, 'disable' => 0]);
        if ($using_count > 0) {
            if ($type == 'del') {
                return true;//不用操作
            } else {
                //安装、启用的情况
                if (file_exists($sys_tags_file)) {
                    if (!is_writeable($sys_tags_file)) {
                        return data_return_arr($sys_tags_file . '未设置可写权限', -1);
                    }
                    $sys_tags = include($sys_tags_file);
                    if (!empty($sys_tags)) {
                        if (key_exists($tag, $sys_tags)) {
                            return true;
                        } else {
                            $sys_tags[] = $tag;//增加一个插件
                            file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                            //真正的控制
                            $setTag = self::action_plugin_tags($tag, $type);
                            if (isset($setTag['code'])) {
                                return $setTag;
                            }
                            return true;
                        }
                    } else {
                        $sys_tags = [$tag];
                        file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                        //真正的控制
                        $setTag = self::action_plugin_tags($tag, $type);
                        if (isset($setTag['code'])) {
                            return $setTag;
                        }
                        return true;
                    }
                } else {
                    if (!is_writeable(CONF_PATH)) {
                        return data_return_arr(CONF_PATH . '未设置可写权限', -1);
                    }
                    $sys_tags = [$tag];
                    file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                    //真正的控制
                    $setTag = self::action_plugin_tags($tag, $type);
                    if (isset($setTag['code'])) {
                        return $setTag;
                    }
                    return true;
                }
            }
        } else {
            //如果无人用，则必须执行行为操作
            $setTag = self::action_plugin_tags($tag, $type);
            if (isset($setTag['code'])) {
                return $tag;
            }
            if (file_exists($sys_tags_file)) {
                if (!is_writeable($sys_tags_file)) {
                    return data_return_arr($sys_tags_file . '未设置可写权限', -1);
                }
                $sys_tags = include($sys_tags_file);
                if (empty($sys_tags)) {
                    if ($type == 'del') {
                        return true;
                    } else {
                        $sys_tags = [$tag];
                        return file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                    }
                } else {
                    if (in_array($tag, $sys_tags)) {

                        if ($type == 'add') {
                            return true;
                        } else {
                            //先移除后重写文件
                            $key = array_search($tag, $sys_tags);
                            unset($sys_tags[$key]);

                            return file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                        }
                    } else {
                        if ($type == 'del') {
                            //先移除后重写文件
                            $key = array_search($tag, $sys_tags);
                            unset($sys_tags[$key]);
                            return file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                        } else {
                            $sys_tags[] = $tag;
                            return file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                        }
                    }
                }
            } else {
                if ($type == 'del') {
                    return true;
                } else {
                    if (!is_writeable(CONF_PATH)) {
                        return data_return_arr(CONF_PATH . '未设置可写权限', -1);
                    }
                    $sys_tags = [$tag];
                    return file_put_contents($sys_tags_file, "<?php \n return " . var_export(array_unique($sys_tags), true) . ";\n?>");
                }
            }
        }

    }

    /**
     * 解压应用
     * @param $params
     * @return array
     */
    public static function action_unpack($params)
    {
        if (empty($params['app'])) {
            return data_return_arr('app应用未选择', -1);
        }
        $toPath = TEMP_PATH . '/unpack_app/';
        if (!is_dir($toPath)) {
            if (!@mkdir($toPath, 0777, true)) {
                return data_return_arr('请给予' . $toPath . '目录写入权限', -1);
            }
        };
        if (!move_uploaded_file($params['app']['tmp_name'], $toPath . 'app.zip')) {
            return data_return_arr('上传失败', -1);
        }
        //基本的文件路径
        $controller_path = APP_PATH . 'plugin/controller/';
        $view_path = APP_PATH . 'plugin/view/';
        $static_path = PUBLIC_PATH . 'static/plugins/';

        $zip = new \ZipArchive();

        //打开zip文件
        $res = $zip->open($toPath . 'app.zip');

        if ($res) {
            // 解压缩文件到指定目录
            $zip->extractTo($toPath);
            $zip->close();

            if (!file_exists($toPath . 'bs_controller/config.json')) {
                return data_return_arr('非合法应用', -1);
            }
            $configStr = file_get_contents($toPath . 'bs_controller/config.json');
            if (empty($configStr)) {
                return data_return_arr('配置文件丢失', -1);
            }
            $config = json_decode($configStr, true);

            //必须的基本信息配置
            $info_keys = [
                'plugin_tag', 'name', 'logo', 'author_url', 'version',
                'desc', 'contact',
            ];
            if (!isset($config['info'])) {
                delete_dir_file($toPath);
                return data_return_arr('应用配置不合法', -1);
            }
            $gkey = array_keys($config['info']);
            foreach ($info_keys as $v) {
                if (!in_array($v, $gkey)) {
                    delete_dir_file($toPath);
                    return data_return_arr('非完整可用配置', -1);
                }
            }

            $app_name = $config['info']['plugin_tag'];

            if (empty($app_name)) {
                delete_dir_file($toPath);
                return data_return_arr('安装包错误', -1);
            }
            $app_controller_path = $controller_path . trim($app_name) . '/';
            $app_view_path = $view_path . trim($app_name) . '/';
            $app_static_path = $static_path . trim($app_name) . '/';

            if (is_dir($app_controller_path)) {
                delete_dir_file($toPath);//删除解压目录和文件
                return data_return_arr('应用已存在', -1, $app_controller_path);
            }
            if (is_dir($app_view_path)) {
                delete_dir_file($toPath);//删除解压目录和文件
                return data_return_arr('视图目录已存在', -1);
            }
            if (is_dir($app_static_path)) {
                delete_dir_file($toPath);//删除解压目录和文件
                return data_return_arr('静态资源目录已存在', -1);
            }

            $controller = self::list_dir($toPath . 'bs_controller/');
            if ($controller) {
                //创建应用目录
                $mk = @mkdir($app_controller_path, 0777, true);
                if (!$mk) {
                    delete_dir_file($toPath);//删除解压目录和文件
                    return data_return_arr('请给予应用目录' . $app_controller_path . '写权限', -1);
                }
                FileUtil::moveDir($toPath . 'bs_controller/', $app_controller_path);
                $view = self::list_dir($toPath . 'bs_view/');
                if ($view) {
                    $mk = @mkdir($app_view_path, 0777, true);
                    if (!$mk) {
                        delete_dir_file($toPath);//删除解压目录和文件
                        return data_return_arr('请给予应用目录' . $app_view_path . '写权限', -1);
                    }
                    FileUtil::moveDir($toPath . 'bs_view/', $app_view_path);
                }
                $static = self::list_dir($toPath . 'bs_static/');
                if ($static) {
                    $mk = @mkdir($app_static_path, 0777, true);
                    if (!$mk) {
                        delete_dir_file($toPath);//删除解压目录和文件
                        return data_return_arr('请给予应用目录' . $app_static_path . '写权限', -1);
                    }
                    FileUtil::moveDir($toPath . 'bs_static/', $app_static_path);
                }
            }
            delete_dir_file($toPath);//删除解压目录和文件
            //自动保存到数据库
            self::action_install(['plugin_tag' => $app_name]);
        }
        return data_return_arr();
    }

    /**
     * 更新应用
     * @param $params
     * @return array
     */
    public static function action_update_app($params)
    {
        if (empty($params['app'])) {
            return data_return_arr('app应用未选择', -1);
        }
        $toPath = TEMP_PATH . '/unpack_app/';
        if (!is_dir($toPath)) {
            if (!@mkdir($toPath, 0777, true)) {
                return data_return_arr('请给予' . $toPath . '目录写入权限', -1);
            }
        };
        if (!move_uploaded_file($params['app']['tmp_name'], $toPath . 'app.zip')) {
            return data_return_arr('上传失败', -1);
        }
        //基本的文件路径
        $controller_path = APP_PATH . 'plugin/controller/';
        $view_path = APP_PATH . 'plugin/view/';
        $static_path = PUBLIC_PATH . 'static/plugins/';

        $zip = new \ZipArchive();

        //打开zip文件
        $res = $zip->open($toPath . 'app.zip');

        if ($res) {
            // 解压缩文件到指定目录
            $zip->extractTo($toPath);
            $zip->close();

            if (!file_exists($toPath . 'bs_controller/config.json')) {
                return data_return_arr('非合法应用', -1);
            }
            $configStr = file_get_contents($toPath . 'bs_controller/config.json');
            if (empty($configStr)) {
                return data_return_arr('配置文件丢失', -1);
            }
            $config = json_decode($configStr, true);

            //必须的基本信息配置
            $info_keys = [
                'plugin_tag', 'name', 'logo', 'author_url', 'version',
                'desc', 'contact',
            ];
            if (!isset($config['info'])) {
                delete_dir_file($toPath);
                return data_return_arr('应用配置不合法', -1);
            }
            $gkey = array_keys($config['info']);
            foreach ($info_keys as $v) {
                if (!in_array($v, $gkey)) {
                    delete_dir_file($toPath);
                    return data_return_arr('非完整可用配置', -1);
                }
            }

            $app_name = $config['info']['plugin_tag'];

            if (empty($app_name)) {
                delete_dir_file($toPath);
                return data_return_arr('安装包错误', -1);
            }
            $app_controller_path = $controller_path . trim($app_name) . '/';
            $app_view_path = $view_path . trim($app_name) . '/';
            $app_static_path = $static_path . trim($app_name) . '/';

            //删除已有的
            if (is_dir($app_controller_path)) {
                delete_dir_file($app_controller_path);
                //return data_return_arr('应用已存在', -1, $app_controller_path);
            } else {
                return data_return_arr('应用不存在，请使用上传功能，而不是更新', -1);
            }
            if (is_dir($app_view_path)) {
                delete_dir_file($app_view_path);//删除解压目录和文件
                // return data_return_arr('视图目录已存在', -1);
            }
            if (is_dir($app_static_path)) {
                delete_dir_file($app_static_path);//删除解压目录和文件
                //return data_return_arr('静态资源目录已存在', -1);
            }

            $controller = self::list_dir($toPath . 'bs_controller/');
            if ($controller) {
                //创建应用目录
                $mk = @mkdir($app_controller_path, 0777, true);
                if (!$mk) {
                    delete_dir_file($toPath);//删除解压目录和文件
                    return data_return_arr('请给予应用目录' . $app_controller_path . '写权限', -1);
                }
                FileUtil::moveDir($toPath . 'bs_controller/', $app_controller_path);
                $view = self::list_dir($toPath . 'bs_view/');
                if ($view) {
                    $mk = @mkdir($app_view_path, 0777, true);
                    if (!$mk) {
                        delete_dir_file($toPath);//删除解压目录和文件
                        return data_return_arr('请给予应用目录' . $app_view_path . '写权限', -1);
                    }
                    FileUtil::moveDir($toPath . 'bs_view/', $app_view_path);
                }
                $static = self::list_dir($toPath . 'bs_static/');
                if ($static) {
                    $mk = @mkdir($app_static_path, 0777, true);
                    if (!$mk) {
                        delete_dir_file($toPath);//删除解压目录和文件
                        return data_return_arr('请给予应用目录' . $app_static_path . '写权限', -1);
                    }
                    FileUtil::moveDir($toPath . 'bs_static/', $app_static_path);
                }
            }
            delete_dir_file($toPath);//删除解压目录和文件
            //自动保存到数据库
            self::action_install(['plugin_tag' => $app_name]);
        }

        return data_return_arr();
    }

    /**
     * 打包下载
     * @param $params
     * @return array
     */
    public static function action_pack($params)
    {
        //基本的文件路径
        $controller_path = APP_PATH . 'plugin/controller/' . $params['plugin_tag'];
        $view_path = APP_PATH . 'plugin/view/' . $params['plugin_tag'];
        $static_path = PUBLIC_PATH . 'static/plugins/' . $params['plugin_tag'];

        //临时储存位置
        $temp_dir = TEMP_PATH . '/pack_app/';
        if (!is_dir($temp_dir)) {
            if (!mkdir($temp_dir, 0777, true)) {
                return data_return_arr('目录没有写入权限' . $temp_dir, -1);
            }
        }
        //最终目标
        $zipName = $temp_dir . $params['plugin_tag'] . '.zip';
        $zip = new \ZipArchive ();
        $zip->open($zipName, \ZipArchive::CREATE);
        if (is_dir($controller_path)) {
            self::createZip(opendir($controller_path), $zip, $controller_path, 'bs_controller');
        }

        if (is_dir($view_path)) {
            self::createZip(opendir($view_path), $zip, $view_path, 'bs_view');
        }

        if (is_dir($static_path)) {
            self::createZip(opendir($static_path), $zip, $static_path, 'bs_static');
        }
        self::createZip(opendir($temp_dir), $zip, $temp_dir, $params['plugin_tag']);
        //设置应用标识
        //$zip->addFromString('app.bs', $params['plugin_tag']);
        $zip->addFromString('说明.txt', "下载后请勿更改目录结构和文件结构，否则上传无法安装！！！\r\n created by BS_SHOP,https://www.wei1.top");
        $zip->close();

        //下载文件

        if (is_file($zipName)) {
            ob_start();
            header('Content-Type:application/zip');
            header('Content-disposition:attachment;filename=' . $params['plugin_tag'] . '.zip');
            $filesize = filesize($zipName);
            readfile($zipName);
            header('Content-length:' . $filesize);
            unlink($zipName);
            ob_end_flush();
            exit();
        }
        return data_return_arr('打包失败', -1);
    }

    /**
     * 多级目录文件获取
     * @param $dir
     * @return array|bool
     */
    private static function list_dir($dir)
    {
        $files = array();
        if (is_dir($dir)) {
            $fh = opendir($dir);
            while (($file = readdir($fh)) !== false) {
                if (strcmp($file, '.') == 0 || strcmp($file, '..') == 0) {
                    continue;
                }
                $filepath = $dir . '/' . $file;
                if (is_dir($filepath)) {
                    $files = array_merge($files, self::list_dir($filepath));
                } else {
                    array_push($files, $filepath);
                }
            }
            closedir($fh);
        } else {
            $files = false;
        }
        return $files;
    }

    /**
     * 操作行为管理
     * @param $tag
     * @param $action
     * @return array|void
     */
    private static function action_plugin_tags($tag, $action)
    {
        if ($action == 'add') {
            //Hook添加行为监听
            $plugin = json_decode(file_get_contents(APP_PATH . 'plugin/controller/' . $tag . '/config.json'), true);
            if (!empty($plugin['hook'])) {
                $tags = include CONF_PATH . 'tags.php';
                foreach ($plugin['hook'] as $hook => $class) {
                    if (key_exists($hook, $tags)) {
                        $tags[$hook] = array_unique(array_merge($tags[$hook], $class));
                    } else {
                        $tags = array_merge($tags, [$hook => $class]);
                    }
                }
                //写入tag文件
                if (!is_writeable(CONF_PATH . 'tags.php')) {
                    return data_return_arr('请给予' . CONF_PATH . 'tags.php文件写权限', -1);
                } else {
                    file_put_contents(CONF_PATH . 'tags.php', "<?php \n return " . var_export($tags, true) . "\n ?>");
                }
            }
        } elseif ($action == 'del') {
            if (!is_file(APP_PATH . 'plugin/controller/' . $tag . '/config.json')) {
                return data_return_arr('应用不存在:' . $tag, -1);
            }
            //Hook移除行为监听
            $plugin = json_decode(file_get_contents(APP_PATH . 'plugin/controller/' . $tag . '/config.json'), true);
            if (!empty($plugin['hook'])) {
                $tags = include CONF_PATH . 'tags.php';
                foreach ($plugin['hook'] as $hook => $class) {
                    if (key_exists($hook, $tags)) {
                        foreach ($tags[$hook] as $key => $val) {
                            foreach ($class as $name) {
                                if ($val == $name) {
                                    unset($tags[$hook][$key]);
                                }
                            }
                        }
                        if ($tags[$hook] == []) {
                            unset($tags[$hook]);
                        }
                    }
                }
                //写入tag文件
                if (!is_writeable(CONF_PATH . 'tags.php')) {
                    return data_return_arr('请给予' . CONF_PATH . 'tags.php文件写权限', -1);
                } else {
                    file_put_contents(CONF_PATH . 'tags.php', "<?php \n return " . var_export($tags, true) . "\n ?>");
                }
            }
        }
    }

    /**
     * 创建应用
     * @param $params
     * @return array
     */
    public static function action_create($params)
    {
        $app_name = $params['info']['plugin_tag'];
        $controller_path = APP_PATH . 'plugin/controller/';
        $view_path = APP_PATH . 'plugin/view/';
        $static_path = PUBLIC_PATH . 'static/plugins/';
        if (is_dir($controller_path . $app_name)) {
            return data_return_arr('应用标识已存在', -1);
        }
        if (!is_writeable($controller_path) || !is_writeable($view_path) || !is_writeable($static_path)) {
            return data_return_arr('这些目录的上级目录必须有可写权限:' . PHP_EOL .
                $controller_path . ';' . PHP_EOL . $view_path . ';'
                . PHP_EOL . $static_path, -1);
        }
        $controller_path = APP_PATH . 'plugin/controller/' . $app_name;
        $view_path = APP_PATH . 'plugin/view/' . $app_name;
        $static_path = PUBLIC_PATH . 'static/plugins/' . $app_name;
        mkdir($controller_path, 0777, true);
        mkdir($view_path . '/index/', 0777, true);
        mkdir($static_path . '/css/', 0777, true);
        mkdir($static_path . '/img/', 0777, true);
        if (!move_uploaded_file($params['logo']['tmp_name'], $static_path . '/img/' . 'logo.png')) {
            return data_return_arr('上传logo失败', -1);
        }
        $params['info']['logo'] = '/static/plugins/' . $app_name . '/img/logo.png';

        $now = date('Y-m-d H:i:s');
        $classTpl = "<?php
/**
 * @email blog.alipay168.cn
 * @author bs_shop
 * @link http://blog.alipay168.cn
 * @Date: $now
 */
namespace app\\plugin\\controller\\$app_name;

use think\\Controller;
class Index extends Controller
{
    function index()
    {
        return \$this->fetch();
    }

    //配置的方式，可选
    public static function config()
    {
        \$element = [];
        return [
            \"element\"=> \$element,
        ];
    }
}";
        file_put_contents($controller_path . '/Index.php', $classTpl);
        $hookTpl = "<?php
/**
 * @email blog.alipay168.cn
 * @author bs_shop
 * @link http://blog.alipay168.cn
 * @Date: $now
 */

namespace app\plugin\controller\\$app_name;

class Hook
{

    // 应用响应入口
    public function run(\$params = [])
    {
        //todo 写行为逻辑
    }

}";
        file_put_contents($controller_path . '/Hook.php', $hookTpl);
        file_put_contents($static_path . '/css/index.css', ".a{color:red;font-size:20px;}");


        $config = [
            'info' => $params['info'],
            'hook' => [],
            'add_time' => time(),
            'up_time' => time()
        ];
        file_put_contents($controller_path . '/config.json', json_encode($config,
            JSON_UNESCAPED_UNICODE));


        file_put_contents($view_path . '/index/index.html', "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>新应用</title>
    <link rel=\"stylesheet\" href=\"/static/plugins/" . $app_name . "/css/index.css\">
</head>
<body>
Hello World！
<span class=\"a\">应用创建成功</span>
</body>
</html>");

        //自动保存到数据库
        self::action_install(['plugin_tag' => $app_name]);

        return data_return_arr();
    }

    /**
     * 更新应用的状态：启用或者禁用
     * @param $params
     * @return array
     */
    public static function action_status(array $params)
    {
        $has = AppCommon::data_get('plugins', ['plugin_tag' => $params['plugin_tag']], 'id,disable');
        if (!$has) {
            return data_return_arr('应用未安装', -1);
        }
        $res = AppCommon::data_update('plugins', ['id' => $has['id']], ['disable' => $has['disable'] == 0 ? 1 : 0, 'up_time' => time()]);

        if ($res) {
            if ($has['disable'] == 0) {
                //检查系统
                $sys_tag = self::action_system_plugin($params['plugin_tag'], 'del');
                if (isset($sys_tag['code'])) {
                    return $sys_tag;
                }
            } else {
                //检查系统
                $sys_tag = self::action_system_plugin($params['plugin_tag'], 'add');
                if (isset($sys_tag['code'])) {
                    return $sys_tag;
                }
            }
        }
        return $res ? data_return_arr('操作成功') : data_return_arr('更新状态失败');
    }

    /**
     * 应用配置数据
     * @param $params
     * @return array
     */
    public static function action_update_data($params)
    {
        $has = AppCommon::data_get('plugins', ['plugin_tag' => $params['plugin_tag']], 'id');
        if (!$has) {
            return data_return_arr('应用未安装', -1);
        }
        if (!isset($params['data'])) {
            return data_return_arr('应用数据未提交正确', -1);
        }

        $res = AppCommon::data_update('plugins',
            ['id' => $has['id']],
            [
                'plugin_data' => is_array($params['data']) ? json_encode($params['data'], JSON_UNESCAPED_UNICODE) : $params['data'],
                'up_time' => time()
            ]
        );

        return $res ? data_return_arr('操作成功') : data_return_arr('未更新');
    }

    /**
     * 安装应用
     * @param array $params
     * @return array
     */
    public static function action_install(array $params)
    {
        $has = AppCommon::data_get('plugins', ['plugin_tag' => $params['plugin_tag']], 'id');
        if ($has) {
            return data_return_arr('应用已安装', -1);
        }
        $res = AppCommon::data_add('plugins', [
            'disable' => 1,
            'up_time' => time(),
            'add_time' => time(),
            'plugin_tag' => $params['plugin_tag'],

        ]);

        return $res ? data_return_arr('操作成功', 0) : data_return_arr('安装应用失败');
    }

    /**
     * 卸载应用
     * @param array $params
     * @return array
     */
    public static function action_uninstall(array $params)
    {
        $has = AppCommon::data_get('plugins', ['plugin_tag' => $params['plugin_tag']], 'id,disable');
        if (!$has) {
            return data_return_arr('应用未安装或已卸载', -1);
        }
        $res = AppCommon::data_del('plugins', ['plugin_tag' => $params['plugin_tag']]);
        //启用中的插件直接删除时移除行为监控
        if ($res && $has['disable'] == 0) {
            //检查系统
            $sys_tag = self::action_system_plugin($params['plugin_tag'], 'del');
            if (isset($sys_tag['code'])) {
                return $sys_tag;
            }
        }
        return $res ? data_return_arr('操作成功', 0) : data_return_arr('卸载应用失败');
    }

    /**
     * 通常用在私有插件公共查询
     * @param $plugin_tag
     * @return array
     */
    public static function get_plugin_info($plugin_tag)
    {

        $info = AppCommon::data_get('plugins', ['plugin_tag' => $plugin_tag], '*');
        if (!$info) {
            return data_return_arr('应用未安装或已卸载', -1);
        }
        if (empty($info['plugin_data'])) {
            $info['plugin_data'] = [];
        } else {
            $info['plugin_data'] = json_decode($info['plugin_data'], true);
        }
        return data_return_arr('ok', 0, $info);
    }
}