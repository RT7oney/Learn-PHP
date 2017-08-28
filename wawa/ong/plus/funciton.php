<?php //

$PLUSfunciton = 'funciton';


function fenjieimg( $ji ){ 

        /*  分解内容的图片 */
        $aaa = array();
        $ji = str_ireplace( 'IMG' , 'img' , $ji);
        $ji = str_ireplace( 'src' , 'src' , $ji);
        $ji = str_ireplace( '>' , ' >' , $ji );
        preg_match_all('#src=(.*) #iUs', $ji , $matches );
        $aaa['count'] = count($matches['0']);
        $aaa['bao']=$matches['0'];
        $aaa['bbao']=$matches['1'];
        return $aaa;
}





function toxls( $x ,$file){

        ob_clean();
        header("Content-type:text/csv");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename= $file.csv ");
        echo iconv( "UTF-8", "GBK//IGNORE",$x);
        exit();
        
        
}


function anquanqu( $name ){

        return str_replace( array( '#','/','，','|','、','\\','*','_','-','?','<','>','.',"\n","\r",'【','】','(',')','：','{','}','\'','"',':',' ',';',' '), array(), strtolower( trim($name)));
}


function msgbox ( $mess='' , $location='yes'){ 

        if( isset( $_GET['ajson'])){

           ob_clean();
           header('Content-type:application/json;charset=UTF-8');
           if( $location == 'yes' ) $location = 1;
           $token = token();

           if( isset( $_GET['action'])) $_SESSION[ $_GET['action']]  = $token;
           exit( json_encode( array( 'code' => $location,'msg' => $mess, 'token' =>  $token)));
        }

        if( $location == 'yes') 
           $locations = "window.history.back();";
        else 
           $locations = " window.location.href='".$location."';";

        if($mess == '')
           echo  '<script>'. $locations.'</script>';
        else
           echo  '<script>alert("'.$mess.'");'. $locations.'</script>';

        die;
}


function adminmsgbox( $mess = '',$location = ''){

        if( isset( $_GET['ajson'])){

           ob_clean();
           if( $location == 'yes' || $location == '' ) $location = 1;

           header('Content-type:application/json;charset=UTF-8');
           $token = token();

           if( isset( $_GET['action'])) $_SESSION[ $_GET['action']]  = $token;
        
           exit( json_encode( array( 'code' => $location , 'msg' => $mess , 'token' =>  $token)));
        
        }
       
        if( $location == 'yes')
            echo '<script> '.( $mess == ''?'': 'alert("'.$mess.'");').' window.history.back();</script>';
        else if($location == '')
            echo '<script> '.( $mess == ''?'': 'alert("'.$mess.'");').' window.parent.parent.scrollTo(0,0);parent.location.reload();</script>';
        else echo '<script> '.( $mess == ''?'': 'alert("'.$mess.'");').'  window.location.href="'.$location.'";</script>';
        die;
}


function listmit( $page_size, $page){ 
    
        $page= (float)( $page) <= 0 ? 1 : $page;
        $page_size = (float)( $page_size) <= 0 ? 1 : $page_size;
        return $pages = ( ( $page-1) * $page_size). "," . $page_size;
}


function qsubstr($str, $start=0, $length=1, $charset="utf-8", $suffix=false){

        if( $length == 0) return $str;

        if( function_exists( "mb_substr")) {
              if( mb_strlen( $str, $charset) <= $length) return $str;
              $slice = mb_substr( $str, $start, $length, $charset);
        }else {
              $re['utf-8']   = "/[/x01-/x7f]|[/xc2-/xdf][/x80-/xbf]|[/xe0-/xef][/x80-/xbf]{2}|[/xf0-/xff][/x80-/xbf]{3}/";
              $re['gb2312'] = "/[/x01-/x7f]|[/xb0-/xf7][/xa0-/xfe]/";
              $re['gbk']         = "/[/x01-/x7f]|[/x81-/xfe][/x40-/xfe]/";
              $re['big5']         = "/[/x01-/x7f]|[/x81-/xfe]([/x40-/x7e]|/xa1-/xfe])/";
              preg_match_all( $re[ $charset], $str, $match);
              if( count( $match[0]) <= $length) return $str;
              $slice = join( "", array_slice( $match[0], $start, $length));
        }

        if( $suffix ) return $slice."";
        return $slice;
}


function ywselect($data,$zhi='',$biaoshi='',$kid=''){ 

        $x='';
        foreach( $data as $k => $v){

              if( $biaoshi =='') $z = $v;
              else $z = $v[ $biaoshi];

              if( $kid !='') $k = $v[ $kid];
              if( $zhi == $k && $zhi !='') $x .= '<option value="'. $k .'" selected="selected">'. $z .'</option>';
              else   $x .='<option value="'. $k .'">'. $z .'</option>';
        }
        return $x;
}


function getarray($para) {

        $arg  = "";
        while ( list ( $key, $val) = each ( $para))  $arg .= $key . "=" . $val . "&";
        $arg = substr( $arg , 0 , count( $arg) -2 );
        if( get_magic_quotes_gpc() ) $arg = stripslashes( $arg);
        return $arg;
}


function yzcode( $biaodan = 'code' , $lx = 0 ,$time = 0 , $schu = 1){

        /*  验证code
           $biaodan = 接收表单;
        */

        if( ! isset( $_POST[ $biaodan ] ) ||
            ! isset( $_SESSION['code'] ) ||
            $_SESSION['code'] == ''
        )   return false;

        $CODE = $lx == 1 ? $_POST[ $biaodan] : strtolower( $_POST[$biaodan] );

        if( $_SESSION['code'] != $CODE ) return false;

        if( $schu == 1 ) unset( $_SESSION['code'] );

        if( $time > 0 ){

           if( ! isset( $_SESSION['codetime'] ) || ( $_SESSION['codetime'] + $time) < time()  )return false;

           if( $schu == 1 ) unset( $_SESSION['codetime'] );

        }

        return true;

}


function yzsms( $SMS , $CODE ){

        /*验证短信*/

        global $Mem ;

        $HASH = 'sms/'.mima( $SMS );
        $DATA = $Mem -> g( $HASH );

        if( ! $DATA ) return false;
        if( $DATA != $CODE) return false;

        $Mem -> d( $HASH );
        return true;

}


function token(){

        return md5('令牌'. time() . rand(1,9999999999).'token产生');
}


function yztoken( $token = 'token',$TOKEN = 'token' ){

        /*  验证token
           $token 传递什么值 POST SESSION 都是相同值
        */


        if(!isset( $_POST[$token] ) && isset( $_GET[$token]) ) $_POST[$token] = $_GET[$token];

        if(!isset( $_POST[$token] )    ||
           !isset( $_SESSION[$TOKEN] ) ||
           strlen( $_SESSION[$TOKEN] ) != 32 ||
           $_POST[$token] != $_SESSION[$TOKEN]

        )   return false;

        if( isset( $_POST[$token] ) )    unset( $_POST[$token] );
        if( isset( $_SESSION[$TOKEN] ) ) unset( $_SESSION[$TOKEN] );
        if( isset( $_POST['submit'] ) )  unset( $_POST['submit'] );

        return true;

}


function yzpost( $canshu = array() ){

        /* 验证POST */

        if( $canshu ){

            foreach( $canshu as $ong ){

                list( $name , $type , $zhi ) = explode( '#' , $ong );

                if( !isset( $_POST[$name] ) ) return array( 'code' => '0' , 'biao' => $name ,'msg' => $zhi );

                $_POST[$name] = trim( $_POST[$name] );

                if( $type == 'len' ){

                    if( $_POST[$name] == '' ) return array( 'code' => '0' , 'biao' => $name ,'msg' => $zhi );

                    list( $XI , $DA ) = explode( '-' , $zhi.'-' );

                    $zlen = strlen( $_POST[$name] );

                    if( $DA != '' ){
                       
                        if($zlen < $XI || $zlen > $DA  ) return array( 'code' => '0' , 'biao' => $name ,'msg' => $XI.'-'.$DA);

                    }else if( $zlen != $XI ) return array( 'code' => '0' , 'biao' => $name , 'msg' => $XI );

                }else if( $type == '=' ){

                    if( $_POST[$name] != $zhi ) return array( 'code' => '0' , 'biao' => $name ,'msg' => $zhi );
                }
            }
        }

        return  array( 'code' => '1' , 'biao' => 'all' ,'msg' => '' );
}


function adminlog( $id, $type = 0, $data = '', $ip = ''){

        /*管理日志记录
           $id    管理人员uid
           $type  管理日志分类 0 登录 1 退出 2 被挤掉  3 修改 4 删除 5 添加
           $data  日志详细设置
           $ip    指定ip记录
        */

        $adminlog = db('adminlog');
        return $adminlog -> insert( array(  'uid' => $id ,
                                           'type' => $type ,
                                           'data' => $data ,
                                             'ip' => $ip == '' ? ip(): $ip,
                                          'atime' => time()
                                          )
                                    ); 
}


function userlog( $id, $type = 0, $data = '', $ip = ''){

        /*
           管理日志记录
           $id    管理人员uid
           $type  管理日志分类 0 登录 1 退出 2 被挤掉  3 修改 4 删除 5 添加
           $data  日志详细设置
           $ip    指定ip记录
        */

        $adminlog = db('userlog');
        return $adminlog -> insert( array( 'uid' => $id ,
                                          'type' => $type ,
                                          'data' => $data ,
                                            'ip' => $ip == '' ? ip(): $ip,
                                         'atime' => time()
                                          )
                                  ); 
}


function xinghao( $str ){
         
         /* 星号隐藏 */

         $len = strlen( $str );
         if( ! $str || $len < 4) return '***';

         $zuisao = $len / 3;
         if( is_int( $zuisao ) ) $huo = qsubstr($str,1, $zuisao - 1 > 0 ? $zuisao-1 : 1);
         else $huo = qsubstr( $str , 3 , $len / 2);

         return   str_replace( $huo ,'***',$str);
}


function   uid( $id , $qx = '' ,$D = ''){

           /*
            用户uid
            $id 帐号id
            $qx  = 2 删除缓存返回失败
                 = 1 强行更新缓存
             返回 -1 加大缓存力度
           */

            $id = (float) trim( $id);

            if( $id < 1 )return false;

            global $Mem; 
            $hash = 'uid/'.$id ;
     
            if( $qx == 2){

                $Mem -> d( $hash);
                return false;
            }

            $data = $Mem -> g( $hash);

            if( $data === '-1' && $qx == '')return false;

            if( $data && $qx == '')return $data;

            if( $D == ''){ 

                $db = db('user');
                $dbc = $db  -> where( array( 'uid' => $id) )-> find();

           }else $dbc = $D ->setshiwu('0') ->setbiao('user')  -> where( array( 'uid' => $id) )-> find();

           if( $dbc){

                    $Mem ->s ( $hash, $dbc);
                    return $dbc;

           }else{ 
                    $Mem ->s ( $hash, '-1', 10);
                    return false;
           }
}


function adminuid( $id , $qx = ''){

           /*
            缓存管理用户uid
            $id 帐号id
            $qx  = 2 删除缓存返回失败
                 = 1 强行更新缓存
            返回 -1 加大缓存力度
           */

            $id = (float) trim( $id);
            if( $id < 1) return false;
            global $Mem; 

            $hash = 'adminuid/'.$id ;
     
            if( $qx == 2){

                $Mem -> d( $hash);
                return false;
            }

            $data = $Mem -> g( $hash);

            if( $data === '-1' && $qx == '')return false;
            if( $data && $qx == '')return $data;

            $db = db('admin');

            $dbc = $db -> find( array( 'id' => $id));

            if( $dbc){
      
                 $Mem ->s ( $hash, $dbc);
                 return $dbc;
            }else{ 

                 $Mem ->s ( $hash, '-1', 10);
                 return false;
            }
}


function orderid(){

        return date('YmdHis') .rand(1000,9999).rand(10,99);
}


function adminfenzu( $type = '0' ){

        /*
            读取管理分组
            -1 全部分组读取出来
        */

        if( $type == '0') return '0';

        $adminfenzu =  db( 'adminfenzu');
       
        if( $type == -1)
            $shuju = $adminfenzu -> select();
        else
            $shuju = $adminfenzu -> where( array( 'id' => $type) ) -> find();

        if( $shuju) return $shuju; 
        else        return false;
}


