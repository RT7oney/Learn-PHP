<?php
/**
 * Created by PhpStorm.
 * User: yuanzhao
 * Date: 16/2/3
 * Time: 下午2:25
 */
error_reporting(E_ALL);
session_start();
require_once('phpcjlk_v1.0/QueryList.class.php');
//请求session获取session_id
$url = "https://www.jinjiangcard.com";
common_curl_post_session($url);
$url = "https://www.jinjiangcard.com/mobile/payAction/prePaid";
$dataaa['phoneNo'] = '18672792565';
$dataaa['phoneNo2'] = '18672792565';
$dataaa['amount'] = '10';
$dataaa['total'] = '11.00';
$dataaa['fee'] = '1.00';
$post = common_curl_post($url,$dataaa);
//echo $post;
phpQuery::newDocument($post);
$re['img_url'] = pq(".yzm")->find('img')->attr('src');
$re['formToken'] = pq("input[name=formToken]")->val();
$re['total'] = pq("input[name=total]")->val();
//请求_lolita_uid 和保存图片
common_curl_get($re['img_url']);//请求验证码

//print_r($re);
//充值
$url = 'https://www.jinjiangcard.com/mobile/payAction/pay';
$pay_data['total'] = '11.00';
$pay_data['mobile'] = '18672792565';
$pay_data['formToken'] = $re['formToken'];
$pay_data['fee'] = '1.00';
$pay_data['rechargeAmount'] = 10;
$pay_data['cardNo'] = '1232 1321 3213 2131 231';
$pay_data['password'] = '233211';
$pay_data['captchaCode'] = 'f2ez5';
$pay_post = common_curl_post_4($url,$pay_data);
//
phpQuery::newDocument($pay_post);
$re['result'] = pq("#result")->text();
$re['fail'] = pq(".fail")->text();
$re['fail_msg'] = pq(".fail")->siblings('p')->text();
print_r($re);
////echo $pay_post;
exit;


function common_curl_post($url, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout on response
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_COOKIE,$_SESSION['session_id']);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}
function common_curl_post_4($url, $data)
{
    $header['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
//    $header['Accept-Encoding'] = 'gzip, deflate, br';
    $header['Accept-Language'] = 'zh-CN,zh;q=0.8,en;q=0.6,zh-TW;q=0.4';
    $header['Connection'] = 'keep-alive';
    $header['Cache-Control'] = 'max-age=0';
    $header['Content-Length'] = strlen(http_build_query($data));
    $header['Content-type'] = 'application/x-www-form-urlencoded';
    $header['Host'] = 'www.jinjiangcard.com';
    $header['Origin'] = 'https://www.jinjiangcard.com';
    $header['Upgrade-Insecure-Requests'] = '1';
//    $header['Referer'] = 'https://www.jinjiangcard.com/mobile/payAction/prePaid';
    $headerArr = array();
    foreach( $header as $n => $v ) {
        $headerArr[] = $n .':' . $v;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.jinjiangcard.com/mobile/payAction/prePaid');
    curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );
//    print_r($headerArr);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout on response
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_COOKIE,$_SESSION['_lolita_uid'].'; '.$_SESSION['session_id']);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}
function common_curl_post_session($url)
{
    if(!isset($_SESSION['session_id'])){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout on response
        $return = curl_exec($ch);
        preg_match('|Set-Cookie: (.*);|U', $return, $results);
        $_SESSION['session_id'] = $results[1];
        curl_close($ch);
    }
}
function common_curl_get($url) {
    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_HEADER, 1 );
    curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5');
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10); //timeout on connect
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 10); //timeout on response
    curl_setopt($ch, CURLOPT_COOKIE,$_SESSION['session_id']);
    $return = curl_exec ( $ch );
    $content_length = get_content_length($return);
    $header = substr($return,0,(strlen($return)-$content_length));
    $content = substr($return,(strlen($return)-$content_length));
    //根据内容长度获取头部和内容
    preg_match('|Set-Cookie: (.*);|U', $header, $results);
    $_SESSION['_lolita_uid'] = $results[1];
    file_put_contents("./cache/".session_id().'.jpg', $content);
//    print_r($results);
    curl_close ( $ch );
//    return $content;
}
function get_content_length($return){
    foreach(explode("\n",$return) as $key=>$val){
        if(preg_match('/Content-Length/', $val)){
            return trim(explode(':',$val)[1]);
        }
    }
}
