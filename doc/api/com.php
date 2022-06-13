<?php

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/com/uploader  <newapi>[新]</newapi>上传-图片

 * @apiName com_uploader
 * @apiGroup common
 *

 * @apiParam {String} from 上传来源，comment-商品评价,feedback-留言反馈
 * @apiParam {Number} [ord_id] 订单详情商品的记录ID，from=comment时必填
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"上传成功","data":{"url":"http:\/\/shop.test.top\/upload\/mall\/comment\/6592012a8f022833c6af7e6ef34e8951.jpg"}}
 *
 */
