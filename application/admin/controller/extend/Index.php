<?php


namespace app\admin\controller\extend;


use app\admin\controller\com\Admin;
use app\common\controller\AppCommon;
use app\service\DiyLog;
use app\service\PluginsService;
error_reporting(E_ALL);

class Index extends Admin
{

    function index()
    {
        $dbPlugins = AppCommon::data_list_nopage('plugins', ['disable' => 0]);
        if (!empty($dbPlugins)) {
            $tags = array_column($dbPlugins, 'plugin_tag');
            $plugins = PluginsService::get_all_plugin_list($tags);
        }
        if (!empty($plugins)) {
            array_walk($plugins,function(&$v){
                $v['info']['desc'] = nl2br($v['info']['desc']);
            });
            $upTime = array_column($plugins, 'up_time');
            array_multisort($plugins, SORT_DESC, $upTime);
            $this->assign('data', $plugins);
        }
        $this->assign('category', $this->app_category());

        return $this->fetch();
    }

    //应该管理页面
    function manager()
    {
        $plugins = PluginsService::get_all_plugin_list();
        if (!empty($plugins)) {
            $dbPlugins = AppCommon::data_list_nopage('plugins');
            if (!empty($dbPlugins)) {
                $dbPlugins = array_column($dbPlugins, null, 'plugin_tag');
                foreach ($plugins as &$v) {
                    $v['status'] = 1;
                    $v['info']['desc'] = nl2br($v['info']['desc']);
                    if (!empty($dbPlugins[$v['info']['plugin_tag']]['disable'])) {
                        $v['status'] = 0;
                    }
                }
                unset($v);
            }else{
                array_walk($plugins ,function (&$v){
                    $v['status'] = 0;
                    $v['info']['desc'] = nl2br($v['info']['desc']);
                });
            }
            $upTime = array_column($plugins, 'up_time');
            array_multisort($plugins, SORT_DESC, $upTime);
        }
        $this->assign('category', $this->app_category());
        $this->assign('data', $plugins);
        $this->assign('envs', $this->check_env());
        return $this->fetch();
    }

    private function check_env()
    {
        $env = [
            ['path' => CONF_PATH, 'desc' => '配置目录，针对tag.php、system_tags.php'],
            ['path' => APP_PATH . 'plugin/controller/', 'desc' => '插件逻辑目录'],
            ['path' => APP_PATH . 'plugin/view/', 'desc' => '插件页面目录'],
            ['path' => PUBLIC_PATH . 'static/plugins/', 'desc' => '插件静态资源目录'],
            ['path' => CONF_PATH . 'tags.php', 'desc' => '行为文件保存文件'],
            ['path' => TEMP_PATH, 'desc' => '临时文件目录'],
        ];

        array_walk($env, function (&$v) {
            $v['path'] = str_replace("\\", '/', $v['path']);
            if ((!is_dir($v['path']) && !is_file($v['path'])) || !is_writable($v['path'])) {
                $v['status'] = 0;
            } else {
                $v['status'] = 1;
            }
            $v['path'] = str_replace(ROOT_PATH, '/', $v['path']);
        });

        return $env;
    }


    private function app_category()
    {
        $category = AppCommon::data_list_nopage('plugins_category');
        $category_id = array_column($category, 'category_id');
        return array_combine($category_id, $category);
    }


    //上传
    function upload_app()
    {
        if (!config('bs.is_developer')) {
            return data_return('请先开启开发者模式', -1);
        }
        if (empty($_FILES['app'])) {
            return data_return('请先上传文件', 1);
        }
        $files = $_FILES['app'];
        if ($files['error'] == 0 &&
            $files['size'] > 0 &&
            $files['size'] < 1024 * 1024 * 2) {
            $extArray = explode('.', $files['name']);
            $fileExt = $extArray[count($extArray) - 1];
            if ($fileExt != "zip") {
                return data_return('请上传zip文件', -1);
            }
            $this->param['app'] = $files;
            $res = PluginsService::action_unpack($this->param);
            return data_return($res['msg'], $res['code']);
        } else {
            return data_return('仅支持2M以内的zip格式应用', -1, $_FILES);
        }
    }


