<?php
/**
 * @email wei@alipay168.cn
 * @author 小韦
 * @link http://blog.alipay168.cn
 * @Date: 2020/12/4 22:46
 */

namespace app\server;


use app\common\common;
use app\common\model\ConfigSys;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkCmsPromUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsDetailRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsPidGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsPidQueryRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsPromotionUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsRecommendGetRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsSearchRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsSearchRequest_RangeListItem;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsZsUnitUrlGenRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkMemberAuthorityQueryRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParam;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParamRangeItemsItem;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParam;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParamRangeItemsItem;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOrderListRangeGetRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkResourceUrlGenRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkRpPromUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkTopGoodsListQueryRequest;
use Com\Pdd\Pop\Sdk\PopAccessTokenClient;
use Com\Pdd\Pop\Sdk\PopHttpClient;

use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOrderListIncrementGetRequest;
use think\Db;
use think\Hook;

class GuidePddServer
{
    private static $clientId = '';
    private static $clientSecret = '';
    private static $pid = '';//app
    private static $openid = '';
    public static $accessToken = '';
    public static $refresh_token = '';
    public static $expires_at = 1643255712;
    public static $userRemark = 'zacaoyizu123';


    public function __construct()
    {
        $this->init_config();
    }

    //初始化配置
    private function init_config()
    {
        $data = (new ConfigSys())->get_value(ConfigSys::key_union);
        if (!empty($data)) {
            self::$clientId = !empty($data['pdd_clientId']) ? $data['pdd_clientId'] : '';
            self::$clientSecret = !empty($data['pdd_clientSecret']) ? $data['pdd_clientSecret'] : '';
            self::$accessToken = !empty($data['pdd_accessToken']) ? $data['pdd_accessToken'] : '';
            self::$refresh_token = !empty($data['pdd_refresh_token']) ? $data['pdd_refresh_token'] : '';
            self::$pid = !empty($data['pdd_pid']) ? $data['pdd_pid'] : '';
        }
    }


    //商品详情
    public function goods_detail($params = [])
    {
        $key = md5(__FILE__.__FUNCTION__.json_encode($params));
        if ($data = cache($key)){
            return data_return_arr('ok', 0, $data);
        }
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsDetailRequest();
        $request->setPid(self::$pid);
        $request->setCustomParameters(self::$userRemark);
        $request->setGoodsSign($params['gsign']);
        // $request->setSearchId('pdd.ddk.goods.search');
        // $request->setZsDuoId(0L);

        //发起接口请求
        $response = $client->syncInvoke($request);
        $content = $response->getContent();

        if (empty($content['goods_detail_response']['goods_details'][0])) {

            return data_return_arr('网络正忙', -1);
        }
        cache($key,$content['goods_detail_response']['goods_details'][0],600);
        return data_return_arr('ok', 0, $content['goods_detail_response']['goods_details'][0]);
    }

    //多多客获取爆款排行商品接口：pdd.ddk.top.goods.list.query
    public static function top_goods_list($params = [])
    {
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $pageSize = !empty($params['pageSize']) ? intval($params['pageSize']) : 20;
        //创建client客户端
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);
        //创建请求对象
        $request = new PddDdkTopGoodsListQueryRequest();
        $request->setLimit(20);
        $request->setListId($page);
        $request->setOffset(($page - 1) * $pageSize);
        $request->setPId(self::$pid);
        $request->setSortType(1);//	1-实时热销榜；2-实时收益榜

