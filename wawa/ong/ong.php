<?php
/* ongsoft phpFrame Application
 * ******************************************
 * home: www.ongsoft.com   mail: ai@13yd.com
 * Copyright  ongsoft
 * Trademark  ONG
 * ******************************************
 */

ob_start();
if( !defined( 'ONGHEAD') || ONGHEAD =='') header("Content-Type:text/html;charset=utf-8"); 
else                                      header( ONGHEAD ); 

if( !defined( 'ONGPHP')) exit( 'Error OngSoft'); 

function request_uri(){

        if ( isset( $_SERVER['argv']))
                $uri = $_SERVER['PHP_SELF'].( empty( $_SERVER['argv']) ? '' :  ( '?'. $_SERVER['argv'][0] )   );
        else if( isset( $_SERVER['QUERY_STRING'])) $uri = $_SERVER['PHP_SELF'].(empty($_SERVER['QUERY_STRING'] ) ? '' : ( '?'. $_SERVER['QUERY_STRING'] ));
        else if( isset( $_SERVER['REQUEST_URI']) ) $uri = $_SERVER['REQUEST_URI'];
        else  $uri = $_SERVER['PHP_SELF'].(empty($_SERVER['QUERY_STRING'] ) ? '' : ( '?'. $_SERVER['QUERY_STRING'] ));
        $_SERVER['REQUEST_URI'] = $uri;
}

request_uri();

$URI = ltrim( strtolower( urldecode( trim($_SERVER["REQUEST_URI"]))),'/'); 

if(! isset( $BAT ) ){


    $ZHURU = array( '<', '>', '..', '(', ')','"',"'","*",'[',']','{','}','$');

    foreach( $ZHURU  as $anyou){

            if( strpos( $URI , $anyou) !== false){

                header( 'HTTP/1.1 404 Not Found');
                exit  ( '<script>alert("error");window.location.href="/";</script>"');

            }
    }

}

if( defined( 'ONGCON') && ONGCON !='') $CONLJI =  ONGPHP.ONGCON.".php";

                                  else $CONLJI =  ONGPHP."conn.php";

                      $CONN = include  $CONLJI;


if( defined( 'ONGDB') && ONGDB !='')  $DBLJI =  ONGPHP.ONGDB.".php";
 
                                 else $DBLJI =  ONGPHP."config.php";

                     $DBCO = include  $DBLJI;

// if( isset( $CONN['dbug'] ) && $CONN['dbug'] == '0') error_reporting(!E_ALL);
                     error_reporting(E_ALL & ~E_NOTICE);

if( isset( $CONN['shiqu']) && $CONN['shiqu'] != '') @date_default_timezone_set( $CONN['shiqu']); 

function zifuzhuan($data){

    if( ! get_magic_quotes_gpc() ) return addslashes( str_replace( array( '0xbf27' , '0xbf5c27' ), array( "'" , "'" ) , $data ));else return $data;
}

if( $_POST ){

    if( strstr( strtolower( json_encode( $_POST) ), $DBCO[$CONN['modb']]['qian'])  && ONGNAME != 'install') exit('feifa');
}

$FUJIAN = array('gif'=> 'gif', 'jpg' => 'jpg', 'jpeg' => 'jpeg', 'png' => 'png', 'swf' => 'swf', 'flv' => 'flv', 'mp3' => 'mp3', 'wav' => 'wav', 'wma' => 'wma', 'wmv' => 'wmv' , 'mid' => 'mid', 'avi' => 'avi' , 'mpg' => 'mpg', 'asf' => 'asf' , 'rm' => 'rm', 'rmvb' => 'rmvb', 'doc' => 'doc', 'docx' => 'docx', 'xls' => 'xls', 'xlsx' => 'xlsx', 'ppt' => 'ppt', 'htm' => 'htm', 'html' => 'html', 'txt' => 'txt', 'zip' => 'zip', 'rar' => 'rar', 'gz' => 'gz', 'bz2' => 'bz2', '7z' => '7z') ;

define('WEBFENG',$CONN['fenge']);

function plus( $plus){   

        /* return false; //编译替换 */

        global $CONN;
        
        if( is_array( $plus)){

            $pluss = array_flip( array_flip( $plus));
            $hcs =   md5( implode( '@',$pluss));

            global  ${'PLUS'. $hcs};

            if( ${'PLUS'. $hcs})  return false;

            $lujin = ONGPHP.'plus/temp/'. $hcs.'.php';
              
            if($CONN['hchs']=='1'){  
                    
                    if(file_exists($lujin)){
                           
                              include $lujin; 
                              return true;
                    } 
            }

            $das = array();

            foreach( $pluss as $anyou){

                global  ${'PLUS'. $anyou};
                          
                    if( ! ${'PLUS'. $anyou}){
                           
                        include ONGPHP.'plus/'. $anyou.'.php';
                           
                        if( $CONN['hchs'] == '1')$das[] = file_get_contents(ONGPHP.'plus/'. $anyou.'.php');

                    }
                }

            if( $CONN['hchs'] == '1'){

                if(! ${'PLUS'. $hcs}){

                    ${'PLUS'. $hcs} =12;

                    $sssx = '<?php '.'$PLUS'. $hcs.'=2;';

                    $sssx .= str_replace('<?php //' , '' , implode(' ',$das) );

                    file_put_contents($lujin,$sssx);

                }
            }

        }else{

            global ${'PLUS'.$plus};  
  
            if( ! ${'PLUS'. $plus}) include ONGPHP.'plus/'.$plus.'.php';

        }

}


