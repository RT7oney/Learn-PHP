<?php
/**
 * Created by PhpStorm.
 * User: LUOCHAO
 * Date: 10/05/2017
 * Time: 15:56
 */

// Pear Mail 扩展
require_once('Mail.php');
require_once('Mail/mime.php');
require_once('lib/wccRedis.php');


send_mail();

/**
 * author luochao
 * 发送邮件
 */
function send_mail()
{
    $redis = new wccRedis();

    //******************** 发送人的配置信息 ********************************
    $smtpinfo = array();
    $smtpinfo["host"] = "smtp.126.com";//SMTP服务器
    $smtpinfo["port"] = '25'; //SMTP服务器端口
    $smtpinfo["username"] = "luochao252@126.com"; //发件人邮箱
    $smtpinfo["password"] = "kong2017";//发件人邮箱密码
    $smtpinfo["timeout"] = 30;//网络超时时间，asd
    $smtpinfo["auth"] = TRUE;//登录验证

//    $smtpinfo["debug"] = TRUE;//调试模式TRUE

    while (True) {
        try {
            $task = $redis->pop('sendemail', true);
            if ($task) {
                $data = json_decode($task);
                //开始发送邮件
                set_time_limit(0);//不限制时间，默认时间为30秒

                // 收件人列表
                $mailAddr = array($data->sendfrom);

                // 发件人显示信息
                $from = "管理员 <luochao252@126.com>";

                // 收件人显示信息
                $to = implode(',', $mailAddr);

                // 邮件标题
                $subject = $data->subject;

                // 邮件正文
                $content = "<h3>$data->htmlbody</h3>";

                // 邮件正文类型，格式和编码
                $contentType = "text/html; charset=utf-8";

                //换行符号 Linux: \n  Windows: \r\n
                $crlf = "\n";
                $mime = new Mail_mime($crlf);
                $mime->setHTMLBody($content);

                $param['text_charset'] = 'utf-8';
                $param['html_charset'] = 'utf-8';
                $param['head_charset'] = 'utf-8';
                $body = $mime->get($param);

                $headers = array();
                $headers["From"] = $from;
                $headers["To"] = $to;
                $headers["Subject"] = $subject;
                $headers["Content-Type"] = $contentType;
                $headers = $mime->headers($headers);
                $smtp =& Mail::factory('smtp', $smtpinfo);
                $mail = $smtp->send($mailAddr, $headers, $body);
                $smtp->disconnect();

//                //日志记录路径
//                $log_dir = $_SERVER ['DOCUMENT_ROOT'] . "/wochacha_script/send_email/log/";
//                if (!file_exists($log_dir)) {
//                    mkdir($log_dir, 0777, true);
//                }
                if (PEAR::isError($mail)) {
                    //发送失败
//                    file_put_contents($log_dir . "sendemail.log", date('Y-m-d H:i:s') . "\r" . $data->sendfrom . "\r" . $data->subject . "\r" . $data->htmlbody . "fail\r\n", FILE_APPEND);
                    echo 'Email sending failed: ' . $mail->getMessage() . "\n";
                } else {
                    //发送成功
//                    file_put_contents($log_dir . "sendemail.log", date('Y-m-d H:i:s') . "\r" . $data->sendfrom . "\r" . $data->subject . "\r" . $data->htmlbody . "success\r\n", FILE_APPEND);
                    echo "success!\n";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
        sleep(3);
    }
}