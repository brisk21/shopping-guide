<?php

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/account/get_vcode  <newapi>[新]</newapi>验证码-图形验证码
 * @apiDescription 获取图形验证码，直接返回图片，可以直接放在图片的src位置显示图片
 * @apiName verify_get_vcode
 * @apiGroup verifycode


 * @apiParam {String} pwd 新密码
 * @apiParam {String} dcode 动态码
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/account/get_change_pwd_dcode  <newapi>[新]</newapi>动态码-修改密码
 * @apiDescription 登录后可以进行密码修改，获取动态码即可
 * @apiName verify_get_change_pwd_dcode
 * @apiGroup verifycode

 *
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
{"code":0,"msg":"发送成功,注意查收","data":[]}

 *
 */
/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/account/get_forget_pwd_dcode  <newapi>[新]</newapi>动态码-重置密码
 * @apiDescription 忘记密码时可以找回密码，通过账号和动态码验证
 * @apiName verify_get_forget_pwd_dcode
 * @apiGroup verifycode

 * @apiParam {String} account 登录账号，仅限邮箱或者手机号的用户
 * @apiParam {String} vcode 图形验证码，通过/mall/account/get_vcode获取
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
    {"code":0,"msg":"发送成功,注意查收","data":[]}

 *
 */