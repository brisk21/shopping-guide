<?php


namespace app\union\controller\api;

use app\common\model\UnionFeedback;
use think\Exception;

class Home extends DgApiBase
{
    //轮播
    public function banner_list()
    {
        $from = input('from', 'home');
        if ($from == 'user') {
            $data = \GuzzleHttp\json_decode('[{"id":6,"name":"个人中心2","type":2,"pic":"http://oss.dmjvip.com/download/advimg/20201024163338233.jpg","status":0,"clickCount":null,"url":"https%3A%2F%2Fcdn.java3.cn%2Fjd2020.html","note":null,"sort":null,"startTime":null,"endTime":"2021-11-26 11:33:00","createTime":"2020-10-10 15:21:12","urlType":"0","colour":null}]', true);
            $data = [];
        } elseif ($from == 'buycard') {
            $data = \GuzzleHttp\json_decode('[{"id":45,"name":"买买卡","type":8,"pic":"https://s3.ax1x.com/2020/12/08/rp0Dyj.png","status":0,"clickCount":null,"url":"https%3A%2F%2Fcdn.java3.cn%2Fjd2020.html","note":null,"sort":null,"startTime":null,"endTime":"2021-11-26 11:33:00","createTime":"2021-11-26 11:33:00","urlType":"0","colour":null}]', true);
        } else {
            //clickCount: null
            //colour: "#6f1301"
            //createTime: "2022-04-12 02:19:44"
            //endTime: null
            //id: 54
            //name: "webview同步官方轮播图-专题-口碑国货榜"
            //note: null
            //pic: "https://img.alicdn.com/imgextra/i3/2053469401/O1CN017ZFOYx2JJiA3Rivji_!!2053469401.png"
            //sort: 6
            //startTime: null
            //status: 0
            //type: 1
            //url: "https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D573"
            //urlType: "0"


            /**
             * activityId: "20150318020000721"
             * link: ""
             * sourceType: 2
             * topicId: -1
             * topicImage: "https://img.alicdn.com/imgextra/i3/2053469401/O1CN01iSmM9f2JJi7eWD1x7_!!2053469401.jpg"
             * topicName: "猫超"
             */
            /*$data = $this->dtk->tb_banner();
            if (!empty($data)){

            }*/

            $data = array(
                'doubleLineList' =>
                    array(),
                'singleLineList' =>
                    array(),
                'bottomBannerList' =>
                    array(),
                'topBannerList' =>
                    array(
                        0 =>
                            array(
                                'id' => 54,
                                'name' => 'webview同步官方轮播图-专题-口碑国货榜',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i3/2053469401/O1CN017ZFOYx2JJiA3Rivji_!!2053469401.png',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => 'https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D573',
                                'note' => NULL,
                                'sort' => 6,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '0',
                                'colour' => '#6f1301',
                            ),
                        1 =>
                            array(
                                'id' => 55,
                                'name' => 'webview同步官方轮播图-专题-宝贝计划',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i1/2053469401/O1CN01FCOVJe2JJi9yBgUqv_!!2053469401.png',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => 'https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D572',
                                'note' => NULL,
                                'sort' => 5,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '0',
                                'colour' => '#637386',
                            ),
                        2 =>
                            array(
                                'id' => 56,
                                'name' => '同步官方轮播图-淘宝-猫超',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i4/2053469401/O1CN01i11egr2JJiA7bx10I_!!2053469401.png',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => NULL,
                                'note' => NULL,
                                'sort' => 4,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '2',
                                'colour' => '#a20609',
                            ),
                        3 =>
                            array(
                                'id' => 57,
                                'name' => 'webview同步官方轮播图-专题-吃喝玩乐',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i4/2053469401/O1CN01MbY4pC2JJiA1fUzrL_!!2053469401.png',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => 'https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D560',
                                'note' => NULL,
                                'sort' => 3,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '0',
                                'colour' => '#ffc400',
                            ),
                        4 =>
                            array(
                                'id' => 58,
                                'name' => 'webview同步官方轮播图-专题-视频会员',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i2/2053469401/O1CN010XmASr2JJiA0l8G07_!!2053469401.png',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => 'https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D543',
                                'note' => NULL,
                                'sort' => 2,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '0',
                                'colour' => '#201611',
                            ),
                        5 =>
                            array(
                                'id' => 59,
                                'name' => 'webview同步官方轮播图-【日常专题】猫超单件包邮',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i1/2053469401/O1CN01i5khVP2JJi8aDzXUp_!!2053469401.jpg',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => 'https%3A%2F%2Fmall.wei1.top%2Findex.php%2F%3Fr%3D%2Factivitydemo%26id%3D557',
                                'note' => NULL,
                                'sort' => 1,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '0',
                                'colour' => '#e74e18',
                            ),
                        6 =>
                            array(
                                'id' => 60,
                                'name' => '同步官方轮播图-【淘特】新人1分购日常长期',
                                'type' => 1,
                                'pic' => 'https://img.alicdn.com/imgextra/i2/2053469401/O1CN01JGzzk62JJi9LcKxMd_!!2053469401.jpg',
                                'status' => 0,
                                'clickCount' => NULL,
                                'url' => NULL,
                                'note' => NULL,
                                'sort' => 0,
                                'startTime' => NULL,
                                'endTime' => NULL,
                                'createTime' => '2022-04-12 02:19:44',
                                'urlType' => '2',
                                'colour' => '#a74e0e',
                            ),
                    ),
            );
        }
        data_return('ok', 0, $data);
    }

