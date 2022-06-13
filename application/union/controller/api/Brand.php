<?php


namespace app\union\controller\api;

//品牌
class Brand extends DgApiBase
{
    public function getCategoryList()
    {
        $req = $this->dtk->tb_super_category();
        if ($req) {
            foreach ($req as &$v) {
                unset($v['subcategories']);
            }
            unset($v);
        }
        data_return('ok', 0, $req);
    }

    public function getBrandList()
    {
        $arg['cid'] = !empty($this->params['brandcat']) ? $this->params['brandcat'] : 6;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        $req = $this->dtk->tb_brand_columns($arg);
        $brandList = [];
        if (empty($req['lists'])) {
            data_return('没有更多啦', 0, [
                'brandList' => $brandList
            ]);
        }
        foreach ($req['lists'] as $item) {
            $brand = [
                'brandLogo' => $item['brandLogo'],
                'brandcat' => $arg['cid'],
                'id' => $item['brandId'],
                'fqBrandName' => $item['brandName'],
                'insideLogo' => null,
                'introduce' => $item['brandDesc'],
                'item' => [],
            ];
            foreach ($item['goodsList'] as $goods) {
                $brand['item'][] = [
                    'goodsId' => $goods['goodsId'],
                    'title' => $goods['title'],
                    'dtitle' => $goods['dTitle'],
                    'desc' => $goods['desc'],
                    'actualPrice' => $goods['actualPrice'],
                    'originalPrice' => $goods['originPrice'],
                    'shopName' => $item['brandFeatures'],
                    'couponPrice' => $goods['couponPrice'],
                    'searchSource' => 1,
                    'shopType' => null,
                    'monthSales' => $goods['monthSales'],
                    'mainPic' => $goods['mainPic'],
                    'commissionRate' => $goods['commissionRate'],
                    'video' => $goods['video'],
                    //返现
                    'backmoney' => round($goods['commissionRate']  * $goods['actualPrice'], 2),
                    //补贴金额
                    'buMoney' => 0,
                ];
            }
            $brandList[] = $brand;
        }
        data_return('ok', 0, [
            'brandList' => $brandList
        ]);
    }

    public function getSingleBrand()
    {
        $arg['brandId'] = !empty($this->params['id']) ? $this->params['id'] : 0;
        $arg['page'] = !empty($this->params['pageId']) ? $this->params['pageId'] : 1;
        $arg['pageSize'] = !empty($this->params['pageSize']) ? $this->params['pageSize'] : 20;
        $req = $this->dtk->tb_brand_goods($arg);

        $brandList = [];
        if (empty($req['list'])) {
            data_return('没有更多啦', 0, [
                'brandList' => $brandList
            ]);
        }

        $brandList = [
            'brandLogo' => $req['brandLogo'],
            'brandcat' => null,
            'id' => $req['brandId'],
            'fqBrandName' => $req['brandName'],
            'insideLogo' => null,
            'introduce' => $req['brandDesc'],
        ];
        foreach ($req['list'] as $goods) {
            $brandList['items'][] = [
                'goodsId' => $goods['goodsId'],
                'title' => $goods['title'],
                'dtitle' => $goods['dTitle'],
                'desc' => $goods['desc'],
                'actualPrice' => $goods['actualPrice'],
                'originalPrice' => $goods['originPrice'],
                'shopName' => $req['brandFeatures'],
                'couponPrice' => $goods['couponPrice'],
                'searchSource' => 1,
                'shopType' => null,
                'monthSales' => $goods['monthSales'],
                'mainPic' => $goods['mainPic'],
                'commissionRate' => $goods['commissionRate'],
                'video' => $goods['video'],
                //返现
                'backmoney' => round($goods['commissionRate'] * $goods['actualPrice'], 2),
                //补贴金额
                'buMoney' => 0,
            ];
        }
        data_return('ok', 0, [
            'brandList' => $brandList
        ]);
    }

}