function logac( $name = '', $qx ='' ){

        /* 
            $name  一般等于表的名字
            $qx    强行更新
        */

        global $Mem;

        if( $name == '' ) return false;

        $HASH = 'logac/'.mima( $name);
        $DATA = $Mem -> g( $HASH );

        if( $DATA === '-1') return false;
        if( $DATA && $qx == '' )return $DATA;

        $D = db( 'logac');
        
        $SHUJU  = $D -> where( array( 'type' => $name )) -> find();

        if( $SHUJU ){
            
            if( $SHUJU['data'] != '' ){

                $DATA = explode( ',' , $SHUJU['data']);
                $Mem -> s( $HASH , $DATA);

                return $DATA;
            }
        }
        
        $Mem -> s( $HASH ,'-1','10');

        return false;
}


function jiaqian( $UID , $TYPE = 0 , $JINE = 0,$JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = ''){

          /* 加钱
             $UID  用户uid
             $TYPE = 0 , $JINE = 0,$JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = ''
             
          */
         
        $D = db( 'user');

        $sql = '';

        

        if( $JIFEN != '0'){

            $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID,'jifen >='=> ($JIFEN < 0 ? -$JIFEN: 0 ) )) -> update( array( 
                   
                   'jifen +' => $JIFEN,
                  
                 )
                );

            $sql .=$D -> setshiwu(1) -> setbiao('jifenlog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $JIFEN,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                        ));
        }

        if( $JINE != '0'){

              $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID ,'jine >='=> ($JINE < 0 ? -$JINE: 0 ) )) -> update( array( 
                    'jine +' => $JINE,
                   
                 )
                );

            $sql .=$D -> setshiwu(1) -> setbiao('jinelog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $JINE,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                        ));
        }


        if( $HUOBI != '0'){
              $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID,'huobi >='=> ($HUOBI < 0 ? -$HUOBI: 0 ))) -> update( array( 
              
                   'huobi +' => $HUOBI,
                 )
                );

            $sql .= $D -> setshiwu(1) -> setbiao('huobilog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $HUOBI,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                       ));
        }

        $fan = $D -> qurey($sql ,'shiwu');

       

        if( $fan ){

            uid($UID ,1,$D );

            return true;

        }else return false;

}


function huobi( $CONN ,$lx = 1 ){

        $fan = array($CONN['jine'],$CONN['jifen'],$CONN['huobi']);
        if( $lx != 1) return $fan;
        $shuju = array();
        foreach( $fan as $k => $v) $shuju[] = $k.','.$v;
        return implode('@', $shuju );

}


function houtaifenjie( $biaoti , $k , $v ,$tuiuse = '' ){

        /* 后台菜单分解
           $biaoti  表单的标题带# 分组
           $k       表单的name
           $v       表单的值
          
        */
        $x = '';

        $fenjie = explode('#',$biaoti);

        $x .='<div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">'.$fenjie['0'].'：</label>
                <div class="formControls col-xs-8 col-sm-9">';

        $gaodu = 'style="height:300px"';

        if( isset($fenjie['2'] )) $gaodu = 'style="height:'.$fenjie['2'].'px"';


        if( isset( $fenjie['1'] )){

            if( $fenjie['1']  == 'textarea' )
                
                $x .='<textarea name="'.$k.'" '.$gaodu.' class="input-text" placeholder="">'.$v.'</textarea>';

            else if( $fenjie['1']  == 'nopass' ){

                if($v != '') $v = $tuiuse;
                $x .='<input type="text" class="input-text" name="'.$k.'" value="'.$v.'">';

            }else if( $fenjie['1']  == 'text' ) $x .='<input type="text" class="input-text" name="'.$k.'" value="'.$v.'">';

            else if( $fenjie['1']  == 'password' ) $x .='<input type="password" class="input-text" name="'.$k.'" value="'.$v.'">';
            else if( $fenjie['1']  == 'imgupdate' ){

                $x .='<input type="text" class="input-text" style="width:60%;"  value="'.$v.'" placeholder="" id="imgshow'.md5($k).'"  name="'.$k.'" > <input type="button" id="filePicker2'.md5($k).'"  value="update"  />';
                $x .="<script>KindEditor.ready(function(K) { 
                                var uploadbutton".md5($k)." = K.uploadbutton({
                                                    button : K('#filePicker2".md5($k)."')[0],
                                                 fieldName : 'all',
                                                       url : '".$_SERVER['SCRIPT_NAME']."?action=".$_GET['action']."&mode=edit&uplx=all&apptoken=".session_id()."',
                                               afterUpload : function(data) {
                                                                if ( data.error === 0) {
                                                                        var url = K.formatUrl(data.url, 'absolute');
                                                                        K('#imgshow".md5($k)."').val(url);

                                                                }else{ 
                                                                    
                                                                    layer.msg(data.message, { time: 2000 });
                                                                }
                                                            }, afterError : function( str ) {
                                                                    layer.msg(str, { time: 2000,  });
                                                            }
                            });

                            uploadbutton".md5($k).".fileBox.change(function(e) {

                                                    uploadbutton".md5($k).".submit();
                            });
                            
                            K('.ke-upload-area').css({'width':'88px'});

                           });
                </script>";

            }else if( $fenjie['1']  == 'imgtuji2' ){ 

                 $x.='<div class="idcplist'.md5($k).'">';
               

                    if( ! is_array( $v ) ) $v = unserialize($v);


                    if( is_array ( $v ) ){

                         foreach(  $v  as $ks=>$vv){

                             if($vv == '')continue;


                             $x.='<div class="tupianji f-l" style="margin-right:8px;" id="picddel'.md5($k.'_'.$ks).'"><img src="'.$vv.'" alt="..." class="thumbnail" style="width:100px;height:100px;"><input type="hidden" name="'.$k.'[]" value="'.$vv.'"><a href="javascript:deltc(\''.md5($k.'_'.$ks).'\');"><i class="Hui-iconfont" style="color:red;font-size:22px;margni-left:8px;display:block;">&#xe6e2;</i></a></div>';

                         }

                     }

               $x.='</div>';

                     global $CONN;
               $x.='<input type="button" id="filePicker2'.md5($k).'" class="ke-button-common ke-button" value="update"  />';
               $x .="<script>
                  if(typeof i === 'undefined') i= 1;
                  i = i*1+'".count($v)."';
               KindEditor.ready(function(K) { 

                   var editor = K.editor({
                    allowFileManager : false,
                    filePostName : 'all',
                       uploadJson : '".$_SERVER['SCRIPT_NAME']."?action=".$_GET['action']."&mode=edit&uplx=all&apptoken=".session_id()."',
                       langType: '".$CONN['htlang']."'
                });

                K('#filePicker2".md5($k)."').click(function() {
                    editor.loadPlugin('multiimage', function() {
                        editor.plugin.multiImageDialog({
                            clickFn : function(urlList) {
                                
                                
                                K.each(urlList, function(i, data) {
                                    if (data.error === 0) { 
                                        
                                        var url = K.formatUrl(data.url, 'absolute');";

                                        $x .='   i++; $(".idcplist'.md5($k).'").append(\'<div class="tupianji f-l" style="margin-right:8px;" id="picddel\'+(i+1)+\'"><img src="\'+data.url+\'" alt="..." class="thumbnail" style="width:100px;height:100px;"><input type="hidden" name="'.$k.'[]" value="\'+data.url+\'"><a href="javascript:deltc(\'+(i+1)+\');"><i class="Hui-iconfont" style="color:red;font-size:22px;margni-left:8px;display:block;">&#xe6e2;</i></a></div>\');
                                      var url = K.formatUrl(data.url, "absolute");';

                                     $x .= " } 
                                    
                                editor.hideDialog();
                            
                              });
                          }
                    });
                });
                });

             });
             
             </script>";

            
            
            
            }else if( $fenjie['1']  == 'imgtuji' ){ 

               $x.='<div class="idcplist'.md5($k).'">';
               
                    if( ! is_array( $v ) ) $v = unserialize($v);

                    if( is_array ( $v ) ){

                         foreach(  $v  as $ks=>$vv){

                             if($vv == '')continue;


                             $x.='<div class="tupianji f-l" style="margin-right:8px;" id="picddel'.md5($k.'_'.$ks).'"><img src="'.$vv.'" alt="..." class="thumbnail" style="width:100px;height:100px;"><input type="hidden" name="'.$k.'[]" value="'.$vv.'"><a href="javascript:deltc(\''.md5($k.'_'.$ks).'\');"><i class="Hui-iconfont" style="color:red;font-size:22px;margni-left:8px;display:block;">&#xe6e2;</i></a></div>';

                         }

                     }

               $x.='</div>';


               $x.='<input type="button" id="filePicker2'.md5($k).'"  value="update"  />';
               $x .="<script>
                  if(typeof i === 'undefined') i= 1;
                  i = i*1+'".count($v)."';
               KindEditor.ready(function(K) { 
                       var uploadbutton".md5($k)." = K.uploadbutton({
                    button : K('#filePicker2".md5($k)."')[0],
                    fieldName : 'all',
                    url : '".$_SERVER['SCRIPT_NAME']."?action=".$_GET['action']."&mode=edit&uplx=all&apptoken=".session_id()."',
                    afterUpload : function(data) {
                        if (data.error === 0) { var url = K.formatUrl(data.url, 'absolute');";

               $x .='   i++; $(".idcplist'.md5($k).'").append(\'<div class="tupianji f-l" style="margin-right:8px;" id="picddel\'+(i+1)+\'"><img src="\'+data.url+\'" alt="..." class="thumbnail" style="width:100px;height:100px;"><input type="hidden" name="'.$k.'[]" value="\'+data.url+\'"><a href="javascript:deltc(\'+(i+1)+\');"><i class="Hui-iconfont" style="color:red;font-size:22px;margni-left:8px;display:block;">&#xe6e2;</i></a></div>\');
                            var url = K.formatUrl(data.url, "absolute");';



                $x .= " } else {

                            layer.msg(data.message, { time: 2000,  });

                        

                        }
                    },
                    afterError : function(str) {
                        
                        layer.msg(str, { time: 2000,  });
                    }
                });

                uploadbutton".md5($k).".fileBox.change(function(e) {
                    uploadbutton".md5($k).".submit();
                });

                K('.ke-upload-area').css({'width':'88px'});

             });
             
             </script>";


            }else if( $fenjie['1']  == 'textqunji' ){ 

                $x.='<div class="qujicplist'.md5($k).'">';

                    if(! is_array($v)) $v = array(); 

                    $candan =  explode(',',$fenjie['2']);

                    if( $v ){

                        $z = 1;

                        


                    foreach($v as $cc){
                        

                            $x.='<div id="'.md5($k).$z.'" data="'.md5($k).'" style="margin-top:5px;">';

                            foreach( $candan as $wouc){

                               

                                 if( isset( $cc[$wouc] )) $s = $cc[$wouc];
                                 else $s = '';

                                 if(strpos( $wouc , 'update-') !== false  ){

                                     $kk = ($k.'['.$z.']['.$wouc.']');

                                  

                                         $x .=$wouc.': <input type="text" class="input-text" style="width:208px;margin-right:2px;"  value="'.$s.'" placeholder="" id="imgshow'.md5($kk).'"  name="'.$k.'['.$z.']['.$wouc.']" > <input type="button" id="filePicker2'.md5($kk).'"  value="update"  />';
                                         $x .="<script>KindEditor.ready(function(K) { 
                                var uploadbutton".md5($kk)." = K.uploadbutton({
                                                    button : K('#filePicker2".md5($kk)."')[0],
                                                 fieldName : 'all',
                                                       url : '".$_SERVER['SCRIPT_NAME']."?action=".$_GET['action']."&mode=edit&uplx=all&apptoken=".session_id()."',
                                               afterUpload : function(data) {
                                                                if ( data.error === 0) {
                                                                        var url = K.formatUrl(data.url, 'absolute');
                                                                        K('#imgshow".md5($kk)."').val(url);

                                                                }else{ 
                                                                    
                                                                    layer.msg(data.message, { time: 2000 });
                                                                }
                                                            }, afterError : function( str ) {
                                                                    layer.msg(str, { time: 2000,  });
                                                            }
                            });

                            uploadbutton".md5($kk).".fileBox.change(function(e) {

                                                    uploadbutton".md5($kk).".submit();
                            });
                            
                            K('.ke-upload-area').css({'width':'88px'});

                           });
                </script>";

                                    
                                 
                                 
                                 
                                 }else $x.=$wouc.': <input type="text" class="input-text" style="width:208px;margin-right:2px;" name="'.$k.'['.$z.']['.$wouc.']" value="'.$s.'">';

                            }

                            $x.='<a href="javascript:shanchuduo(\''.md5($k).$z.'\')" style="color:Red;"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></div>';
                            $z++;

                       }

                      

                    }

                $x.='</div><a  style="color:blue;" href="javascript:zengjia(\''.md5($k).'\',\''.$k.'\',\''.$fenjie['2'].'\')"> <i class="Hui-iconfont"  style="color:green;">&#xe600;</i> </a>';


            }else if( $fenjie['1']  == 'select' ){ 


                $DSZU = array();
                
                if(strpos( $fenjie['2'] , 'logac-') !== false  ) $fenjie['2'] = logacto( str_replace('logac-','', $fenjie['2']) );


                $tmen = explode('@',$fenjie['2']);

                if( $tmen ){

                    foreach($tmen as $mm ){

                        $tt = explode(',',$mm);
                        $DSZU[$tt['0']] = $tt['1'];
                    }
                }

                $x.= '<select name="'.$k.'" class="select">'.(ywselect( $DSZU, $v)).'</select>';

            }else if( $fenjie['1']  == 'hidden' ){

                return '<input type="hidden" class="input-text" name="'.$k.'" value="'.$v.'">';

            }else if( $fenjie['1']  == 'show' ){

                $x.='<span class="yddddd">'.$v.' </span>';

            }else if( $fenjie['1']  == 'time' ){

                $x.='<span class="yddddd">'.($v > 0 ? date('Y-m-d H:i:s',$v ):'NO time').' </span>';

            }else if( $fenjie['1']  == 'selectshow' ){

                $DSZU = array();
                
                if(strpos( $fenjie['2'] , 'logac-') !== false  ) $fenjie['2'] = logacto( str_replace('logac-','', $fenjie['2']) );


                $tmen = explode('@',$fenjie['2']);

                if( $tmen ){

                    foreach($tmen as $mm ){

                        $tt = explode(',',$mm);
                        $DSZU[$tt['0']] = $tt['1'];
                    }
                }

               

                $x.= '<span class="yddddd '.$k.$v.'">'.(isset($DSZU[$v])?$DSZU[$v]:' NO data').' </span>';

            }else if( $fenjie['1']  == 'ui' ){

                global $CONN, $NOUI;

                if( !isset( $fenjie['2'] ) || $fenjie['2'] == '' )$fenjie['2'] = '300px';

                $classv =  'UI'.md5($k);
                if( isset($NOUI) && $NOUI == 1)

                    $x .= '<textarea name="'.$k.'"   style="width:100%;height:'.$fenjie['2'].';">'.$v.'</textarea>';
                
 
                else

                $x .='<script type="text/javascript"> 
                        var editor;
                        KindEditor.ready(function(K) {
                            editor = K.create(".'.$classv.'", {
                            resizeType : 1, 
                            langType: \''.$CONN['htlang'].'\',
                            allowPreviewEmoticons : false,
                            allowImageUpload : true,
                            filePostName : \'all\',
                            uploadJson : "'.$_SERVER['SCRIPT_NAME'].'?action='.(isset($_GET['action'])?$_GET['action']:'').'&mode='.(isset($_GET['mode'])?$_GET['mode']:'').'&uplx=all&apptoken='.session_id().'",
                        allowFileManager : false
                        }); });
                    </script><textarea name="'.$k.'" class="'.$classv.'" style="width:100%;height:'.$fenjie['2'].';">'.$v.'</textarea>';
            }


        }else  $x .='<input type="text" class="input-text" name="'.$k.'" value="'.$v.'">';


        $x .='</div></div>';

        return $x;

}


