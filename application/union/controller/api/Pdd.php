<?php

namespace app\union\controller\api;


use app\server\GuideServer;

class Pdd extends DgApiBase
{
    public function superSearch()
    {
        $arg['keyword'] = !empty($this->params['keyWords']) ? $this->params['keyWords'] : '';
        $arg['withCoupon'] = !empty($this->params['withCoupon']) ? 1 : 0;
        $arg['catId'] = !empty($this->params['catId']) ? $this->params['catId'] : '';
        $sort = !empty($this->params['sort']) ? $this->params['sort'] : 0;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['limit']) ? $this->params['limit'] : 20;
        if ($sort == 'total_sales_des') {
            $arg['sort'] = 6;
        } elseif ($sort == 'renqi') {
            $arg['sort'] = 0;
        } elseif ($sort == 'price_asc') {
            $arg['sort'] = 3;
        } elseif ($sort == 'price_des') {
            $arg['sort'] = 4;
        } else {
            $arg['sort'] = 0;
        }
        $req = $this->pdd->goods_list_search($arg);
        $lists = [];
        if (!empty($req['data']['list'])) {
            foreach ($req['data']['list'] as $item) {
                $lists[] = GuideServer::format_pdd_item($item);
            }
        }

        data_return('ok', 0, [
            'goodsList' => $lists,
        ]);
    }

    public function getGoodsDetails()
    {
        $req = $this->pdd->goods_detail(
            ['gsign' => $this->params['goodsSign']]
        );
        if (!empty($req['code'])) {
            data_return('商品已抢光啦', -1);
        }
        $goods = $req['data'];
        $data = GuideServer::format_pdd_item($goods);
        $data = array_merge($data,[
            'itemLink' => '',
            'cid' => $goods['category_id'],
            'marketingMainPic' => $goods['goods_image_url'],
            'video' => !empty($goods['video_urls']) ? $goods['video_urls'] : '',
            'couponEndTime' => $goods['coupon_end_time'] ? date('Y-m-d', $goods['coupon_end_time']) : '',
            'couponStartTime' => $goods['coupon_start_time'] ? date('Y-m-d', $goods['coupon_start_time']) : '',
            'sellerId' => '',
            'descScore' => null,
            'shipScore' => null,
            'serviceScore' => null,
            'shopLogo' => $goods['mall_img_url'],
            'detailPics' => '',
            'imgs' => $goods['goods_gallery_urls'],
            'isCollection' => null,
        ]);

        data_return('ok', 0, $data);
    }

    public function getCategoryList()
    {
        $data = \GuzzleHttp\json_decode(' [ { "id": 239, "name": "男装", "level": 1, "parentId": 0 }, { "id": 2603, "name": "办公用品", "level": 1, "parentId": 0 }, { "id": 2629, "name": "文化用品", "level": 1, "parentId": 0 }, { "id": 2933, "name": "3C数码配件", "level": 1, "parentId": 0 }, { "id": 5217, "name": "古董文玩/邮币/字画/收藏", "level": 1, "parentId": 0 }, { "id": 5752, "name": "影音电器", "level": 1, "parentId": 0 }, { "id": 5834, "name": "手机", "level": 1, "parentId": 0 }, { "id": 5839, "name": "二手数码", "level": 1, "parentId": 0 }, { "id": 5851, "name": "电脑", "level": 1, "parentId": 0 }, { "id": 5906, "name": "数码相机/单反相机/摄像机", "level": 1, "parentId": 0 }, { "id": 5921, "name": "智能设备", "level": 1, "parentId": 0 }, { "id": 5955, "name": "厨房电器", "level": 1, "parentId": 0 }, { "id": 6076, "name": "大家电", "level": 1, "parentId": 0 }, { "id": 6128, "name": "生活电器", "level": 1, "parentId": 0 }, { "id": 6209, "name": "个人护理保健", "level": 1, "parentId": 0 }, { "id": 6290, "name": "网络设备", "level": 1, "parentId": 0 }, { "id": 6398, "name": "零食/坚果/特产", "level": 1, "parentId": 0 }, { "id": 6536, "name": "咖啡/麦片/冲饮", "level": 1, "parentId": 0 }, { "id": 6586, "name": "茶", "level": 1, "parentId": 0 }, { "id": 6630, "name": "粮油米面/南北干货/调味品", "level": 1, "parentId": 0 }, { "id": 6758, "name": "酒类", "level": 1, "parentId": 0 }, { "id": 6785, "name": "保健食品/膳食营养补充食品", "level": 1, "parentId": 0 }, { "id": 6883, "name": "传统滋补品", "level": 1, "parentId": 0 }, { "id": 7323, "name": "电子元器件市场", "level": 1, "parentId": 0 }, { "id": 7629, "name": "摩托车/装备/配件", "level": 1, "parentId": 0 }, { "id": 7639, "name": "汽车/用品/配件/改装", "level": 1, "parentId": 0 }, { "id": 8172, "name": "水产肉类/新鲜蔬果/熟食", "level": 1, "parentId": 0 }, { "id": 8439, "name": "女装/女士精品", "level": 1, "parentId": 0 }, { "id": 8502, "name": "新车/二手车", "level": 1, "parentId": 0 }, { "id": 8508, "name": "流行男鞋", "level": 1, "parentId": 0 }, { "id": 8509, "name": "女鞋", "level": 1, "parentId": 0 }, { "id": 8538, "name": "箱包皮具/女包/男包", "level": 1, "parentId": 0 }, { "id": 8583, "name": "内衣裤袜", "level": 1, "parentId": 0 }, { "id": 8634, "name": "腕表眼镜", "level": 1, "parentId": 0 }, { "id": 8669, "name": "服饰配件", "level": 1, "parentId": 0 }, { "id": 8721, "name": "本地化生活服务", "level": 1, "parentId": 0 }, { "id": 8722, "name": "电影/演出/体育赛事", "level": 1, "parentId": 0 }, { "id": 8723, "name": "个性定制/设计服务", "level": 1, "parentId": 0 }, { "id": 8724, "name": "购物卡/礼品卡/代金券", "level": 1, "parentId": 0 }, { "id": 8725, "name": "婚庆/摄影/摄像服务", "level": 1, "parentId": 0 }, { "id": 8726, "name": "教育培训", "level": 1, "parentId": 0 }, { "id": 8727, "name": "景点门票/周边游", "level": 1, "parentId": 0 }, { "id": 8728, "name": "旅游路线/商品/服务", "level": 1, "parentId": 0 }, { "id": 8729, "name": "生活缴费", "level": 1, "parentId": 0 }, { "id": 8730, "name": "影视/会员/腾讯QQ专区", "level": 1, "parentId": 0 }, { "id": 8731, "name": "特价酒店/客栈/公寓旅馆", "level": 1, "parentId": 0 }, { "id": 8732, "name": "网络服务/软件", "level": 1, "parentId": 0 }, { "id": 8733, "name": "网上营业厅", "level": 1, "parentId": 0 }, { "id": 8734, "name": "休闲娱乐", "level": 1, "parentId": 0 }, { "id": 8736, "name": "游戏服务/直播", "level": 1, "parentId": 0 }, { "id": 9313, "name": "床上用品", "level": 1, "parentId": 0 }, { "id": 9314, "name": "电子/电工", "level": 1, "parentId": 0 }, { "id": 9315, "name": "基础建材", "level": 1, "parentId": 0 }, { "id": 9316, "name": "家居饰品", "level": 1, "parentId": 0 }, { "id": 9317, "name": "家装灯饰光源", "level": 1, "parentId": 0 }, { "id": 9318, "name": "家装主材", "level": 1, "parentId": 0 }, { "id": 9319, "name": "居家布艺", "level": 1, "parentId": 0 }, { "id": 9320, "name": "全屋定制", "level": 1, "parentId": 0 }, { "id": 9321, "name": "商业/办公家具", "level": 1, "parentId": 0 }, { "id": 9322, "name": "特色手工艺", "level": 1, "parentId": 0 }, { "id": 9323, "name": "五金工具", "level": 1, "parentId": 0 }, { "id": 9324, "name": "住宅家具", "level": 1, "parentId": 0 }, { "id": 11683, "name": "电动车/配件/交通工具", "level": 1, "parentId": 0 }, { "id": 11684, "name": "户外/登山/旅行野营用品", "level": 1, "parentId": 0 }, { "id": 11685, "name": "运动/瑜伽/健身/球类", "level": 1, "parentId": 0 }, { "id": 11686, "name": "运动包/户外包/配件", "level": 1, "parentId": 0 }, { "id": 11687, "name": "运动服/休闲服", "level": 1, "parentId": 0 }, { "id": 11688, "name": "运动鞋", "level": 1, "parentId": 0 }, { "id": 11689, "name": "自行车/骑行装备/零配件", "level": 1, "parentId": 0 }, { "id": 13176, "name": "OTC药品", "level": 1, "parentId": 0 }, { "id": 13177, "name": "精制中药材", "level": 1, "parentId": 0 }, { "id": 13178, "name": "隐形眼镜/护理液", "level": 1, "parentId": 0 }, { "id": 14697, "name": "奶粉/辅食/营养品/零食", "level": 1, "parentId": 0 }, { "id": 14740, "name": "婴童用品", "level": 1, "parentId": 0 }, { "id": 14933, "name": "童鞋/婴儿鞋/亲子鞋", "level": 1, "parentId": 0 }, { "id": 14966, "name": "童装/婴儿装/亲子装", "level": 1, "parentId": 0 }, { "id": 15083, "name": "玩具/童车/益智/积木/模型", "level": 1, "parentId": 0 }, { "id": 15356, "name": "孕产妇用品/孕妇装/营养", "level": 1, "parentId": 0 }, { "id": 15543, "name": "书籍/杂志/报纸", "level": 1, "parentId": 0 }, { "id": 16155, "name": "农机/农具/农膜", "level": 1, "parentId": 0 }, { "id": 16192, "name": "畜牧/养殖物资", "level": 1, "parentId": 0 }, { "id": 16209, "name": "农用物资", "level": 1, "parentId": 0 }, { "id": 16237, "name": "成人用品", "level": 1, "parentId": 0 }, { "id": 16288, "name": "宠物/宠物食品及用品", "level": 1, "parentId": 0 }, { "id": 16548, "name": "餐饮具", "level": 1, "parentId": 0 }, { "id": 16676, "name": "厨房/烹饪用具", "level": 1, "parentId": 0 }, { "id": 16794, "name": "收纳整理", "level": 1, "parentId": 0 }, { "id": 16901, "name": "家庭/个人清洁工具", "level": 1, "parentId": 0 }, { "id": 16989, "name": "居家日用", "level": 1, "parentId": 0 }, { "id": 17134, "name": "节庆用品/礼品", "level": 1, "parentId": 0 }, { "id": 17249, "name": "烟品/打火机/瑞士军刀", "level": 1, "parentId": 0 }, { "id": 17285, "name": "洗护清洁剂/卫生巾/纸/香薰", "level": 1, "parentId": 0 }, { "id": 17412, "name": "饰品/流行首饰/摆件/保养鉴定", "level": 1, "parentId": 0 }, { "id": 17455, "name": "珠宝/钻石/翡翠/黄金", "level": 1, "parentId": 0 }, { "id": 17671, "name": "鲜花园艺/绿植仿真/园林设备", "level": 1, "parentId": 0 }, { "id": 17803, "name": "乐器/吉他/钢琴/配件", "level": 1, "parentId": 0 }, { "id": 18088, "name": "装修设计/施工/监理", "level": 1, "parentId": 0 }, { "id": 18270, "name": "医疗健康服务", "level": 1, "parentId": 0 }, { "id": 18349, "name": "处方药", "level": 1, "parentId": 0 }, { "id": 18482, "name": "彩妆/香水/美妆工具", "level": 1, "parentId": 0 }, { "id": 18574, "name": "美容美体仪器", "level": 1, "parentId": 0 }, { "id": 18601, "name": "美发护发/假发", "level": 1, "parentId": 0 }, { "id": 18637, "name": "美容护肤/美体/精油", "level": 1, "parentId": 0 }, { "id": 18814, "name": "器械保健", "level": 1, "parentId": 0 }, { "id": 19298, "name": "婴童尿裤", "level": 1, "parentId": 0 }, { "id": 20078, "name": "汽车服务", "level": 1, "parentId": 0 }, { "id": 20118, "name": "交通出行", "level": 1, "parentId": 0 }, { "id": 20340, "name": "房地产", "level": 1, "parentId": 0 }, { "id": 20645, "name": "模玩/动漫/周边/cos/桌游", "level": 1, "parentId": 0 }, { "id": 21417, "name": "音乐/影视/明星/音像", "level": 1, "parentId": 0 }, { "id": 22561, "name": "包装用品", "level": 1, "parentId": 0 }, { "id": 22856, "name": "搬运/仓储/物流设备", "level": 1, "parentId": 0 }, { "id": 22881, "name": "标准件/零部件/工业耗材", "level": 1, "parentId": 0 }, { "id": 22931, "name": "机械设备", "level": 1, "parentId": 0 }, { "id": 22964, "name": "清洗/食品/商业设备", "level": 1, "parentId": 0 }, { "id": 22986, "name": "橡塑材料及制品", "level": 1, "parentId": 0 } ]', true);
        data_return('ok', 0, $data);
    }

    //转链
    public function generateUrl()
    {
        $this->pdd_check_auth();
        $req = $this->pdd->get_url([
            'group' => true,
            'gsign' => $this->params['goodsSign']
        ]);
        if (empty($req['data']['url'])) {
            data_return('服务正忙，请稍后', -1, $req);
        }

        $links = $req['data'];
        $data = [
            'schemaUrl' => !empty($links['schema_url']) ? $links['schema_url'] : $links['schema_url'],
            'mobileShortUrl' => $links['mobile_short_url'],
            'shortUrl' => $links['short_url'],
            'weAppWebViewShortUrl' => $links['we_app_web_view_short_url'],
            'weAppPagePath' => isset($links['we_app_info']['page_path']) ? $links['we_app_info']['page_path'] : ''
        ];
        data_return('ok', 0, $data);
    }

    //商品推荐-拼多多专属页面
    public function getGoodsRecommend()
    {
        $arg['catId'] = !empty($this->params['catId']) ? $this->params['catId'] : '';
        $arg['page'] = !empty($this->params['offset']) ? $this->params['offset'] : 1;
        $arg['pageSize'] = !empty($this->params['limit']) ? $this->params['limit'] : 20;

        if (empty($arg['catId'])){
            $req = $this->pdd->get_recommend_goods([
                'type' => 4,
                'page' => $arg['page'],
            ]);
        }else{
            $req = $this->pdd->goods_list_search($arg);
            $lists = [];
            if (!empty($req['data']['list'])) {
                foreach ($req['data']['list'] as $item) {
                    $lists[] = GuideServer::format_pdd_item($item);
                }
            }
        }

        if (!empty($req['data']['list'])) {
            foreach ($req['data']['list'] as $item) {
                $lists[] = GuideServer::format_pdd_item($item);
            }
        }
        data_return('ok', 0, [
            'goodsList' => $lists,
        ]);

    }


}