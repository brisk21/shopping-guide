<?php


namespace app\union\controller\api;


use app\server\GuideHaoDanKuServer;
use think\Controller;
use think\Request;



class Share extends DgApiBase
{
    protected $hdk;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->hdk = new GuideHaoDanKuServer();
    }

    //达人说
    public function share_list()
    {
        $req = $this->hdk->talent_info([
            'talentcat' => !empty($this->params['talentcat']) ? intval($this->params['talentcat']) : 0
        ]);

        $topData = $newData = $clickData = [];
        if (!empty($req)) {
            foreach ($req as $key => $v) {
                if (!in_array($key, ['topdata', 'clickdata', 'newdata']) || empty($v)) {
                    continue;
                }
                $tmpArr = [];

                foreach ($v as $item) {
                    $tmpArr[] = [
                        'appImage' => $item['app_image'],
                        'article' => $item['article'],
                        'articleBanner' => $item['article_banner'],
                        'composeImage' => $item['compose_image'],
                        'followTimes' => $item['followtimes'],
                        'headImg' => empty($item['head_img']) ? null : $item['head_img'],
                        'highQuality' => $item['highquality'],
                        'id' => $item['id'],
                        'image' => $item['image'],
                        'itemNum' => $item['itemnum'],
                        'label' => $item['label'],
                        'name' => $item['name'],
                        'shortTitle' => $item['shorttitle'],
                        'talentId' => $item['talent_id'],
                        'talentName' => $item['talent_name'],
                        'talentcat' => $item['talentcat'],
                        //'tclass'=>$item[''],
                        'tkItemId' => $item['tk_item_id'],
                        'readtimes' => $item['readtimes'],
                        'type' => 0,
                    ];
                }
                if ($key == 'topdata') {
                    $topData = $tmpArr;
                } elseif ($key == 'newdata') {
                    $newData = $tmpArr;
                } elseif ($key == 'clickdata') {
                    $clickData = $tmpArr;
                }

            }
        }
        data_return('ok', 0, [
            'topdata' => $topData,
            'newdata' => $newData,
            'clickdata' => $clickData
        ]);
    }

    public function share_info()
    {
        $req = $this->hdk->talent_detail([
            'talent_id' => empty($this->params['id']) ? '' : $this->params['id']
        ]);
        $data = [
            'addtime' => date('Y-m-d H:i:s', $req['addtime']),
            'appImage' => $req['app_image'],
            'articleBanner' => $req['article_banner'],
            'articleLabel' => htmlspecialchars_decode($req['article']),
            'composeImage' => $req['compose_image'],
            'followTimes' => $req['followtimes'],
            'headImg' => $req['head_img'],
            'highQuality' => $req['highquality'],
            'id' => $req['id'],
            'invalidList' => [],
            'itemNum' => count($req['items']),
            'items' => [],
            'label' => $req['label'],
            'name' => $req['name'],
            'readTimes' => $req['readtimes'],
            'shorttitle' => $req['shorttitle'],
            'talentId' => $req['talent_id'],
            'talentName' => $req['talent_name'],
            'tkItemId' => $req['itemid_str'],
        ];
        if (!empty($req['items'])) {
            foreach ($req['items'] as $item) {
                $data['items'][] = [
                    'couponmoney' => $item['couponmoney'],
                    'couponurl' => $item['couponurl'],
                    'itemendprice' => $item['itemendprice'],
                    'itemid' => $item['itemid'],
                    'itempic' => $item['itempic'],
                    'itemshorttitle' => $item['itemshorttitle'],
                    'itemtitle' => $item['itemtitle'],
                    'rkrates' => $item['tkrates'],
                    'tkmoney' => $item['tkmoney'],
                    'itemprice' => $item['itemprice'],
                    'itemsale' => $item['itemsale'],
                    'shopname' => $item['shopname'],
                    'shoptype' => $item['shoptype'],
                ];
            }
        }
        data_return('ok', 0, $data);

    }
}