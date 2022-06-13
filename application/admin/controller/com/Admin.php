<?php


namespace app\admin\controller\com;


use app\common\controller\AppCommon;
use app\service\ConfigService;
use app\service\DiyLog;
use app\service\ErrorService;
use app\service\UpdateService;
use think\Controller;
use think\Request;

//ErrorService::catch_error();
class Admin extends Controller
{
    public $param = null;
    public $admin_uid = null;
    public $admin_info = null;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->param = input();


        $this->admin_uid = session('admin_uid', '', 'bs_admin_');
        if (empty($this->admin_uid)) {
            if (IS_AJAX || IS_POST) {
                data_return('登录超时', 401, ['url' => url('/admin/account/login')]);
            }
            $domain = request()->domain();
            $currentUrl = $domain . $_SERVER['REQUEST_URI'];
            cookie('admin_backurl', $currentUrl, 3600);
            return $this->error('登录超时', url('/admin/account/login'), '', 1);
        }
        $this->admin_info = AppCommon::data_get('admin', ['uid' => $this->admin_uid], 'account,role_id,uid,status');
        //非正常状态检测
        if (empty($this->admin_info) || $this->admin_info['status'] <> 1) {
            if (IS_AJAX || IS_POST) {
                data_return('你的账号异常，请联系系统管理员', 403, ['url' => url('/admin/account/login')]);
            }
            return $this->error('你的账号异常，请联系系统管理员', url('/admin/account/login'), '', 1);
        }

        //权限检测
        $auth = $this->check_auth($request);
        if (!$auth) {
            if (IS_AJAX || IS_POST) {
                data_return('无权操作', 403);
            }
            return $this->error('无权操作');
        }
        $webConf = ConfigService::get('web');
        $version = UpdateService::get_version();
        $conf = [
            'bs_title' => !empty($webConf['title']) ? $webConf['title'] : 'BS后台管理',
            'version' => !empty($version['old']['app_version']) ? 'v' . $version['old']['app_version'] . '.0' : 'v1.0',
        ];
        $this->assign('webConf', $conf);
        $this->assign('menu', $this->get_menu());
    }

    private function check_auth($request)
    {
        if ($this->admin_info['role_id'] == 0) {
            return true;
        }
        $model = $request->module();
        $controller = $request->controller();
        $action = $request->action();
        $qxStr = strtolower('@' . $model . '@' . str_replace(['/', '.'], '@', $controller) . '@' . $action);

        //方法1：直接对比菜单（高速，加载缓存菜单的非实时）

        $menu = $this->get_menu(true);
        $myMenu = array_column($menu, null, 'qx_str');
        if (empty($myMenu[$qxStr])) {
            return false;
        } else {
            return true;
        }

        //方法2：实时检测数据库（高实时性，消耗数据库查询）
        $data = AppCommon::db("admin_menu")
            ->alias('a')
            ->join('admin_role_auth b', 'a.id=b.menu_id', 'left')
            ->where(['b.role_id' => $this->admin_info['role_id'], 'a.qx_str' => $qxStr])
            ->field('a.id')
            ->find();
        if (empty($data['id'])) {
            return false;
        }
        return true;

    }


    private function get_menu($noTree = false)
    {
        $cacheKey = 'admin_menus' . $this->admin_info['role_id'];
        $data = cache($cacheKey);
        if (empty($data)) {
            if ($this->admin_info['role_id'] == 0) {
                //超级管理全部获取
                $data = AppCommon::data_list_nopage('admin_menu', ['status' => 1, 'type' => 1], '*', 'sort desc,id desc');
            } else {
                $data = AppCommon::db("admin_menu")
                    ->alias('a')
                    ->join('admin_role_auth b', 'a.id=b.menu_id', 'left')
                    ->where(['b.role_id' => $this->admin_info['role_id'], 'a.id' => ['>', 0]])
                    ->field('a.id,a.name,a.fid,a.status,a.type,a.is_new,a.url,a.qx_str,a.class_name,a.sort')
                    ->order('a.sort desc,a.id asc')
                    ->select();
            }
            if (empty($data)) {
                if (IS_AJAX || IS_POST) {
                    data_return('账号无任何权限', 403, ['url' => url('/admin/account/login')]);
                }
                return $this->error('账号无任何权限', url('/admin/account/login'), '', 1);
            }
            //缓存起来
            cache($cacheKey, $data, ['expire' => 3600], 'admin_menu');
        }


        if ($noTree) {
            return $data;
        }

        $menu = tree($data, 'id', 'fid', 'subcat');

        return $menu;
    }

    /**
     * 管理员操作日志
     * @param $arg array title-标题，content-内容
     * @return false|int|string
     */
    public function add_admin_log($arg)
    {
        $title = !empty($arg['title']) ? mb_substr($arg['title'], 0, 255) : '未设置';
        if (empty($arg['content']) || empty($this->admin_uid)) {
            return false;
        }
        $content = is_array($arg['content']) || is_object($arg['content']) ? json_encode($arg['content'], 256) : $arg['content'];

        return AppCommon::data_add('admin_action_log', [
            'title' => $title,
            'content' => $content,
            'add_time' => time(),
            'uid' => $this->admin_uid
        ]);
    }

}