function wlx($mingzi,$shuchu=1){

        if( file_exists( ONGPHP.'Ong.php')){

            if( $shuchu !=  1 )
                 return iconv( "UTF-8", "GBK//IGNORE", $mingzi);
            else
                 return iconv( "GBK", "UTF-8//IGNORE", $mingzi);

        }else return $mingzi;
}


function isssl(){

        if(!isset( $_SERVER['HTTPS'])) return false;
        else if( $_SERVER['HTTPS'] === 1)  return true;
        else if( $_SERVER['HTTPS'] === 'on') return true;
        else if( $_SERVER['SERVER_PORT'] == 443) return true;
        return false;
}


$AGENT = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' ;

$SHOUJI = ( 
            strpos( $AGENT, "NetFront" ) ||
            strpos( $AGENT, "iPhone") ||
            strpos( $AGENT, "iPad")  ||
            strpos( $AGENT, "MIDP-2.0") ||
            strpos( $AGENT, "Opera Mini") ||
            strpos( $AGENT, "UCWEB") ||
            strpos( $AGENT, "Android") ||
            strpos( $AGENT, "Windows CE") ||
            strpos( $AGENT, "SymbianOS")

           );

if( defined( 'ONGQHTPL') && ONGQHTPL !='') $CONN['htpl'] = ONGQHTPL;
if( defined( 'ONGQQTPL') && ONGQQTPL !='') $CONN['qtpl'] = ONGQQTPL;

define( 'QTLANG' , ONGPHP.'../tpl/home/'.wlx( $CONN['qtpl'] ).'/qt_'.$CONN['qtlang'].'.php' );
define( 'QTLAUI' , ONGPHP.'../tpl/home/'.wlx( $CONN['qtpl'] ).'/qt_ui.php' );

if( ONGQQTPL == ''

    &&  ( $SHOUJI  ||
            ( $CONN['WAPHTTP'] != ''  &&  $_SERVER['HTTP_HOST'] == $CONN['WAPHTTP'] )
        ) 
    &&  file_exists( ONGPHP.'../tpl/home/wap'.wlx($CONN['qtpl']).'/index.php')

)   $CONN['qtpl'] = 'wap' . $CONN['qtpl'];

define( 'HTLANG', ONGPHP.'../tpl/lang/ht_'.$CONN['htlang'].'.php');

define( 'SOFTNAME', '先锋科技');
define( 'SOFTHTTP', '');
define( 'SOFTVER' , 'QQ:624103075');

define( 'PAGETRIM' , $CONN['pagetrim']);

if( isssl() ) $HOSTQZ = 'https://' ; else  $HOSTQZ = 'http://' ;

if( $CONN['HTTP'] != '') {

    if( $SHOUJI && $CONN['WAPHTTP'] != '' )  
            define( 'WZHOST', $HOSTQZ . $CONN['WAPHTTP'] . $CONN['dir'] );
    else if($CONN['WAPHTTP'] != ''  && $CONN['WAPHTTP'] == $_SERVER ['HTTP_HOST'] )  
            define( 'WZHOST', $HOSTQZ . $CONN['WAPHTTP'] . $CONN['dir'] );
    else    define( 'WZHOST', $HOSTQZ . $CONN['HTTP'] . $CONN['dir'] );

}else       define( 'WZHOST', $HOSTQZ . $_SERVER['HTTP_HOST'] . $CONN['dir']);

define( 'QTPL' , ONGPHP.'../tpl/home/'.wlx($CONN['qtpl']).'/');
define( 'HTPL' , ONGPHP.'../tpl/admin/'.wlx($CONN['htpl']).'/');
define( 'TPL'  , $CONN['dir'].'tpl/');
define( 'DQTPL', $CONN['dir'].'tpl/home/'.$CONN['qtpl'].'/');
define( 'DHTPL', $CONN['dir'].'tpl/admin/'.$CONN['htpl'].'/');

if( defined( 'ONGTEMP')) define('Txpath',ONGPHP.ONGTEMP.'/'); else define('Txpath',ONGPHP.'temp/');

include ONGPHP.'ufunction.php';

if( defined( 'ONGNAME')) include ONGPHP.'moudl/'.ONGNAME.".php";