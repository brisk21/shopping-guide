<?php
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/ready  <newapi>[新]</newapi>订单-预创建
 * @apiName order_ready
 * @apiGroup order
 *
 * @apiParam {Number} [id] 商品ID，从商品“立即购买”时必填，从购物车无需
 * @apiParam {Number} [count] 商品数量，从商品详情“立即购买”时必填，默认1，从购物车无需
 * @apiParam {Number} [addr_id] 收货地址id
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"order":{"totalMoney":"0.03"},"address":{"id":12,"uid":"bs1e7cdd3a5c3265c3f3c7bb77602d8ec9","province":"北京","city":"北京市","area":"石景山区","town":"","address":"222222","is_default":1,"mobile":"111","username":"111"},"goods_list":[{"thumb":"https:\/\/img.pddpic.com\/gaudit-image\/2021-09-22\/f29932acb3abb743c6f5e2613a2a1f09.jpeg","title":"韩束巨水光臻时沁润礼盒护肤品补水保湿提亮肤色控油淡斑化妆品","price":"0.01","status":1,"stock":1000,"stock_locked":0,"store_num":"1234567890","count":3}]}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/create  <newapi>[新]</newapi>订单-创建订单
 * @apiName order_create
 * @apiGroup order
 *
 * @apiParam {Number} [id] 商品ID，从商品“立即购买”时必填，从购物车无需
 * @apiParam {Number} [count] 商品数量，从商品详情“立即购买”时必填，默认1，从购物车无需
 * @apiParam {Number} addr_id 收货地址id
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.order_sn 订单编号

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"order_sn":"BS2021121013525356960675"}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/pay  <newapi>[新]</newapi>订单-支付(余额)
 * @apiDescription 订单流程：预生成》创建》支付》完成
 * @apiName order_pay
 * @apiGroup order


 * @apiParam {String} order_sn 订单编号
 * @apiParam {String=credit} payType 支付方式，credit-余额
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.order_sn 订单编号

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"支付成功","data":{"order_sn":"BS2021121013525356960675"}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/wx_param  <newapi>[新]</newapi>订单-微信调起支付
 * @apiDescription 订单流程：预生成》创建》微信支付》请求调起支付参数》支付》完成
 * @apiName order_wx_param
 * @apiGroup order


 * @apiParam {String} order_sn 订单编号
 * @apiParam {String=wechat} payType 支付方式，wechat-微信
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"payParam":{"appId":"xxx","timeStamp":"1639116883","nonceStr":"sdfdsfdsf2wexdfdsf","package":"prepay_id=wxdsfwef11312s","paySign":"sdofjdofjowejfoewi","signType":"MD5"}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/recharge  <newapi>[新]</newapi>订单-充值调起支付
 * @apiDescription 订单流程：充值》输入金额》请求接口》调起支付参数》支付》完成
 * @apiName order_recharge
 * @apiGroup order


 * @apiParam {Number} money 充值金额
 * @apiParam {String=wechat} payType 支付方式，wechat-微信
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"payParam":{"appId":"xxx","timeStamp":"1639116883","nonceStr":"sdfdsfdsf2wexdfdsf","package":"prepay_id=wxdsfwef11312s","paySign":"sdofjdofjowejfoewi","signType":"MD5"},"order_sn":"BS2021121013525356960675"}}
 *
 */


