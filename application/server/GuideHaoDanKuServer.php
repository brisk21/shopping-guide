<?php


namespace app\server;

//好单库
use app\common\common;
use app\common\model\ConfigSys;

class GuideHaoDanKuServer
{
    protected $apikey = '';

    public function __construct()
    {
        $this->init_config();
    }

    //初始化配置
    private function init_config()
    {
        $data = (new ConfigSys())->get_value(ConfigSys::key_union);
        if (!empty($data)) {
            $this->apikey = !empty($data['haodanku_apikey']) ? $data['haodanku_apikey'] : '';
        }
    }


    //达人说
    public function talent_info($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . 'abc' . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $uri = 'http://v2.api.haodanku.com/talent_info';
        $param['apikey'] = $this->apikey;
        $param['talentcat'] = empty($arg['talentcat']) ? 0 : $arg['talentcat'];

        $req = \GuzzleHttp\json_decode(curl_get_request($uri, $param), true);
        if (empty($req['code']) || !$req['code'] == 1) {
            common::add_log('好单库' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $req);
            return [];
        }
        cache($key, $req['data'], 300);
        return $req['data'];
    }

    //文章详情
    public function talent_detail($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . 'abc' . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $uri = 'http://v2.api.haodanku.com/talent_article';
        $param['apikey'] = $this->apikey;
        $param['id'] = $arg['talent_id'];

        $req = \GuzzleHttp\json_decode(curl_get_request($uri, $param), true);
        if (empty($req['code']) || !$req['code'] == 1) {
            common::add_log('好单库' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $req);
            return [];
        }
        cache($key, $req['data'], 86400);
        return $req['data'];
    }
}