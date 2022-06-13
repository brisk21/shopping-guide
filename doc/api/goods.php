<?php
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/goods_list  <newapi>[新]</newapi>商品-列表
 * @apiName goods_list
 * @apiGroup goods
 *
 * @apiParam {String} [from] 来源，home-jingxuan：首页精选；home_list-首页下面的商品列表；hot_category-首页热门推荐；detail-详情页面下面的列表
 * @apiParam {Number} [page] 分页，默认1
 * @apiParam {Number} [id] 详情页面请求时需要填写（方便返回类似的）
 * @apiParam {Number} [category_id] 分类编号
 * @apiParam {String} [keyword] 搜索字符串
 * @apiParam {String} [sort] 排序，normal-综合，price_desc-价格倒叙，price_asc-价格正序，sale_asc-销量正序，sale_desc-销量倒叙

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"goods":[{"id":997,"title":"优妮修护滋养焗油膏护发素女干枯毛躁修护免蒸发膜滑溜溜顺滑营养","market_price":"49.00","price":"0.01","stock":999,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-04-02\/c2682072a3c1c2dc4e7e7229344f34a2.jpeg"},{"id":993,"title":"英国VANOW高档智能保温杯男士女316不锈钢刻字定制logo泡茶水杯子","market_price":"169.00","price":"0.01","stock":1000,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-06-25\/548ea0b59cfd05667c080d05080e4231.jpeg"},{"id":987,"title":"浪莎打底裤女秋冬加绒加厚外穿连裤袜肉色显瘦保暖光腿神器超自然","market_price":"21.80","price":"0.01","stock":1000,"sale":0,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-01-06\/af6ccaf7536835e00d078989c310d4d8.jpeg"}],"total":3}}

 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/goods_detail  <newapi>[新]</newapi>商品-详情
 * @apiName goods_detail
 * @apiGroup goods
 *

 * @apiParam {Number} id 商品ID

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"goods":{"id":994,"title":"超威威王强效洁厕净洁厕灵液马桶清洁剂除重垢尿垢马桶清洁剂洁厕","goods_desc":"超威威王强效洁厕净洁厕灵液马桶清洁剂除重垢尿垢马桶清洁剂洁厕","thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-11\/81fdda1477802fa3e7fc5388381e0f77.jpeg","market_price":"12.90","price":"0.01","stock":1000,"sale":0,"status":1,"banners":["https:\/\/img.pddpic.com\/mms-material-img\/2021-03-11\/b9114204-a06e-48c0-97a2-98a6f9776c35.jpeg.a.jpeg","https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-11\/81fdda1477802fa3e7fc5388381e0f77.jpeg"],"content":"<img style=\"max-width: 100%\" src=\"https:\/\/img.pddpic.com\/mms-material-img\/2021-03-11\/b9114204-a06e-48c0-97a2-98a6f9776c35.jpeg.a.jpeg\"\/><img style=\"max-width: 100%\" src=\"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-11\/81fdda1477802fa3e7fc5388381e0f77.jpeg\"\/>","category_id":9,"store_num":"1234567890","has_favorite":null}}}

 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/get_classify  <newapi>[新]</newapi>商品-分类列表
 * @apiName get_classify
 * @apiGroup goods
 *



 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"category":[{"category_id":1,"name":"日常百货","parent_id":0,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg","subcat":[{"category_id":3,"name":"酒水饮品","parent_id":1,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":4,"name":"纸巾牙刷","parent_id":1,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":13,"name":"未分组","parent_id":1,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"}]},{"category_id":2,"name":"服装礼饰","parent_id":0,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg","subcat":[{"category_id":5,"name":"男装","parent_id":2,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":6,"name":"女装","parent_id":2,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":7,"name":"上衣","parent_id":2,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"}]},{"category_id":8,"name":"油品粮食","parent_id":0,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg","subcat":[{"category_id":9,"name":"大米","parent_id":8,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":10,"name":"面条","parent_id":8,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"},{"category_id":11,"name":"螺蛳粉","parent_id":8,"status":1,"img":"\/static\/mall\/upload\/pro3.jpg"}]}]}}

 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/goods/get_comment  <newapi>[新]</newapi>商品-获取评价
 * @apiName goods_get_comment
 * @apiGroup goods
 *

 * @apiParam {Number} id 商品ID
 * @apiParam {Number} [page] 分页，默认1

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"comment":[{"is_hide_user":1,"content":"实在太好了，我喜欢","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/b7a41d904b4d6cb5bffae74d906b05ab.jpg","http:\/\/shop.test.top\/upload\/mall\/comment\/539368c2b485262dc9cc7a9986b246d5.jpeg","http:\/\/shop.test.top\/upload\/mall\/comment\/48cf5010823149f7fe322b7b8bb3c523.jpg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":5,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}},{"is_hide_user":1,"content":"实在太好了，我喜欢","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/b7a41d904b4d6cb5bffae74d906b05ab.jpg","http:\/\/shop.test.top\/upload\/mall\/comment\/539368c2b485262dc9cc7a9986b246d5.jpeg","http:\/\/shop.test.top\/upload\/mall\/comment\/48cf5010823149f7fe322b7b8bb3c523.jpg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":5,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}},{"is_hide_user":1,"content":"实在太好了，我喜欢","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/b7a41d904b4d6cb5bffae74d906b05ab.jpg","http:\/\/shop.test.top\/upload\/mall\/comment\/539368c2b485262dc9cc7a9986b246d5.jpeg","http:\/\/shop.test.top\/upload\/mall\/comment\/48cf5010823149f7fe322b7b8bb3c523.jpg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":5,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}},{"is_hide_user":1,"content":"实在太好了，我喜欢","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/b7a41d904b4d6cb5bffae74d906b05ab.jpg","http:\/\/shop.test.top\/upload\/mall\/comment\/539368c2b485262dc9cc7a9986b246d5.jpeg","http:\/\/shop.test.top\/upload\/mall\/comment\/48cf5010823149f7fe322b7b8bb3c523.jpg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":5,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}},{"is_hide_user":1,"content":"实在太好了，我喜欢","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/b7a41d904b4d6cb5bffae74d906b05ab.jpg","http:\/\/shop.test.top\/upload\/mall\/comment\/539368c2b485262dc9cc7a9986b246d5.jpeg","http:\/\/shop.test.top\/upload\/mall\/comment\/48cf5010823149f7fe322b7b8bb3c523.jpg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":5,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}},{"is_hide_user":1,"content":"袜子质量一般，有点味道","imgs":["http:\/\/shop.test.top\/upload\/mall\/comment\/971a73545d147bdac869a029f690f08a.jpeg"],"status":1,"add_time":"2021-12-17","uid":"bs91ca7180113e01fde28a157bb75bb78c","star":3,"user":{"avatar":"http:\/\/shop.test.top\/\/static\/com\/img\/user-default.jpg","nickname":"匿名用户"}}]}}
 *
 */