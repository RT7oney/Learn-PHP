<?php //
$PLUSupdate = 'update';

function check_gifcartoon( $image_file ){ 

        $fp = fopen($image_file,'rb'); 
        $image_head = fread($fp,1024); 
        fclose($fp); 
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/", $image_head)?false:true;
} 

function suoluetu( $imgqian){

            global $CONN;

            list( $width , $height , $type ) = getimagesize($imgqian);

            if(!$width)return false;

             $imghou   = $imgqian.'suoluetu.jpg';
             $zhiliang = (int)$CONN['upzhiliang'];

             if($zhiliang < 30 )$zhiliang = 30;
             else if ($zhiliang > 99 )$zhiliang = 95;


             $new_width  = $width > $CONN['updayu'] && $height> $CONN['updayu'] ? $width * $CONN['upsuobili']: $width; 
             
             $new_height = $height > $CONN['updayu'] && $width > $CONN['updayu'] ? $height * $CONN['upsuobili']: $height; 
         
            switch( $type ){ 

             case 1: 

                $giftype = check_gifcartoon($imgqian);
            
              if( $giftype){ 

                $image_wp=imagecreatetruecolor($new_width, $new_height); 

                $image = imagecreatefromgif($imgqian); 

                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                

                imagejpeg($image_wp, $imghou, $zhiliang); 
                imagedestroy($image_wp); 
              } 
              break; 

            case 2: 

              $image_wp = imagecreatetruecolor($new_width, $new_height); 
              $image = imagecreatefromjpeg($imgqian); 

              imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 

              imagejpeg($image_wp, $imghou, $zhiliang); 
              imagedestroy($image_wp); 
              break; 

            case 3: 

              $image_wp = imagecreatetruecolor($new_width, $new_height); 
              $image = imagecreatefrompng($imgqian);
              imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
              imagejpeg($image_wp , $imghou, $zhiliang );  
              imagedestroy($image_wp); 
              break; 

          } 

          return '';
}



function shuiying( $imgqian){

         
             global $CONN;

             list($width,$height,$type) = getimagesize($imgqian);

            
             if(!$width)return false;

             $imghou   = $imgqian.'shuiying.jpg';

             $zhiliang = (int)$CONN['upzhiliang'];

             if($zhiliang < 30 ) $zhiliang = 30;
             else if ($zhiliang > 99 ) $zhiliang = 95;

             $new_width  = $width ; 
             $new_height = $height; 

             $LUJIN = ONGPHP.'../tpl/font/watermark.png';

             $images = imagecreatefrompng( $LUJIN);

             list( $widthss ,$heightss ) = getimagesize( $LUJIN);

             if( $CONN['upx'] !='' &&  $CONN['upy'] != ''  && $CONN['upweizhi'] == '0'){
                  
                  $X = $CONN['upx'] ;
                  $Y = $CONN['upy'] ;
             
             }else if( $CONN['upweizhi'] == '1' ){  /* 中上*/

                  $X = ($width - $widthss) / 2;
                  $Y = 0;
             
             }else if( $CONN['upweizhi'] == '2' ){  /* 右上*/

                  $X = $width - $widthss;
                  $Y = 0;

             }else if( $CONN['upweizhi'] == '3' ){  /* 右中*/

                  $X = $width - $widthss;
                  $Y = ($height - $heightss) / 2 ;

             }else if( $CONN['upweizhi'] == '4' ){  /* 右下*/

                  $X = $width - $widthss;
                  $Y = $height - $heightss;

             }else if( $CONN['upweizhi'] == '5' ){  /* 中下*/

                  $X = ($width - $widthss) / 2;
                  $Y = $height - $heightss;

             }else if( $CONN['upweizhi'] == '6' ){  /* 左下*/

                  $X = 0;
                  $Y = $height - $heightss;

             }else if( $CONN['upweizhi'] == '7' ){  /* 左中*/

                  $X = 0;
                  $Y = ($height - $heightss) / 2;

             }else if( $CONN['upweizhi'] == '8' ){  /* 中中 */

                  $X = ($width - $widthss) / 2;
                  $Y = ($height - $heightss) / 2;
             
             }else  $Y = $X = 0;
            
              switch( $type ){ 

                case 1: 
                  $giftype = check_gifcartoon($imgqian);
                  if( $giftype){ 

                    $image_wp=imagecreatetruecolor($new_width, $new_height); 
                    $image = imagecreatefromgif($imgqian); 

                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagecopymerge ( $image_wp , $images , $X , $Y, 0, 0,$widthss, $heightss , 100 );
                    
                    imagejpeg($image_wp, $imghou, $zhiliang); 
                    imagedestroy($image_wp); 

                  } 

                  break; 

                case 2: 
                  $image_wp = imagecreatetruecolor($new_width, $new_height); 
                  $image = imagecreatefromjpeg($imgqian); 

                  imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height); 
                  imagecopymerge ( $image_wp , $images , $X , $Y, 0, 0,$widthss, $heightss , 100 );

                  imagejpeg($image_wp, $imghou, $zhiliang); 
                  imagedestroy($image_wp); 
                  break; 

                case 3: 
                  $image_wp = imagecreatetruecolor($new_width, $new_height); 
                  $image = imagecreatefrompng($imgqian);
                  imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                  imagecopymerge ( $image_wp , $images , $X , $Y, 0, 0,$widthss, $heightss , 100 );

                  imagejpeg($image_wp , $imghou, $zhiliang );  
                  imagedestroy($image_wp); 
                  break; 

          } 

          return '';


}

