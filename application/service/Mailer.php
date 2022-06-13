<?php


namespace app\service;

use app\common\controller\AppCommon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send($arg)
    {
        $mail = new PHPMailer(1);
        $conf = AppCommon::data_get('config', ['key' => 'email']);
        if (empty($conf)) {
            return ['code' => -1, 'msg' => '邮箱未配置'];
        }
        $conf = json_decode($conf['value'], true);
        if (empty($arg['to'])) {
            return ['code' => -1, 'msg' => '收件人未设置'];
        }
        if (!is_array($arg['to'])) {
            $arg['to'] = [$arg['to']];
        }
        if (empty($arg['title'])) {
            return ['code' => -1, 'msg' => '未设置邮件标题'];
        }
        if (empty($arg['content'])) {
            return ['code' => -1, 'msg' => '未设置邮件内容'];
        }
        //附件
        if (!empty($arg['attachment'])) {
            if (!is_array($arg)) {
                $arg['attachment'] = [$arg['attachment']];
            }
        }


        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->CharSet = $mail::CHARSET_UTF8;
            $mail->isSMTP();
            $mail->Hostname = URL_WEB;
            $mail->Host = $conf['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $conf['username'];
            $mail->Password = $conf['pwd'];
            $mail->SMTPSecure = $conf['encryption'];
            $mail->Port = $conf['port'];
            $mail->setFrom($conf['username'], $conf['nickname']);
            foreach ($arg['to'] as $v) {
                // $v = ['account'=>'132@xx.com','nickname'=>'昵称'];
                if (is_array($v)) {
                    if (empty($v['account'])) {
                        return ['code' => -1, 'msg' => '收件人格式错误'];
                    }
                    $mail->addAddress($v['account'], $v['nickname']);
                } else {
                    $mail->addAddress($v);
                }
            }
            //附件
            if (!empty($arg['attachment'])) {
                foreach ($arg['attachment'] as $f) {
                    if (file_exists($f)) {
                        $mail->addAttachment($f);
                    }
                }
            }


            $mail->isHTML(!empty($conf['isHtml']));
            $mail->Subject = $arg['title'];
            $mail->Body = $arg['content'];

            $res = $mail->send();
            if ($res){
                return ['code' => 0, 'msg' => '发送成功'];
            }
            return ['code' => -1, 'msg' => '发送失败'];
        } catch (Exception $e) {
            return ['code' => -1, 'msg' => $mail->ErrorInfo];
        }
    }
}