function logacto( $logac , $lx = 1 ){
        
        /*logac 解析表单系列 */
        if($lx == 2)
             $fan = $logac;
        else $fan = logac( $logac );

        if( $fan ){

            $shuju = array();
            foreach( $fan as $k => $v) $shuju[] = $k.','.$v;
            return implode('@', $shuju );

        }else return ',全部';
}


function logacjiexi( $logac ){
 

        $D = db( 'logac');

        $SHUJU  = $D -> where( array( 'type' => $logac )) -> find();

        if( $SHUJU ){
            
            if( $SHUJU['data'] != '' ){

                $tmen = explode('@',$SHUJU['data']);
                 $level = false;

                if( $tmen ){
                     $level = array();

                    foreach($tmen as $mm ){

                        $tt = explode(',',$mm);
                        $level[$tt['0']] = $tt['1'];
                    }
                }

                return $level;
            }
        }

        return false;
}


function qtfile(){

        /* 读取前台模版文件 */

        $qtpl = array();
        $dir  = ONGPHP.'../tpl/home/';
        $ds   = DIRECTORY_SEPARATOR;
        $dir  = substr( $dir , -1 ) == $ds ? substr( $dir , 0 , -1 ) : $dir ;

        if ( is_dir( $dir ) && $handle = opendir( $dir ) ){

            while ( $file = readdir( $handle ) ){

                if ( $file == '.' || $file == '..' ) continue;
                else  $qtpl[ $file ] = $file;

            }
            closedir( $handle );
        }

        return  $qtpl;

}


function url( $name = ''){

        global $CONN;

        /* url过滤 */
        return str_replace( array( '//',',','，','|','、','\\','*','?',
                                    '<','>','.',"\n","\r",'【','】',
                                    '(',')','：','{','}','\'','"',':',' ',';', $CONN['sosoword'] , $CONN['userword'],$CONN['houzui']
                            ),
                            array('/'),
                            strtolower( $name )
                        );

}


function mourl($url = '', $http = '', $URL = '' , $ID = 0 , $LX = 1 ){

        /* url连接组合

        $url url 连接
        $http  外网连接
        $mos   自定义url
        yunxing 1 phpinfo模式
                2 动态模式
                3 伪静态
                4 静态模式
        id  id
        lx  1 分类 2 内容
        */

        if( $http != '' )  return $http;
        if( $url  == '' )  return WZHOST;

        global $CONN;

        $xxx = $URL == '' ? $CONN['houzui']:$URL;

        if( $CONN['zhiurloff'] == 1 && $ID > 0 ){

            if( $LX == 1) $url = $CONN['zhiurltype'].$ID;
            else          $url = $CONN['zhiurlcent'].$ID;

        }

        if( $CONN['yunxing'] == '1' ) 
             return WZHOST.'index.php'.'/'.$url.$xxx;
        else if( $CONN['yunxing'] == '2' ) 
             return WZHOST.'index.php'.'?'.$url.$xxx;
        else return WZHOST.$url.$xxx; 

}


function error404( $MSGBOX  = '',$LX = '0'){

        /*  输出页面404
           输出调试错误等
       */
       global $Memsession,$Mem,$CONN,$LANG,$HTTP;

       $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
       $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
       $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

       $NTPL  =  QTPL.'404.php';
       if( file_exists( $NTPL)) include $NTPL;
       else echo $MSGBOX;

       if( $LX == '0' ) die;
}


function chaurl( $url , $QX = '', $D = '' ){

        /* 查找url 
            lx 1 分类
            lx 2 内容
        */
        global $Mem,$CONN;
        $url = trim( $url );
        if( $url == '' )return false;
        $HASH = 'url/'.mima( $url );

        if( $QX == '2'){

            $Mem -> d( $HASH );
            return false;
        }

        $DATA = $Mem -> g( $HASH );

        if( $DATA === '-1' && $QX == '' )     return false;
        if( $DATA && $QX == '' ) return $DATA;

         
        if( $CONN['zhiurloff'] == 1 && $QX == '' ){

            
            $lxx = 0;
            $IDD = 0;

            if( $CONN['zhiurltype'] != '' ){

                if( strpos( $url , $CONN['zhiurltype'] ) !== false){
                
                    $lxx = 1;
                    $IDD = (float)str_replace( $CONN['zhiurltype'] , '', $url );
                }
            
            
            }else if( $CONN['zhiurlcent'] != ''){

                if( strpos( $url , $CONN['zhiurlcent'] ) !== false){
                
                    $lxx = 2;
                    $IDD = (float)str_replace( $CONN['zhiurlcent'] , '', $url );

                }else{

                    $lxx = 1;
                    $IDD = (float)$url;
                }

            }
            

            if( $lxx < 1 ){

                if( strpos( $url , $CONN['zhiurlcent'] ) !== false){
                
                    $lxx = 2;
                    $IDD = (float)str_replace( $CONN['zhiurlcent'] , '', $url );

                }else if( $CONN['zhiurlcent'] == '' ){
                  
                    $IDD = (float)$url ;
                
                }

            }

            if( $lxx == 1 ){

                if( $D == '' )$D = db('type');
                 else $D ->setbiao('type');
            
            
            }else if( $lxx == 2 ){

                if( $D == '' )$D = db('center');
                 else $D ->setbiao('center');
            
            
            
            }else return false;

            $where = array('id' => $IDD);

             $DATA = $D ->where( $where )-> find();

            if( $DATA ){

                $SHUZU = array( 'lx' => $lxx,
                                'id' => $DATA['id'],
                );

                $Mem -> s( $HASH , $SHUZU );
                return $SHUZU;

            }else{
            
            
                $Mem -> s( $HASH , '-1' , 10 );
                return false;
            }


        }



        $where = array( 'url' => $url );

        if( $D == '' )$D = db('type');
        else $D ->setbiao('type');

        $DATA = $D ->where( $where )-> find();

        if( $DATA ){

            $SHUZU = array( 'lx' => 1,
                            'id' => $DATA['id'],
            );

            $Mem -> s( $HASH , $SHUZU );
            return $SHUZU;

        }else{

            $DATA = $D -> setbiao('center')->where( $where )-> find();

            if( $DATA ){

                $SHUZU = array( 'lx' => 2,
                                'id' => $DATA['id'],
                );

                $Mem -> s( $HASH , $SHUZU);
                return $SHUZU;

            }else{
            
                $Mem -> s( $HASH , '-1' , 10 );
                return false;
            }
        }
}


function sclx1(){

        $fan = 0;
        global $Mem;

        if( ! $Mem -> g('danjutype') ){

            $dtype = db('type');
            $num = $dtype->query("SHOW TABLE STATUS LIKE  '{$dtype->biao()}'",'other');
            $shuju = (float) ($num['Auto_increment']);
            if( $shuju < 1) $shuju = 1;
            $Mem -> s('danjutype',$shuju);

        }else $shuju = (float)$Mem ->ja('danjutype',1);

        return $fan+$shuju;
}


function sclx2(){

 
        $fan = 0;
        global $Mem;

        if( ! $Mem -> g('danjucenter') ){

            $dtype = db('center');
            $num = $dtype->query("SHOW TABLE STATUS LIKE  '{$dtype->biao()}'",'other');
            $shuju = (float) ($num['Auto_increment']);
            if( $shuju < 1) $shuju = 1;

            $Mem -> s('danjucenter',$shuju);

        }else $shuju = (float)$Mem ->ja('danjucenter',1);

        return $fan+$shuju;
}


function sjurl( $url = '' , $lx = 1 ){
        
        /*随机产生心的url*/

        $mozhi = '000001';
        global $CONN,$Mem;

         $zifu = 'abcdefghijklmnopqrstuvwxyz';

        $url = trim( $url );

        switch( $lx ){

            case 0:   /*全局每日日期ID-201610010001*/

                $HASH = 'qj/s'.date('Ymd');
                $url  = $Mem ->g( $HASH );
                if( !$url ){

                    $url = date('Ymd').$mozhi;
                    $Mem ->s( $HASH, $url);

                }else $url = $Mem ->ja( $HASH, 1);
                break;

            case 1: /*全局ID自动增加+1*/

                
                $url = sclx1() + sclx2()+1;
                $url = $url .$zifu{rand(0,25)};

                break;

            case 2: /*前缀+单个ID自动增加+1*/

                

                $url = sclx1() + 1;
                $url = $CONN['neirongqz'].$url;
                $url = $url .$zifu{rand(0,25)};

                break;

            case 3: /*生成全拼-shengchengquanpin*/

               

                $url = pinyin( $url ).$zifu{rand(0,25)};
                break;

            case 4: /*生成首字母-scszm*/

              


                $url = pinyin( $url ,3 ).$zifu{rand(0,25)};
                break;

            case 5: /*完全自定义-默人标题*/

               

                $url = $url .$zifu{rand(0,25)};

                break;

            case 6: /*时间戳-1475422908*/

                $url = $url.rand(0,9);
                break;

            default:

                $url = sclx1() + sclx2()+1;
                $url = $url .$zifu{rand(0,25)};
                break;
        }

        return $url;

}


