<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');


plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );


/*
 api 通用调取
*/


$Memsession = $Mem = new txtcc();


$ID = (int) isset( $_GET['id']) ? $_GET['id'] : 0;

$ACTION = array( 'chenshi' => '城市id',
                   'vocde' => '验证码',
                  'chaoff' => '查询订单状态',
                  'moxing' => '产品模型',
                    'test' => '测试数据',
                    'tiao' => '跳转连接',
                   
           );

if( isset( $_GET['action']) && $ACTION[ $_GET['action']] ){



    if( $_GET['action'] == 'tiao' ){

        $ID = ( float )( isset( $_GET['id'] ) ? $_GET['id'] : 0 );
        $LX = ( float )( isset( $_GET['lx'] ) ? $_GET['lx'] : 1 );



        $DATA =  danye(  $ID ,  '' , $LX );


        if( $DATA ){

        Header("Location: ".$DATA['link']);

        }else Header("Location: ".WZHOST);

        exit();

    }else if( $_GET['action'] == 'test' ){
   

 
    
    }else if( $_GET['action'] == 'chaoff' ) {

        $data = array();
        $ORDER = array();

        if( isset( $_POST['tkey'] ) ){

           $DB = db('dingdan');
           $ORDER =   $DB ->where( array( 'orderid' => $_POST['tkey'] ) )-> find();

        }

        if(isset( $ORDER['id'] ) &&  $ORDER['id'] > 0 ){

            $data['start'] = 1;

            if( $ORDER['off'] == 2)$data['msg'] = 2;
            else  if( $ORDER['off'] == 3 || $ORDER['off'] == 4 )$data['msg'] = 1;



        }else $data['msg'] = -1;

        exit(json_encode( $data));


    
    
    }else if( $_GET['action'] == 'chenshi' ) {

		$DATA = chengshi($ID);

		if( $DATA ){

			  if($ID > 0) unset( $DATA['0']);
		       
			  exit( json_encode( array( 'code' => '1', 'data' => $DATA   , 'msg' => 'yes data' )));
		
		}else exit( json_encode( array( 'code' => '0', 'data' => array() , 'msg' =>  'no data' ))); 
	
	
	}else if( $_GET['action'] == 'vocde'){


          if(  isset( $_GET['apptoken'] ) && strlen( trim( $_GET['apptoken']) ) > 60 ){ 
                
                session_id( $_GET['apptoken']);
            }

           setsession( $CONN['sessiontime'] );
           echo vcode('6','0123456789',4,100,32,88,6);
          
           exit();
    
    
    }else if( $_GET['action'] == 'moxing'){


        $D = db('chanpingg');

        $DATA = $D ->where(array( 'id' => $ID )) -> find();

        if( $DATA ){


            $LANG = include HTLANG;

            $DATA['canshu'] = unserialize( $DATA['canshu'] );

             if(isset( $DATA['canshu']['shuju'] ) && $DATA['canshu']['shuju']){
                
                 foreach($DATA['canshu']['shuju'] as $dk => $dv){


                     if( $dv['name']!= ''){

                ?>

                <li class="canshu<?php echo $dk;?>" data="<?php echo $dk;?>">
                     <input type="text" placeholder="<?php echo $LANG['guigena'];?>" name="canshu[<?php echo $dk;?>][name]" value="<?php echo $dv['name'];?>" class="input-text ccdname" style="width:80%;"><a href="javascript:dadanchu(<?php echo $dk;?>)" style="clear:both;"> <i class="Hui-iconfont" style="color:red;font-size:28px"> </i> </a>


                    
                     
                     <p style="margin-top:10px;"> 

                     <?php unset($dv['name']);

                      $sll = count($dv);
                     
                     if($sll > 0){

                         $zf=0;
                         foreach($dv as $dddc){

                             if( $dk == '0' ){ 
                                 
                                 
                                 
                                 $tazhi = token();
                                 ?>

                             <label class="l<?php echo $dk;?>_<?php echo $zf;?>">
                             
                             <input placeholder="<?php echo $LANG['guigecs'];?>"   type="text" class="input-text ccdcanshu" style="width:15%;" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][canshu]" value="<?php echo isset($dddc['canshu'])?$dddc['canshu']:'';?>"> 
                             
                             <input placeholder="<?php echo $LANG['beizhu']?>" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][miaosu]"  type="text" class="input-text" style="width:15%;"  value="<?php echo isset($dddc['miaosu'])?$dddc['miaosu']:'';?>"> 
                             
                             <input type="text" class="input-text" style="width:50%;"  value="<?php echo isset($dddc['tupian'])?$dddc['tupian']:'' ;?>" id="imgshowac<?php echo $tazhi;?>"  placeholder="<?php echo $LANG['guigetp']?>" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][tupian]" > 
                             <input type="button" id="filePicker<?php echo $tazhi;?>"  value="update"  />
                             
                             
                             <script>KindEditor.ready(function(K) {    var uploadbuttonac<?php echo $tazhi;?> = K.uploadbutton({  button : K("#filePicker<?php echo $tazhi;?>")[0], fieldName : "all",  url : updatedurl ,afterUpload : function(data) { if ( data.error === 0) {var url = K.formatUrl(data.url, "absolute");  K("#imgshowac<?php echo $tazhi;?>").val(url);}else{  layer.msg(data.message, { time: 2000 });}}, afterError : function( str ) {layer.msg(str, { time: 2000,  }); }});uploadbuttonac<?php echo $tazhi;?>.fileBox.change(function(e) {uploadbuttonac<?php echo $tazhi;?>.submit();}); });</script>


                           <a href="javascript:dlanchu(<?php echo $dk;?>,<?php echo $zf;?>)"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a>
                           
                           </label>
                             
                             
                             
                       <?php      }else{
                    ?>

                    <label class="l<?php echo $dk;?>_<?php echo $zf;?>"><input placeholder="<?php echo $LANG['guigecs'];?>" " maxlength="30" type="text" value="<?php echo $dddc['canshu'];?>" class="input-text ccdcanshu" style="width:158px;" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][canshu]"> <a href="javascript:dlanchu(<?php echo $dk;?>,<?php echo $zf;?>)"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></label>




                     <?php } $zf++;} }?>
                     
                    
                     
                     
                     </p>
                        <div style="clear:both;"></div> <a href="javascript:adanchu(<?php echo $dk;?>)" style="clear:both;"> <i class="Hui-iconfont" style="color:green;">
                        </i>
                        </a>
                        
                      </li>



                <?php  } } }




                $content = ob_get_contents();
                ob_clean();

                exit( json_encode( array( 'code' => '1', 'data' => $content , 'msg' =>  'data' )));






        
        }else exit( json_encode( array( 'code' => '0', 'data' => array() , 'msg' =>  'no data' )));



    }else exit( json_encode( array( 'code' => '0', 'data' => array() , 'msg' =>  'no data' )));


}else exit( json_encode( array( 'code' => '0', 'data' => array() , 'msg' => 'no file' )));