function updateoss( $lujin , $CONN ){

        /*oss图片上传*/


        if( !file_exists( $lujin)) return false;

        $NEIRONG = file_get_contents($lujin );

        $APID = $CONN['ftpuser'];
        $APKY = $CONN['ftppass'];

        $request_url  = $CONN['ftpurl'];
        $curl_handle = curl_init();

        $cmd5 = base64_encode(md5($NEIRONG, true));
        $shijia = gmdate('D, d M Y H:i:s \G\M\T',time());

       

        $LUJIN = str_replace(array(ONGPHP,'..'),'',$lujin);

        $temp_arr = explode( "." , $LUJIN);
        $file_ext = array_pop( $temp_arr);
        $file_ext = trim( $file_ext);
        $file_ext = strtolower( $file_ext);

        if( !(strpos( ','.$CONN['isoss'].',' ,','.$file_ext.',' ) !== false) ) return false;

        $REST   = 'PUT';
        $filher = filemete( $LUJIN ) ;

        $string_to_sign =  $REST."\n".
            $cmd5."\n" .
            $filher."\n" .
           $shijia."\n" .
            "/".trim($CONN['ftpport'],'/').'/'.trim($LUJIN,'/');
        $qianm = base64_encode(hash_hmac('sha1', $string_to_sign,  $APKY, true));
        $temp_headers = array( 'Content-MD5: '.$cmd5,
            'Content-Type: '.$filher,
            'Authorization: OSS '.$APID.':'.$qianm,
            'Date: '.  $shijia,
            'Host: '.$request_url,
            'Content-Length: '.strlen($NEIRONG)
        );

        curl_setopt($curl_handle, CURLOPT_URL, $request_url.'/'.$LUJIN);
        curl_setopt($curl_handle, CURLOPT_FILETIME, true);
        curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT, false);
        curl_setopt($curl_handle, CURLOPT_MAXREDIRS, 5);
        curl_setopt($curl_handle, CURLOPT_HEADER, false);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT, 360);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,360);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $temp_headers);
        curl_setopt($curl_handle, CURLOPT_NOSIGNAL, true);
        curl_setopt($curl_handle, CURLOPT_REFERER, $request_url);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, "RequestCore/1.4.3");
        curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, $REST);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$NEIRONG );

        $data = curl_exec( $curl_handle);
        curl_close( $curl_handle );

        /*@unlink( $lujin );*/

        return true;

}


function updateftp( $lujin ){
          
        global $CONN;

        if( isset($CONN['isoss']) &&  $CONN['isoss'] !='' ) return updateoss( $lujin , $CONN );
        if( $CONN['ftpurl'] =='' ) return false;

        $ftp_server = $CONN['ftpurl'];
        $conn_id = ftp_connect( $ftp_server, $CONN['ftpport']);
        if( ! $conn_id ) return false;
        if( ! @ftp_login( $conn_id, $CONN['ftpuser'] ,  $CONN['ftppass'])) return false;

        $shuju = explode( '../' , $lujin);
        $path = $shuju['1'];
        $dir = explode( '/', $path);
        $file_ext = array_pop( $dir);
        $path = ''; 
        $ret = true; 

        for ( $i = 0 ; $i < count( $dir) ; $i++ ){
          
            $path .= '/' . $dir[ $i]; 
             if( ! @ftp_chdir( $conn_id, $path)){
                 
                   @ftp_chdir( $conn_id ,'/'); 
                   if(! @ftp_mkdir( $conn_id, $path)){ 
                       $ret = false; 
                        break; 
                   } 
            } 
        } 

        if( file_exists( $lujin)){

            $fp = fopen( $lujin , 'r');
            if( !@ftp_fput( $conn_id , $file_ext , $fp, FTP_BINARY)) return false;
            fclose( $fp);
            ftp_close( $conn_id);

            return true;

        }else return false;
}


function updatepic( $lujin ){

        global $CONN;

        updateftp( $lujin);

        if( $CONN['upsuo'] == 1 ){  
           
            suoluetu( $lujin );
            updateftp( $lujin .'suoluetu.jpg');

        }

        if( $CONN['shuiying'] == 1){
           
            shuiying( $lujin );
            updateftp( $lujin.'shuiying.jpg');
        }

        return  '';


}

