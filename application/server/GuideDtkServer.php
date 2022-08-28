<?php


namespace app\server;

use app\common\common;
use app\common\model\ConfigSys;

require_once EXTEND_PATH."dtk/vendor/autoload.php";
/**
 * 大淘客
 * Class GuideDtkServer
 * @package app\server
 */
class GuideDtkServer
{

    public $conf;
    //渠道
    public static $authLinkQuDao = 'https://mos.m.taobao.com/inviter/register?inviterCode=2ZNEFN&src=pub&app=common';
    //会员
    public static $authLinkHuiYuan = 'https://mos.m.taobao.com/inviter/recruit?inviterCode=83LFHL&src=pub&app=common';


    public function __construct()
    {
        $this->init_config();
    }

    //初始化配置
    private function init_config()
    {
        $data = (new ConfigSys())->get_value(ConfigSys::key_union);
        $this->conf = [
            'appkey' => !empty($data['dtk_appkey']) ? trim($data['dtk_appkey']) : '',
            'pid' => !empty($data['dtk_pid']) ? trim($data['dtk_pid']) : '',
            'appsecret' => !empty($data['dtk_appsecret']) ? trim($data['dtk_appsecret']) : '',
            'inviterCode' => !empty($data['dtk_inviterCode']) ? trim($data['dtk_inviterCode']) : '',
            'pdd_pid' => !empty($data['dtk_pdd_pid']) ? trim($data['dtk_pdd_pid']) : '',
            'jd_pid' => !empty($data['dtk_jd_pid']) ? trim($data['dtk_jd_pid']) : '',
            'jd_unionId' =>!empty($data['dtk_jd_unionId']) ? trim($data['dtk_jd_unionId']) : '',
        ];
    }

    //淘宝超级搜索
    public function tb_goods_super_search($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetGoodsListSuperSearch();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.3.0');
        $param = [
            'keyWords' => !empty($arg['keyword']) ? $arg['keyword'] : '热销'
        ];
        //搜索类型：0-综合结果，1-大淘客商品，2-联盟商品
        $param['type'] = 0;
        if (!empty($arg['type'])) {
            $param['type'] = intval($arg['type']);
        }
        //
        //排序字段信息 销量（total_sales） 价格（price），排序_des（降序），排序_asc（升序），示例：升序查询销量total_sales_asc 新增排序字段和排序方式，默认为0，0-综合排序，1-销量从高到低，2-销量从低到高，3-佣金比例从低到高，4-佣金比例从高到低，5-价格从高到低，6-价格从低到高(2021/1/15新增字段，之前的排序方式也可以使用)
        if (!empty($arg['sort'])) {
            $param['sort'] = $arg['sort'];
        }
        //活动id，多个使用,分隔符。示例1,2,3（12/7新增字段）
        if (!empty($arg['activityId'])) {
            $param['activityId'] = $arg['activityId'];
        }
        //是否有券，1为有券，默认为全部
        if (!empty($arg['hasCoupon'])) {
            $param['hasCoupon'] = $arg['hasCoupon'];
        }
        $param['pageId'] = !empty($arg['pageId']) ? intval($arg['pageId']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];

    }