/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/my_orders  <newapi>[新]</newapi>订单-订单列表
 * @apiDescription 订单流程：预生成》创建》支付》完成》我的订单列表
 * @apiName order_my_orders
 * @apiGroup order


 * @apiParam {Number} [page] 当前分页，默认1
 * @apiParam {Number} status 状态：0-待支付，1-代发货，2-待收货，3-待评价（已完成），不填或者''空字符代表全部
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"orders":[{"order_sn":"BS2021121013525356960675","price":"0.03","status":1,"pay_time":1639115573,"pay_price":"0.03","add_time":1639115573,"goods_list":[{"id":110,"order_sn":"BS2021121013525356960675","goods_id":968,"thumb":"https:\/\/img.pddpic.com\/gaudit-image\/2021-09-22\/f29932acb3abb743c6f5e2613a2a1f09.jpeg","title":"韩束巨水光臻时沁润礼盒护肤品补水保湿提亮肤色控油淡斑化妆品","price":"0.01","count":3}]},{"order_sn":"BS2021120815010412233426","price":"0.01","status":0,"pay_time":0,"pay_price":"0.00","add_time":1638946864,"goods_list":[{"id":109,"order_sn":"BS2021120815010412233426","goods_id":42,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-25\/7f43ebe854d702edde7b1708695a5756.jpeg","title":"公牛明装开关插座面板一开五孔16a86型家用墙壁明线明装多孔插座","price":"0.01","count":1}]},{"order_sn":"BS2021120814172485444066","price":"0.03","status":1,"pay_time":1638944245,"pay_price":"0.03","add_time":1638944244,"goods_list":[{"id":108,"order_sn":"BS2021120814172485444066","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":3}]},{"order_sn":"BS2021120814165984447764","price":"0.03","status":1,"pay_time":1638944220,"pay_price":"0.03","add_time":1638944219,"goods_list":[{"id":107,"order_sn":"BS2021120814165984447764","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":3}]},{"order_sn":"BS2021120814161481842882","price":"0.03","status":1,"pay_time":1638944175,"pay_price":"0.03","add_time":1638944174,"goods_list":[{"id":106,"order_sn":"BS2021120814161481842882","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":3}]},{"order_sn":"BS2021120814154581828868","price":"0.01","status":1,"pay_time":1638944146,"pay_price":"0.01","add_time":1638944145,"goods_list":[{"id":105,"order_sn":"BS2021120814154581828868","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":1}]},{"order_sn":"BS2021120814145442022721","price":"0.02","status":1,"pay_time":1638944095,"pay_price":"0.02","add_time":1638944094,"goods_list":[{"id":104,"order_sn":"BS2021120814145442022721","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":2}]},{"order_sn":"BS2021120814085686048321","price":"0.02","status":1,"pay_time":1638943736,"pay_price":"0.02","add_time":1638943736,"goods_list":[{"id":103,"order_sn":"BS2021120814085686048321","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":2}]},{"order_sn":"BS2021120814064345625544","price":"0.02","status":2,"pay_time":1638943604,"pay_price":"0.02","add_time":1638943603,"goods_list":[{"id":102,"order_sn":"BS2021120814064345625544","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":2}]},{"order_sn":"BS2021120814051282610959","price":"0.01","status":1,"pay_time":1638943512,"pay_price":"0.01","add_time":1638943512,"goods_list":[{"id":101,"order_sn":"BS2021120814051282610959","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":1}]},{"order_sn":"BS2021120814042125829227","price":"0.01","status":1,"pay_time":1638943461,"pay_price":"0.01","add_time":1638943461,"goods_list":[{"id":100,"order_sn":"BS2021120814042125829227","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":1}]},{"order_sn":"BS2021120814032788866768","price":"0.03","status":1,"pay_time":1638943408,"pay_price":"0.03","add_time":1638943407,"goods_list":[{"id":99,"order_sn":"BS2021120814032788866768","goods_id":43,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2021-03-10\/93b26764136d5084822e7339e5e7d632.jpeg","title":"两盒特惠装一梳彩染发剂膏纯自己天然在家植物染男2021显白流行色","price":"0.01","count":3}]},{"order_sn":"BS2021120810345756705828","price":"0.01","status":1,"pay_time":1638930897,"pay_price":"0.01","add_time":1638930897,"goods_list":[{"id":98,"order_sn":"BS2021120810345756705828","goods_id":99,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2020-07-12\/78654515a50255c8d3d31eeb4ce544a8.jpeg","title":"小浣熊儿童宝宝洗发水沐浴露二合一小孩新生婴幼儿用品洗护家庭装","price":"0.01","count":1}]}]}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/del  <newapi>[新]</newapi>订单-删除

 * @apiName order_del
 * @apiGroup order


 * @apiParam {String} order_sn 订单编号
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.order_sn 订单编号

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"删除成功","data":[]}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/detail  <newapi>[新]</newapi>订单-详情
 * @apiDescription 订单流程：预生成》创建》订单列表》待支付》详情》再次付款
 * @apiName order_detail
 * @apiGroup order


 * @apiParam {String} order_sn 订单编号
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.order_sn 订单编号

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"order":{"id":107,"order_sn":"BS2021121719321944572625","uid":"bs91ca7180113e01fde28a157bb75bb78c","status":3,"price":"0.02","pay_price":"0.02","add_time":1639740739,"up_time":1639741088,"send_time":0,"pay_time":1639740739,"pay_type":"credit","trans_id":"","address":{"id":11,"uid":"bs91ca7180113e01fde28a157bb75bb78c","province":"北京","city":"北京市","area":"东城区","town":"","address":"xxxx浩","is_default":1,"mobile":"1655555555","username":"小编"},"cancel_pay_time":1639744339,"store_num":"123456","is_del":0,"pay_openid":"","express_com":"yunda","express_no":"1234444444444444444","refund_total":"0.00","receive_time":1639741088,"refund":null},"address":{"id":11,"uid":"bs91ca7180113e01fde28a157bb75bb78c","province":"北京","city":"北京市","area":"东城区","town":"","address":"xxxx浩","is_default":1,"mobile":"1655555555","username":"小编"},"goods_list":[{"id":73,"order_sn":"BS2021121719321944572625","goods_id":47,"thumb":"https:\/\/img.pddpic.com\/gaudit-image\/2021-11-21\/1550c02383aec776ebc721a33478bf9e.jpeg","title":"珀莱雅水乳护肤品套装女学生党化妆品全套洗面奶爽肤补水保湿正牌","price":"0.01","count":1,"commented":null},{"id":74,"order_sn":"BS2021121719321944572625","goods_id":48,"thumb":"https:\/\/t00img.yangkeduo.com\/goods\/images\/2020-09-03\/7d8faca96b4c63215df0ac0d9e0c69ef.jpeg","title":"南极人袜子男中筒秋冬季保暖船袜男士袜子复古百搭透气高筒篮球袜","price":"0.01","count":1,"commented":{"id":3}}]}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/order_count  <newapi>[新]</newapi>订单-数量统计

 * @apiName order_order_count
 * @apiGroup order
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.count 统计对象
 * @apiSuccess {String} data.count.count0 待付款
 * @apiSuccess {String} data.count.count1 代发货
 * @apiSuccess {String} data.count.count2 待收货
 * @apiSuccess {String} data.count.count3 待评价

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"count":{"count0":"1","count1":"11","count2":"1","count3":0}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/refund_apply  <newapi>[新]</newapi>订单-申请售后

 * @apiName order_refund_apply
 * @apiGroup order
 *
 * @apiParam {String} order_sn 订单编号
 * @apiParam {Number} type 退款类型，1-仅退款，2-退货退款，3-仅退货
 * @apiParam {String} reason 退款原因
 * @apiParam {String} money 退款金额，不得大于实付金额
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
    {"code":0,"msg":"ok","data":[]}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/refund_cancel  <newapi>[新]</newapi>订单-取消售后

 * @apiName order_refund_cancel
 * @apiGroup order
 *
 * @apiParam {String} order_sn 订单编号
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
    {"code":0,"msg":"ok","data":[]}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/get_virtual_info  <newapi>[新]</newapi>订单-虚拟品信息
    @apiDescription 虚拟商品发货在独立的接口展示
 * @apiName order_get_virtual_info
 * @apiGroup order
 *
 * @apiParam {String} order_sn 订单编号
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"order":{"order_sn":"BS2021122213463434822258","send_time":"2021-12-22 15:18:37","content_virtual":"<p>欢迎使用bs_shop购物VIP会员卡，您已购买VIP会员功能，请在有效期前使用，<font color=\"#ff0000\">请勿泄露<\/font>。<\/p><table class=\"table table-bordered\"><tbody><tr><td><b>卡号<\/b><\/td><td>1234567892<\/td><\/tr><tr><td><b>卡密<\/b><\/td><td>xe454x1f1615<\/td><\/tr><tr><td><b>有效期&nbsp;&nbsp;<\/b><\/td><td><font color=\"#ff0000\">2022-12-22 00:00:00<\/font><\/td><\/tr><tr><td><b>激活码&nbsp; &nbsp;<\/b><\/td><td>246165<\/td><\/tr><\/tbody><\/table><p><b>使用说明<\/b>：<\/p><p>打开【<a href=\"https:\/\/blog.alipay168.cn\/\" target=\"_blank\">绑卡<\/a>】，输入上面的卡号、卡密、激活码即可自动激活。<\/p><p><font color=\"#ff0000\">请在有效期前使用，超过有效期概不退换。<\/font><\/p><p><br><\/p>","uid":"bs91ca7180113e01fde28a157bb75bb78c","add_time":1640151994}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/comment_action  <newapi>[新]</newapi>评论-发表

 * @apiName order_comment_action
 * @apiGroup order
 *
 * @apiParam {String} from 操作类型:add-新增，del-删除
 * @apiParam {Number} ord_id 订单详情商品的记录ID，在详情里面goods_list返回的ID
 * @apiParam {Number} [isHidden] 是否匿名，1-是，0-否
 * @apiParam {Number} [star] 评价的星星数量，1~5星,del删除时不需要
 * @apiParam {String} [imgs] 评价图片，多个可以用逗号隔开(英文)，也可以提交数组
 * @apiParam {String} [content] 评价的内容，5~200字符
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"评价成功，感谢您的支持","data":[]}
 * */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/order/comment  <newapi>[新]</newapi>评论-获取

 * @apiName order_comment
 * @apiGroup order
 *
 * @apiParam {String=get} from 操作类型:get
 * @apiParam {Number} ord_id 订单详情商品的记录ID，在详情里面goods_list返回的ID
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"comment":{"id":3,"uid":"bs91ca7180113e01fde28a157bb75bb78c","order_goods_id":88,"goods_id":53,"content":"***，这个***，真的不懒啊哦","star":4,"add_time":1640851612,"imgs":["http:\/\/g.abc.top\/upload\/mall\/comment\/1b1eef32be5910a91593060bd3ef72ce.jpg"],"is_hide_user":1,"status":0}}}
 * */