        //发起接口请求
        $response = $client->syncInvoke($request);
        $content = $response->getContent();
        if (empty($content['top_goods_list_get_response']['list'])) {

            return data_return('网络正忙', -1);
        }
        $data = [
            'total' => $content['top_goods_list_get_response']['total'],
            'list_id' => $content['top_goods_list_get_response']['list_id'],
            'list' => $content['top_goods_list_get_response']['list'],
        ];
        return data_return('ok', 0, $data);
    }

    //转链
    public function get_url($params = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);
        $request = new PddDdkGoodsPromotionUrlGenerateRequest();
        $request->setCustomParameters(self::$userRemark);

        $request->setGenerateMallCollectCoupon(false);
        $request->setGenerateQqApp(false);
        $request->setGenerateSchemaUrl(true);
        $request->setGenerateShortUrl(true);
        $request->setGenerateWeApp(false);
        $request->setMultiGroup(!empty($params['group']) ? true : false);
        $request->setPId(self::$pid);
        $goodsSignList[] = $params['gsign'];
        $request->setGoodsSignList($goodsSignList);
        $request->setSearchId('pdd.ddk.top.goods.list.query');
        $request->setGenerateAuthorityUrl(false);
        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (!empty($content['error_response'])) {
            return data_return_arr('网络正忙', -1, $content['error_response']);
        }

        $data = $content['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];
        return data_return_arr('ok', 0, $data);
    }

    //商品查询：https://jinbao.pinduoduo.com/third-party/api-detail?apiName=pdd.ddk.goods.search
    public static function goods_list_search($params = [])
    {
        $page = !empty($params['page']) ? intval($params['page']) : 1;
        $pageSize = !empty($params['pageSize']) ? intval($params['pageSize']) : 20;
        //创建client客户端
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsSearchRequest();

        //活动商品标记数组，例：[4,7]，4-秒杀，7-百亿补贴，31-品牌黑标，10564-精选爆品-官方直推爆款，10584-精选爆品-团长推荐，24-品牌高佣，20-行业精选，21-金牌商家，10044-潜力爆品，10475-爆品上新，其他的值请忽略
        $activityTags = array(4, 7, 10564, 10584, 24, 21, 31, 20, 10044, 10475);
        // $activityTags[] = 0;
        $request->setActivityTags($activityTags);
        if (!empty($params['catId'])){
            $request->setCatId($params['catId']);
        }
        $request->setCustomParameters(self::$userRemark);

        $request->setIsBrandGoods(false);
        if (!empty($params['keyword'])) {
            $request->setKeyword(trim($params['keyword']));
        }

        if (!empty($params['gsign'])) {
            $goodsSignList = $params['gsign'];
            $request->setGoodsSignList($goodsSignList);
        }


        // $request->setListId('str');
        // $request->setMerchantType(0);
        // $merchantTypeList = array();
        // $merchantTypeList[] = 0;
        // $request->setMerchantTypeList($merchantTypeList);
        if (!empty($params['opt_id'])) {
            $request->setOptId($params['opt_id']);
        }
        $request->setPage($page);
        $request->setPageSize($pageSize);
        $request->setPid(self::$pid);
        $rangeList = array();
        //$item = new PddDdkGoodsSearchRequest_RangeListItem();
        // $item->setRangeFrom(0L);
        // $item->setRangeId(0);
        //$item->setRangeTo(0L);
        // $rangeList[] = $item;
        //  $request->setRangeList($rangeList);

        if (!empty($params['range_list'])) {
            $request->setRangeList($params['range_list']);
        }

        //排序方式:0-综合排序;1-按佣金比率升序;2-按佣金比例降序;3-按价格升序;4-按价格降序;5-按销量升序;6-按销量降序;7-优惠券金额排序升序;8-优惠券金额排序降序;9-券后价升序排序;10-券后价降序排序;11-按照加入多多进宝时间升序;12-按照加入多多进宝时间降序;13-按佣金金额升序排序;14-按佣金金额降序排序;15-店铺描述评分升序;16-店铺描述评分降序;17-店铺物流评分升序;18-店铺物流评分降序;19-店铺服务评分升序;20-店铺服务评分降序;27-描述评分击败同类店铺百分比升序，28-描述评分击败同类店铺百分比降序，29-物流评分击败同类店铺百分比升序，30-物流评分击败同类店铺百分比降序，31-服务评分击败同类店铺百分比升序，32-服务评分击败同类店铺百分比降序

        // $request->setUse_customized(false);
        if (isset($params['sort'])) {
            $request->setSortType(intval($params['sort']));
        } else {
            $request->setSortType(0);
        }
        // $request->setWithCoupon(false);
        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('err', $content['error_response']);
            return data_return_arr('网络正忙', -1);
        }


        $data['list'] = $content['goods_search_response']['goods_list'];
        return data_return_arr('ok', 0, $data);
    }

    //pdd.ddk.goods.recommend.get多多进宝商品推荐API
    public function get_recommend_goods($param = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . 'abdc' . json_encode($param));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsRecommendGetRequest();


        // 猜你喜欢场景的商品类目，20100-百货，20200-母婴，20300-食品，20400-女装，20500-电器，20600-鞋包，20700-内衣，20800-美妆，20900-男装，21000-水果，21100-家纺，21200-文具,21300-运动,21400-虚拟,21500-汽车,21600-家装,21700-家具,21800-医药;
        //$request->setCatId(20100);
        //0-1.9包邮, 1-今日爆款, 2-品牌清仓,3-相似商品推荐,4-猜你喜欢,5-实时热销,6-实时收益,7-今日畅销,8-高佣榜单，默认1


        if (!empty($param['type'])) {
            $request->setChannelType($param['type']);
        }


        $limit = 20;
        $offset = ($param['page'] - 1) * $limit;

        /* $activityTags = array();
         $activityTags[] = 0;
         $request->setActivityTags($activityTags);*/
        //$request->setCatId(0L);
        //$request->setChannelType(0);
        if (!empty($param['gsign'])) {
            $goodsSignList[] = $param['gsign'];
            $request->setGoodsSignList($goodsSignList);
        }
        $request->setOffset($offset);
        $request->setLimit($limit);
        if (!empty($param['listid'])) {
            $request->setListId($param['listid']);
        }


        $request->setPid(self::$pid);
        $request->setCustomParameters(self::$userRemark);

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();

        if (isset($content['error_response'])) {
            if ($content['error_response']['error_code'] == 50001){
                $this->pdd_check_auth();
            }
            return data_return_arr('网络正忙', -1, $content['error_response']);
        } elseif (!empty($content['goods_basic_detail_response']['list'])) {
            cache($key, [
                'code' => 0,
                'msg' => 'ok',
                'data' => $content['goods_basic_detail_response']
            ], 60);
        }


        return data_return_arr('ok', 0, $content['goods_basic_detail_response']);

    }

    public function pdd_check_auth()
    {
        if (!$this->is_authed()) {
            $req = $this->auth_url();
            if (!empty($req['data']['mobile_url'])) {
                data_return('您需要先授权才能使用该功能，是否马上授权？', config('code.pdd_auth'), [
                    'mobile_url' => $req['data']['mobile_url'],
                    'url' => $req['data']['url'],
                ]);
            }
        }
    }

    //按支付时间段查询订单
    public function syn_order($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);


        $request = new PddDdkOrderListRangeGetRequest();

        $request->setEndTime(date('Y-m-d H:i:s', strtotime('-1 day', strtotime(date('Y-m-d H:i:s')))));
        // $request->setLastOrderId('str');
        $request->setPageSize(300);
        $request->setQueryOrderType(1);//	订单类型：1-推广订单；2-直播间订单
        $request->setStartTime(date('Y-m-d H:i:s'));

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            return data_return('网络正忙', -1, $content['error_response']);
        }

        return data_return('ok', 0, $content);
    }

    //按更新时间同步已支付后的订单
    public function syn_order2($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);
        $request = new PddDdkOrderListIncrementGetRequest();
        $num = !empty($param['minute']) ? intval($param['minute']) : 20;
        $request->setPage(1);
        $request->setPageSize(300);
        $request->setQueryOrderType(0);
        $request->setReturnCount(false);
        $request->setStartUpdateTime(strtotime("-$num minutes", time()));
        $request->setEndUpdateTime(time());

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            return data_return_arr('网络正忙', -1, $content['error_response']);
        }
        if (empty($content['order_list_get_response']['order_list'])) {
            return data_return_arr('暂无订单', 0);
        }
        return data_return_arr('ok', 0, $content['order_list_get_response']['order_list']);
    }



    //生成营销工具推广链接：pdd.ddk.oauth.rp.prom.url.generate
    //https://jinbao.pinduoduo.com/third-party/api-detail?apiName=pdd.ddk.oauth.rp.prom.url.generate
    public function get_oauth_prom_url($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkOauthRpPromUrlGenerateRequest();


        if (!isset($param['channelType'])) {
            $param['channelType'] = 10;
        }
        //必填：-1-活动列表，0-红包(需申请推广权限)，2–新人红包，3-刮刮卡，5-员工内购，6-购物车，10-生成绑定备案链接，12-砸金蛋，13-一元购C端页面，14-千万补贴B端页面，15-充值中心B端页面，16-千万补贴C端页面，17-千万补贴投票页面，18-一元购B端页面，19-多多星选B端页面；红包推广权限申请流程链接：https://jinbao.pinduoduo.com/qa-system?questionId=289
        $request->setChannelType($param['channelType']);
        $request->setGenerateShortUrl(true);
        $request->setCustomParameters(self::$userRemark);
        $diyLotteryParam = new PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParam();
        $diyLotteryParam->setOptId(0);

        /*  $rangeItems = array();
          $item = new PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParamRangeItemsItem();*/
        /* $item->setRangeFrom(0L);
         $item->setRangeId(0);
         $item->setRangeTo(0L);*/
        /*$rangeItems[] = $item;
        $diyLotteryParam->setRangeItems($rangeItems);*/
        /*$request->setDiyLotteryParam(diyLotteryParam);*/
        $diyRedPacketParam = new PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParam();
        /*$amountProbability = array();
        $amountProbability[] = 0L;*/
        /* $diyRedPacketParam->setAmountProbability($amountProbability);
         $diyRedPacketParam->setDisText(false);
         $diyRedPacketParam->setNotShowBackground(false);
         $diyRedPacketParam->setOptId(0);*/
        /*$rangeItems = array();
        $item = new PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParamRangeItemsItem();
        $item->setRangeFrom(0L);
        $item->setRangeId(0);
        $item->setRangeTo(0L);
        $rangeItems[] = $item;
        $diyRedPacketParam->setRangeItems($rangeItems);*/
        /*  $request->setDiyRedPacketParam(diyRedPacketParam);*/
        $request->setGenerateQqApp(false);
        $request->setGenerateSchemaUrl(false);
        $request->setGenerateWeApp(false);
        $pIdList = array();
        $pIdList[] = self::$pid;
        $request->setPIdList($pIdList);
        /* $request->setAmount(0L);
         $request->setScratchCardAmount(0L);*/

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            return data_return_arr('网络正忙', -1, $content['error_response']);
        }

        return data_return_arr('ok', 0, $content['rp_promotion_url_generate_response']);
    }

    //生成AccessToken
    public function getToken($code)
    {
        $accessTokenClient = new PopAccessTokenClient(self::$clientId, self::$clientSecret);
        $result = $accessTokenClient->generate($code);
        $result = $result->getContent();
        common::add_log('授权codetoken', [$result]);

        return $result;
    }

    //刷新AccessToken
    public function refresh_token()
    {
        $refreshToken = self::$refresh_token;
        $accessTokenClient = new PopAccessTokenClient(self::$clientId, self::$clientSecret);
        $result = $accessTokenClient->refresh($refreshToken);
        $result = $result->getContent();
        common::add_log('pdd_刷新AccessToken', [$result]);
        return $result;
    }


    //获取授权code
    public function get_code($returnUrl)
    {
        $url = "http://jinbao.pinduoduo.com/open.html";
        //client_id
        $url .= "?client_id=" . self::$clientId;
        //授权类型为CODE
        $url .= "&response_type=code";
        //授权回调地址
        $url .= "&redirect_uri=" . $returnUrl;
        return $url;
    }

    //检查是否已经授权
    public function check_auth()
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);
        $request = new PddDdkMemberAuthorityQueryRequest();

        $request->setPid(self::$pid);
        $request->setCustomParameters(self::$userRemark);
        $response = $client->syncInvoke($request, self::$accessToken);

        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return_arr('系统正忙', -1, $content['error_response']);
        }

        //1-已绑定；0-未绑定
        $bindStatus = $content['authority_query_response']['bind'];
        return data_return_arr('ok', 0, $bindStatus);
    }

    /**
     * 检查是否已授权
     * @return bool
     */
    public function is_authed()
    {
        $c = $this->check_auth();
        if ($c['code'] == 0 && $c['data'] == 1) return true;
        return false;
    }

    //生成授权链接APP或者H5
    public function get_auth_url($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsPromotionUrlGenerateRequest();
        $request->setGenerateAuthorityUrl(true);
        $request->setPId(self::$pid);


        $request->setCustomParameters(self::$userRemark);

        $request->setGenerateMallCollectCoupon(false);
        $request->setGenerateQqApp(false);
        $request->setGenerateSchemaUrl(false);
        $request->setGenerateShortUrl(false);
        $request->setGenerateWeApp(false);
        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return_arr('系统正忙', -1, $content['error_response']);
        }
        //common::add_log('pddAuth:' . __CLASS__ . __FUNCTION__ . __LINE__, $content);
        return data_return_arr('ok', 0, $content['goods_promotion_url_generate_response']);
    }

    //生成商城-频道推广链接
    public function get_cms_url($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkCmsPromUrlGenerateRequest();
        //0, "1.9包邮"；1, "今日爆款"； 2, "品牌清仓"； 4,"PC端专属商城"；不传值为默认商城
        $request->setChannelType(isset($param['channelType']) ? trim($param['channelType']) : '');

        $request->setCustomParameters(self::$userRemark);
        $request->setGenerateMobile(false);
        $request->setGenerateSchemaUrl(false);
        $request->setGenerateShortUrl(true);
        $request->setPIdList([self::$pid]);
        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        //common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content);
        return data_return('ok', 0, $content['cms_promotion_url_generate_response']['url_list']);
    }


    //pdd.ddk.resource.url.gen生成多多进宝频道推广
    public function get_resource_url($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkResourceUrlGenRequest();
        $request->setCustomParameters(self::$userRemark);
        $request->setPid(self::$pid);
        $request->setGenerateWeApp(false);
        //频道来源：4-限时秒杀,39997-充值中心, 39998-转链type，39999-电器城，39996-百亿补贴，40000-领券中心
        $request->setResourceType(isset($param['channelType']) ? intval($param['channelType']) : '4');
        if (!empty($param['url'])) {
            $request->setUrl($param['url']);
        }

        // $request->setUrl('str');//原链接

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        //common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content);
        return data_return('ok', 0, $content['resource_url_response']);
    }

    //本功能适用于采集群等场景。将其他推广者的推广链接转换成自己的；通过此api，可以将他人的招商推广链接，转换成自己的招商推广链接。
    public function unit_url($arg = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsZsUnitUrlGenRequest();
        $request->setCustomParameters(self::$userRemark);
        $request->setPid(self::$pid);
        $request->setSourceUrl($arg['url']);

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        //common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content);
        return data_return('ok', 0, $content['goods_zs_unit_generate_response']);
    }

    /**
     * 本接口用于将其他推广者的推广链接直接转换为自己的,只支持短链
     * @param array $param
     * @return array
     */
    public function get_anny_url($param = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);
        $request = new PddDdkGoodsZsUnitUrlGenRequest();
        $request->setPid(self::$pid);
        $request->setSourceUrl($param['url']);
        $request->setCustomParameters(self::$userRemark);

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        //common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content);
        return data_return('ok', 0, $content['goods_zs_unit_generate_response']);


    }

    //创建推广位
    public static function pid_create($name = '')
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsPidGenerateRequest();
        //默认创建个数
        $request->setNumber(1);
        $pIdNameList = array();
        $pIdNameList[] = $name ? $name : date('YmdHis');
        $request->setPIdNameList($pIdNameList);
        //$request->setMediaId(0);
        try {
            $response = $client->syncInvoke($request, self::$accessToken);
        } catch (\Com\Pdd\Pop\Sdk\PopHttpException $e) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $e->getMessage());
            return data_return('系统正忙', -1, $e->getMessage());
        }
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        return data_return('ok', 0, $content['p_id_generate_response']);
    }

    //查询推广位
    public static function pid_query($arg = [])
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkGoodsPidQueryRequest();
        if (!empty($arg['page'])) {
            $request->setPage(intval($arg['page']));
        }
        if (!empty($arg['page_size'])) {
            $request->setPageSize(intval($arg['page_size']));
        }
        if (!empty($arg['pid_list'])) {
            $request->setPidList($arg['pid_list']);
        }
        //推广位状态：0-正常，1-封禁
        if (!empty($arg['status'])) {
            $request->setStatus($arg['status']);
        }

        try {
            $response = $client->syncInvoke($request, self::$accessToken);
        } catch (\Com\Pdd\Pop\Sdk\PopHttpException $e) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $e->getMessage());
            return data_return('系统正忙', -1, $e->getMessage());
        }
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }
        return data_return('ok', 0, $content['p_id_query_response']);
    }

    //获取备案授权url
    public function auth_url()
    {
        $client = new PopHttpClient(self::$clientId, self::$clientSecret);

        $request = new PddDdkRpPromUrlGenerateRequest();
        $request->setChannelType(10);
        $request->setCustomParameters(self::$userRemark);
        $request->setGenerateQqApp(false);
        $request->setGenerateSchemaUrl(false);
        $request->setGenerateShortUrl(false);
        $request->setGenerateWeApp(false);
        $pIdList = array();
        $pIdList[] = self::$pid;
        $request->setPIdList($pIdList);

        $response = $client->syncInvoke($request, self::$accessToken);
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            common::add_log('pddErr:' . __CLASS__ . __FUNCTION__ . __LINE__, $content['error_response']);
            return data_return('系统正忙', -1, $content['error_response']);
        }

       return data_return_arr('ok',0,$content['rp_promotion_url_generate_response']['url_list'][0]);
    }

}