    //首页导航图标
    public function get_navs()
    {
        $data = array(
            0 =>
                array(
                    'id' => 1,
                    'mname' => '新人免单',
                    'mpic' => 'http://hxshapp.oss-cn-beijing.aliyuncs.com/20211129/ecce3842-a48c-40ba-bcde-5bf06d454460.png',
                    'murl' => '/pages/active/zeroBuy',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => 20,
                    'createTime' => NULL,
                    'updateTime' => '2021-04-09 13:29:19',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            1 =>
                array(
                    'id' => 2,
                    'mname' => '9.9包邮',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210806/-4Yel_yYuZC-ufeaIBYsfJdWuHQ.png',
                    'murl' => '../active/specialOffer',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => 19,
                    'createTime' => NULL,
                    'updateTime' => '2022-04-07 11:02:43',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            2 =>
                array(
                    'id' => 4,
                    'mname' => '京东',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210806/pyw16A3rVruQriP6xG7aTokhNPw.png',
                    'murl' => '../active/jdSearch',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => 17,
                    'createTime' => NULL,
                    'updateTime' => '2020-10-10 10:54:57',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            3 =>
                array(
                    'id' => 7,
                    'mname' => '辣妈优选',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxah2n.png',
                    'murl' => '../active/spicyMother',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => 14,
                    'createTime' => NULL,
                    'updateTime' => '2020-10-10 14:43:07',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            4 =>
                array(
                    'id' => 8,
                    'mname' => '拼多多',
                    'mpic' => 'http://hxshapp.oss-cn-beijing.aliyuncs.com/20211129/d977fb4c-9713-4162-9956-b0c2b79d5a44.png',
                    'murl' => '../active/pddsearch',
                    'status' => 0,
                    'isDelete' => 0,
                    'sort' => 13,
                    'createTime' => NULL,
                    'updateTime' => '2020-10-10 14:43:14',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            5 =>
                array(
                    'id' => 10,
                    'mname' => '唯品会',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210806/DWl4e37l9pAHlCqvgX0-qq_G08E.png',
                    'murl' => '/pages/active/vipsearch',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => 13,
                    'createTime' => NULL,
                    'updateTime' => '2020-10-10 10:35:34',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            6 =>
                array(
                    'id' => 9,
                    'mname' => '大牌优选',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/pinpai.png',
                    'murl' => '../active/brandSale',
                    'status' => 0,
                    'isDelete' => 0,
                    'sort' => 12,
                    'createTime' => NULL,
                    'updateTime' => '2020-10-10 14:43:19',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            7 =>
                array(
                    'id' => 22,
                    'mname' => '低价影票',
                    'mpic' => 'http://hxshapp.oss-cn-beijing.aliyuncs.com/20211129/cc9b73c5-760c-4f06-adaf-77ce6e8c79ba.png',
                    'murl' => 'https://s.click.taobao.com/YAdH1tu?daily_activity=1',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => '2022-04-24 00:12:59',
                    'urlType' => 13,
                    'type' => NULL,
                ),
            8 =>
                array(
                    'id' => 44,
                    'mname' => '新人免单',
                    'mpic' => 'https://s1.ax1x.com/2020/09/23/wxNAGn.png',
                    'murl' => '../active/zeroBuy',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => '2021-04-09 13:29:12',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            9 =>
                array(
                    'id' => 45,
                    'mname' => '9.9包邮',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxNOwF.png',
                    'murl' => '../active/specialOffer',
                    'status' => 0,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            10 =>
                array(
                    'id' => 46,
                    'mname' => '外卖红包',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxNvFJ.png',
                    'murl' => '../active/takeoutFood',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            11 =>
                array(
                    'id' => 47,
                    'mname' => '京东',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxUCy6.png',
                    'murl' => '../active/jdSearch',
                    'status' => 0,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            12 =>
                array(
                    'id' => 48,
                    'mname' => '买买卡',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxaU4H.png',
                    'murl' => '../active/buyCard',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            13 =>
                array(
                    'id' => 49,
                    'mname' => '首单礼金',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxayb8.png',
                    'murl' => 'http://tb.s775775.cn/',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            14 =>
                array(
                    'id' => 50,
                    'mname' => '辣妈优选',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210512/wxah2n.png',
                    'murl' => '../active/spicyMother',
                    'status' => 0,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            15 =>
                array(
                    'id' => 51,
                    'mname' => '拼多多',
                    'mpic' => 'https://img.alicdn.com/imgextra/i2/2053469401/O1CN01QEnmGK2JJi4UsQ4ra_!!2053469401.png',
                    'murl' => '../active/pddsearch',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => NULL,
                    'urlType' => 1,
                    'type' => NULL,
                ),
            17 =>
                array(
                    'id' => 94,
                    'mname' => '美团红包',
                    'mpic' => 'https://hxshapp.oss-cn-beijing.aliyuncs.com/app/img/20210806/e7GyHPLX-Vxt93xx68PPqrQBDG8.png',
                    'murl' => '/pages/mine/mt',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => '2022-04-26 04:30:53',
                    'urlType' => 1,
                    'type' => NULL,
                ),
            18 =>
                array(
                    'id' => 95,
                    'mname' => '饿了么红包',
                    'mpic' => 'http://shxz.oss-cn-shanghai.aliyuncs.com/20210716/64a198a5-adff-47f4-9f16-0dde40f2fa40.png',
                    'murl' => '/pages/mine/elm',
                    'status' => -1,
                    'isDelete' => 0,
                    'sort' => NULL,
                    'createTime' => NULL,
                    'updateTime' => '2022-04-26 05:09:32',
                    'urlType' => 1,
                    'type' => NULL,
                ),
        );

        foreach ($data as $k => $v) {
            if ($v['status'] <> 0) {
                unset($data[$k]);
            }
        }
        $data = array_values($data);
        data_return('ok', 0, $data);
    }

    public function getHelpList()
    {
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":[{"id":1,"parentId":0,"title":"热门问题","content":null,"sort":null,"isDelete":0,"status":0,"createTime":null,"updateTime":null},{"id":2,"parentId":0,"title":"产品功能","content":null,"sort":null,"isDelete":0,"status":0,"createTime":null,"updateTime":null},{"id":3,"parentId":0,"title":"关于订单","content":null,"sort":null,"isDelete":0,"status":0,"createTime":null,"updateTime":null},{"id":4,"parentId":0,"title":"关于优惠","content":null,"sort":null,"isDelete":0,"status":0,"createTime":null,"updateTime":null},{"id":5,"parentId":0,"title":"其他帮助","content":null,"sort":null,"isDelete":0,"status":0,"createTime":null,"updateTime":null}],"message":"操作成功"}', true);

        data_return('ok', 0, $data['data']);
    }

    public function getHelpDetail()
    {
        $data = [
            'title' => '问题标题',
            'content' => '问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容问题内容'
        ];

        data_return('ok', 0, $data);
    }

    //提交反馈
    public function saveFeedBack()
    {
        $content = !empty($this->params['content']) ? trim(strip_tags($this->params['content'])) : '';
        if (empty($content)) {
            data_return('内容不能为空', -1);
        }
        $keyId = md5($content);
        if (cache($keyId)) {
            data_return('5分钟内尽可提交一条哦', 0);
        }
        $model = new UnionFeedback();
        if ($model->where(['uid' => $this->uid, 'add_time' => ['>=', strtotime('today')]])->count() >= 10) {
            data_return('当日反馈过多', -1);
        }
        if ($model->where(['uid' => $this->uid, 'content' => $content])->field('id')->find()) {
            data_return('反馈已记录', 0);
        }

        $res = $model->save([
            'uid' => $this->uid,
            'content' => $content
        ]);

        cache($keyId, 1, 300);
        data_return('感谢您的反馈', 0, ['res' => $res]);
    }

    //买买卡
    public function active_buy_card()
    {
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":[{"id":26,"parentId":0,"cname":"分类3","cpic":null,"hurl":null,"sort":2,"status":0,"isDelete":0,"createTime":"2020-12-07 03:21:22","updateTime":"2020-12-07 05:52:17","htype":0,"describe":null},{"id":19,"parentId":0,"cname":"分类1","cpic":null,"hurl":null,"sort":1,"status":0,"isDelete":0,"createTime":"2020-10-27 15:28:49","updateTime":"2020-12-07 05:52:01","htype":0,"describe":null},{"id":25,"parentId":0,"cname":"分类2","cpic":null,"hurl":null,"sort":1,"status":0,"isDelete":0,"createTime":"2020-12-07 03:21:14","updateTime":"2020-12-07 05:52:08","htype":0,"describe":null}],"message":"操作成功"}', true);
        data_return('ok', 0, $data['data']);
    }


    //本地生活
    public function local_life()
    {
        $data = \GuzzleHttp\json_decode('{"cache":false,"code":0,"data":[{"id":4,"goodsName":"饿了么果蔬囤券","goodsDes":"天天最高领16元红包","goodsImg":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/elmicon.png","nameTitle":"饿了么","goodsPic":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/wm_guoshu.png","status":0,"clickCount":5,"url":"./elmgs","sort":4,"urlType":1,"createTime":"2020-12-07 01:31:25","updateTime":"2020-12-07 01:31:25","type":null},{"id":3,"goodsName":"饿了么红包","goodsDes":"天天抢66元霸王餐红包","goodsImg":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/elmicon.png","nameTitle":"饿了么","goodsPic":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/wm_elmhongbao.png","status":0,"clickCount":52,"url":"./elmlq","sort":3,"urlType":1,"createTime":"2020-12-07 01:31:25","updateTime":"2020-12-07 01:31:25","type":null},{"id":1,"goodsName":"美团外卖红包","goodsDes":"美团 最高领56元红包","goodsImg":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/waimaiicon.png","nameTitle":"美团外卖","goodsPic":"https://www.wdxkd.com/addons/hc_card/template/mobile/img/waimai/wm_hongbao1.png","status":0,"clickCount":3,"url":"./mtwm","sort":1,"urlType":1,"createTime":"2020-12-07 01:31:25","updateTime":"2020-12-07 01:31:25","type":null}],"message":"操作成功"}', true);
        data_return('ok', 0, $data['data']);
    }
}