    //更新应用
    function update_app()
    {
        $param_set = $this->base_set(true);
        if (isset($param_set['code'])) {
            return $param_set;
        }
        if (!config('bs.is_developer')) {
            return data_return('请先开启开发者模式', -1);
        }
        if (empty($_FILES['app'])) {
            return data_return('请先上传文件', 1);
        }
        $files = $_FILES['app'];
        if ($files['error'] == 0 &&
            $files['size'] > 0 &&
            $files['size'] < 1024 * 1024 * 2) {
            $extArray = explode('.', $files['name']);
            $fileExt = $extArray[count($extArray) - 1];
            if ($fileExt != "zip") {
                return data_return('请上传zip文件', -1);
            }
            $this->param['app'] = $files;
            return PluginsService::action_update_app($this->param);
        } else {
            return data_return('仅支持2M以内的zip格式应用', -1, $_FILES);
        }

    }

    /**
     * 基础设置
     * @return array|void
     */
    private function base_set($need_developer = false)
    {
        if (empty($this->param['tag'])) {
            return data_return('参数有误', -1);
        }
        if ($need_developer) {
            if (!config('bs.is_developer')) {
                return data_return('请先开启开发者模式', -1);
            }
        }
        $this->param['plugin_tag'] = $this->param['tag'];
    }


    //修改状态
    function set_status()
    {
        $param_set = $this->base_set();
        if (isset($param_set['code'])) {
            data_return($param_set['msg'], $param_set['code']);
        }
        $res = PluginsService::action_status($this->param);
        data_return($res['msg'], $res['code']);
    }

    //完全移除应用
    function remove()
    {
        $param_set = $this->base_set(true);
        if (isset($param_set['code'])) {
            data_return($param_set['msg'], $param_set['code']);
        }
        $res = PluginsService::action_delete_app($this->param);

        data_return($res['msg'], $res['code']);
    }

    //打包下载
    function pack()
    {
        $param_set = $this->base_set(true);
        if (isset($param_set['code'])) {
            return $param_set;
        }
        $res = PluginsService::action_pack($this->param);
        if (!IS_AJAX) {
            if (isset($res['code'])) {
                return $this->error($res['msg']);
            }
        } else {
            return $res;
        }
        return $res;
    }

    //应用设置页面
    function setting()
    {
        if (empty($this->param['tag'])) {
            return $this->error('参数有误');
        }

        $tag = $this->param['tag'];

        //判断类是否存在
        $class = "\\app\\plugin\\controller\\$tag\\Index";
        if (!class_exists($class)) {
            return $this->error($class . ' Not found');
        }
        //判断配置函数是否存在
        if (!method_exists($class, 'config')) {
            return $this->error('应用无需配置');
        }
        //调用配置函数
        $action = 'config';
        $config = (new $class($this->request))->$action();
        if (empty($config['element'])) {
            return $this->error('应用无需配置');
        }
        $data = PluginsService::get_plugin_data(['plugin_tag' => $tag]);

        $this->assign('data', $data['data']['plugin_data']);
        $this->assign('element', $config['element']);
        $this->assign('plugin_tag', $tag);
        return $this->fetch();
    }


    function form()
    {
        if (!empty($this->param['tag'])) {
            $config_json = APP_PATH . 'plugin' . DS . 'controller' . DS . $this->param['tag'] . DS . 'config.json';
            if (!file_exists($config_json)) {
                return $this->error('应用不存在');
            }
            $data = json_decode(file_get_contents($config_json), true);
            $info = $data['info'];
            $action = 'edit_app';
        } else {
            $info = [
                "plugin_tag" => "bs" . date('Ymdi'),
                "name" => "",
                "logo" => "",
                "author" => "",
                "author_url" => "",
                "version" => "1.0.0",
                "desc" => "",
                "contact" => "",
            ];
            $action = 'create_app';
        }

        $this->assign('category', $this->app_category());
        $this->assign('data', $info);
        $this->assign('action', $action);
        return $this->fetch();
    }

