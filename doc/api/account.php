<?php

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/account/logout  <newapi>[新]</newapi>账号-退出登录
 * @apiName account_logout
 * @apiGroup account

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
 * @api {post}  /mall/account/do_login  <newapi>[新]</newapi>账号-登录
 * @apiName account_do_login
 * @apiGroup account

 * @apiParam {String} account 登录账号
 * @apiParam {String} pwd 登录密码
 * @apiParam {String} [token] 防重复口令
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层
 * @apiSuccess {String} data.token 登录口令，请全局带上，后台检验用户信息

 *
 * @apiSuccessExample Success-Response:
{"code":0,"msg":"登录成功","data":{"token":"TW1Oa016VmhZVFJsTlRjMFkyVXhORE0xTmpJMk16STROek0wWkdFMlpXRjhNVFl6T1RFeE9UUTROWHhpY3pJME9UQXlNVE14WkRKaVltTTBZVGsxTldZM1lqSmtaRE14TVRSaFkyUmk="}}
 *
 */

/**
 * @apiVersion 1.0.0
 * @api {post}  /mall/account/reg_action  <newapi>[新]</newapi>账号-注册
 * @apiDescription <span style="color:red;">参数如：account=abc&vcode=EDC6Q&pwd1=123456&pwd2=123456&token=39399caa35e98e402a351d9951dde94a</span>
 * @apiName account_reg_action
 * @apiGroup account

 * @apiParam {String} account 登录账号
 * @apiParam {String} vcode 图形验证码
 * @apiParam {String} pwd1 登录密码
 * @apiParam {String} pwd2 确认密码
 * @apiParam {Number} dcode 短信动态码
 * @apiParam {String} [token] 防重复口令
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
 * @api {post}  /mall/account/reset_pwd  <newapi>[新]</newapi>账号-找回密码
 * @apiName account_reset_pwd
 * @apiGroup account

 * @apiParam {String} account 登录账号
 * @apiParam {String} pwd 新密码
 * @apiParam {String} dcode 动态码
 *
 * @apiSuccess {Number} code 返回信息码 0 表示查询正常
 * @apiSuccess {String} msg 返回说明信息
 * @apiSuccess {String} data 数据层


 *
 * @apiSuccessExample Success-Response:
    {"code":0,"msg":"修改成功","data":[]}
 *
 */

