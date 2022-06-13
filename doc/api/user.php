<?php

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/my_credits  <newapi>[新]</newapi>用户-账户余额
 * @apiName user_my_credits
 * @apiGroup user
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.credits 账户对象
 * @apiSuccess {String} data.credits.point 积分
 * @apiSuccess {String} data.credits.credit 余额
 * @apiSuccess {String} data.credits.goods 收藏商品数量

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"credits":{"point":8,"credit":"1008.75","goods":2}}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/data_count  <newapi>[新]</newapi>数量统计
 * @apiName user_data_count
 * @apiGroup user
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} count 数据层
 * @apiSuccess {String} count.credits 账户对象
 * @apiSuccess {String} count.credits.point 积分
 * @apiSuccess {String} count.credits.credit 余额
 * @apiSuccess {String} count.goods 收藏商品数量
 * @apiSuccess {String} count.msg 未读消息数量
 * @apiSuccess {String} count.order 订单统计

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"count":{"order":{"count0":"1","count1":"19","count2":"1","count3":"2"},"credit":{"point":78,"credit":"100322.78"},"goods":4,"msg":9}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/my_records  <newapi>[新]</newapi>用户-余额交易记录
 * @apiName user_my_records
 * @apiGroup user
 *
 * @apiParam {Number} [page] 分页，默认1
 * @apiParam {Number} type 类型，1-交易，2-充值，3-提现
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"records":[{"add_time":"2021-12-08 10:34:57","remark":"商品支付","num":0.01,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:03:28","remark":"商品支付","num":0.03,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:04:21","remark":"商品支付","num":0.01,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:05:12","remark":"商品支付","num":0.01,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:06:44","remark":"商品支付","num":0.02,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:08:56","remark":"商品支付","num":0.02,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:14:55","remark":"商品支付","num":0.02,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:15:46","remark":"商品支付","num":0.01,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:16:15","remark":"商品支付","num":0.03,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:17:00","remark":"商品支付","num":0.03,"type":1,"ctype":"-"},{"add_time":"2021-12-08 14:17:25","remark":"商品支付","num":0.03,"type":1,"ctype":"-"},{"add_time":"2021-12-10 13:52:53","remark":"商品支付","num":0.03,"type":1,"ctype":"-"}]}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/my_address  <newapi>[新]</newapi>用户-收货地址列表
 * @apiName user_my_address
 * @apiGroup user
 *
 * @apiParam {Number} [page] 分页，默认1
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
 * {"code":0,"msg":"ok","data":{"address":[{"id":12,"uid":"bs1e7cdd3a5c3265c3f3c7bb77602d8ec9","province":"北京","city":"北京市","area":"石景山区","town":"","address":"222222","is_default":1,"mobile":"111","username":"111"}]}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/my_address_info  <newapi>[新]</newapi>用户-收货地址详情
 * @apiName my_address_info
 * @apiGroup user
 *
 * @apiParam {Number} id 地址ID
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
    {"code":0,"msg":"ok","data":{"address":{"id":13,"uid":"bs1e7cdd3a5c3265c3f3c7bb77602d8ec9","province":"河北省","city":"石家庄市","area":"长安区","town":"","address":"bs_shop开发大楼35层5-3号","is_default":1,"mobile":"13500000025","username":"小白"}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/my_address_action  <newapi>[新]</newapi>用户-收货地址操作
 * @apiName my_address_action
 * @apiGroup user
 *
 * @apiParam {Number} [id] 地址ID,编辑或者删除时必填
 * @apiParam {Number} [is_default] 是否默认，1-默认，0-非默认
 * @apiParam {String} [from] 操作方式，填写“del”代表删除该地址
 * @apiParam {Number} mobile 收件号码
 * @apiParam {String} username 收件人
 * @apiParam {String} addr  省市区，用空格分开，如“北京 北京市 石景山区”
 * @apiParam {String} detail  详细地址 ，如石景山bsShop商城开发大楼35层

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
 * @api {post}  /mall/user/info <newapi>[新]</newapi>用户-基本信息
 * @apiName user_info
 * @apiGroup user
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
    {"code":0,"msg":"ok","data":{"user_info":{"account":"wei@alipay168.cn","uid":"bs76eb38dc7a8550b10d506b157e17d50f","status":1}}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/msg_list <newapi>[新]</newapi>消息-列表
 * @apiName user_msg_list
 * @apiGroup user
 *
 * @apiParam {Number} [page] 当前分页
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"msg_list":[{"id":9,"title":"退款成功","content":"您的订单已退款，请自行查看订单......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":8,"title":"退款成功","content":"您的订单已退款，请自行查看订单......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":7,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":6,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":5,"title":"确认收货成功","content":"您购买的商品已被确认收货，若不......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":4,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":3,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":2,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"},{"id":1,"title":"您购买的商品发货啦","content":"您购买的商品发货了，查看发货信......","type":1,"add_time":"2021年12月22日","typeDesc":"系统通知"}]}}
 *
 */


/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/user/feedback <newapi>[新]</newapi>留言反馈
 * @apiName user_feedback
 * @apiGroup user
 *
 * * @apiParam {String} category 分类，请参考页面
 * * @apiParam {String} content 内容，200字以内
 * * @apiParam {String} [from] 来源，msg-留言，feedback-反馈
 * * @apiParam {String} [imgs] 图片地址，多个用逗号分开
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"感谢您的留言\/反馈","data":[]}
 *
 */