    //创建应用
    function create_app()
    {
        if (!config('bs.is_developer')) {
            return data_return('请先开启开发者模式', -1);
        }
        $rule = [
            ['type' => 'length', 'key' => 'tag', 'rule' => '2,20', 'msg' => '应用标识长度应在2~20字符',],
            ['type' => 'length', 'key' => 'name', 'rule' => '2,20', 'msg' => '应用名称需2~20字符',],
            ['type' => 'length', 'key' => 'desc', 'rule' => '2,10000', 'msg' => '功能描述需10~10000字符',],
            ['type' => 'empty', 'key' => 'author', 'msg' => '作者未填写',],
            ['type' => 'empty', 'key' => 'version', 'msg' => '请填写版本号',],
            ['type' => 'empty', 'key' => 'contact', 'msg' => '填一下联系方式吧',],
            ['type' => 'isset', 'key' => 'category', 'msg' => '请选择应用分类',],
            ['type' => 'isset', 'key' => 'can_install', 'msg' => '请选择是否开放安装',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        if (empty($_FILES['logo'])) {
            return data_return('请上传应用图标', -1);
        }
        if ($_FILES['logo']['error'] <> 0 || $_FILES['logo']['size'] < 0 || $_FILES['logo']['size'] > 1024 * 200) {
            return data_return('图片应在200k以内', -1);
        }
        $extArray = explode('.', $_FILES['logo']['name']);
        $fileExt = $extArray[count($extArray) - 1];
        if (!in_array(strtolower($fileExt), ['png', 'jpeg', 'jpg'])) {
            return data_return('图标仅支持png，jpeg，jpg', -1);
        }

        if (preg_match("/[\x7f-\xff]/", $this->param['tag'])) {
            return data_return('标识不能包含中文', -1);
        }

        if (!preg_match('/^[A-Za-z]+$/', substr($this->param['tag'], 0, 1))) {
            return data_return('应用标识仅支持字母开头', -1);
        }

        $this->param['logo'] = $_FILES['logo'];
        $this->param['info'] = [
            "plugin_tag" => $this->param['tag'],
            "category_id" => intval($this->param['category']),
            "name" => $this->param['name'],
            "logo" => '',
            "author" => $this->param['author'],
            "author_url" => $this->param['author_url'],
            "version" => $this->param['version'],
            "desc" => $this->param['desc'],
            "contact" => $this->param['contact'],
            "can_install" => intval($this->param['can_install']),
            "has_front_page" => intval($this->param['has_front_page']),
            "need_config" => intval($this->param['need_config']),

        ];

        $res = PluginsService::action_create($this->param);
        if ($res['code'] <> 0) {
            return data_return($res['msg'], -1);
        }
        return data_return();
    }


    //编辑操作
    function edit_app()
    {
        if (!config('bs.is_developer')) {
            return data_return('请先开启开发者模式', -1);
        }
        $rule = [
            ['type' => 'length', 'key' => 'tag', 'rule' => '2,20', 'msg' => '应用标识长度应在2~20字符',],
            ['type' => 'length', 'key' => 'name', 'rule' => '2,20', 'msg' => '应用名称需2~20字符',],
            ['type' => 'length', 'key' => 'desc', 'rule' => '2,10000', 'msg' => '功能描述需10~10000字符',],

            ['type' => 'empty', 'key' => 'author', 'msg' => '作者未填写',],
            ['type' => 'empty', 'key' => 'version', 'msg' => '请填写版本号',],
            ['type' => 'empty', 'key' => 'contact', 'msg' => '填一下联系方式吧',],
            ['type' => 'isset', 'key' => 'category', 'msg' => '应用分类未选择',],
            ['type' => 'isset', 'key' => 'can_install', 'msg' => '是否开放安装未选择',],
        ];
        $check = check_param($this->param, $rule);
        if ($check['code'] <> 0) {
            data_return($check['msg'], $check['code']);
        }
        if (!empty($_FILES['logo'])) {
            if ($_FILES['logo']['error'] <> 0 || $_FILES['logo']['size'] < 0 || $_FILES['logo']['size'] > 1024 * 200) {
                return data_return('图片应在200k以内 ', -1);
            }
            $extArray = explode('.', $_FILES['logo']['name']);
            $fileExt = $extArray[count($extArray) - 1];
            if (!in_array(strtolower($fileExt), ['png', 'jpeg', 'jpg'])) {
                return data_return('图标仅支持png，jpeg，jpg', -1);
            }
            $static_path = PUBLIC_PATH . 'static/plugins/' . $this->param['tag'];
            if (!is_dir($static_path . '/img/')) {
                $mk = @mkdir($static_path . '/img/', 0777, true);
                if (!$mk) {
                    return data_return('请设置' . PUBLIC_PATH . 'static/plugins/目录可写', -1);
                }
            }
            if (!move_uploaded_file($_FILES['logo']['tmp_name'], $static_path . '/img/' . 'logo.png')) {
                return data_return('上传logo失败', -1);
            } else {
                $logo = '/static/plugins/' . $this->param['tag'] . DS . 'img' . DS . 'logo.png?v=' . time();
            }
        }


        $config_json = APP_PATH . 'plugin' . DS . 'controller' . DS . $this->param['tag'] . DS . 'config.json';
        if (!file_exists($config_json)) {
            return data_return('应用不存在', -1);
        }
        $data = json_decode(file_get_contents($config_json), true);

        $data['info'] = [
            "plugin_tag" => $data['info']['plugin_tag'],
            "category_id" => intval($this->param['category']),
            "name" => $this->param['name'],
            "logo" => !empty($logo) ? $logo : $data['info']['logo'],
            "author" => $this->param['author'],
            "author_url" => $this->param['author_url'],
            "version" => $this->param['version'],
            "desc" => $this->param['desc'],
            "contact" => $this->param['contact'],
            "can_install" => intval($this->param['can_install']),
            "has_front_page" => intval($this->param['has_front_page']),
            "need_config" => intval($this->param['need_config']),
        ];
        if (!isset($data['add_time'])) {
            $data['add_time'] = 0;
        }
        $data['up_time'] = time();

        $res = file_put_contents($config_json, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $res ? data_return('更新成功', 0, $data) : data_return('操作失败', -1);
    }

    //更新应用的设置
    function setting_update()
    {
        if (empty($this->param['tag'])) {
            data_return('参数有误', -1);
        }
        $tag = $this->param['tag'];

        //判断类是否存在
        $class = "\\app\\plugin\\controller\\$tag\\Index";
        if (!class_exists($class)) {
            data_return($class . ' Not found');
        }
        //判断配置函数是否存在
        if (!method_exists($class, 'config')) {
            data_return('this static function [config] is not defined');
        }
        //调用配置函数
        $config = $class::config();
        $element = $config['element'];
        if (empty($element)) {
            data_return('应用无需配置', -1);
        }

        $names = array_column($element, 'name');
        $element = array_combine($names, $element);
        $this->param['data'] = [];
        foreach ($names as $val) {
            if ($element[$val]['is_required'] && empty($this->param[$val])) {
                return data_return($element[$val]['message'], -1);
            }
            $this->param['data'][$val] = $this->param[$val];
        }
        $this->param['plugin_tag'] = $tag;

        return PluginsService::action_update_data($this->param);
    }


}