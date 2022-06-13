<?php
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/favorite_action  <newapi>[新]</newapi>收藏-增删
 * @apiDescription 如果已经收藏则自动取消，否则自动新增收藏，status=1代表收藏，status=0代表取消收藏
 * @apiName favorite_action
 * @apiGroup favorite
 *
 * @apiParam {Number} id 商品ID
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"收藏成功","data":{"status":1}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/my_favorite_goods  <newapi>[新]</newapi>收藏-列表
 * @apiName my_favorite_goods
 * @apiGroup favorite
 *
 * @apiParam {Number} [page] 分页，默认1


 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"goods":[{"id":997,"title":"优妮修护滋养焗油膏护发素女干枯毛躁修护免蒸发膜滑溜溜顺滑营养","market_price":"49.00","price":"0.01","stock":999,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-04-02\/c2682072a3c1c2dc4e7e7229344f34a2.jpeg","aid":41},{"id":994,"title":"超威威王强效洁厕净洁厕灵液马桶清洁剂除重垢尿垢马桶清洁剂洁厕","market_price":"12.90","price":"0.01","stock":1000,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-11\/81fdda1477802fa3e7fc5388381e0f77.jpeg","aid":42},{"id":952,"title":"皮尔卡丹春秋新款牛仔裤男士直筒弹力宽松商务休闲百搭修身长裤子","market_price":"198.00","price":"0.01","stock":1000,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2020-12-16\/bd4519684b5e8bec3f3ea4e962898fa9.jpeg","aid":44}]}}
 *
 */