function update( $guanid = 0 ,$type = 0 ,$adminid = 0, $uid = 0,$sid = 0){  

               /* 图片上传处理
                  $guanid   管理id
                  $type     上传分类
                  $adminid  管理员id
                  $uid      用户uid
                  $sid      商家id
 
               */

         ob_clean();
         $ext_arr = array( 'image' => array('gif', 'jpg', 'jpeg', 'png'),
                           'flash' => array('swf', 'flv'),
                           'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
                            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2','7z'),
                             'all' => array('gif', 'jpg', 'jpeg', 'png' ,'swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb','doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2','7z','apk')
                    );


         if( isset( $_GET['uplx']) && isset(  $ext_arr[ $_GET['uplx']])) $LX = $_GET['uplx'];
         else  $LX = 'all';

         global $CONN,$LANG;

         $max_size = isset( $_GET['maxsize']) && $CONN['maxsize'] >= $_GET['maxsize'] &&  $_GET['maxsize'] > 10 ? $_GET['maxsize'] : $CONN['maxsize'];

         if (! empty( $_FILES[ $LX]['error'])) {

                switch( $_FILES[ $LX]['error']){
                    case '1':
                        $error = $LANG['update']['error1'];  
                        break;
                    case '2':
                        $error = $LANG['update']['error2'];
                        break;
                    case '3':
                        $error = $LANG['update']['error3'];
                        break;
                    case '4':
                        $error = $LANG['update']['error4'];
                        break;
                    case '6':
                        $error = $LANG['update']['error6'];
                        break;
                    case '7':
                        $error = $LANG['update']['error7'];
                        break;
                    case '8':
                        $error = $LANG['update']['error8'];
                        break;
                    case '999':
                    default:
                        $error =  $LANG['update']['error999'];
              }
               
               return  array( 'code'=> '0', 'msg' => $error );
         }

         $qianzui = 'attachment/'.$LX.'/'.date('Ym').'/';
         $files =  $CONN['dir'].$qianzui;
         $WJIAN =  ONGPHP.'../'.ltrim( $qianzui  ,'/');


         jianli($WJIAN);

         if ( empty( $_FILES) === false) {


                
                $file_name = $_FILES[$LX]['name'];
                

 


                $tmp_name  = $_FILES[$LX]['tmp_name'];
                
                $file_size = $_FILES[$LX]['size'];
                
                if ( !$file_name ) return  array( 'code'=> '0', 'msg' => $LANG['update']['meiwenjian']);
                
                if ( @is_dir( $WJIAN ) === false) return array( 'code'=> '0', 'msg' => $LANG['update']['meimulu'] );
            
                if ( @is_writable( $WJIAN ) === false) return array( 'code'=> '0', 'msg' => $LANG['update']['meixieru']);
                
                if ( @is_uploaded_file( $tmp_name) === false) return array( 'code'=> '0', 'msg' => $LANG['update']['chuanshibai']);

                if ( $file_size > $max_size ) return array( 'code'=> '0', 'msg' => $LANG['update']['maxsizeda'] ); 

                $temp_arr = explode( "." , $file_name);

                $file_ext = array_pop( $temp_arr);

                $file_ext = trim( $file_ext);

                $file_ext = strtolower( $file_ext);

                if( in_array( $file_ext , $ext_arr[ $LX]) === false)  return  array( 'code'=> '0', 'msg' => $LANG['update']['shangchuanyun'].implode( ',' , $ext_arr[ $LX]) );
                 
                $Nfile =  date('d').'_'.mima( time().rand( 1 , 9999999)).'.'.$file_ext;

                $returnfile = $files.$Nfile;


                 $md5hash = md5( md5_file( $tmp_name).( $uid.'_'.$guanid.'_'.$type));

                 $D = db('fujian');

                 $reutrntoken  = $D ->where( array( 'token' => $md5hash))-> find();

                 $CDN = '';
          
                 if( ! $reutrntoken ){

                  if ( move_uploaded_file( $tmp_name, $WJIAN.$Nfile ) === false) return array( 'code'=> '0', 'msg' => $LANG['update']['chuanshibai']);

                        @chmod( $WJIAN.$Nfile , 0644);

                        $CDN = updatepic( $WJIAN.$Nfile );

                        $charu = $D -> insert( array(  'guanid' => $guanid ,
                                                'type' => $type,
                                             'adminid' => $adminid ,
                                                'name' => anquanqu($file_name),
                                                 'uid' => $uid ,
                                                 'sid' => $sid ,
                                                 'cdn' => $CDN,
                                               'atime' => time(),
                                                 'pic' => $returnfile ,
                                              'houzui' => $file_ext,
                                                'size' => $file_size,
                                               'token' => $md5hash,
                              ));

                        if( $charu ) $returnfile = $CDN.$returnfile;

                 }else  $returnfile = $reutrntoken['cdn'].$reutrntoken['pic'];

                

                if( strpos( $_SERVER["HTTP_USER_AGENT"] , "MSIE")) header( 'Content-type:text/html; charset=UTF-8' );
                else  header( 'Content-type:application/json ;charset=UTF-8');

                return  array( 'code' => 1 , 'content' =>  array( 'pic' => $returnfile,'size' => $file_size,'houzui' => $file_ext) );

         }else  return  array( 'code'=> '0', 'msg' => $LANG['update']['meiwenjian']);

}