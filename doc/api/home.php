<?php

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/home/get_navs  <newapi>[新]</newapi>首页-图标导航
 * @apiName home_get_navs
 * @apiGroup home
 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"navs":[{"id":1,"title":"超级红包","url":"http:\/\/blog.wei1.top","img":"http:\/\/g.abc.top\/static\/mall\/images\/icon-link1.png"},{"id":2,"title":"酒水饮料","url":"\/mall\/goods\/pro_list.html?category_id=3","img":"http:\/\/g.abc.top\/static\/mall\/images\/icon-link2.png"},{"id":3,"title":"我的订单","url":"\/mall\/order\/all_orders.html","img":"http:\/\/g.abc.top\/static\/mall\/images\/icon-link3.png"},{"id":4,"title":"个人主页","url":"\/mall\/user\/index.html","img":"http:\/\/g.abc.top\/static\/mall\/images\/icon-link4.png"},{"id":9,"title":"dsfdsf","url":"\/mall\/home\/index","img":"http:\/\/g.abc.top\/upload\/bsnavs\/905fd482498ebe4bc9565f678007775f.jpg"}]}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/home/get_article  <newapi>[新]</newapi>首页-公告列表
 * @apiName home_get_article
 * @apiGroup home
 *
 * @apiParam {Number} [page] 分页，默认1
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"article":[{"id":2,"title":"写一个连续的就业班教程"},{"id":1,"title":"这个是好商城，第一个开发的连续版本"}]}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/home/get_article_info  <newapi>[新]</newapi>首页-公告详情
 * @apiName get_article_info
 * @apiGroup home
 *
 * @apiParam {Number} id 公告ID
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"article":{"id":2,"title":"写一个连续的就业班教程","content":"这是文章内容这是文章内容这是文章内容这是文章内容这是文章内容这是文章内容这是文章内容这是文章内容8","add_time":"2021-10-23","up_time":1638776601,"status":1,"count_view":0}}}
 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/home/get_banner  <newapi>[新]</newapi>首页-轮播图
 * @apiName get_banner
 * @apiGroup home
 *

 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"ok","data":{"banner":[{"id":1,"title":"","url":"http:\/\/blog.wei1.top","img":"http:\/\/g.abc.top\/static\/mall\/upload\/ban1.jpg"},{"id":2,"title":"","url":"\/mall\/goods\/pro_list.html?category_id=3","img":"http:\/\/g.abc.top\/static\/mall\/upload\/ban2.jpg"},{"id":3,"title":"","url":"\/mall\/order\/all_orders.html","img":"http:\/\/g.abc.top\/static\/mall\/upload\/ban3.jpg"},{"id":4,"title":"","url":"\/mall\/user\/index.html","img":"http:\/\/g.abc.top\/static\/mall\/upload\/ban4.jpg"}]}}
 *
 */