function scurl( $url = '' , $lx = 1 ,$jisu = 1, $tyid = 0){

        /* 生成新的url

            lx = 1 分类url   2 内容url
            0 全局每日日期ID-201610010001
            1 全局ID自动增加+1
            2 前缀+单个ID自动增加+1
            3 生成全拼-shengchengquanpin
            4 生成首字母-scszm
            5 完全自定义-默人标题
            6 时间戳-1475422908
        */

        global $CONN,$Mem;

        if($jisu > 100 )return time().rand(10,99);

        $url =  url( $url ) ;
        $mozhi = '00001';

        if( $lx == 1 ){

            $TYLX = $CONN['typems'] ;
            

            switch( $CONN['typems'] ){

                case 0:   /*全局每日日期ID-201610010001*/

                    $HASH = 'qj/'.date('Ymd');
                    $url  = $Mem ->g( $HASH );
                    if( !$url ){

                        $url = date('Ymd').$mozhi;
                        $Mem ->s( $HASH, $url);

                    }else $url = $Mem ->ja( $HASH, 1);
                    break;

                case 1: /*全局ID自动增加+1*/

                        $url =  sclx1() + sclx2();

                    break;

                case 2: /*前缀+单个ID自动增加+1*/

                    
                        $url = sclx1();
                      

                        $url = $CONN['typeqz'].$url;
                    break;

                case 3: /*生成全拼-shengchengquanpin*/

                    $url = pinyin( $url );
                    break;

                case 4: /*生成首字母-scszm*/

                    $url = pinyin( $url ,3 );
                    break;

                case 5: /*完全自定义-默人标题*/

                    break;

                case 6: /*时间戳-1475422908*/

                    $url = time().rand(10,99);
                    break;

                default:

                    $url = time().rand(10,99);
                    break;
            }

        }else{

            $TYLX = $CONN['neirongms'];

            switch( $CONN['neirongms'] ){

                case 0: /*全局每日日期ID-201610010001*/

                    $HASH = 'qj/'.date('Ymd');
                    $url = $Mem ->g( $HASH );

                    if( !$url ){

                        $url = date('Ymd').$mozhi;
                        $Mem ->s( $HASH, $url);

                    }else $url = $Mem ->ja( $HASH, 1);
                    break;

                case 1: /*全局ID自动增加+1*/

                   

                         $url = sclx1() + sclx2();
                      
                  
                    break;

                case 2: /*前缀+单个ID自动增加+1*/

                   
                       $url = sclx2();
                      

                    $url = $CONN['neirongqz'].$url;
                    break;

                case 3: /*生成全拼-shengchengquanpin*/

                    $url = pinyin( $url );
                    break;

                case 4: /*生成首字母-scszm*/

                    $url = pinyin( $url ,3 );
                    break;

                case 5: /*完全自定义-默人标题*/

                    break;

                case 6: /*时间戳-1475422908*/

                    $url = time().rand(10,99);
                    break;

                case 7: /*7,分类url+(前缀+单个ID自动增加)*/

                    $qzui = '';


                    $danye = danye( $tyid );
                    if($danye && $danye['url'] != '' ) $qzui = $danye['url'];


                    $url = sclx2() + $jisu;
                    $url =  $qzui.$CONN['neirongqz'].$url;
                    break;

                default:

                    $url = time().rand(10,99);
                    break;

            }

        }

        $fanhui = chaurl( $url , 1 );
        $jisu++;
        if( $fanhui || $url == '' ) $url = scurl( sjurl( $url , $TYLX )  , $lx , $jisu , $tyid);

        return $url;

}


function sjtype( $diqu ){
        /* 读取系统分类
            (上级读取)

        */
        $diqu = (float)$diqu;
        if( $diqu < 1 ) return 0;
        
        $shuzu = array();

        $D = db('type');

        $shuju = $D ->where(array('id' => $diqu ))-> find();

        if($shuju){

              if($shuju['cid'] != '0') $shuzu = sjtype( $shuju['cid'] ) ;
        
              $shuzu[] = $shuju['cid'];

        }else return false;

        return $shuzu;
        
        
}


function cetype( $diqu = 1, $qx = '' ){

        /* 读取系统分类
           (全部读取)
        */
        $diqu = (float)$diqu;
        if( $diqu < 1 ) return 0;
        global $Mem , $CONN;

        $shuzu = array();

        $HASH = 'xttype/'.$diqu;

        if( $qx == '2'){

            $Mem -> d( $HASH );
            return false;
        }

        $shuzu = $Mem -> g( $HASH);
        if( $shuzu === '-1' && $qx == '') return false;
        if( $shuzu  && $qx == '')  return $shuzu;

        $D = db('type');
        $shuju = $D ->where( array( 'leixin' => 1 ))-> select();

        if( $shuju ){

            $z = '';
            $i = 0;

            foreach($shuju as $ong){

                if( $ong['cid'] > 0 )$z = '--';
                else $z = '';
                $shuzu[ $ong['id']] =  $z.$ong['name'];
            }


        }else{

            $Mem -> s( $HASH , '-1', 10);
            return false;
        }

        $Mem -> s( $HASH , $shuzu , 10);
        return $shuzu;
}


function xjtype( $diqu ,$J = '' ){

        /*
            读取系统分类
            (下级分类包含)
        */

        $diqu  = (float) $diqu;

        if( $diqu < 1 ) return 0;

       

        $shuzua = array();

        if( $J == '') $J = db('type');
        else $J ->setbiao ('type');

        $shuju = $J ->where( array( 'cid' => $diqu ) )-> select();

        if( $shuju ){

            foreach( $shuju as $woqu){

                $shuzus = xjtype( $woqu['id'] , $J );


                if($shuzus ) {
                    $shuzua = array_merge( $shuzus ,$shuzua  ) ;
                   if(isset($shuzua['0']) ) unset($shuzua['0']);
                }

                $shuzua[ $woqu['cid']] = $woqu['cid']; 
            }
        }



        return $shuzua;

}


function xjcid( $diqu ,$J = '' ){

        /*
            读取系统分类
            (下级分类包含)
        */

        $diqu  = (float) $diqu;

        if( $diqu < 1 ) return 0;

       

        $shuzua = array($diqu => $diqu);

        if( $J == '') $J = db('type');
        else $J ->setbiao ('type');

        $shuju = $J ->where( array( 'cid' => $diqu ) )-> select();

        if( $shuju ){

            foreach( $shuju as $woqu){

                $shuzus = xjcid( $woqu['id'] , $J );


                if($shuzus ) {
                    $shuzua = array_merge( $shuzus ,$shuzua  ) ;
                   if(isset($shuzua['0']) ) unset($shuzua['0']);
                }

                $shuzua[ $woqu['id']] = $woqu['id']; 
            }
        }

        return $shuzua;

}


function morentpl( $lx = '0',$motie = '默认' ){

        $nei = array();
        global $CONN;
        $QIlj =  QTPL.'ui.php';
        $QIUI = false;
        if(file_exists( $QIlj ) ) $QIUI = include $QIlj;
        

        if($lx == '0'){

            $nei[] = ''.','.$motie.' '.$CONN['morenlist'];

            if( $QIUI ){

                foreach( $QIUI['list']  as $wo => $vv){

                    $nei[] = $wo.','.$vv.' '. $wo;
                }
            }

        }else if($lx == 1){

            $nei[] = ''.','.$motie.' '.$CONN['morencent'];

            if( $QIUI ){

                foreach( $QIUI['center']  as $wo => $vv){
                 $nei[] = $wo.','.$vv.' '. $wo;
                
                }
            }
        
        
        }

        return implode( '@' , $nei );

}


function quchuk( $date ,$tihuan= '' ,$KK = ''){ 

        /*去出括号 和去 a*/
        $date = preg_replace ( "@<a(.*?)a>@is" , $tihuan , htmlspecialchars_decode( $date ) );
        if( $KK == '' ) $date = preg_replace ( "@<(.*?)>@is" , $tihuan , $date );
        return $date;
}


function keyset( $key , $url = '' , $data = '', $bjq = '', $bjw = ''){

        /*
            keyset 关键词连接生成
            $bjq   标记前
            $bjw   标记后
            $data  内容
            $url 网页连接地址  yes 加粗关键词
        */

        if( $key == '' )  return $data;
        $HDATA = explode( ',' , $key );
        global $CONN;

        $STR = '' ;

        if( $data == '' ){

          

            foreach($HDATA as  $kk) $STR .= $bjq.' <a href="'.mourl($CONN['sosoword'].$CONN['fenge'].$kk ).'" title="'.$kk.'">'.$kk.'</a>'.$bjw;
  
        }else if($url =='yes'){

                foreach( $HDATA as $vv => $kk ) $data = str_replace( $kk , '@@#'. $vv. '#@@' , $data );

                foreach( $HDATA as $vv => $kk ){

                        $urls = $bjq.$kk.$bjw;
                        $data = str_replace('@@#'.$vv.'#@@', $urls , $data );
                }

                $STR .=$data;


        }else if($url =='no'){

                foreach( $HDATA as  $vv => $kk ) $data = str_replace( $kk , '@@#'.$vv.'#@@' , $data );
                foreach( $HDATA as  $vv => $kk ){

                        $urls= $bjq.' <a href="'.mourl($CONN['sosoword'].$CONN['fenge'].$kk ).'" title="'.$kk.'">'.$kk.'</a>'.$bjw;
                        $data= str_replace( '@@#'.$vv.'#@@' , $urls , $data );
                }

                $STR .=$data;



        }else{

                foreach( $HDATA as  $vv => $kk ) $data = str_replace( $kk , '@@#'.$vv.'#@@' , $data );
                foreach( $HDATA as  $vv => $kk ){

                        $urls= $bjq.' <a href="'.$url.'" title="'.$kk.'">'.$kk.'</a>'.$bjw;
                        $data= str_replace( '@@#'.$vv.'#@@' , $urls , $data );
                }

                $STR .=$data;

        }

        return $STR;

}


function danye(  $id = 0 , $D = '' , $xx = 0 , $QX = ''){  
    
        /*单个读取  $xx 0 分类 1 内容*/

        $id    = (float)$id;
        if( $id < 1) return false;

        $HASH = 'danye/'.$id.'_'.$xx;
        global $Mem;

        $DATA = array();
        if( $QX == '2' ){

            $Mem -> d( $HASH );
            return false;

        }

        $DATA =  $Mem -> g( $HASH );

        if( $DATA && $DATA == '-1'  && $QX == '') return false;
        if( $DATA && $QX == '' )  return $DATA;

        if( $D == '' ) $D = db('type');

        if( $xx == 1 ) $D -> setbiao ( 'center' );
        else           $D -> setbiao ( 'type' );

        $DATA = $D->where( array('id' => $id ) )->find();

        if($DATA){

            $DATA['link']      = mourl( $DATA['url'] , $DATA['http'] ,'' , $id , ( $xx == 1 ? 2: 1 ));
            $DATA['linkstyle'] = $DATA['http'] == '' ? 1 : 2 ;

        }else{ 

            $Mem -> s( $HASH ,'-1' , 10 );
            return false;


        }

        $Mem -> s( $HASH , $DATA ,20);

        return $DATA;
}



function neirlist( $TJ = array() , $biao = 'center' , $D = ''){

        /* 

        $TJ {
            page  当前页面
            num   默认读取条数
            order 排序条件
            cid   子类读取
            len   标题长度
            limit   单个处理
            pagenum  分页按钮显示个数
            http     原来的http
            where    接管where条件
            httph   后面接受的参数
        }

        $D  数据库连接
        $biao    读取的表默认 center

        */

        if( $D == '' )$D = db( $biao );
        else $D -> setbiao( $biao );
        $DATA = $wheres = $DATAselect = array();
        $DATA['page'] = $DATA['date'] = array();

        $page  = (float)( isset( $TJ['page'] ) && $TJ['page'] !='' ? $TJ['page']  :1 );
        $num   = (float)( isset( $TJ['num'] )  && $TJ['num']  !='' ? $TJ['num']   :10 );
        $order = isset( $TJ['order'] )&& $TJ['order']!='' ? $TJ['order'] :'id DESC';
      $namelen = (float)( isset( $TJ['len'] )  && $TJ['len']  !='' ? $TJ['len']   : 30 );
        $total = (float)( isset( $TJ['total']) && $TJ['total'] != '' ?$TJ['total']:0 );

        if( isset( $TJ['cid'] ) && $TJ['cid'] != '' ){

           if( is_array( $TJ['cid'] )) $wheres['cid IN'] = implode(',',$TJ['cid']);
           else                        $wheres['cid']    = $TJ['cid'];
        }
        
        $pagenum = isset( $TJ['pagenum'] ) && $TJ['pagenum'] != '' ?  $TJ['pagenum'] : 5 ;
        global $LANG,$CONN;

        $YUANHTTP = isset( $TJ['http'] ) ? $TJ['http']  : '';
        $httph    = isset( $TJ['httph'] )? $TJ['httph'] : $CONN['houzui'];

        if( isset( $TJ['limit'] ) )
              $pages = $TJ['limit'];
        else  $pages = listmit( $num , $page );

        $wheres['off'] = 2;

        if( isset( $TJ['where'] ) && $TJ['where'] != '' ) $wheres = $TJ['where'];

        $DATA['num']    = $num ;
        $DATA['pgnum']  = $page ;

        $DATA['zongsu'] = $dczong = 0;

        if( $total < 1 )
        $DATA['zongsu'] = $dczong =  $D->where($wheres)-> total();

        $DATAselect = $D->where($wheres)->order($order)->limit($pages)->select();

        if(!$DATAselect) $DATAselect = array();

        foreach($DATAselect as $dk){

                $dk['yname'] = $dk['name'];
                $dk['name']  = qsubstr( $dk['yname'] , 0 , $namelen );
                $dk['link']  = mourl  (   $dk['url'] , $dk['http'] ,'' , $dk['id'] , ( $biao == 'type' ? 1 : 2 ));
                $dk['linkstyle'] = $dk['http'] == '' ? 1 : 2 ;
                $DATA['date'][$dk['id']]= $dk;

        }

        $kkkk = pagec( $LANG['PAGE'] , $num , $dczong , $pagenum , $page , mourl($YUANHTTP , '' , $CONN['fenge'] ) , $httph );
        if($dczong > $num) $DATA['page'] = $kkkk ;

        return $DATA;
}


