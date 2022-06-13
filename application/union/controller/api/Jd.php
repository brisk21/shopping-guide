<?php


namespace app\union\controller\api;


use think\Request;

class Jd extends DgApiBase
{
    public function superSearch()
    {
        $sort = !empty($this->params['sort']) ? $this->params['sort'] : '';
        $arg['keyword'] = !empty($this->params['keyword']) ? $this->params['keyword'] : '';
        $arg['owner'] = !empty($this->params['owner']) ? $this->params['owner'] : '';
        $arg['isCoupon'] = !empty($this->params['withCoupon']) ? 1 : '';
        $arg['pageId'] = !empty($this->params['pageIndex']) ? $this->params['pageIndex'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        $arg['cid1'] = !empty($this->params['goodsType'])?$this->params['goodsType']:'';
        if ($sort == 'total_sales_des') {
            $arg['sortName'] = 'inOrderComm30Days';
            $arg['sort'] = 'desc';
        } elseif ($sort == 'renqi') {
            $arg['sortName'] = 'inOrderCount30Days';
            $arg['sort'] = 'desc';
        } elseif ($sort == 'price_asc') {
            $arg['sortName'] = 'price';
            $arg['sort'] = 'asc';
        } elseif ($sort == 'price_des') {
            $arg['sortName'] = 'price';
            $arg['sort'] = 'desc';
        }
        $goods = $this->dtk->jd_goods_search($arg);
        $data = [];
        if (!empty($goods['list'])) {

            foreach ($goods['list'] as $item) {
                $imgs = [];
                if ($item['imageUrlList']) {

                    foreach ($item['imageUrlList'] as $v) {
                        $imgs[] = [
                            'url' => $v
                        ];
                    }
                }
                $data[] = [
                    'mainPic' => $item['whiteImage'],
                    'originalPrice' => $item['price'],
                    'actualPrice' => $item['lowestCouponPrice'],
                    'backmoney' => $item['commission'],
                    'title' => $item['skuName'],
                    'dtitle' => $item['skuName'],
                    'materialUrl' => $item['materialUrl'],
                    'shopName' => $item['shopName'],
                    'goodsId' => $item['skuId'],
                    'imageList' => $imgs,
                    'couponPrice' => !empty($item['couponList'][0]['discount']) ? $item['couponList'][0]['discount'] : 0,
                    'useStartTime' => !empty($item['couponList'][0]['discount']) ? $item['couponList'][0]['useStartTime'] : '',
                    'couponStartTime' => !empty($item['couponList'][0]['getStartTime']) ? $item['couponList'][0]['getStartTime'] : '',
                    'useEndTime' => !empty($item['couponList'][0]['discount']) ? $item['couponList'][0]['useEndTime'] : '',
                    'couponEndTime' => !empty($item['couponList'][0]['getEndTime']) ? $item['couponList'][0]['getEndTime'] : '',

                    'commission' => $item['commission'],
                    'searchSource' => 3,
                    'shopType' => null,
                ];
            }
        }


        data_return('ok', 0, [
            'goodsList' => $data,
        ]);

        $req = $this->dtk->jd_goods_search($arg);

        data_return('ok', 0, $req);
    }

    //todo 缓存
    public function getTopCatList()
    {
        $req = $this->dtk->jd_category();
        $data = [];
        if (!empty($req)) {
            foreach ($req as $k => $v) {
                $data[] = [
                    'jdCatId' => $v['id'],
                    'name' => $v['name'],
                    'icon' => null,
                    'sort' => null,
                    'isShow' => 'Y',
                    'parentId' => $v['parentId'],
                    'jingtuituiId' =>$v['id'],
                ];
            }
        }
        data_return('ok', 0, $data);
    }

    public function getGoodsList()
    {
       $this->params['pageIndex'] = $this->params['offset'];
       return $this->superSearch();
    }

    //详情图片
    public function getWareStyle()
    {
        $req = $this->dtk->jd_goods_detail([
            'skuIds' => input('goodsId')
        ]);
        $imgs = [];
        if (!empty($req[0]['detailImages'])) {
            $imgs = $req[0]['detailImages'];
        }
        data_return('ok', 0, [
            'goodsId' => input('goodsId'),
            'imgArray' => $imgs,
            'source' => $req
        ]);

    }

    //转链
    public function getUnionurl()
    {
        $materialUrl = $this->params['materialUrl'];

        $req = $this->dtk->jd_goods_url_single([
            'materialId' => $materialUrl,
            //todo 用户唯一序列号
            'positionId' => 123456
        ]);
        if (empty($req['shortUrl'])) {
            data_return('网络超时，请稍后', -1);
        }
        data_return('ok', 0, [
            'link' => $req['shortUrl']
        ]);

    }

}