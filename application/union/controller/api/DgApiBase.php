<?php


namespace app\union\controller\api;


use app\common\common;
use app\common\model\CommonUserTbauth;
use app\server\GuideDtkServer;
use app\server\GuidePddServer;
use app\service\CommonUser;
use think\Controller;
use think\Request;

class DgApiBase extends Controller
{
    protected $params;

    protected $noAuth = [];

    protected $bs_api_key = '';
    private $apiKeyList = ['bsSq4vkNo23dcw35Is3H'];


    protected $pdd;
    protected $dtk;
    //已授权的默认uid，用于获取列表
    protected $defultPddAuthedUid = 'bs8761cfc65a8178c26c6be0d3dc963b6b';
    protected $defaultPddCustomParameters = '';
    //淘宝默认搜索ID
    protected $defaultTbRelationId = 2764524766;

    protected $uid = 'bs8761cfc65a8178c26c6be0d3dc963b6b';
    private $union_code = '123456';

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->params = input();
        $bsapiHeader = \request()->header(['bsapikey', 'bstoken']);

        //fixme 验证sign签名
        if (empty($bsapiHeader['bsapikey'])) {
            data_return('api_key缺失', -1);
        } elseif (!in_array($bsapiHeader['bsapikey'], $this->apiKeyList)) {
            data_return('api_key未授权', -1);
        }
        $this->bs_api_key = $bsapiHeader['bsapikey'];
        $this->check_user($bsapiHeader['bstoken']);


        //拼多多备案授权,uid唯一，sid自定义，还可以加入其它参数
        $this->defaultPddCustomParameters = ['uid' => $this->defultPddAuthedUid, 'sid' => $this->bs_api_key, 'bid' => $this->union_code];
        GuidePddServer::$userRemark = json_encode($this->defaultPddCustomParameters);
        //$this->pdd = server('GuidePddServer');
        //$this->dtk = server('GuideDtkServer');

        $this->pdd = new GuidePddServer();
        $this->dtk = new GuideDtkServer();
    }

    public function pdd_check_auth()
    {
        if (!$this->pdd->is_authed()) {
            $req = $this->pdd->auth_url();
            if (!empty($req['data']['mobile_url'])) {
                data_return('您需要先授权才能使用该功能，是否马上授权？', config('code.pdd_auth'), [
                    'mobile_url' => $req['data']['mobile_url'],
                    'url' => $req['data']['url'],
                ]);
            }
        }
    }

    //获取用户淘宝授权关系ID
    public function tbauth_info()
    {
        return (new CommonUserTbauth())->fetchData(['uid' => $this->uid], 'relation_id');
    }

    public function tb_check_auth()
    {
        $authInfo = $this->tbauth_info();
        if (empty($authInfo['relation_id'])) {
            $url = GuideDtkServer::$authLinkQuDao;
            data_return('您点击下方确定按钮进入授权成为淘宝渠道商后使用，是否马上授权？', config('code.tb_auth'), ['url' => $url]);
        } else {
            $this->defaultTbRelationId = $authInfo['relation_id'];
        }
    }

    //验证是否需要登录
    protected function check_user($token)
    {
        if (!$token){
            return ;
        }
        $user = CommonUser::app_token_user($token, 'uid,account,union_code,status');
        if (!$user) {
            //todo 非白名单验证
        }
        if ($user['status'] == 1) {
            data_return('账号异常，限制登录', -1);
        }
        $this->union_code = $user['union_code'];
        $this->uid = $user['uid'];
        // common::add_log($user,$token);
    }
}