function menulist( $kk = '' , $JJ = ''){ 
    
        /*  导航菜单
            $kk  = 上级id
            $JJ 数据库连接
        */

        if( $JJ == '' ) $JJ = db( 'type' );
        else $JJ -> setbiao( 'type' );

        $kk = (float) $kk;

        $DATA = array();

        if( $kk == '0' )
            $wheres=array('off' => 2 , 'xianoff' => 1 ,'cid' => 0 ); 
        else
            $wheres=array('off' => 2 , 'cid' => $kk ); 

        $DATAs = $JJ->where($wheres)->order("paixu DESC,id ASC")->select();

        if( $DATAs ){
      
            foreach( $DATAs as $anyou){

                $anyou['link'] = mourl($anyou['url'],$anyou['http'] ,'' , $anyou['id'] , 1 );
                $anyou['linkstyle'] = $anyou['http'] == '' ? 1 : 2 ;
                $DATA[$anyou['id']] = $anyou;
            }
        }

        return $DATA;

}


function daoha( $id ,$db = ''){

        /*  $ID 分类id
            $db  数据库连接
        */

        $shuzu= array();
        $id = (float) $id ;
        if( $id < 1 ) return false;

        if( $db == '' ) $db = db( 'type' );
        else $db -> setbiao( 'type' );

        $fenl = $db ->where( array( 'id' => $id ) ) -> find();
        if( ! $fenl ) return false;

        if( $fenl['cid'] != '0' ) $shuzu = daoha( $fenl['cid'] , $db );
        $shuzu[] =$fenl;

        return($shuzu);
}


function daohtml( $ID ,$db = ''){

        /* $ID 分类id
           $db  数据库连接
        */
        $zhis = daoha( $ID , $db );

        if( $zhis ){

            $daohang = array();
            $su = count( $zhis );
            $i=0;

            foreach($zhis as $woqu){

                $daohang[] = '<a href="'.mourl($woqu['url'],$woqu['http'] , '' ,$woqu['id'] , 1).'" '.($su-1 ==$i?' class="hover"':'').' title="'.$woqu['name'].'">'.$woqu['name'].'</a>';
            
                $i++;
            }

            return ($daohang);
        }
}


function shangxia(  $id , $CID = 0 , $D = '' ){

        /* 上下文章连接 */

        $data = array();

        if( $D == '' ) $D = db( 'center' ); 
        else $D -> setbiao( 'center' );
        
        $id   = (float) $id;
        $CID  = (float) $CID;

        $WHEREs = array('id <' => $id );
        $WHEREx = array('id >' => $id );

        if( $CID > 0){

            $WHEREs['cid'] = $CID;
            $WHEREx['cid'] = $CID;
        }

        $shangyi = $D -> where( $WHEREs ) -> order( "id DESC" ) -> find();
        $xiayi   = $D -> where( $WHEREx ) -> order( "id ASC"  ) -> find();

        if( $xiayi ){

            $data['xiayi']=array(
                                'id'   => $xiayi['id'], 
                                'cid'  => $xiayi['cid'],
                                'name' => $xiayi['name'],
                              'tupian' => $xiayi['tupian'],
                                'link' => mourl( $xiayi['url'] , $xiayi['http'] , '' , $xiayi['id'] , 2 ),
            );

        }else $data['xiayi']= false;

        if( $shangyi ){

            $data['shangyi']=array(
                                'id'   => $shangyi['id'],
                                 'cid' => $shangyi['cid'],
                                'name' => $shangyi['name'],
                              'tupian' => $shangyi['tupian'],
                                'link' => mourl( $shangyi['url'], $shangyi['http'] , '' , $shangyi['id'] , 2 ),
            );

        }else $data['shangyi']= false;

        return $data;
}


function neirong( $KHTTP , $HTTP, $URI , $CONN , $LANG){

        /*  内容分配
            lx 1 分类
            lx 2 内容
            $KHTTP 快捷分配 lx  id renqi
            $HTTP 组合参数
            $URI  原来url
            $CONN 系统配置
            $LANG 前台语言包
        */

        global $HUOBIICO,$HUOBI;

        $PAGE = (float)( isset($HTTP['1']) ? $HTTP['1'] : 1 );

        if($KHTTP['lx'] == '1') $D = db( 'type' );
        else                    $D = db( 'center' );

        $ID    =  (float) $KHTTP['id'];
        
        $where = array( 'id' => $ID );

        $DATA  = $D  ->where( $where )-> find();

        if( $DATA ){

            $ZDATA  = array();
            $TPLJIN = '';

            if( $DATA['off'] ==  '1') error404( $LANG['ERshenhe'] ,1 );
            else{


                if( $KHTTP['lx'] == '1' ){

                    if( $DATA['leixin'] == '1')

                            $TPLJIN  =  QTPL.anquanqu( $DATA['listmb'] == '' ? $CONN['morenlist']:$DATA['listmb']).'.php';

                    else    $TPLJIN  =  QTPL.anquanqu( $DATA['neromb'] == '' ? $CONN['morencent']:$DATA['neromb']).'.php';

                    if( file_exists( $TPLJIN ) ) return include  $TPLJIN;
                    else  error404( $LANG['ERnofil'] . $TPLJIN );

                }else{

                    if( $DATA['cid'] > 0 ){

                        $ZDATA = $D -> setbiao( 'type') -> where( array('id' => $DATA['cid'] ))->find();

                        if( $ZDATA ) $TPLJIN  =  QTPL.anquanqu( $ZDATA['neromb'] == '' ? $CONN['morencent']: $ZDATA['neromb'] ).'.php';
                        else         $TPLJIN  =  QTPL.anquanqu( $DATA['neromb']  == '' ? $CONN['morencent']: $DATA['neromb']  ).'.php';
                    
                    
                    }else $TPLJIN  =  QTPL.anquanqu( $DATA['neromb'] == '' ? $CONN['morencent']:$DATA['neromb']).'.php';

                    if( file_exists( $TPLJIN ) ) return include  $TPLJIN;
                    else  error404( $LANG['ERnofil'] . $TPLJIN );

                }

            }

        }else error404( $LANG['ERnoid'] , 1 );

}


function chengshi( $che = '' , $qx = '' ){

       /* 读取下级城市列表
          $che  上级城市id
          $qx   强行更新
       */
        global $Mem,$CONN;

        $che = (float) $che;
        $HASH =  'diqu/'.mima($che);
        $DATA = $Mem  -> g($HASH);

        if($DATA && $qx == '') return $DATA;

        $DATA = array( '0' => $CONN['chengshi'] );
        $DB = db( 'chengshi');
        $data = $DB ->order('diqu asc')->where( array('shangji' =>  $che ))-> select();

        if( $data ){

            foreach($data as $shu){ 

                $DATA[ $shu['diqu']] = $shu['name'];
            }
        }

        $Mem ->s( $HASH , $DATA , 300 );

        return  $DATA;
}


function chengshijiexi( $D = '' , $cheng ){

        /* 根据 城市id 循环出名字 */

        if( $D == '' ) $D = db( 'chengshi');
        else $D ->setbiao( 'chengshi');

        $fanhui = array();

        foreach( $cheng as $v ){

            if($v == '0') continue;
            $shuju = $D -> where( array('diqu' => $v)) -> find();
            if( $shuju ) $fanhui[ $v ] = $shuju['name'];
        }

        return  $fanhui;

}


function chengshiid( $diqu , $qx = '' ){

        /*城市上级id
          根据当前查找上级城市
        */

        $diqu = (float) $diqu;
        $shuzu = array();
        global $Mem , $CONN;

        if( $diqu < 1 ) return 0;

        $HASH = 'chengshiid/'.$diqu;

        if( $qx == '2'){

            $Mem -> d( $HASH );
        
            return false;
        }

        $shuzu = $Mem -> g( $HASH);
        if( $shuzu === '-1' && $qx == '') return false;
        if( $shuzu  && $qx == '')  return $shuzu;

        $D = db('chengshi');
       
        $shuju = $D ->where(array('diqu' => $diqu ))-> find();

        if( $shuju ){

            if( $shuju['shangji'] != '0') $shuzu = chengshiid($shuju['shangji']) ;

            $shuzu[] = $shuju['shangji'];
         
        }else{
               $Mem -> s( $HASH , '-1', 10);
               return false;
        }
               $Mem -> s( $HASH , $shuzu , 300);

        return $shuzu;
}


function diqubaohan( $ID = 0){

         /*城市包含id*/

        $ID  = (float) $ID;
        if( $ID < 1 ) return false;
        $shuzu = array();

        $D = db('chengshi');

        $yiji = $D ->where( array( 'diqu' => $ID))-> find();

        if( $yiji ){

             $shuzu[$ID] = $ID;

             if( strstr($yiji['diqu']  , '0000' )){

                  /*市集数据*/
                 $t =  $D ->where( array( 'shangji' => $ID))-> select();

                 if( $t ){

                     foreach( $t as $x){

                           $shuzu[ $x['diqu']] = $x['diqu'];

                           if( strstr($x['diqu']  , '00' )){ 

                                 /*读取县级数据*/
                                 $tt =  $D ->where( array( 'shangji' => $x['diqu'] ))-> select();
                                 if( $tt ){
                           
                                      foreach( $tt as $xx ){

                                          $shuzu[ $xx['diqu']] = $xx['diqu'];
                                      }
                                  }
                            }
                     }
                 }


            }else if( strstr($yiji['diqu']  , '00' )){

                 $t =  $D ->where( array( 'shangji' => $ID))-> select();

                 if($t){

                        foreach($t as $x) $shuzu[ $x['diqu']] = $x['diqu'];
                 }
            }

        }else return false;

        return $shuzu;
}


function yunfeiid(  $ID = 0, $QX = '' , $DD = '' ){

        global $Mem;

        $ID = (float) $ID;

        $HASH  = 'yunfeiid/'.$ID;

        if( $QX == '2'){

            $Mem -> d($HASH);
        
        
        return false;
        }

        $DATA = $Mem -> g( $HASH );
        if($DATA && $DATA =='-1')return false;
        if($DATA && $QX == '')return $DATA;
        if($DD == '')$DD = db('yunfei');
        else $DD ->setbiao('yunfei');

        
        if( $ID > 0) $DATA = $DD ->where(array('id' => $ID) )->find();
        else{

            $DATAA = $DD -> select();

            if($DATAA){

                foreach($DATAA as $kk ){

                    $DATA[$kk['id']] = $kk['name'];

                }

            }else{

                $DATA = false;
            
            }

        }

        if($DATA){

            $Mem -> s($HASH,$DATA) ;

        }else{

          $Mem -> s($HASH,'-1',10);
        }


        return $DATA;

}


function hongbao( $UID ){

         /*
           读取红包
         
         */
         
        if( $UID < 1 ) return false;

        $D = db('hongbao');

        $shuju = array();

        /* 过期修改 */
        $D -> where(array( 'gtime <' => time() ,'uid' => $UID ) ) -> update(array('off' => 2));

        /* 没有剩余钱了修改 */
        $D -> where(array( 'shengyujine' => '0','uid' => $UID ) ) -> update(array('off' => 1));

        $data = $D -> order("gtime asc,id asc") -> where( array( 'off' => '0' ,'uid' => $UID )) -> select();

        if( $data ){
            
            foreach( $data as $ong ){

                $shuju[ $ong['id'] ] = $ong;
            }

            return $shuju;

        }else return false;

}


