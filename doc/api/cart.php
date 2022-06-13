<?php
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/my_cart_total  <newapi>[新]</newapi>购物车-统计
 * @apiName my_cart_total
 * @apiGroup cart
 *
 * @apiParam {String} [from] detail-来自商品详情；checked-预结算购物车

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"total":1,"totalMoney":"0.00"}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/my_cart_goods  <newapi>[新]</newapi>购物车-我的商品
 * @apiName my_cart_goods
 * @apiGroup cart
 *

 * @apiParam {Number} [page] 分页，默认1

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"goods":[{"title":"狗狗零食磨牙棒宠物小型犬鸡肉冻干大礼包整箱幼犬泰迪大型犬金毛","price":"0.01","thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2020-10-16\/536363ab91ac7718891a25da4444249c.jpeg","id":51,"count":1,"status":1,"goods_id":955,"store_name":"bs_shop购物商城"},{"title":"卓诗尼女童公主裙夏装2021新款儿童韩版立体蝴蝶连衣裙女孩裙子潮","price":"0.01","thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-05-21\/43dfef1751e57ca4d6e251449102958b.jpeg","id":50,"count":1,"status":1,"goods_id":956,"store_name":"bs_shop购物商城"},{"title":"韩束巨水光臻时沁润礼盒护肤品补水保湿提亮肤色控油淡斑化妆品","price":"0.01","thumb":"https:\/\/img.pddpic.com\/gaudit-image\/2021-09-22\/f29932acb3abb743c6f5e2613a2a1f09.jpeg","id":49,"count":1,"status":1,"goods_id":968,"store_name":"bs_shop购物商城"}],"isAllChecked":true}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/my_cart_select_status  <newapi>[新]</newapi>购物车-选择状态
 * @apiName my_cart_select_status
 * @apiGroup cart
 *
 * @apiParam {String} [id] 购物车记录,传入代表操作某记录，否则代表全选或者全不选
 * @apiParam {String} dotype 操作类型，1-选中，0-去除选中

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"操作成功","data":[]}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/my_cart_action  <newapi>[新]</newapi>购物车-增减数量
 * @apiName my_cart_action
 * @apiGroup cart
 *
 * @apiParam {Number} [id] 购物车记录,在购物列表操作需要
 * @apiParam {Number} [goods_id] 商品编号,在商品详情操作是输入
 * @apiParam {Number} count 最终数量,小于1时代表删除
 * @apiParam {String} dotype 操作类型 Increase-增,Decrease-减少，del-直接删除某商品

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"操作成功","data":[]}
 *
 */