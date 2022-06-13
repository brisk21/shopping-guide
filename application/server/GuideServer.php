<?php


namespace app\server;


use app\common\common;

class GuideServer
{
    public static $isApp = false;

    //拼多多格式化
    public static function format_pdd_item(&$item)
    {
        $val = [
            'goodsId' => $item['goods_id'],
            'goodsSign' => $item['goods_sign'],
            'title' => $item['goods_name'],
            'dtitle' => $item['goods_name'],
            'desc' => $item['goods_desc'],
            'actualPrice' => round($item['min_group_price'] / 100 - $item['coupon_discount'] / 100, 2),
            'originalPrice' => round($item['min_normal_price'] / 100, 2),
            'shopName' => $item['mall_name'],
            'couponPrice' => round($item['coupon_discount'] / 100, 2),
            'searchSource' => 2,
            'shopType' => null,
            'monthSales' => $item['sales_tip'],
            'mainPic' => $item['goods_thumbnail_url'],
            'commissionRate' => round($item['promotion_rate'] / 10, 2),
            //返现
            'backmoney' => round(round($item['min_group_price'] / 100 - $item['coupon_discount'] / 100, 2) * $item['promotion_rate'] / 1000, 2),
            //补贴金额
            'buMoney' => 0,
        ];
        return $val;
    }

    //淘宝格式化
    public static function format_tb_item(&$item)
    {
        return [
            'goodsId' => $item['goodsId'],
            'title' => $item['title'],
            'dtitle' => $item['dtitle'],
            'desc' => $item['desc'],
            'actualPrice' => $item['actualPrice'],
            'originalPrice' => $item['originalPrice'],
            'shopName' => $item['shopName'],
            'couponPrice' => $item['couponPrice'],
            'searchSource' => 1,
            'shopType' => $item['shopType'],
            'monthSales' => $item['monthSales'],
            'mainPic' => $item['mainPic'],
            'commissionRate' => $item['commissionRate'],
            //返现
            'backmoney' => round($item['commissionRate'] / 100 * $item['actualPrice'], 2),
            //补贴金额
            'buMoney' => 0,
        ];
    }

    //微信小程序格式化
    public static function format_xcx_item($val)
    {
        $item = [
            'id' => $val['productId'],//唯一标识
            'title' => $val['title'],//标题
            'thumb' => $val['img'],//缩略图
            'market_price' => '--',//市场价
            'price' => $val['minPrice'],//最终金额
            'coupon' => $val['discountPrice'],//优惠金额
            'volume' => $val['volume'],//销量
            'commission' => $val['commissionValue'],//佣金（元）
            'commission_rate' => $val['commissionRatio'],//佣金率（万分）
            'pt_type' => '4',//平台类型，1-拼多多，2-淘宝，3-京东，4-小程序
        ];

        $item['shopInfo'] = $val['shopInfo'];
        $item['couponInfo'] = $val['couponInfo'];


        return $item;
    }

    /**
     * 返回html格式的item
     * @param $item
     * @param int $role 0-普通用户，1-社团长类型
     * @return string
     */
    public static function item2html($item, $role = 0)
    {
        if (self::$isApp){
            return $item;
        }
        if ($role == 1) {
            /*$html = '<li><div data-id="'.$item['id'].'"><div class="proimg"><img alt="" src="' . $item['thumb'] . '"></div> <div class="protxt"><div class="name goods-item-name"><a style="color: blue" data-id="' . $item['id'] . '">' . $item['title'] . '</a></div><div>
           <span class="monthSales">销量:' . $item['volume'] . '</span>&nbsp;<span class="monthSales">佣金:' . $item['commission'] . '</span>&nbsp;</div>
           <div class="wy-pro-pri ">¥' . $item['price'] . '&nbsp;  <span style="width: 100%" data-id="' . $item['id'] . '" class="weui-btn weui-btn-area_inline weui-btn_default puhuotext"><b class="puhuo">去分享</b></span></div></div></div></li>';*/$html = '<li><div   data-id="'.$item['id'].'"><div class="proimg"><img alt="" src="' . $item['thumb'] . '"></div> <div class="protxt"><div class="name goods-item-name"><a style="color: blue;'.($item['pt_type']==4?'height:40px;':'').'" data-id="' . $item['id'] . '" data-extend="'.($item['pt_type']==4?$item['shopInfo']['appId']:'').'" >' . $item['title'] . '</a></div><div>
           <span class="monthSales">销量:' . $item['volume'] . '</span>&nbsp;<span class="monthSales">佣金:' . $item['commission'] . '</span>&nbsp;</div>
           <div class="wy-pro-pri ">¥' . $item['price'] . '&nbsp;  </div></div></div></li>';
        } else {
            $html = '<li><div class="goods-item-name" data-id="'.$item['id'].'"><div class="proimg"><img alt="" src="' . $item['thumb'] . '"></div> <div class="protxt"><div class="name goods-item-name"><a style="color: blue" data-id="' . $item['id'] . '">' . $item['title'] . '</a></div><div>
            <span class="monthSales">销量:' . $item['volume'] . '</span>&nbsp;&nbsp;</div>
            <div class="wy-pro-pri ">¥' . $item['price'] . '&nbsp;  </div></div></div></li>';
        }

        return $html;
    }

    public static function order2html($item)
    {
        $tpl = ' <div class="weui-panel weui-panel_access">
          <div class="weui-panel__hd"><span>单号：'.$item['order_sn'].'</span><span class="ord-status-txt-ts fr">'.$item['statusDesc'].'</span></div>
          <div class="weui-media-box__bd  pd-10">
            <div class="weui-media-box_appmsg ord-pro-list">
              <div class="weui-media-box__hd">
                <a href=""><img class="weui-media-box__thumb" src="'.($item['item_thumb']?$item['item_thumb']:'/static/union/images/nodata.png').'" alt=""></a>

              </div>
              <div class="weui-media-box__bd">
                <h1 class="weui-media-box__desc">
                  <a href="javascript:void(0)" class="ord-pro-link">'.$item['item_title'].'</a>
                </h1>

                <div class="clear mg-t-10">
                  <div class="wy-pro-pri fl">¥<em class="num font-15">'.$item['price'].'</em></div>


                  <!--<div class="pro-amount fr"><span class="font-13">数量×<em class="name">1</em></span></div>-->
                  <div style="clear: both"></div>
                  <div class="time">'.$item['add_time'].'</div>
                </div>
              </div>
            </div>
          </div>
          <div class="ord-statistics">
           <!-- <span>共<em class="num">1</em>件商品,</span>-->
            <span class="wy-pro-pri">总金额：¥<em class="num font-15">'.$item['price'].'</em></span>
            <span class="wy-pro-pri">佣金：¥<em class="num font-15">'.$item['commission'].'</em></span>
          </div>
        </div>';

        return $tpl;
    }


    public static function base_detail()
    {
        return [
            'id' => '',//唯一标识
            'title' => '',//标题
            'thumb' => '',//缩略图
            'market_price' => '',//市场价
            'price' => '',//最终金额
            'coupon' => '',//优惠金额
            'volume' => '',//销量
            'commission' => '',//佣金（元）
            'commission_rate' => '',//佣金率（百分）
            'pt_type' => '',//平台类型，1-拼多多，2-淘宝，3-京东，4-小程序,
            'thumbs' => [],//轮播相册
            'video_urls' => [],//视频地址
            'detail_imgs' => [],//详情图片
        ];
    }







}