function fahongbao( $D = '' , $uid = 0 , $jine = 10 ,$keyong = 10, $day = 10 ,$type = 0 , $fuid = 0 , $sid = 0 , $beizhu = ''){

             /* uid 用户uid
              jine    红包金额
              keyong  红包大于多少可用
              day     过期时间
              type    红包类型
              fuid    发放红包的用户
              sid     发放红包商家
              beizhu  备注
             */
            if($keyong < 0 ) $keyong = 0;
            if($day < 1)     $day= 1;
            if($jine < 0.01) $jine = 0.01;

            if( $D =='') $D = db( 'hongbao' );
            else   $D -> setbiao( 'hongbao' );

            $sql = $D -> setshiwu('1') -> insert( array(
                                         'fuid' => $fuid,
                                          'sid' => $sid,
                                          'uid' => $uid,
                                   'haobaojine' => $jine,
                                   'dayukeyong' => $keyong ,
                                        'atime' => time(),
                                        'gtime' => time() +$day * 3600*24,
                                   'shengyujine'=> $jine,
                                         'type' => $type,
                                       'beizhu' => $beizhu
                   ));

            return $D -> qurey( $sql , 'shiwu');
}


function xitongpay( $id , $qx = ''){

        /*  支付方式
            -1  只需要id 和名字
            0   前台显示
            其他 读取单个数据无限制
        */

        $shuzu = array();
        global $Mem ;

        $HASH = 'xitongpay/'.$id;

        if( $qx == '2'){

            $Mem -> d( $HASH );
            return false;
        }

        $shuzu = $Mem -> g( $HASH);

        if( $shuzu === '-1' && $qx == '' ) return false;
        if( $shuzu  && $qx == '' )  return $shuzu;

        $D = db('pay');

        $shuzu = array();

        if( $id == '0' ){

            /*所有支付 限时开启的*/
            $shuzu = $D ->where( array( 'off' => 1 , 'xianshi' => 1 )) -> order ( 'paixu desc')-> select();

            if( !$shuzu){

                $Mem -> s( $HASH ,'-1' , 30);

                return false;
            }
        
        }else if( $id == '-1'){

            /*全部支付 id 和名字*/
            $shuzus = $D -> select();

            if( !$shuzus){

                $Mem -> s( $HASH ,'-1' , 30);

                return false;

            }

            foreach($shuzus as $kk){

                    $shuzu[ $kk['id']] = $kk['name'];
            }
            
        }else if( $id == '-2'){

            /*所有开启支付 id 和名字*/
            $shuzus = $D ->where( array( 'off' => 1) )  -> order ( 'paixu desc') -> select();

            if( !$shuzus){

                $Mem -> s( $HASH ,'-1' , 30);
                return false;

            }

            foreach($shuzus as $kk){

                    $shuzu[ $kk['id']] = $kk;
            }

            
        }else if( $id == '-3'){
            /*所有app 开启支付 id 和名字 */
            $shuzu = $D ->where( array( 'off' => 1,'isapp' => 1 )) -> order ( 'paixu desc')-> select();

            if( !$shuzu ){

                $Mem -> s( $HASH ,'-1' , 30 );
                return false;

            }

        }else {

            if(  ((int)$id)  > 0 )
                $shuzu = $D ->where( array( 'id' => $id , 'off' => 1   ))-> find(); 
            else
                $shuzu = $D ->where( array( 'payfile' => $id , 'off' => 1   ))-> find(); 

            if( !$shuzu){

                $Mem -> s( $HASH ,'-1' , 30 );

                return false;

            }

        }
        
        $Mem -> s( $HASH , $shuzu );

        return $shuzu;
}


function youqing($NUM = 10,$D= '',$LEX = ''){

        if( $D == '' ) $D = db('youqing');
        else $D ->setbiao('youqing');

        $WHERE = array('off' => 2);

        if($LEX !='') $WHERE['leixing'] = $LEX;

        $DATA = array();

        $DATA = $D ->where($WHERE) ->order('paixu desc,id desc')->limit((float)$NUM)-> select();

        return $DATA;
      


}


function alltype( $D = ''){

        if( $D == '' )$D = db( 'type' );
        else $D -> setbiao( 'type' );

        $SHUJU = array();

        $DD = $D ->zhicha('id,name,url,http,tupian')-> select();

        if( $DD ){

            foreach( $DD as $ong){

                $SHUJU[$ong['id']] = array( 'name' => $ong['name'],
                                             'url' => $ong['url'],
                                            'link' => mourl( $ong['url'] , $ong['http'] , '' , $ong['id'] , 1 ),
                                          'tupian' => $ong['tupian'],
                                          
                    
                );
            
            }
        }

        return $SHUJU ;


}


function shouquandi( $type = 0 , $CPID = 0, $biaoshi ){

        $jishu  =   array( 'jishu' => '',
                            'mima' => '',
                             'off' => 1 ,
                    );

        $chanpin =  danye( $CPID , '' ,1 );

        if( $chanpin ){

            if( $type == '0' ){

                /*有权控制 退货信息*/

                $jishu['off'] = 2;

                $jishu['jishu'] = $biaoshi['kahao'];
                $jishu['mima']  =  $biaoshi['kamima'];

             
             
            }else if( $type == 1 ){

                /* 下载地址*/

                $jishu['off']   = 2 ;
                $jishu['jishu'] = $chanpin['kahao'];
                $jishu['mima']  = $chanpin['kamima'];


            }else if( $type == 2 ){

                /*网盘密码*/

                $jishu['off'] = 2;
                $jishu['jishu'] = $chanpin['kahao'];
                $jishu['mima'] = $chanpin['kamima'];

            }
            /*其他处理自行扩展*/



        }




        return $jishu;

}


function apptongxin( $data = array() , $start = '1' ,  $code = '0' , $msg = '' , $apptoken = '' ){
         
        /*  $data 数据 array()
           
            $code 业务码
            $msg  一些系统提示
            $apptoken 传递通信token

            200 操作成功
            401 需要登录用户
            500 内部服务器错误
            304 修改失败
            410 删除失败
            404 查询失败
            406 新增失败
            415 非法数据 token错误
        */

        global $CONN;

        if( $CONN['dbug'] == '0' )ob_clean();

        header('HTTP/1.1 '. $start);

        if( $start != 200 && $start != 401 && $start != 415 && $CONN['dbug'] == '0' ) exit();


        return  array( 
                        'code'  => $code,
                         'data' => $data ,
                          'msg' => $msg ,
                        'token' => $apptoken
                );
}