    //相似商品-猜你喜欢
    public function tb_similar_goods($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetListSimilerGoods();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.2.2');

        $param = [
            'id' => $arg['goodsId']
        ];
        if (!empty($arg['size'])) {
            $param['size'] = $arg['size'];
        }
        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    //淘宝商品
    public function goods_tb_list($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetGoodsList();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.2.4');

        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;
        //排序方式，默认为0，0-综合排序，1-商品上架时间从高到低，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
        $param['sort'] = !empty($arg['sort']) ? intval($arg['sort']) : 0;

        //大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
        $param['cids'] = !empty($arg['cids']) ? intval($arg['cids']) : '';
        //大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
        $param['subcid'] = !empty($arg['subcid']) ? intval($arg['subcid']) : '';
        //商品卖点，1.拍多件活动；2.多买多送；3.限量抢购；4.额外满减；6.买商品礼赠
        $param['specialId'] = !empty($arg['specialId']) ? intval($arg['specialId']) : '';

        //1-聚划算商品，0-所有商品，不填默认为0
        $param['juHuaSuan'] = !empty($arg['juHuaSuan']) ? intval($arg['juHuaSuan']) : 0;
        //1-淘抢购商品，0-所有商品，不填默认为0
        $param['taoQiangGou'] = !empty($arg['taoQiangGou']) ? intval($arg['taoQiangGou']) : 0;
        //1-天猫商品， 0-非天猫商品，不填默认所有商品
        $param['tmall'] = !empty($arg['tmall']) ? intval($arg['tmall']) : '';

        //1-天猫超市商品， 0-所有商品，不填默认为0
        $param['tchaoshi'] = !empty($arg['tchaoshi']) ? intval($arg['tchaoshi']) : '';

        //1-金牌卖家商品，0-所有商品，不填默认为0
        $param['goldSeller'] = !empty($arg['goldSeller']) ? intval($arg['goldSeller']) : 0;

        //1-海淘商品， 0-所有商品，不填默认为0
        $param['haitao'] = !empty($arg['haitao']) ? intval($arg['haitao']) : 0;

        //1-预告商品，0-所有商品，不填默认为0
        $param['pre'] = !empty($arg['pre']) ? intval($arg['pre']) : 0;

        //1-活动预售商品，0-所有商品，不填默认为0。（10.30新增字段）
        $param['preSale'] = !empty($arg['preSale']) ? intval($arg['preSale']) : 0;

        //1-品牌商品，0-所有商品，不填默认为0
        $param['brand'] = !empty($arg['brand']) ? intval($arg['brand']) : 0;
        //当brand传入0时，再传入brandIds可能无法获取结果。品牌id可以传多个，以英文逗号隔开，如：”345,321,323”
        if (!empty($arg['brandIds'])) {
            $param['brandIds'] = $arg['brandIds'];
        }

        //价格（券后价）下限 Number
        if (!empty($arg['priceLowerLimit'])) {
            $param['priceLowerLimit'] = $arg['priceLowerLimit'];
        }
        //价格（券后价）上限
        if (!empty($arg['priceUpperLimit'])) {
            $param['priceUpperLimit'] = $arg['priceUpperLimit'];
        }
        //最低优惠券面额
        if (!empty($arg['couponPriceLowerLimit'])) {
            $param['couponPriceLowerLimit'] = $arg['couponPriceLowerLimit'];
        }
        //最低佣金比率
        if (!empty($arg['commissionRateLowerLimit'])) {
            $param['commissionRateLowerLimit'] = $arg['commissionRateLowerLimit'];
        }
        //最低月销量
        if (!empty($arg['monthSalesLowerLimit'])) {
            $param['monthSalesLowerLimit'] = $arg['monthSalesLowerLimit'];
        }
        //偏远地区包邮，1-是，0-非偏远地区，不填默认所有商品
        if (!empty($arg['freeshipRemoteDistrict'])) {
            $param['freeshipRemoteDistrict'] = $arg['freeshipRemoteDistrict'];
        }
        //定向佣金类型，3查询定向佣金商品，否则查询全部商品
        if (!empty($arg['directCommissionType'])) {
            $param['directCommissionType'] = $arg['directCommissionType'];
        }
        //是否为精选商品，默认全部，1-精选商品
        if (!empty($arg['choice'])) {
            $param['choice'] = $arg['choice'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }

        if (!empty($arg['from']) && $arg['from'] == 'dgapp') {
            cache($key, $res['data'], 60);
            return $res['data'];
        }
        $goods = [];
        if (!empty($res['data']['list'])) {
            foreach ($res['data']['list'] as $val) {
                $goods[] = GuideServer::format_tb_item($val);
            }
        }
        $data = [
            'pageId' => $res['data']['pageId'],
            'total' => $res['data']['totalNum'],
            'goScroll' => $res['data']['goScroll'],
            'goods' => $goods,
        ];
        cache($key, $data, 60);
        return $data;
    }

    //每日爆品推荐
    public function tb_explosive_goods($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetExplosiveGoodsList();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;
        //价格区间，1表示10~20元区；2表示20~40元区；3表示40元以上区；默认为1
        if (!empty($arg['PriceCid'])) {
            $param['PriceCid'] = $arg['PriceCid'];
        }
        if (!empty($arg['cids'])) {
            $param['cids'] = $arg['cids'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }


    //热搜记录
    public function tb_hot_keyword($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . 'abc' . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetTop100();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.1');
        //1：买家热搜榜（默认）、2：淘客热搜榜
        $param['type'] = 1;
        if (!empty($arg['type'])) {
            $param['type'] = $arg['type'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //联想词
    public function tb_suggestion($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . 'abcD' . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetGoodsSearchSuggestion();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.2');
        $param['keyWords'] = $arg['keyWords'];
        //当前搜索API类型：1.大淘客搜索 2.联盟搜索 3.超级搜索
        $param['type'] = 2;
        if (!empty($arg['type'])) {
            $param['type'] = $arg['type'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //热搜榜
    public function tb_hot_keywords($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetListHotWords();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.1');
        //1：买家热搜榜（默认）、2：淘客热搜榜
        $param['type'] = 1;
        if (!empty($arg['type'])) {
            $param['type'] = $arg['type'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //高佣精选
    public function tb_height_commission_goods($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetListHeightCommission();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;
        //大淘客一级类目id，仅对实时榜单、全天榜单有效
        if (!empty($arg['cid'])) {
            $param['cid'] = $arg['cid'];
        }
        //排序：默认按佣金比例降序1-按销量降序，2-按销量升序，3-按佣金比例降序，4-按佣金比例升序
        if (!empty($arg['sort'])) {
            $param['sort'] = $arg['sort'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    //榜单
    public function tb_ranking_goods($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetRankingList();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.3.0');
        $param['rankType'] = 1;
        //榜单类型，1.实时榜 2.全天榜 3.热推榜 5.热词飙升榜 6.热词排行榜 7.综合热搜榜
        if (!empty($arg['rankType'])) {
            $param['rankType'] = $arg['rankType'];
        }
        //大淘客一级类目id，仅对实时榜单、全天榜单有效
        if (!empty($arg['cid'])) {
            $param['cid'] = $arg['cid'];
        }
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;

        if (!empty($arg['cids'])) {
            $param['cids'] = $arg['cids'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 120);
        return $res['data'];
    }

    //9.9包邮
    public function tb_nine_goods($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetNineOpGoodsList();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v2.0.0');
        //9.9精选的类目id，分类id请求详情：-1-精选，1 -5.9元区，2 -9.9元区，3 -19.9元区（调整字段）
        $param['nineCid'] = $arg['nineCid'];
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;
        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }

        cache($key, $res['data'], 180);
        return $res['data'];
    }

    //淘宝搜索
    public function goods_tb_search($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetDtkSearchGoods();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.2.4');
        $param['keyWords'] = !empty($arg['keyword']) ? trim($arg['keyword']) : '日用';
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;
        //排序方式，默认为0，0-综合排序，1-商品上架时间从新到旧，2-销量从高到低，3-领券量从高到低，4-佣金比例从高到低，5-价格（券后价）从高到低，6-价格（券后价）从低到高
        $param['sort'] = !empty($arg['sort']) ? intval($arg['sort']) : 0;

        //大淘客的一级分类id，如果需要传多个，以英文逗号相隔，如：”1,2,3”。当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
        $param['cids'] = !empty($arg['cids']) ? intval($arg['cids']) : '';
        //大淘客的二级类目id，通过超级分类API获取。仅允许传一个二级id，当一级类目id和二级类目id同时传入时，会自动忽略二级类目id
        $param['subcid'] = !empty($arg['subcid']) ? intval($arg['subcid']) : '';
        //商品卖点，1.拍多件活动；2.多买多送；3.限量抢购；4.额外满减；6.买商品礼赠
        $param['specialId'] = !empty($arg['specialId']) ? intval($arg['specialId']) : '';

        //1-聚划算商品，0-所有商品，不填默认为0
        $param['juHuaSuan'] = !empty($arg['juHuaSuan']) ? intval($arg['juHuaSuan']) : 0;
        //1-淘抢购商品，0-所有商品，不填默认为0
        $param['taoQiangGou'] = !empty($arg['taoQiangGou']) ? intval($arg['taoQiangGou']) : 0;
        //1-天猫商品， 0-非天猫商品，不填默认所有商品
        $param['tmall'] = !empty($arg['tmall']) ? intval($arg['tmall']) : '';

        //1-天猫超市商品， 0-所有商品，不填默认为0
        $param['tchaoshi'] = !empty($arg['tchaoshi']) ? intval($arg['tchaoshi']) : '';

        //1-金牌卖家商品，0-所有商品，不填默认为0
        $param['goldSeller'] = !empty($arg['goldSeller']) ? intval($arg['goldSeller']) : 0;

        //1-海淘商品， 0-所有商品，不填默认为0
        $param['haitao'] = !empty($arg['haitao']) ? intval($arg['haitao']) : 0;

        //1-预告商品，0-所有商品，不填默认为0
        $param['pre'] = !empty($arg['pre']) ? intval($arg['pre']) : 0;

        //1-活动预售商品，0-所有商品，不填默认为0。（10.30新增字段）
        $param['preSale'] = !empty($arg['preSale']) ? intval($arg['preSale']) : 0;

        //1-品牌商品，0-所有商品，不填默认为0
        $param['brand'] = !empty($arg['brand']) ? intval($arg['brand']) : 0;
        //当brand传入0时，再传入brandIds可能无法获取结果。品牌id可以传多个，以英文逗号隔开，如：”345,321,323”
        if (!empty($arg['brandIds'])) {
            $param['brandIds'] = $arg['brandIds'];
        }

        //价格（券后价）下限 Number
        if (!empty($arg['priceLowerLimit'])) {
            $param['priceLowerLimit'] = $arg['priceLowerLimit'];
        }
        //价格（券后价）上限
        if (!empty($arg['priceUpperLimit'])) {
            $param['priceUpperLimit'] = $arg['priceUpperLimit'];
        }
        //最低优惠券面额
        if (!empty($arg['couponPriceLowerLimit'])) {
            $param['couponPriceLowerLimit'] = $arg['couponPriceLowerLimit'];
        }
        //最低佣金比率
        if (!empty($arg['commissionRateLowerLimit'])) {
            $param['commissionRateLowerLimit'] = $arg['commissionRateLowerLimit'];
        }
        //最低月销量
        if (!empty($arg['monthSalesLowerLimit'])) {
            $param['monthSalesLowerLimit'] = $arg['monthSalesLowerLimit'];
        }
        //偏远地区包邮，1-是，0-非偏远地区，不填默认所有商品
        if (!empty($arg['freeshipRemoteDistrict'])) {
            $param['freeshipRemoteDistrict'] = $arg['freeshipRemoteDistrict'];
        }
        //定向佣金类型，3查询定向佣金商品，否则查询全部商品
        if (!empty($arg['directCommissionType'])) {
            $param['directCommissionType'] = $arg['directCommissionType'];
        }
        //是否为精选商品，默认全部，1-精选商品
        if (!empty($arg['choice'])) {
            $param['choice'] = $arg['choice'];
        }

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }

        $goods = [];
        if (!empty($res['data']['list'])) {
            foreach ($res['data']['list'] as $val) {
                $goods[] = GuideServer::format_tb_item($val);
            }
        }
        $data = [
            'pageId' => $res['data']['pageId'],
            'total' => $res['data']['totalNum'],
            'goods' => $goods,
        ];
        cache($key, $data, 60);
        return $data;
    }

    //淘宝商品详细
    public function goods_tb_detail($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetGoodsDetails();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.2.3');
        $param = [];
        if (!empty($arg['id'])) {
            $param['id'] = $arg['id'];
        }
        if (!empty($arg['goodsId'])) {
            $param['goodsId'] = $arg['goodsId'];
        }
        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }

        cache($key, $res['data'], 300);
        return $res['data'];
    }

    //品牌栏目
    public function tb_brand_columns($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetBrandColumnList();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        //大淘客分类id
        $param['cid'] = $arg['cid'];
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }

        cache($key, $res['data'], 300);
        return $res['data'];
    }

    //品牌详情
    public function tb_brand_goods($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetBrandList();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        //大淘客分类id
        $param['brandId'] = $arg['brandId'];
        $param['pageId'] = !empty($arg['page']) ? intval($arg['page']) : 1;
        $param['pageSize'] = !empty($arg['pageSize']) ? intval($arg['pageSize']) : 20;

        $res = json_decode($client->setParams($param)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }

        cache($key, $res['data'], 300);
        return $res['data'];
    }

    //淘宝分类-超级分类
    public function tb_super_category()
    {
        $key = md5(__FILE__ . __FUNCTION__);
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetSuperCategory();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.1.0');

        $res = json_decode($client->request(), true);
        if (!empty($res['code'])) {
            return [];
        }
        cache($key, $res['data'], 86400);
        return $res['data'];
    }

    //淘宝分类-超级分类
    public function tb_banner()
    {
        $client = new \GetCarouseList();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v2.0.0');

        $res = json_decode($client->request(), true);
        if (!empty($res['code'])) {
            return [];
        }

        return $res['data'];
    }

    //转链
    public function link_tb($param = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($param));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetPrivilegeLink();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.3.1');
        $arg['pid'] = $this->conf['pid'];

        $arg['goodsId'] = $param['goodsId'];
        if (!empty($param['special_id'])) {
            $arg['specialId'] = $param['special_id'];
        }
        if (!empty($param['channelId'])) {
            $arg['channelId'] = $param['channelId'];
        }
        //淘宝客外部用户标记，如自身系统账户ID；微信ID等
        if (!empty($param['uid'])) {
            $arg['externalId'] = $param['uid'];
        }

        $res = json_decode($client->setParams($arg)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //拼多多商品搜索//https://www.dataoke.com/pmc/api-d.html?id=71
    public function pdd_search_goods($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetPddGoodsSearch();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v2.0.0');
        $param = [];
        //活动商品标记数组，例：[4,7]， 4-秒杀，7-百亿补贴，31-品牌黑标，10564-精选爆品-官方直推爆款，10584-精选爆品-团长推荐， 24-品牌高佣，20-行业精选，21-金牌商家，10044-潜力爆品，10475-爆品上新，其他的值请忽略
        if (!empty($arg['activityTags'])) {
            $param['activityTags'] = $arg['activityTags'];
        }

        //自定义屏蔽一级/二级/三级类目ID，自定义数量不超过20个;
        if (!empty($arg['blockCats'])) {
            $param['blockCats'] = $arg['blockCats'];
        }
        //屏蔽商品类目包：1-拼多多小程序屏蔽的类目&关键词;2-虚拟类目;3-医疗器械;4-处方药;5-非处方药
        if (!empty($arg['blockCatPackages'])) {
            $param['blockCatPackages'] = $arg['blockCatPackages'];
        }
        //商品类目ID
        if (!empty($arg['catId'])) {
            $param['catId'] = $arg['catId'];
        }
        //商品goodsSign列表 访问括号内链接可查看字段相关说明(http://www.dataoke.com/kfpt/open-gz.html?id=100)
        if (!empty($arg['goodsSignList'])) {
            $param['goodsSignList'] = $arg['goodsSignList'];
        }
        if (!empty($arg['isBrandGoods'])) {
            $param['isBrandGoods'] = $arg['isBrandGoods'];
        }
        //商品关键词(暂不支持goodid进行搜索，如需定向搜索商品建议使用goodsign进行搜索)
        if (!empty($arg['keyword'])) {
            $param['keyword'] = $arg['keyword'];
        }
        //翻页时建议填写前页返回的list_id值
        if (!empty($arg['listId'])) {
            $param['listId'] = $arg['listId'];
        }
        //店铺类型数组 1-个人，2-企业，3-旗舰店，4-专卖店，5-专营店，6-普通店（未传为全部）
        if (!empty($arg['merchantTypeList'])) {
            $param['merchantTypeList'] = $arg['merchantTypeList'];
        }
        //默认值1，商品分页数
        if (!empty($arg['page'])) {
            $param['page'] = $arg['page'];
        }

        if (!empty($arg['pageSize'])) {
            $param['pageSize'] = $arg['pageSize'];
        }
        //筛选范围列表 样例：[{"range_id":0,"range_from":1,"range_to":1500}, {"range_id":1,"range_from":1,"range_to":1500}]
        if (!empty($arg['rangeList'])) {
            $param['rangeList'] = $arg['rangeList'];
        }

        //排序方式:0-综合排序;2-按佣金比例降序;3-按价格升序;4-按价格降序;6-按销量降序;9-券后价升序排序;10-券后价降序排序;16-店铺描述评分降序
        if (isset($arg['sortType'])) {
            $param['sortType'] = $arg['sortType'];
        }
        //是否只返回优惠券的商品，0返回所有商品，1只返回有优惠券的商品
        if (!empty($arg['withCoupon'])) {
            $param['withCoupon'] = $arg['withCoupon'];
        }
        //是否返回分类信息数据 0-否；1-是
        if (!empty($arg['withCategoryInfo'])) {
            $param['withCategoryInfo'] = $arg['withCategoryInfo'];
        }
        $param['pid'] = $this->conf['pdd_pid'];

        if (!empty($arg['customParameters'])) {
            $param['customParameters'] = $arg['customParameters'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    public function pdd_goods_detail($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetPddProductDetails();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v2.0.0');
        $param = [];

        if (!empty($arg['goodsSign'])) {
            $param['goodsSign'] = $arg['goodsSign'];
        }
        //搜索id，建议填写，可提高收益。可通过pdd.ddk.goods.recommend.get、pdd.ddk.goods.search、pdd.ddk.top.goods.list.query等接口获取
        if (!empty($arg['searchId'])) {
            $param['searchId'] = $arg['searchId'];
        }
        //商品主图类型：1-场景图，2-白底图，默认为0
        if (!empty($arg['goodsImgType'])) {
            $param['goodsImgType'] = $arg['goodsImgType'];
        }
        $param['goodsId'] = '';
        if (!empty($arg['goodsId'])) {
            $param['goodsId'] = $arg['goodsId'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [$res];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    //拼多多分类
    public function pdd_category($parentId = 0)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode([$parentId]));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \PddCategorySearch();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [];
        if (!empty($parentId)) {
            $param['parentId'] = $parentId;
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //拼多多商品转链
    public function pdd_goods_url($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetGoodsPromGenerate();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v2.0.0');
        $param = [
            'pid' => $this->conf['pdd_pid'],
            'goodsSign' => $arg['goodsSign'],
        ];
        if (!empty($arg['customParameters'])) {
            $param['customParameters'] = $arg['customParameters'];
        }
        if (!empty($arg['zsDuoId'])) {
            $param['zsDuoId'] = $arg['zsDuoId'];
        }
        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . __FUNCTION__ . __LINE__), [$res, $param]);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //京东商品搜索
    public function jd_goods_search($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetJdGoodsSearch();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [
            'pid' => $this->conf['jd_pid']
        ];
        if (!empty($arg['cid1'])) {
            $param['cid1'] = $arg['cid1'];
        }
        if (!empty($arg['pageId'])) {
            $param['pageId'] = $arg['pageId'];
        }
        if (!empty($arg['pageSize'])) {
            $param['pageSize'] = min($arg['pageSize'], 30);
        }
        //skuid集合(一次最多支持查询100个sku)，多个使用“,”分隔符
        if (!empty($arg['skuIds'])) {
            $param['skuIds'] = $arg['skuIds'];
        }
        //商品类型：自营[g]，POP[p]
        if (!empty($arg['owner'])) {
            $param['owner'] = $arg['owner'];
        }


        if (!empty($arg['keyword'])) {
            $param['keyword'] = $arg['keyword'];
        }
        //京喜商品类型，1京喜、2京喜工厂直供、3京喜优选（包含3时可在京东APP购买），入参多个值表示或条件查询
        if (!empty($arg['jxFlags'])) {
            $param['jxFlags'] = $arg['jxFlags'];
        }
        //排序字段(price：单价, commissionShare：佣金比例, commission：佣金， inOrderCount30Days：30天引单量， inOrderComm30Days：30天支出佣金)
        if (!empty($arg['sortName'])) {
            $param['sortName'] = $arg['sortName'];
        }
        //asc：升序；desc：降序。默认降序
        if (!empty($arg['sort'])) {
            $param['sort'] = $arg['sort'];
        }
        if (!empty($arg['couponUrl'])) {
            $param['couponUrl'] = $arg['couponUrl'];
        }

        if (!empty($arg['isCoupon'])) {
            $param['isCoupon'] = 1;
        }
        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    //京东转链-批量
    public function jd_goods_url_batch($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetPromotionUnionConvert();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [
            'unionId' => $this->conf['jd_unionId'],
            //
            //待转链京东商品物料地址(需要urlencode，优惠券无法进行转链，无法转链的地址会按照原数据返回)
            'content' => $arg['content'],
        ];
        //新增推广位id （若无subUnionId权限，可入参该参数用来确定不同用户下单情况）,number类型
        if (!empty($arg['positionId'])) {
            $param['positionId'] = $arg['positionId'];
        }
        //联盟子推客身份标识（不能传入接口调用者自己的pid）
        if (!empty($arg['childPid'])) {
            $param['childPid'] = $arg['childPid'];
        }
        //子渠道标识，您可自定义传入字母、数字或下划线，最多支持80个字符，该参数会在订单行查询接口中展示，需要有权限才可使用
        if (!empty($arg['subUnionId'])) {
            $param['subUnionId'] = $arg['subUnionId'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //京东转链-单条
    public function jd_goods_url_single($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetSinglePromotionUnionConvert();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [
            'unionId' => $this->conf['jd_unionId'],
            //推广物料url，例如活动链接、商品链接等；不支持仅传入skuid
            'materialId' => $arg['materialId'],
        ];
        //新增推广位id （若无subUnionId权限，可入参该参数用来确定不同用户下单情况）,number类型
        if (!empty($arg['positionId'])) {
            $param['positionId'] = $arg['positionId'];
        }
        //联盟子推客身份标识（不能传入接口调用者自己的pid）
        if (!empty($arg['childPid'])) {
            $param['childPid'] = $arg['childPid'];
        }
        //子渠道标识，您可自定义传入字母、数字或下划线，最多支持80个字符，该参数会在订单行查询接口中展示，需要有权限才可使用
        if (!empty($arg['subUnionId'])) {
            $param['subUnionId'] = $arg['subUnionId'];
        }
        //转链类型，默认短链，短链有效期60天1：长链2：短链 3：长链+短链，
        if (!empty($arg['chainType'])) {
            $param['chainType'] = $arg['chainType'];
        }
        //礼金批次号
        if (!empty($arg['giftCouponKey'])) {
            $param['giftCouponKey'] = $arg['giftCouponKey'];
        }

        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 3600);
        return $res['data'];
    }

    //京东商品详情
    public function jd_goods_detail($arg)
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \GetJdGoodsDetails();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [
            //商品skuId，多个使用逗号分隔，最多支持10个skuId同时查询（需使用半角状态下的逗号）
            'skuIds' => $arg['skuIds'],
        ];
        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 180);
        return $res['data'];
    }

    //京东商品分类
    public function jd_category($arg = [])
    {
        $key = md5(__FILE__ . __FUNCTION__ . json_encode($arg));
        $cacheData = cache($key);
        if ($cacheData) {
            return $cacheData;
        }
        $client = new \JdCategorySearch();

        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $param = [];
        if (!empty($arg['parentId'])) {
            $param['parentId'] = $arg['parentId'];
        }
        //类目级别（类目级别 0，1，2 代表一、二、三级类目）
        if (!empty($arg['level'])) {
            $param['level'] = $arg['level'];
        }
        $res = json_decode($client->setParams($param)->request(), true);

        if (!empty($res['code'])) {
            common::add_log('大淘客' . strtolower(__CLASS__ . '/' . __FUNCTION__ . '/' . __LINE__), $res);
            return [];
        }
        cache($key, $res['data'], 60);
        return $res['data'];
    }

    //查询订单
    public function tb_orders($arg = [])
    {
        //https://openapi.dataoke.com/api/tb-service/get-privilege-link
        $client = new \GetOrderDetails();
        $client->setAppKey($this->conf['appkey']);
        $client->setAppSecret($this->conf['appsecret']);
        $client->setVersion('v1.0.0');
        $arg['pid'] = $this->conf['pid'];


        if (empty($arg['queryType'])) {
            //查询时间类型，1：按照订单淘客创建时间查询，2:按照订单淘客付款时间查询，3:按照订单淘客结算时间查询，4：按照订单更新时间（5.27新增字段）
            $arg['queryType'] = 1;

        }
        if (empty($arg['orderScene'])) {
            $arg['orderScene'] = 1;//场景订单场景类型，1:常规订单，2:渠道订单，3:会员运营订单，默认为1


        }

        if (empty($arg['startTime'])) {
            $arg['startTime'] = date('Y-m-d H:i:s', strtotime("-3 hours", time()));
        }
        if (empty($arg['endTime'])) {
            $arg['endTime'] = date('Y-m-d H:i:s');
        }
        $client->setParams($arg);

        $res = json_decode($client->setParams($arg)->request(), true);
        if (!empty($res['code'])) {
            common::add_log('大淘客抓单', $res);
            return [];
        }

        return $res['data'];
    }

}