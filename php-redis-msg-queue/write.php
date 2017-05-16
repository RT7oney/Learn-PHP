<?php
/**
 * Created by PhpStorm.
 * User: LUOCHAO
 * Date: 10/05/2017
 * Time: 15:56
 */
require_once('lib/wccRedis.php');

send();

function send()
{
    $url = 'http;//www.shwh.kong.com/HGFLUOMHFG&$%FMGJS^%^&';
    $data = array(
        'subject' => '商户账号激活',
        'htmlbody' => '激活账号请访问链接：<a href="' . $url . '">' . $url . '</a>',
        'sendfrom' => 'luochao258@qq.com',
    );
    $data = json_encode($data);
    $redis = new wccRedis();

    try {
        $status = $redis->push('sendemail', $data, fasle);
    } catch (wccRedisException $e) {
        echo '发送邮件失败';
    }

    if ($status) {
        echo '发送成功';
    } else {
        echo '发送失败';
    }
}