function xiangou( $uid = 0 , $chanpin = array() ){

        /*  $uid
            $chanpin 产品数据 array( 'xiangou' => 限购数量 'xgtype' => 限购分类 'xgdata' => 限购参数 );
            0 不用限购
            1 每天限购
            2 永久限购
            3 小时限购
            4 分钟限购
            5 每月天数限购

        */

        if( $uid < 1 ) return 0;
        if( $chanpin['xiangou'] < 1 ) return 0;
        if( $chanpin[ 'xgtype'] < 1 ) return 0;

        $D = db( 'dingdanx' );

        if( $chanpin['xgtype'] == '1' ){

            /*每天限购*/

            $time = mktime(0,0,0,date('m'),date('d'),date('Y'));

            $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time ));
            $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ".$WHER);

            return (float) $fan['num'];

        }else if( $chanpin['xgtype'] == '2' ){

            /*永久限购*/

            $WHER  = $D -> wherezuhe( array( 'uid' => $uid, 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' ));
            $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ".$WHER);

            return (float) $fan['num'];

        }else if( $chanpin['xgtype'] == '3' ){

            /* 小时限购 */

            if( $chanpin['xgdata'] == '' ) return 0;

            if( strstr( $chanpin['xgdata'] , ',' )){

                $shuju = explode( ',' , $chanpin['xgdata'] );

                if( in_array(  date('H') , $shuju ) ){

                    $time    = mktime( date('H') , 0 , 0 ,date('m'),date('d'),date('Y'));
                    $endtime = mktime( date('H')+1 , 0 , 0 ,date('m'),date('d'),date('Y'));

                    $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                    $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );

                    return (float) $fan['num'];

                }else return $chanpin['xiangou'];

            }else if( strstr( $chanpin['xgdata'] , '-' )){

                list( $xiao , $da ) = explode( '-' , $chanpin['xgdata'] );

                if( ! $xiao ) return $chanpin['xiangou'];

                if( $da && $xiao ){

                    if( $xiao <= date('H') && $da >= date('H') ){

                        $time    = mktime( $xiao , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( $da , 0 , 0 ,date('m'),date('d'),date('Y'));

                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];
                
                
                }else{


                    if( date('H') == $xiao ){

                        $time    = mktime( $xiao , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( $xiao +1 , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];

                }


            }else{

                $xiao = (float) $chanpin['xgdata'];

                if( date('H') == $xiao ){

                        $time    = mktime( $xiao , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( $xiao +1 , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                }else  return $chanpin['xiangou'];

            }

        }else if( $chanpin['xgtype'] == '4' ){

            /*分钟限购*/

            if( $chanpin['xgdata'] == '' ) return 0;

            if( strstr( $chanpin['xgdata'] , ',' )){

                $shuju = explode( ',' , $chanpin['xgdata'] );

                if( in_array(  date('i') , $shuju ) ){

                    $time    = mktime( date('H') , date('i')   , 0 ,date('m'),date('d'),date('Y'));
                    $endtime = mktime( date('H') , date('i')+1 , 0 ,date('m'),date('d'),date('Y'));

                    $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                    $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );

                    return (float) $fan['num'];

                }else return $chanpin['xiangou'];


            }else if( strstr( $chanpin['xgdata'] , '-' )){

                list( $xiao , $da ) = explode( '-' , $chanpin['xgdata'] );

                if( ! $xiao ) return $chanpin['xiangou'];

                if( $da && $xiao ){

                    if( $xiao <= date('i') && $da >= date('i') ){

                        $time    = mktime( date('H') ,$xiao , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( date('H') , $da  , 0 ,date('m'),date('d'),date('Y'));

                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];
                
                
                }else{


                    if( date('i') == $xiao ){

                        $time    = mktime( date('H') , date('i')   , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( date('H') , date('i')+1 , 0 ,date('m'),date('d'),date('Y'));

                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];

                }


            }else{

                $xiao = (float) $chanpin['xgdata'];
                if( date('i') == $xiao ){

                        $time    = mktime( date('H') , date('i')   , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( date('H') , date('i')+1 , 0 ,date('m'),date('d'),date('Y'));

                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                }else  return $chanpin['xiangou'];

            }


        }else if( $chanpin['xgtype'] == '5' ){

            /* 每月天数限购 */

            if( $chanpin['xgdata'] == '' ) return 0;

            if( strstr( $chanpin['xgdata'] , ',' )){

                $shuju = explode( ',' , $chanpin['xgdata'] );

                if( in_array(  date('d') , $shuju ) ){

                    $time    = mktime( 0 , 0 , 0 ,date('m'),date('d'),date('Y'));
                    $endtime = mktime( 0 , 0 , 0 ,date('m'),date('d')+1,date('Y'));

                    $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                    $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );

                    return (float) $fan['num'];

                }else return $chanpin['xiangou'];


            }else if( strstr( $chanpin['xgdata'] , '-' )){

                list( $xiao , $da ) = explode( '-' , $chanpin['xgdata'] );

                if( ! $xiao ) return $chanpin['xiangou'];

                if( $da && $xiao ){

                    if( $xiao <= date('d') && $da >= date('d') ){

                        $time    = mktime( 0 , 0 , 0 ,date('m'),$xiao,date('Y'));
                        $endtime = mktime( 0 , 0 , 0 ,date('m'),$da ,date('Y'));

                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];
                
                
                }else{


                    if( date('d') == $xiao ){

                        $time    = mktime( 0 , 0 , 0 ,date('m'),$xiao,date('Y'));
                        $endtime = mktime( 0 , 0 , 0 ,date('m'),$xiao+1,date('Y'));
                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                    }else  return $chanpin['xiangou'];

                }


            }else{

                $xiao = (float) $chanpin['xgdata'];

                if( date('d') == $xiao ){

                    $time    = mktime( 0 , 0 , 0 ,date('m'),$xiao,date('Y'));
                    $endtime = mktime( 0 , 0 , 0 ,date('m'),$xiao+1,date('Y'));
                    $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                    $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                    return (float) $fan['num'];

                }else  return $chanpin['xiangou'];

            }


        }else {

                $xiao = (float) $chanpin['xgdata'];
                if( date('H') == $xiao ){

                        $time    = mktime( $xiao , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $endtime = mktime( $xiao +1 , 0 , 0 ,date('m'),date('d'),date('Y'));
                        $WHER  = $D -> wherezuhe( array( 'uid' => $uid , 'cpid' => $chanpin['id'] , 'off IN' => '0,2,3' , 'atime >' =>  $time,'atime <' => $endtime ));
                        $fan   = $D -> qurey( "select sum(num) as num from `{$D->biao()}` ". $WHER );
                        return (float) $fan['num'];

                }else  return $chanpin['xiangou'];

        }

}


function filemete( $LUJIN ){

        $mime_types = array(
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'apk' => 'application/vnd.android.package-archive',
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'doc' => 'application/msword',
        'ogg' => 'audio/ogg',
        'pdf' => 'application/pdf',
        'rtf' => 'text/rtf',
        'mif' => 'application/vnd.mif',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'otg' => 'application/vnd.oasis.opendocument.graphics-template',
        'odi' => 'application/vnd.oasis.opendocument.image',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'otp' => 'application/vnd.oasis.opendocument.presentation-template',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odm' => 'application/vnd.oasis.opendocument.text-master',
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'oth' => 'application/vnd.oasis.opendocument.text-web',
        'sxw' => 'application/vnd.sun.xml.writer',
        'stw' => 'application/vnd.sun.xml.writer.template',
        'sxc' => 'application/vnd.sun.xml.calc',
        'stc' => 'application/vnd.sun.xml.calc.template',
        'sxd' => 'application/vnd.sun.xml.draw',
        'std' => 'application/vnd.sun.xml.draw.template',
        'sxi' => 'application/vnd.sun.xml.impress',
        'sti' => 'application/vnd.sun.xml.impress.template',
        'sxg' => 'application/vnd.sun.xml.writer.global',
        'sxm' => 'application/vnd.sun.xml.math',
        'sis' => 'application/vnd.symbian.install',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'bcpio' => 'application/x-bcpio',
        'torrent' => 'application/x-bittorrent',
        'bz2' => 'application/x-bzip2',
        'vcd' => 'application/x-cdlink',
        'pgn' => 'application/x-chess-pgn',
        'cpio' => 'application/x-cpio',
        'csh' => 'application/x-csh',
        'dvi' => 'application/x-dvi',
        'spl' => 'application/x-futuresplash',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'jar' => 'application/java-archive',
        'jnlp' => 'application/x-java-jnlp-file',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'ksp' => 'application/x-kspread',
        'chrt' => 'application/x-kchart',
        'kil' => 'application/x-killustrator',
        'latex' => 'application/x-latex',
        'rpm' => 'application/x-rpm',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'ms' => 'application/x-troff-ms',
        'ustar' => 'application/x-ustar',
        'src' => 'application/x-wais-source',
        'zip' => 'application/zip',
        'm3u' => 'audio/x-mpegurl',
        'ra' => 'audio/x-pn-realaudio',
        'wav' => 'audio/x-wav',
        'wma' => 'audio/x-ms-wma',
        'wax' => 'audio/x-ms-wax',
        'pdb' => 'chemical/x-pdb',
        'xyz' => 'chemical/x-xyz',
        'bmp' => 'image/bmp',
        'gif' => 'image/gif',
        'ief' => 'image/ief',
        'png' => 'image/png',
        'wbmp' => 'image/vnd.wap.wbmp',
        'ras' => 'image/x-cmu-raster',
        'pnm' => 'image/x-portable-anymap',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'ppm' => 'image/x-portable-pixmap',
        'rgb' => 'image/x-rgb',
        'xbm' => 'image/x-xbitmap',
        'xpm' => 'image/x-xpixmap',
        'xwd' => 'image/x-xwindowdump',
        'css' => 'text/css',
        'rtx' => 'text/richtext',
        'tsv' => 'text/tab-separated-values',
        'jad' => 'text/vnd.sun.j2me.app-descriptor',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        'etx' => 'text/x-setext',
        'mxu' => 'video/vnd.mpegurl',
        'flv' => 'video/x-flv',
        'wm' => 'video/x-ms-wm',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wvx' => 'video/x-ms-wvx',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'ice' => 'x-conference/x-cooltalk',
        '3gp' => 'video/3gpp',
        'ai' => 'application/postscript',
        'aif' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'asc' => 'text/plain',
        'atom' => 'application/atom+xml',
        'au' => 'audio/basic',
        'bin' => 'application/octet-stream',
        'cdf' => 'application/x-netcdf',
        'cgm' => 'image/cgm',
        'class' => 'application/octet-stream',
        'dcr' => 'application/x-director',
        'dif' => 'video/x-dv',
        'dir' => 'application/x-director',
        'djv' => 'image/vnd.djvu',
        'djvu' => 'image/vnd.djvu',
        'dll' => 'application/octet-stream',
        'dmg' => 'application/octet-stream',
        'dms' => 'application/octet-stream',
        'dtd' => 'application/xml-dtd',
        'dv' => 'video/x-dv',
        'dxr' => 'application/x-director',
        'eps' => 'application/postscript',
        'exe' => 'application/octet-stream',
        'ez' => 'application/andrew-inset',
        'gram' => 'application/srgs',
        'grxml' => 'application/srgs+xml',
        'gz' => 'application/x-gzip',
        'htm' => 'text/html',
        'html' => 'text/html',
        'ico' => 'image/x-icon',
        'ics' => 'text/calendar',
        'ifb' => 'text/calendar',
        'iges' => 'model/iges',
        'igs' => 'model/iges',
        'jp2' => 'image/jp2',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'kar' => 'audio/midi',
        'lha' => 'application/octet-stream',
        'lzh' => 'application/octet-stream',
        'm4a' => 'audio/mp4a-latm',
        'm4p' => 'audio/mp4a-latm',
        'm4u' => 'video/vnd.mpegurl',
        'm4v' => 'video/x-m4v',
        'mac' => 'image/x-macpaint',
        'mathml' => 'application/mathml+xml',
        'mesh' => 'model/mesh',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'mov' => 'video/quicktime',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'mpe' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpga' => 'audio/mpeg',
        'msh' => 'model/mesh',
        'nc' => 'application/x-netcdf',
        'oda' => 'application/oda',
        'ogv' => 'video/ogv',
        'pct' => 'image/pict',
        'pic' => 'image/pict',
        'pict' => 'image/pict',
        'pnt' => 'image/x-macpaint',
        'pntg' => 'image/x-macpaint',
        'ps' => 'application/postscript',
        'qt' => 'video/quicktime',
        'qti' => 'image/x-quicktime',
        'qtif' => 'image/x-quicktime',
        'ram' => 'audio/x-pn-realaudio',
        'rdf' => 'application/rdf+xml',
        'rm' => 'application/vnd.rn-realmedia',
        'roff' => 'application/x-troff',
        'sgm' => 'text/sgml',
        'sgml' => 'text/sgml',
        'silo' => 'model/mesh',
        'skd' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'skp' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'snd' => 'audio/basic',
        'so' => 'application/octet-stream',
        'svg' => 'image/svg+xml',
        't' => 'application/x-troff',
        'texi' => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
        'tr' => 'application/x-troff',
        'txt' => 'text/plain',
        'vrml' => 'model/vrml',
        'vxml' => 'application/voicexml+xml',
        'webm' => 'video/webm',
        'webp' => 'image/webp',
        'wrl' => 'model/vrml',
        'xht' => 'application/xhtml+xml',
        'xhtml' => 'application/xhtml+xml',
        'xml' => 'application/xml',
        'xsl' => 'application/xml',
        'xslt' => 'application/xslt+xml',
        'xul' => 'application/vnd.mozilla.xul+xml',
    );

        $temp_arr = explode( "." , $LUJIN);
        $file_ext = array_pop( $temp_arr);
        $file_ext = trim( $file_ext);
        $file_ext = strtolower( $file_ext);
        return isset($mime_types[$file_ext])? $mime_types[$file_ext] : 'application/octet-stream';

}

function osshttp( $PIC, $CONN){


    /* oss http 文件下载 */

    if( isset($CONN['isoss']) &&  $CONN['isoss'] !='' ){

        $cmd5 = base64_encode(md5('', true));
        $EXPIRES = time()+1;
        $string_to_sign =  "GET\n\n\n".$EXPIRES."\n"."/".trim($CONN['ftpport'],'/').'/'.trim($PIC,'/');
        $qianm = base64_encode( hash_hmac( 'sha1' , $string_to_sign,  $CONN['ftppass'], true));

        $URL = $CONN['ftphttp'].trim($PIC,'/').'?OSSAccessKeyId='.$CONN['ftpuser'].'&Expires='.$EXPIRES .'&Signature='.$qianm;
        Header("Location: ".$URL);
        exit();
    
    }else{

        Header("Location: ".WZHOST.ltrim( $PIC , '/' ) );
        exit();

    }

}


function makehtml( $KHTTP , $HTTP, $URI , $CONN , $QLANG ){


    $URI = implode($CONN['fenge'],$HTTP);

    $WENJIAN = wlx( ONGPHP.'../'.$URI.'.html' , 2);
    ob_clean();
    
    $FANHUI = neirong($KHTTP , $HTTP, $URI , $CONN , $QLANG);

    if( $FANHUI ){

        if( $FANHUI  ){
            
            if( ! isset( $HTTP['1'] ) ) $HTTP['1'] = 0;

            $HTTP['1'] = $HTTP['1']+1;

            if($HTTP['1'] <= $xx &&  $HTTP['1'] > 1 ) return makehtml($KHTTP , $HTTP, $URI , $CONN , $QLANG);
        }

    }

    $content = ob_get_contents();

    jianli( $WENJIAN );
    $fp = fopen( $WENJIAN , "w+" );
    fputs ( $fp , $content );
    fclose( $fp );
    ob_clean();

}


function lailu( $id = ''){
         
        
        if( $id != '') return (int)$id;

        /* 判断来路
           电脑,    0
           微信,    1
           手机WAP, 2
           安卓APP, 3
           苹果APP, 4
           其他     5
        */

        $USERSS = $_SERVER['HTTP_USER_AGENT'];

        if ( strstr( $USERSS , "essenger")) return 1;
        else if( strpos( $USERSS,"iPhone" ) && strstr( $USERSS, "APP") ) return  4;
        else if( strpos( $USERSS,"iPad" )   && strstr( $USERSS, "APP") ) return  4;
        else if( strpos( $USERSS,"Android") && strstr( $USERSS, "APP") ) return  3;
        else if( strpos( $USERSS,"NetFront") || strpos( $USERSS , "iPhone" ) || strpos( $USERSS ,"iPad")  || strpos($USERSS,"MIDP-2.0") || strpos($USERSS,"Opera Mini") || strpos($USERSS,"UCWEB") || strpos($USERSS,"Android") || strpos($USERSS,"Windows CE") || strpos($USERSS,"SymbianOS")) return  2;
        else return  0;

}


function argSort($para) {

        ksort( $para );
        reset( $para );
        return $para ;
}


function wenyiyz( $NAME = '' , $VALUE = '' , $Mem , $LX = 1){
        
        /*  $NAME  需要的唯一标识
            $VALUE 标识验证值
            $Mem   缓存接口类
            $LX    1 读设 随机值  2 验证删除随机值
        */

        if( $LX == 1 ){

            $VALUE = mima( orderid() );
            $Mem ->s( 'wenyiyz/'.mima($NAME) , $VALUE, 360 );
            return $VALUE;
         
        }else{

            usleep( rand( 1000 , 10000 ) );

            $fan = $Mem ->g('wenyiyz/'.mima( $NAME ) );
            if(! $fan ) return false;
            if( $fan != $VALUE ) return false;
            else{

                if( $LX != 3 ) $Mem ->d( 'wenyiyz/' . mima( $NAME ) );
                else           $Mem ->s( 'wenyiyz/' . mima( $NAME ) , $fan , 360 );

                return true;
            }

        }
}


function dingguoqi( $USERID = 0 ){

        /* 订单过期 */

        $atime = time() - 3600 ;


        $where = array( 'off IN' => '0,1' , 'atime <'=> $atime);

        if( $USERID > 0) $where['uid'] = $USERID;
        $D = db('dingdan');
        
        $sss = $D -> where( $where )-> update(array( 'off'=> 3 ,'xtime' => time() ));

        $atime = time() - 3600*24*30;
        $where = array( 'off' => '3' , 'atime <'=> $atime);
        if( $USERID > 0)  $where['uid'] = $USERID;

        $D -> where( $where )-> delete();


        return  $sss;


}


function payzhifu(   $USERID  , $TONGYIID ,$LX = 1, $D = '' , $XTID = '' , $paytype =0 ){

        /* 支付订单
            $USERID      用户UID
            $TONGYIID  统一id
            $D         表结构
            $LX   等于1  统一下单
                  等于2  用户id

        */

        $ttype = 0;
        /*日志分类*/


        if( $D == '') $D = db( 'dingdan' );
        else    $D -> setbiao( 'dingdan' );
        $WHEEE = array( 'type' => 0 ,'off' => 0 );
        
        if( $LX == 1 ) $WHEEE['tongyiid'] = $TONGYIID ;
        else           $WHEEE[ 'orderid'] = $TONGYIID ;

        $DINDATA = $D ->where( $WHEEE )-> select();
      

        if(! $DINDATA || $DINDATA['0']['uid'] != $USERID ) return false;

        $huobi0 = $huobi1 = $huobi2 = 0 ;

        $hongbao = 0;
        $hongnum = count( $DINDATA );

        $CHEGONG = false;

        $D -> setshiwu(1);

        $time = time();

        foreach($DINDATA as $ooo){

            $sql = '';

            if( $LX == 1 )
                 $hongbao  = $ooo['hongjine'] / $hongnum ;
            else $hongbao  = sprintf("%.2f", $ooo['fakuaima']);


            $JINE = $ooo['payjine'] - $hongbao;

            if( $JINE  <= '0' ) $JINE = 0;

            if( $JINE > 0 ){

                $sql .= $D -> setbiao('user')    -> where ( array( 'uid' => $USERID,'jine >='=> ($JINE < 0 ?-$JINE : $JINE ) ) ) -> update( array( 'jine -' => $JINE ) );
                $sql .= $D -> setbiao('jinelog') -> insert( array( 'uid' => $USERID,
                                                                  'type' => $ttype,
                                                                  'jine' => - $JINE,
                                                                  'data' => $TONGYIID,
                                                                    'ip' => $ooo['ip'],
                                                                 'atime' => $time,
                                                        ) );
            }



            $cha = $D -> setbiao('dingdanx') ->where( array('orderid' => $ooo['orderid'] ,'huobi' => 0) )-> find();
            if( $cha ) $sql.=  $D  ->where( array( 'orderid' => $ooo['orderid'] ,'huobi' => 0) ) -> update( array( 'off' => 2, 'ctime' => $time ));




            if( $ooo['jifen'] > 0 ){

                $sql .= $D -> setbiao('user') -> where( array( 'uid' => $USERID ,'jifen >='=> ($ooo['jifen'] < 0 ?-$ooo['jifen'] : $ooo['jifen'] )) )->update( array( 'jifen -' => $ooo['jifen'] ) );
                $sql .= $D -> setbiao('jifenlog') -> insert( array( 'uid' => $USERID,
                                                              'type' => $ttype,
                                                              'jine' => - $ooo['jifen'],
                                                              'data' => $TONGYIID,
                                                                'ip' => $ooo['ip'],
                                                             'atime' => $time,
                                                        ) );
            
            
            }

            $cha = $D -> setbiao('dingdanx') ->where( array('orderid' => $ooo['orderid'] ,'huobi' => 1) )-> find();
            if($cha) $sql.=  $D  ->where( array('orderid' => $ooo['orderid'] ,'huobi' => 1) ) -> update( array( 'off' => 2, 'ctime' => $time));




            if( $ooo['huobi'] > 0 ){

                $sql .= $D -> setbiao('user') -> where( array( 'uid' => $USERID,'huobi >='=> ($ooo['huobi'] < 0 ?-$ooo['huobi'] : $ooo['huobi'] ) ) )->update( array( 'huobi -' => $ooo['huobi'] ) );
                $sql .= $D -> setbiao('huobilog') -> insert( array( 'uid' => $USERID,
                                                              'type' => $ttype,
                                                              'jine' => - $ooo['huobi'],
                                                              'data' => $TONGYIID,
                                                                'ip' => $ooo['ip'],
                                                             'atime' => $time,
                                                        ) );
            }

            $cha = $D -> setbiao('dingdanx') ->where( array('orderid' => $ooo['orderid'] ,'huobi' => 2) )-> find();
            if($cha) $sql.=  $D  ->where( array('orderid' => $ooo['orderid'] ,'huobi' => 2) ) -> update( array( 'off' => 2, 'ctime' => $time));




            $sql .= $D-> setbiao('dingdan') ->where( array( 'orderid' => $ooo['orderid'] ) ) ->update( array( 'xtime' =>  $time, 'off' => 2, 'rejine' => $JINE ,'xiorderid' => $XTID , 'paytype'=> $paytype,'faoff' => 1 ));

      
            $fan = $D -> qurey( $sql ,'shiwu');

            if( $fan ){
            
                $D ->setshiwu(0)->setbiao('center') -> where(array( 'id' => $ooo['shid'] )) -> update( array('xiaoliang +'=> 1 ));
            }

            if( $fan && !$CHEGONG ) $CHEGONG = true;

        }

        uid( $USERID , 1);

        return $CHEGONG ;


}



function jisuandiqu( $idd ){
      /* 根据地区 计算上一级 */


      if(strlen( $idd ) != 6 ) return 0; 
      $fan = qsubstr($idd,4,2);

      if($fan == '00') return $idd;
      else return qsubstr($idd,0,4).'00';


}


function chongzhifan(  $XTID , $JINE , $DDID ){

        /* 充值 返回
            $XTID 商户id
            $JINE 金额日志
            $DDID 用户订单
        */
        if( $JINE <= 0 ) return false;

        $paylx = 1;

        $chenggong = false;

        $D = db('dingdan');

        $data = $D -> where( array(  'orderid' => $DDID ) ) -> find();

        if( $data ){







            if( $data['off'] == '1' ){

                $chenggong = true;

                $USERID  =  $data['uid'];

                global $PAYAC;

                $time = time();

                $sql = $D -> setshiwu(1) -> where( array( 'id' => $data['id'] )) -> update( array( 'off' => 2  , 'rejine' => $JINE  , 'xtime' => $time , 'paytype' => $PAYAC['id'] , 'xiorderid' => $XTID ) );

                $sql .= $D -> setbiao( 'user' )  -> where( array( 'uid' => $USERID )) -> update( array( 'jine +' => $JINE ));

                $sql .= $D -> setbiao( 'jinelog' ) -> insert( array( 'uid' => $USERID ,
                                                                    'type' => 1 ,
                                                                    'jine' => $JINE ,
                                                                    'data' => $DDID ,
                                                                      'ip' => $data['ip'],
                                                                   'atime' => $time,
                                                                )
                                                       );

                $fn = $D -> qurey( $sql , 'shiwu');

                if( $fn ){

                    $USER = uid( $USERID , 1);
                    $chenggong = true;

                    czthongzhi( $USER , $JINE , $DDID );

                    if( $data['tongyiid']  != ''){

                        if( $data['diqu'] == 1 ) $paylx = 2;

                        $chenggong = payzhifu( $USERID , $data['tongyiid'] , $paylx , $D, $XTID , $data['paytype'] );
                    }

                    zchongzhifan(  $D , $USER , $JINE , $DDID );

                }else $chenggong = false;
            }
        }

        return $chenggong;
}



function yuanchuang( $DATA ){

         /* 轻度为原创 */

        $DATA =  quchuk( $DATA );
        $zongshu = (float)( strlen( $DATA ) / 3);

        $shu1 = qsubstr( $DATA , 0 , $zongshu  * 0.1  );
        $shu2 = qsubstr( $DATA , $zongshu * 0.5 , $zongshu * 0.1 );
        $shu3 = qsubstr( $DATA , $zongshu * 0.8 , $zongshu * 0.1 );

        $DATA = str_replace( $shu1 , $shu1.$shu2 , $DATA );
        $DATA = str_replace( $shu2 , $shu2.$shu3 , $DATA );
        $DATA = str_replace( $shu3 , $shu3.$shu2 , $DATA );
        return $DATA;

}


function fengecn( $kkk ){

        /*  分割中文 */
        $kkk = str_replace( array( '一','二','三','四','五','六','七','八','九','十'), array(1,2,3,4,5,6,7,8,9,10)  ,quchuk( $kkk ) );
        preg_match_all("/[0-9a-zA-Z]+/", $kkk, $nstr);
        $nstr['0']= array_unique($nstr['0']);
        $gege= '#(.*)'.implode('(.*)',$nstr['0']).'(.*)#is';
        preg_match_all( $gege , $kkk , $zhgss );
        unset($zhgss[0]);

        $zhgsss = array();

        foreach( $zhgss as $kkk ){
       
            if( !isset($kkk['0']) ||  $kkk['0'] == '' ) continue ;
            $zhgsss[]=$kkk['0'];
            
        }

        $zhi  = implode(',',  $nstr['0'] ).',';
        $zhi .= implode(',', $zhgsss );
        $zhi  = str_replace(' ',',',$zhi);
        $zhi  = str_replace(',,','',$zhi);

        return trim( $zhi , ',' );
}



function zyuanchuang(  $star , $assi = 3 ,  $biaoh = 1 ,  $qulie = 1 ,  $yuzhong = 1 ){
    

        /* $star 内容
           $assi  字节除以
           $biaoh  分割后缀补位 1 <br />   2 ,  0 空格  其他就其他
           $qulie  保留分割字数 1 10%  其他多少 就是多少字节
           $yuzhong  1 中文 2 拼音
        */

        $xinnum = ceil( strlen( $star ) / $assi );

        if( $biaoh == 1 ){

            $biaohou = "<br />"; 
        }else if( $biaoh == 2 ){

            $biaohou = ",";
        }else if( $biaoh == '0' ){

            $biaohou = "";
        }else{ 

            $biaohou = $biaoh;
        }

        if($qulie==1 ){

            $taomu  = ceil( $xinnum * 0.1 );

        }else{
                $taomu  =  $qulie;
                preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $star, $matches);
                $star = join('', $matches[0]);
        }

        if( $yuzhong != 1 ){ 

            $star = pinyin( $star );
        }
        
        $xx = '';

        $xx .= qsubstr( $star , ceil( $xinnum * 0.1 ) , $taomu ) . $biaohou ;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.15) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.2 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.3 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.4 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.5 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.6 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.7 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.8 ) , $taomu ) . $biaohou;
        $xx .= qsubstr( $star , ceil( $xinnum * 0.9 ) , $taomu );

        return $xx;
}




function changwei( $qucii , $length = array() ,$biaoh = 2 , $biao = "" ){

        /*
            长尾关键词 随机长尾词
            $quci   关键词
            $biaoh  分割符号  1 换行 2 , 分割
            $biao   第二辅助词
            $length 长尾词数组
        */

        if(     $biaoh == 1 )  $biaohou = "<br />";
        elseif( $biaoh == 2 )  $biaohou = ",";
        else                   $biaohou = $biaoh;
        $string = '';

        $guaci = explode(',' , $qucii);
         
        for( $i = 0 ;  $i < count( $length ); $i++ ){

            $quci  = $guaci[array_rand($guaci,1)];


            if( ($i % rand( 1 , 10) ) == '1'){

                  $biao12 = $biao;
            }else $biao12 = '';
               
            if( ($i % rand( 1 , 10) )== '1'){

                $string .= $quci . $length[$i]. $biao12 .$biaohou;

            }else if( rand( 1 , 3 ) < 3 ){

                $string .= $length[$i]. $quci .$biaohou;
            }
        }

        return trim( $string , $biaohou );
}


function yunjiage( $liang  , $ttvv = array() ){


        /*
        计算用户价格
        $liang  合并的购买数量
        $ttvv 运费永伴参数
        */

        $xjiage = (float)$ttvv['fei'];  /*初始费用*/
        $jian   = (float)$ttvv['jian']; /*初始件数*/
        $jia    = (float)$ttvv['jia'];   /*增加多少量*/
        $zeng   = (float)$ttvv['zeng']; /*增加多少钱*/

        if( $jian <=0 ) $jian = 1;
        if( $jia <=0 )  $jia = $jian;
        if( $zeng<= 0)  $zeng = $xjiage;
        if( $zeng > $xjiage) $zeng = $xjiage;
        $duoyu = $liang - $jian;

        if( $duoyu > 0){

            $xjiage += ceil( $duoyu/$jia) * $zeng;

        }

        return  $xjiage ;

} 


function tehui( $level = 1){

    /* 根据等级 来计算 比例 */
 

    return 1;
}

function createLinkstring( $para) {

            $arg  = "";

            while (list ( $key, $val) = each ($para)) {
                   $arg.=$key."=".$val."&";
            }
    
            $arg = substr($arg,0,count($arg)-2);

    
            if( get_magic_quotes_gpc()){ $arg = stripslashes( $arg);}
    
            return $arg;
}