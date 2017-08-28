<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');
/*
200 操作成功
401 需要登录用户
500 内部服务器错误
304 修改失败
410 删除失败
404 查询失败
406 新增失败
415 非法数据 token错误
exit( json_encode( apptongxin( array()  ,'500', '-1' , 'no mode' ) ) );
*/ 

if( $USERID  < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );

$USER = uid( $USERID );
if( !$USER  ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );

if( $MOD == 'get' ){

    /*
    读取订单数据
    page  页码
    num   读取条数
    type  类型 2 已完成 1 未完成 3 已取消
    
    */

    /* 获取用户信息 */
    $PAGE = (int)( isset( $_POST['page'] ) ? $_POST['page'] : 1 );
    $NUM  = (int)( isset( $_POST['num']  ) ? $_POST['num'] : 8 );
    $TYPE = (int)( isset( $_POST['type']  ) ? $_POST['type'] : 1 );
    if( $NUM < 8 ) $NUM = 8;
    if( $NUM > 88) $NUM = 88;

    $limit = listmit( $NUM , $PAGE);

    $D = db('dingdan');
    $WHERE = array( 'uid' => $USERID,'type' => 0 );

    if( $TYPE == 2){
        /*已完成*/

        $WHERE['faoff'] = 8;
    
    
    }else if( $TYPE == 3){

        /*已取消*/
        $WHERE['off'] = 3;
    
    
    }else{  /*初始读取*/


        $WHERE['off !='] = 3;
        $WHERE['faoff !='] = 8;

    }


    $DATA = $D ->where( $WHERE ) -> limit( $limit ) ->order('id desc')-> select();


    if( $DATA ){

        $FAOFF  = logac('faoff');
        $PAYOFF = logac('payoff');

        $CODE = 1;

        $D ->  setbiao('dingdanx');

        foreach($DATA as $ONG){

            $danxing = $D ->where( array( 'orderid'=> $ONG['orderid'])) ->order('id asc')-> find();
                        if( ! $danxing ) $danxing = array();

            $SHUJU[] = array(  'faoff' => $ONG['faoff'],
                           'faoffname' => $FAOFF[$ONG['faoff']],
                             'orderid' => $ONG['orderid'],
                            'tongyiid' => $ONG['tongyiid'],
                                 'url' => mourl( $CONN['userword'].$CONN['fenge'].'chading','',$CONN['fenge'].$ONG['orderid'].$CONN['houzui']),
                              'tupian' => pichttp($danxing['tupian']),
                                'name' => $danxing['name'],
                              'canshu' => $danxing['canshu'] != '' ? str_replace( '_',' ', $danxing['canshu'] ) : '' ,
                             'jianshu' => $ONG['fakuaidi'],
                               'shifu' => $ONG['payjine'] - (float)$ONG['fakuaima'],
                                 'off' => $ONG['off'],
                             'offname' => $PAYOFF[ $ONG['off'] ],
                             'tongurl' => mourl( $CONN['userword'].$CONN['fenge'].'chading','',$CONN['fenge'].$ONG['orderid'].$CONN['fenge']),
                           'shangname' => '',
                           'atime' =>$ONG['atime'],
                           'jine' => $ONG['jine'],






                
            
                 );
        
        
        }

        

    
    
    
    }else $CODE = -1;

    




    


}else if( $MOD == 'post' ){

    /*新增数据*/
    $hongid  = (float)( isset( $_POST['hongid']) ? $_POST['hongid'] : 0 );
    $shouid  = (float)( isset( $_POST['shouid']) ? $_POST['shouid'] : 0 );
    $TOKEN   = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '' ;  /* token令牌 */
    $dayuyong = -1;

    if( ! wenyiyz( 'ding/'.$USERID, $TOKEN    , $Mem , 2 ) )
    exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );
    
    
    $GWC  = $Mem -> g( 'gouwuche/'. $USERID );

    if( ! is_array( $GWC ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );



    $cunzia = false;

    $XGTYPE = logac('xgtype');
    $YUNTYPE = logac('yuntype');
    $YFFS = logac('yunfs');

    $sql = '';

    $CHANPINI = array();



   

    foreach( $GWC as $DK => $DV ){

        if( $DV ){

            foreach( $DV as $CSU => $vvv){

                $shuju = danye( $vvv['cpid'] , '' , '1' );
                usleep(1);

                if( !$shuju || $shuju['off'] != 2){

                    unset( $GWC[$DK][$CSU] );
                    if( !$GWC ) $GWC = array();
                    $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                    continue;

                    

                }

                $CHANPINI[ $vvv['cpid'] ] = array( 'name' => $shuju['name'],
                                                    'tupian' => $shuju['tupian'],
                        
                                   );

                $CPNUM = array();

                $jiage = $vvv['jiage'];

                if( $jiage < 0 ){

                        unset( $GWC[$DK][$CSU] );
                        if( !$GWC ) $GWC = array();
                        $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                        continue;

                }

                if( $jiage < 0.001 ) {

                        $shuju['xgtype']  = 2;

                        if( $shuju['xiangou'] < 1 || $CONN['xiangou0'] == 1 ) $shuju['xiangou']= 1;

                        $shuju['xgdata'] = $shuju['xiangou'];

                        $CPNUM[$shuju['id']]=  $GWC[$DK][ $CSU ]['num'];

                }

                $NUM = $vvv['num'];

                if( $shuju['xiangou'] > 0 && $shuju['xgtype'] > 0 ){

                        if( $GWC ){

                            foreach($GWC as $ZGC ){

                                if($ZGC ){ 

                                    foreach($ZGC as $ZZGC){

                                        if( !isset( $CPNUM[$ZZGC['cpid']] )) $CPNUM[$ZZGC['cpid']] = $ZZGC['num'];
                                        else $CPNUM[$ZZGC['cpid']] += $ZZGC['num'];
                                    }
                                }
                            }
                        }

                   

                        if( ! isset( $CPNUM[$shuju['id']] )) $CPNUM[$shuju['id']] = 0;

                        if( $CPNUM[$shuju['id']] >= $shuju['xiangou'] && $shuju['xiangou'] > 0  &&   $NUM >= $GWC[$DK][ $CSU ]['num'] ){
                        
                         unset( $GWC[$DK][ $CSU ] );
                         if( !$GWC ) $GWC = array();
                            $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                            continue;
                        
                        }

                        $yigou = xiangou( $USERID  , $shuju );
                        usleep(1);

                        $zuida = $shuju['xiangou'] - $yigou - $CPNUM[$shuju['id']] + $GWC[$DK][ $CSU ]['num'];

                        if( $zuida <= 0 ){

                            unset( $GWC[$DK][$CSU] );
                            if( !$GWC ) $GWC = array();
                            $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                            continue;
                        
                        
                        }

                        if( $NUM > $zuida ){

                        $GWC[$DK][ $CSU ]['num'] = 0;
                        $NUM = $zuida ;
                        }

                    }


                    $GWC[$DK][ $CSU ]['num'] = $NUM;

                    if( $GWC[$DK][ $CSU ]['num'] < 1) {
                        unset( $GWC[$DK][ $CSU ] );
                        if( !$GWC ) $GWC = array();
                            $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                        continue;
                    }

                    if( ! $cunzia && $vvv['type'] == '0' ) $cunzia  = true;


            }
        }
    }

    if( !$GWC ) $GWC = array();

    $Mem -> s( 'gouwuche/'. $USERID , $GWC );

    if(! $GWC )  exit( json_encode( apptongxin( array()  ,'415', '1' , '购物车没有产品'.$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );
   

##########################################################################################
##################################      购物车重新更新完成      ##########################
##########################################################################################

    $YUNFEIJI  = $yunfei = $huobi0 = $huobi1 = $huobi2  = 0;

 

    /* $YUNFEIJI  默认收货地区 */
    $WULIU = $ZONGLIANG = $BAOCAN =  $YUNJL = array();

    if( $cunzia ){

        $SH = db('shouhuo');

        $WULIU = $SH ->where( array( 'id' => $shouid ))-> find();
        if( ! $WULIU ||  $WULIU['uid'] != $USERID  ) exit( json_encode( apptongxin( array()  ,'415', '1' , '收货地址'.$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


        $YUNFEIJI = jisuandiqu(  $WULIU['diqu'] );

    }

    $sql = '';
    
    $DB = db('dingdanx');

    $zyunzueh = array();

    $ZSHANGJIN = 0;


  
    

    foreach( $GWC as  $k => $gou ){



            if( is_array( $gou ) ){ 

                 $SHANGJIN = 0;

                $KUAI = array();

                foreach($gou as $kv => $xiang){

                    if( ! $cunzia && $xiang['type'] == '0' ) $cunzia  = true;

                    $zji = $xiang['num'] * $xiang['jiage'];

                    $yuntype = -1 ;

                    if( $xiang['yunid'] > 0){

                        if( ! isset( $zyunzueh [ $xiang['yunid'] ] ) ) $zyunzueh [ $xiang['yunid'] ] = yunfeiid( $xiang['yunid'] );

                         if($zyunzueh [ $xiang['yunid'] ]['off']  < 1 )
                         $yuntype = $zyunzueh [ $xiang['yunid'] ]['type'];

                        if( ! isset( $KUAI[$xiang['yunid']] ) )  $KUAI[$xiang['yunid']]  = $xiang['num']*$xiang['jinzhong'];
                        else                                     $KUAI[$xiang['yunid']] += $xiang['num']*$xiang['jinzhong'];
                    }

                    $GWC[$k][$kv]['yuntype'] = $yuntype ;

                    if( $xiang['huobi'] == '0'){

                        $huobi0   += $zji;  /*货币金额*/
                        $SHANGJIN += $zji;  /*总金额*/
                        $ZSHANGJIN +=$zji;  /*总金额*/

                    }else if( $xiang['huobi'] == '1')
                        $huobi1  += $zji;
                    else if( $xiang['huobi'] == '2')
                        $huobi2  += $zji;
                }

                $BAYOMO =  $ZUHEMO = array();  /* 包邮参数组合  选择地区组合运费模版 */

                $liang  = 0;

                if( $KUAI ){

                    /* 商家快递总量 */
                    foreach( $KUAI as $KUID => $KUNUM ){
                        /*
                        $KUID   快递id
                        $KUNUM  快递数量
                        off     等于1 包邮
                        */
                        $KUIXQ = $zyunzueh[$KUID];
                        usleep(1);

                        if( $KUIXQ && $KUIXQ['off'] == '0' ){

                            $YUFXQ   = unserialize( $KUIXQ['data'] );    /* 快递模版详情 */
                            $BAODATA = unserialize( $KUIXQ['baodata'] ); /* 快递包邮详情 */

                            if( $YUFXQ ){

                                $KUAIZUHE = array();

                                /* $KUDLX   快递类型 EMS 平邮 包邮
                                   $KUDTYPE 快递类型详情
                                */

                                foreach( $YUFXQ as $KUDLX => $KUDTYPE ){

                                    unset( $KUDTYPE['ding'] );
                                    /* 给与默认运费方式*/
                                    $MOREN = $KUDTYPE['0'];
                                    unset( $KUDTYPE['0'] );

                                    /* 还有其他*/
                                    if( $KUDTYPE ){
                                        /*  $DIQUSX 订单筛选  */
                                        foreach( $KUDTYPE as $DIQUSX  ){

                                            if( strpos( ','.$DIQUSX['diqu'].',' , ','.$YUNFEIJI.',') !== false){
                                                $MOREN = $DIQUSX;
                                                break;
                                            }
                                        }
                                    }
                                    /*给出快递方式 默认价格*/
                                    $KUAIZUHE[$KUDLX]  = $MOREN;
                                }

                                /* 给出计件方式 的快递数据 */
                                $ZUHEMO[$KUIXQ['type']][$KUID] = $KUAIZUHE;
                            }



                            if( $BAODATA ){

                                /* 包邮标识  $KUID  */
                                unset( $BAODATA['ding'] );
                                $biaozuhe = array();

                                foreach($BAODATA as $baosju){

                                    $biaozuhe[$baosju['type']][] = $baosju;
                                }

                                foreach( $biaozuhe as $kuitype => $dezhi ){

                                    /* $kuitype 快递类型*/
                                    $morenbaoyou = $dezhi['0']; unset( $dezhi['0'] );

                                    if( $dezhi ){

                                        foreach( $dezhi as $DIQUSX  ){

                                            if( strpos( ','.$DIQUSX['diqu'].',' , ','.$YUNFEIJI.',') !== false){
                                                $morenbaoyou = $DIQUSX;
                                                break;
                                            }
                                        }
                                    }

                                    $BAYOMO[$KUIXQ['type']][$KUID][$kuitype] = $morenbaoyou;
                                }

                            }
                        }
                    }


                    /*
                        $ZUHEMO  0 计量方式 快递id 快递方式
                        $BAYOMO
                    */

                    foreach( $ZUHEMO as $SHJIA => $ZFANS ){

                        /* 同一个计量方式 */
                        if( count($ZFANS) > 1 ){

                            /* 多个计量方式*/
                            $kecuzna = array();

                            /* $ZFANS 快递信息*/
                            foreach($ZFANS as $zzk => $zzv){

                                foreach($zzv as $ttkk => $ttvv){

                                    if( isset($kecuzna[ $ttkk ])) $kecuzna[ $ttkk ]+=1;
                                    else $kecuzna[ $ttkk ] = 1;
                                }
                            }

                            $xuanzhongke = array();

                            foreach( $kecuzna  as $tk => $tv){

                                if( $tv > 1 ) $xuanzhongke[] = $tk;
                            }

                            /* 多个运费 */

                            if( $xuanzhongke ){

                                $liang  = 0;
                                $zongji = array();

                                foreach( $xuanzhongke as $vvvv ){
                                    $liang  = 0 ;

                                    foreach($ZFANS as $zzk => $zzv){

                                        
                                     
                                        $liang += $KUAI[$zzk];

                                        if( isset( $zzv[$vvvv] ) ) $ttvv = $zzv[$vvvv];
                                        else continue;

                                        $miaoshu = '';
                                        $xjiage  = yunjiage( $liang , $ttvv );

                                        if( ! isset( $zongji[$vvvv] ) ){

                                            $zongji[$vvvv] =array('cpjine'=>$SHANGJIN, 'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $liang ,'yuntype' => $vvvv);
                                       
                                        }else if( $zongji[$vvvv] < $xjiage ){

                                            $zongji[$vvvv] = array( 'cpjine'=>$SHANGJIN,'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $liang ,'yuntype' => $vvvv );
                                        }

                                        /* 可以包邮处理 */

                                        if( isset( $BAYOMO[$SHJIA][$zzk][$vvvv] ) ){

                                            $baoxc   = $BAYOMO[$SHJIA][$zzk][$vvvv];
                                            $BAOJIAN = (float) $baoxc['jian'];
                                            $BAOJINE = (float) $baoxc['mian'];

                                            if( $BAOJINE > 0 && $BAOJIAN > 0  ){

                                                if( $SHANGJIN  >=  $BAOJINE &&  $liang >= $BAOJIAN ) $xjiage =  0;
                                                //$miaoshu = '滿'.$BAOJINE.$CONN['jine'].'并且 满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';

                                            }else if( $BAOJINE > 0  ){

                                                if( $SHANGJIN  >= $BAOJINE   ) $xjiage =  0;
                                                //$miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 包邮';

                                            }else if( $BAOJIAN > 0  ){

                                                if( $liang  >=  $BAOJIAN ) $xjiage =  0;
                                                //$miaoshu = '满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';
                                            }

                                            $zongji[$vvvv] =  array('cpjine'=>$SHANGJIN, 'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $liang  ,'yunid' => $zzk ,'yuntype' => $vvvv );
                                        }
                                    }
                                }


                                if( $zongji ){

                                    foreach( $zongji as $kx1k => $jiage ){

                                        $YUNJL[ $k ][ $SHJIA ][ $kx1k ] = $jiage;
                                    }
                                }



                            }else{

                                foreach($ZFANS as $zzk => $zzv){



                                    $liang = $KUAI[$zzk];

                                    foreach($zzv as $ttkk => $ttvv){

                                        $xjiage  = yunjiage( $liang , $ttvv );
                                        $miaoshu = '';

                                        if( isset( $BAYOMO[ $k][ $SHJIA][ $ttkk] )){

                                            $baoxc = $BAYOMO[$k][$SHJIA][$ttkk];
                                            $BAOJIAN  = (float)$baoxc['jian'];
                                            $BAOJINE= (float)$baoxc['mian'];

                                            if( $BAOJINE > 0 && $BAOJIAN > 0  ){

                                                if( $SHANGJIN  >=  $BAOJINE &&  $liang >= $BAOJIAN )  $xjiage =  0;
                                               // $miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 并且 满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';

                                            }else if( $BAOJINE > 0  ){

                                                if( $SHANGJIN  >= $BAOJINE   )  $xjiage =  0;
                                                //$miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 包邮';

                                            }else if( $BAOJIAN > 0  ){

                                                if( $liang  >=  $BAOJIAN )  $xjiage =  0;
                                                //$miaoshu = '满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';
                                            }
                                        }

                                        $YUNJL[$k][$SHJIA][$ttkk] = array('cpjine'=>$SHANGJIN, 'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $liang  ,'yunid' => $zzk ,'yuntype' => $ttkk );
                                    }
                                }

                            }


                        }else{

                            /* 独立运费*/;
                            foreach( $ZFANS as $zzk => $zzv ){

                                

                                $liang = $KUAI[$zzk];
                                foreach( $zzv as $ttkk => $ttvv ){

                                    $miaoshu = '';
                                    $xjiage = yunjiage( $liang , $ttvv );

                                 

                                    if( isset( $BAYOMO[$SHJIA][$zzk][$ttkk] )){

                                        $baoxc = $BAYOMO[$SHJIA][$zzk][$ttkk];
                                    

                                        $BAOJIAN  = (float)$baoxc['jian'];
                                        $BAOJINE  = (float)$baoxc['mian'];

                                        if( $BAOJINE > 0 && $BAOJIAN > 0  ){

                                            if( $SHANGJIN  >=  $BAOJINE &&  $liang >= $BAOJIAN )  $xjiage =  0;
                                            //$miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 并且 满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';

                                        }else if( $BAOJINE > 0  ){

                                            if( $SHANGJIN  >= $BAOJINE   )  $xjiage =  0;
                                            //$miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 包邮';

                                        }else if( $BAOJIAN > 0  ){

                                            if( $liang  >=  $BAOJIAN )  $xjiage =  0;
                                           // $miaoshu = '满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';
                                        }

                                    }

                                    $YUNJL[$k][$SHJIA][$ttkk] = array( 'cpjine'=>$SHANGJIN,'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $liang ,'yunid' => $zzk ,'yuntype' => $ttkk );

                                }
                            }
                        }

                    }

                }
            }
        }

        $youfei = 0;
        $UERXUA = array();


        if( $YUNJL ){

           

          
          if( isset( $_POST['youfei']) ){
            foreach( $_POST['youfei'] as $k => $v){

                $xuanze = explode('-',$k);
                $UERXUA[$xuanze['0']][$xuanze['1']][$v] = $v;

            }

           }

        }



        $fangshi = array();

        foreach( $YUNJL as $k => $yun ){


            foreach( $yun as $ks => $woqu){

                $fangshi[$k][$ks] = reset($woqu);
               
                if( isset( $UERXUA[$k][$ks] ) ) $fangshi[$k][$ks] = $woqu[ reset( $UERXUA[$k][$ks] ) ];
                

                $ZSHANGJIN += $fangshi[$k][$ks]['jine'];
              
            
            }

        }

        /*
        0  //商家id
        1  //记重方式
         Array
                (
                    [cpjine] => 328  //产品金额
                    [jine] => 15      //邮费价格
                    [miaoshu] =>     //描述
                    [jinshu] => 1     //记重
                    [yunid] => 11    //运费id
                    [yuntype] => 2   //运费方式
                )



        */

       // p( $fangshi );

       $HBSEYU = 0;

        if( $hongid > 0 ) $hongbao = hongbao( $USERID );
        else              $hongbao = false;

        if(! $hongbao  ){

            $hongid   = 0 ;
            $hongjine = 0 ;

        }else{

            if( isset( $hongbao[$hongid] )){


                if( $ZSHANGJIN >= $hongbao[ $hongid ][ 'dayukeyong'  ] ){

                    $HBSEYU = $hongbao[ $hongid ][ 'shengyujine' ];
    
                    $hongjine = $hongbao[ $hongid ][ 'shengyujine' ] ;

                    $KYON = $ZSHANGJIN - $hongjine;

                    if($KYON < 0) $hongjine = $ZSHANGJIN;


                }else{

                    $hongid   = 0 ;
                    $hongjine = 0 ;

                }

            }else{

                $hongid   = 0 ;
                $hongjine = 0 ;
            }
        }


       
        $sql = '';
        $TIME = time();
        $DB = db('dingdanx');
        $DB -> setshiwu('1');
        $tehui = tehui( $USER['level']);
        $LEVE  = $USER['level'];

        $wyiid =  orderid();

        $ORDEDAZ = array();

        

        foreach( $GWC as  $k => $gou ){


            $huobi0 = $huobi1 = $huobi2  = -1;

            $orderid = orderid();

            $cpnum = 0;

            if( is_array( $gou ) ){ 

                $SHANGJIN = 0;

                $KUAI = array();
                $DB -> setbiao('dingdanx');

                foreach($gou as $kv => $xiang){

                    if($xiang['num'] < 1 )  $xiang['num'] = 1;
                    if($xiang['jiage'] < 0) $xiang['jiage'] = 1;

                   

                    if ($xiang['yuntype'] > -1 ){
                        $kuaiid =$fangshi[$k][$xiang['yuntype']]['yunid'];
                        $kuaitype = $fangshi[$k][$xiang['yuntype']]['yuntype'];
                        
                    }else{
						$xiang['yuntype'] = 0;
                        $kuaiid = 0;
                        $kuaitype = 0;
                    }

                    $zji =  $xiang['num'] *  $xiang['jiage'];

                    if( $xiang['huobi'] == '0'){

                            if($huobi0 < 0) $huobi0 = 0;

                            $huobi0   += $zji;  /*货币金额*/
                            $SHANGJIN += $zji;  /*总金额*/

                        }else if( $xiang['huobi'] == '1'){

                            if($huobi1 < 0) $huobi1 = 0;
                            $huobi1  += $zji;

                        }else if( $xiang['huobi'] == '2'){

                            if($huobi2 < 0) $huobi2 = 0;
                            $huobi2  += $zji;

                        } 


                   

                    
                    $mhash = md5($k.$xiang['cpid'].$xiang['canshu'].$TIME);

                    $cpnum++;

                    $sql .= $DB ->insert( array(
                        'orderid' => $orderid  , 
                            'uid' => $USERID , 
                           'shid' => $k ,
                           'cpid' => $xiang['cpid'] ,
                           'jine' => $xiang['jiage'] ,
                            'num' => $xiang['num'] ,
                         'canshu' => $xiang['canshu'],
                           'type' => $xiang['type'],
                          'huobi' => $xiang['huobi'],
                          'atime' => $TIME ,
                             'ip' => ip(),
                           'type' => $xiang['type'],
                            'off' => 0,
                          'tehui' => $tehui,
                          'level' => $LEVE,
                         'kuaiid' => $kuaiid,
                        'kuaijil' => $xiang['yuntype'],
                       'kuaitype' => $kuaitype,
                          'mhash' => $mhash,
                           'name' => $CHANPINI[ $xiang['cpid'] ]['name'],
                         'tupian' => $CHANPINI[ $xiang['cpid'] ]['tupian'],
                        
                     

                    ) );

                }

            }

            $DB -> setbiao('dingdan');

            $suyunfei = 0;
            $kuaixq = '';

            if( isset(  $fangshi[$k] ) ){

       

                foreach( $fangshi[$k] as $zss => $ttt ){

                      $kuaixq.=  '方式:'.$YUNTYPE [$zss] 
                                .' 快递:'.$YFFS[$ttt['yuntype']]
                                .' 运费模版:'.$ttt['yunid']
                                .' 运费:'.$ttt['jine']
                                .' 计量:'.$ttt['jinshu']
                                .' 描述:'.$ttt['miaoshu'].'<br />'
                        ;

                    $suyunfei +=$ttt['jine'];
                
                }

            }

           

            $mhash = md5( $orderid .$wyiid.$USERID.$k.$TIME);

            $hbjine = sprintf("%.2f",$hongjine / count($GWC));

            $payjine = ($huobi0 >-1 ? $huobi0 : 0 )* $tehui + $suyunfei;

            if( $hbjine > $payjine ){

                $hbjine = $payjine;
 
            }

  
            $sql .= $DB -> insert( array(

                                 'orderid' => $orderid ,
                                'tongyiid' => $wyiid,
                                     'uid' => $USERID , 
                                    'shid' => $k ,
                                    'jine' => ($huobi0 >-1 ? $huobi0 : 0 )* $tehui,
                                   'jifen' => ($huobi1 >-1 ? $huobi1 : 0 )* $tehui,
                                   'huobi' => ($huobi2 >-1 ? $huobi2 : 0 )* $tehui,
                                 'payjine' => $payjine,
                               'hongbaoid' => $hongid,
                                'hongjine' => $hongjine,
                                  'yunfei' => $suyunfei,
                                   'mhash' => $mhash,
                                   'atime' => $TIME,
                                'xingming' => $WULIU['xingming'],
                                  'shouji' => $WULIU['shouji'],
                                    'diqu' => $WULIU['diqu'],
                                 'shouhuo' => $WULIU['beizhu'],
                               'fakuaidi'  => $cpnum,
                               'fakuaima'  => $hbjine,
                                   'tehui' => $tehui,
                                   'level' => $LEVE,
                                   'lailu' => lailu(),
                                      'ip' => ip(),
                                  'kuaixq' => $kuaixq

            ));

        }

        if($hongid > 0){

            if($hongjine == $HBSEYU && $HBSEYU  > 0)
                $sql.=$DB ->setbiao('hongbao')->where( array( 'id'=> $hongid ) )->update( array( 'shengyujine'=>'0','stime' => $TIME ,'off' => 1 ) ); 

            else   $sql.=$DB ->setbiao('hongbao')->where( array( 'id'=> $hongid ) )->update( array( 'shengyujine -'=>$hongjine,'stime' => $TIME ) ); 
        }


    


        $fanhui = $DB ->qurey( $sql , 'shiwu');

        if( $fanhui  ){

            $SHUJU = array( 'orderid' => $wyiid );
            $CODE  = 2;
            $Mem   -> d(  'gouwuche/'. $USERID  );

            $YZTOKEN  = wenyiyz( 'ding/'.$USERID , '' , $Mem );
        
        
        }else   exit( json_encode( apptongxin( array()  ,'415', '1' , '订单插入失败'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


}else if( $MOD == 'put' ){

    /*修改数据*/
    $TOKEN   = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '' ;  /* token令牌 */

    if( ! wenyiyz( 'ding/'.$USERID, $TOKEN    , $Mem , 2 ) )
    exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

    $DINGDAN = isset( $_POST['dingid'] ) ? $_POST['dingid'] : '' ; /* 获取 唯一标识 */
    $PAYLX   = isset( $_POST['paylx'] ) ? $_POST['paylx'] : 1 ;    /* 支付类型  默认1 唯一标识 默认 2 单个订单支付 */
    $LX      = isset( $_POST['lx'] ) ? $_POST['lx'] : 1 ;          /* 修改数据更多选项 */

    if( $PAYLX == 1 ) $PAYLX = 1;
    else  $PAYLX = 2;

    if( $DINGDAN == '' )exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法id'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


    if( $LX == 1 ){

        /* 支付订单 */

        $fan = payzhifu(  $USERID  , $DINGDAN ,$PAYLX);

        if( !$fan )exit( json_encode( apptongxin( array()  ,'200', '-1' , '支付失败'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

        $CODE  = 1 ;

    }else if( $LX == 2 ){

        /* 确认收获 */
        $D =  db('dingdan');
        $DATA = $D ->where( array( 'orderid' => $DINGDAN ) )-> find();
        if(! $DATA || $DATA['uid'] !=  $USERID )exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法收货信息'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

        if( $DATA['off'] != 2  ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '状态无法收货'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );



        if( $DATA['faoff'] != 2 ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '状态无法收货'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


        $TSHU = array( 'xtime' => time() );

        $faoff     = logac( 'faoff' );

        $TSHU['faoff'] = 3;

        $TSHU['tihuanhuo'] = $DATA['tihuanhuo'].$TSHU['faoff'].' '.time().' '.$faoff[$TSHU['faoff']] .' user-'.$USERID."\r\n";

        $fan = $D -> where( array( 'id' => $DATA['id'])) -> update( $TSHU );

        if( $fan ){

            $shuju = $D -> setbiao('dingdanx') ->zhicha('cpid,num') ->where( array( 'orderid' => $DINGDAN  )) -> select();

            if( $shuju ){
               
                $D -> setbiao('center');
                foreach($shuju  as $ong ){

                    $D ->where( array( 'id' => $ong['cpid']))-> update(array ( 'xiaoliang +'=>$ong['num'] ) );
                }
            }

        }else exit( json_encode( apptongxin( array()  ,'415', '-1' , '修改数据失败'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

    }else if( $LX == 3 ){

        /* 评论订单 */

    }
  








}else if( $MOD == 'delete' ){

    /*删除数据
    
    hongid:0
    shouid:25
    youfei[0-1]:2
    cpid:5
    num:1
    canshu:4
    
    */

    $hongid = (float)( isset( $_POST['hongid']) ? $_POST['hongid'] : 0 );
    $shouid = (float)( isset( $_POST['shouid']) ? $_POST['shouid'] : 0 );
    $TOKEN  = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '' ;  /* token令牌 */
    $CPID   = (float)( isset( $_POST['cpid']) ? $_POST['cpid'] : 0 ); /* 产品id */
    $NUM    = (float)( isset( $_POST['num']) ? $_POST['num'] : 1 ); /* 产品数量 */
    $CSHU    = (float)( isset( $_POST['canshu']) ? $_POST['canshu'] : 0 );  /*产品参数*/

    if( $NUM < 1 ) $NUM = 1;
    $YUNFEIJI  = $yunfei = $huobi0 = $huobi1 = $huobi2  = 0;

    $ZONGLIANG = $BAOCAN =  $YUNJL = array();

    $xiang = danye( $CPID ,'',1);

    if( ! $xiang ) exit( json_encode( apptongxin( array()  ,'415', '1' , '非法产品id' ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) ); 

    if( $xiang['off'] != 2 )exit( json_encode( apptongxin( array()  ,'415', '1' , '产品关闭' ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

    if( $xiang['canshu'] != '') $xiang['canshu'] = unserialize( $xiang['canshu'] );

    $JIAGE = isset( $xiang['canshu']['jiage'] ) ? $xiang['canshu']['jiage'] : array() ;
    $jiage = $xiang['jiage'];
    $CSU = '';

    $i = 0;
    foreach( $JIAGE as $k => $v ){

        if($i == $CSHU){
            $CSU = $k;
            break;
        }
        $i++;
    }

    $GUIGE =  count( $JIAGE );

    if(  $GUIGE > 0 && $GUIGE < $CSHU+1 ) exit( json_encode( apptongxin( array()  ,'415', '1' , '非法规格' ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


    if( $CSU == '' ) $CSU = key($JIAGE);

    if(isset( $JIAGE[ $CSU ]) )  $jiage = (float)$JIAGE[ $CSU ];
    else  $CSU = '';

    if($jiage < 0 ) exit( json_encode( apptongxin( array()  ,'415', '1' , str_replace('_',' ',$CSU) .' 缺货 ' ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

    

    if( $xiang['xiangou'] > 0 && $xiang['xgtype'] > 0 ){

        if( $jiage < 0.001 ) {

            $xiang['xgtype']  = 2;
            if($xiang['xiangou'] < 1 || $CONN['xiangou0'] == 1 ) $xiang['xiangou'] = 1 ;
            $xiang['xgdata'] = $xiang['xiangou'];

        }

        $XGTYPE = logac('xgtype');

        if( $NUM >= $xiang['xiangou'] ) exit( json_encode( apptongxin( array()  ,'415', '1' , $XGTYPE[$xiang['xgtype']].$xiang['xgdata'].' 超过数量2 '.$xiang['xiangou']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );
        
     


        $yigou = xiangou( $USERID  , $xiang );
        $zuida = $xiang['xiangou'] - $yigou;

        if( $zuida <= 0 )exit( json_encode( apptongxin( array()  ,'415', '1' , $XGTYPE[$xiang['xgtype']].$xiang['xgdata'].' 超过数量2 '.$xiang['xiangou']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );
        

        if( $NUM > $zuida ){ 

            $NUM = $zuida;
        }

    }

    $kuaitype = $JILIANGFS = $ZSHANGJIN = $SHANGJIN = 0;

    $SHJIA = $xiang['shid'];
    $xiang['num'] = $NUM;
    $zji = $NUM * $jiage;

    if( $xiang['huobi'] == '0'){

    $huobi0   += $zji;  /*货币金额*/
    $SHANGJIN += $zji;  /*总金额*/
                        $ZSHANGJIN +=$zji;  /*总金额*/

    }else if( $xiang['huobi'] == '1')
    $huobi1  += $zji;
    else if( $xiang['huobi'] == '2')
    $huobi2  += $zji;

    $JINZHONG = $xiang['num']*$xiang['jinzhong'];

    if( $xiang['yunid'] > 0){

    /*存在运费id*/
    $KUIXQ = yunfeiid( $xiang['yunid'] );

    $JILIANGFS = $KUIXQ['type'];

    $yuntype = logac('yuntype');
    $YFFS = logac('yunfs');



    if( $KUIXQ && $KUIXQ['off'] == '0' ){

        $YUFXQ   = unserialize( $KUIXQ['data'] );    /* 快递模版详情 */
        $BAODATA = unserialize( $KUIXQ['baodata'] ); /* 快递包邮详情 */
        $KUAIZUHE = array();

     

        if( $YUFXQ ){
       
            foreach( $YUFXQ as $KUDLX => $KUDTYPE ){

                unset( $KUDTYPE['ding'] );

                $MOREN = $KUDTYPE['0'];
                unset( $KUDTYPE['0'] );

                if( $KUDTYPE ){

                    foreach( $KUDTYPE as $DIQUSX  ){

                        if( strpos( ','.$DIQUSX['diqu'].',' , ','.$YUNFEIJI.',') !== false){

                            $MOREN = $DIQUSX;
                            break;
                        }
                    }
                     
                }
            $KUAIZUHE[$KUDLX]  = $MOREN;
            }

        }

        if( $BAODATA ){

            unset( $BAODATA['ding'] );
            $biaozuhe = array();

            foreach($BAODATA as $baosju){

                $biaozuhe[$baosju['type']][] = $baosju;
            }
            foreach( $biaozuhe as $kuitype => $dezhi ){

                                    /* $kuitype 快递类型*/
                                    $morenbaoyou = $dezhi['0']; unset( $dezhi['0'] );

                                    if( $dezhi ){

                                        foreach( $dezhi as $DIQUSX  ){

                                            if( strpos( ','.$DIQUSX['diqu'].',' , ','.$YUNFEIJI.',') !== false){
                                                $morenbaoyou = $DIQUSX;
                                                break;
                                            }
                                        }
                                    }

                $BAYOMO[$kuitype] = $morenbaoyou;
            }
        }

        foreach( $KUAIZUHE  as $zzk => $zzv ){

                $xjiage  = yunjiage( $JINZHONG , $zzv );

                $miaoshu = '';

                if( isset( $BAYOMO[ $zzk]) ){

                        $baoxc = $BAYOMO[ $zzk];
                        $BAOJIAN  = (float)$baoxc['jian'];
                        $BAOJINE= (float)$baoxc['mian'];

                        if( $BAOJINE > 0 && $BAOJIAN > 0  ){

                            if( $SHANGJIN  >=  $BAOJINE &&  $JINZHONG >= $BAOJIAN )  $xjiage =  0;
                            $miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 并且 满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';

                        }else if( $BAOJINE > 0  ){

                            if( $SHANGJIN  >= $BAOJINE   )  $xjiage =  0;
                            $miaoshu = '滿'.$BAOJINE.$CONN['jine'].' 包邮';

                        }else if( $BAOJIAN > 0  ){

                            if( $JINZHONG  >=  $BAOJIAN )  $xjiage =  0;
                            $miaoshu = '满'.$BAOJIAN.$yuntype[$SHJIA].' 包邮';
                        }
                
                }

                $YUNJL[$SHJIA][$JILIANGFS][$zzk] = array('cpjine'=>$SHANGJIN, 'jine' =>  $xjiage ,'miaoshu' => $miaoshu,'jinshu' => $JINZHONG  );
        }

    }

    }


        $HBSEYU = 0;

        if( $hongid > 0 ) $hongbao = hongbao( $USERID );
        else              $hongbao = false;

        if(! $hongbao  ){

            $hongid   = 0 ;
            $hongjine = 0 ;

        }else{

            if( isset( $hongbao[$hongid] )){


                if( $ZSHANGJIN >= $hongbao[ $hongid ][ 'dayukeyong'  ] ){

                    $HBSEYU = $hongbao[ $hongid ][ 'shengyujine' ];
    
                    $hongjine = $hongbao[ $hongid ][ 'shengyujine' ] ;

                    $KYON = $ZSHANGJIN - $hongjine;

                    if($KYON < 0) $hongjine = $ZSHANGJIN;


                }else{

                    $hongid   = 0 ;
                    $hongjine = 0 ;

                }

            }else{

                $hongid   = 0 ;
                $hongjine = 0 ;
            }
        }

      

        $UERXUA = array();


        if( $YUNJL ){

           

          
          if( isset( $_POST['youfei']) ){
            foreach( $_POST['youfei'] as $k => $v){

                $xuanze = explode('-',$k);
                $UERXUA[$xuanze['0']][$xuanze['1']][$v] = $v;

            }

           }

        }



        $fangshi = array();

        foreach( $YUNJL as $k => $yun ){


            foreach( $yun as $ks => $woqu){

                $fangshi[$k][$ks] = reset($woqu);
               
                if( isset( $UERXUA[$k][$ks] ) ) $fangshi[$k][$ks] = $woqu[ reset( $UERXUA[$k][$ks] ) ];
                
                      $YUNFEI =  $fangshi[$k][$ks]['jine'];
                $ZSHANGJIN += $fangshi[$k][$ks]['jine'];
              
            
            }

        }
         if(isset( $v) )
        $kuaitype = $v;

      

        $HBSEYU = 0;

        if( $hongid > 0 ) $hongbao = hongbao( $USERID );
        else              $hongbao = false;

        if(! $hongbao  ){

            $hongid   = 0 ;
            $hongjine = 0 ;

        }else{

            if( isset( $hongbao[$hongid] )){


                if( $ZSHANGJIN >= $hongbao[ $hongid ][ 'dayukeyong'  ] ){

                    $HBSEYU = $hongbao[ $hongid ][ 'shengyujine' ];
    
                    $hongjine = $hongbao[ $hongid ][ 'shengyujine' ] ;

                    $KYON = $ZSHANGJIN - $hongjine;

                    if($KYON < 0) $hongjine = $ZSHANGJIN;


                }else{

                    $hongid   = 0 ;
                    $hongjine = 0 ;

                }

            }else{

                $hongid   = 0 ;
                $hongjine = 0 ;
            }
        }


        $sql = '';
        $TIME = time();
        $DB = db('dingdanx');
        $DB -> setshiwu('1');
        $tehui = tehui( $USER['level']);
        $LEVE  = $USER['level'];

        $wyiid =  orderid();
        usleep(10);

        $orderid =  orderid();

        $ORDEDAZ = array();

        $mhash = md5($xiang['shid'].$xiang['id'].$CSU.$TIME);
        
        

        $sql  = $DB ->insert( $mmm = array(
                        'orderid' => $orderid  , 
                            'uid' => $USERID , 
                           'shid' => $xiang['shid'],
                           'cpid' => $xiang['id'] ,
                           'jine' => $xiang['jiage'] ,
                            'num' => $NUM ,
                         'canshu' => $CSU,
                           'type' => $xiang['type'],
                          'huobi' => $xiang['huobi'],
                          'atime' => $TIME ,
                             'ip' => ip(),
                      
                            'off' => 0,
                          'tehui' => $tehui,
                          'level' => $LEVE,
                         'kuaiid' => $xiang['yunid'],
                        'kuaijil' => $JILIANGFS,
                       'kuaitype' => $kuaitype,
                          'mhash' => $mhash,
                           'name' =>  $xiang['name'],
                         'tupian' =>  $xiang['tupian'],
                        
                     

                    ) );



             $suyunfei = 0;
            $kuaixq = '';

            if( isset(  $fangshi[$xiang['shid']] ) ){

       

                foreach( $fangshi[$xiang['shid']] as $zss => $ttt ){

            

                      $kuaixq.=  '方式:'.$yuntype [$zss] 
                                .' 快递:'.$YFFS[$kuaitype]
                                .' 运费模版:'.$xiang['yunid']
                                .' 运费:'.$ttt['jine']
                                .' 计量:'.$ttt['jinshu']
                                .' 描述:'.$ttt['miaoshu'].'<br />'
                        ;

                    $suyunfei +=$ttt['jine'];
                
                }

            }


            
        $mhash = md5( $orderid .$wyiid.$USERID.$xiang['shid'].$TIME);

            $hbjine = sprintf("%.2f",$hongjine );

            $payjine = ($huobi0 >-1 ? $huobi0 : 0 )* $tehui + $suyunfei;

            if( $hbjine > $payjine ){

                $hbjine = $payjine;
 
            }

    $cunzia= false;
   if( $xiang['type'] == '0' ) $cunzia  = true;

    if( $cunzia ){

        $SH = db('shouhuo');

        $WULIU = $SH ->where( array( 'id' => $shouid ))-> find();
        if( ! $WULIU ||  $WULIU['uid'] != $USERID  ) exit( json_encode( apptongxin( array()  ,'415', '1' , '收货地址'.$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


        $YUNFEIJI = jisuandiqu(  $WULIU['diqu'] );

    }
    $DB -> setbiao('dingdan');

  
            $sql .= $DB -> insert( array(

                                 'orderid' => $orderid ,
                                'tongyiid' => $wyiid,
                                     'uid' => $USERID , 
                                    'shid' => $xiang['shid'] ,
                                    'jine' => ($huobi0 >-1 ? $huobi0 : 0 )* $tehui,
                                   'jifen' => ($huobi1 >-1 ? $huobi1 : 0 )* $tehui,
                                   'huobi' => ($huobi2 >-1 ? $huobi2 : 0 )* $tehui,
                                 'payjine' => $payjine,
                               'hongbaoid' => $hongid,
                                'hongjine' => $hongjine,
                                  'yunfei' => $suyunfei,
                                   'mhash' => $mhash,
                                   'atime' => $TIME,
                                'xingming' => $WULIU['xingming'],
                                  'shouji' => $WULIU['shouji'],
                                    'diqu' => $WULIU['diqu'],
                                 'shouhuo' => $WULIU['beizhu'],
                               'fakuaidi'  => 1,
                               'fakuaima'  => $hbjine,
                                   'tehui' => $tehui,
                                   'level' => $LEVE,
                                   'lailu' => lailu(),
                                      'ip' => ip(),
                                  'kuaixq' => $kuaixq

            ));




     if($hongid > 0){

            if($hongjine == $HBSEYU && $HBSEYU  > 0)
                $sql.=$DB ->setbiao('hongbao')->where( array( 'id'=> $hongid ) )->update( array( 'shengyujine'=>'0','stime' => $TIME ,'off' => 1 ) ); 

            else   $sql.=$DB ->setbiao('hongbao')->where( array( 'id'=> $hongid ) )->update( array( 'shengyujine -'=>$hongjine,'stime' => $TIME ) ); 
        }


    


        $fanhui = $DB ->qurey( $sql , 'shiwu');

        if( $fanhui  ){

            $SHUJU = array( 'orderid' => $wyiid );
            $CODE  = 2;
          

            $YZTOKEN  = wenyiyz( 'ding/'.$USERID , '' , $Mem );
        
        
        }else   exit( json_encode( apptongxin( array()  ,'415', '1' , '订单插入失败'  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );






    //if( ! wenyiyz( 'ding/'.$USERID, $TOKEN    , $Mem , 2 ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );


    
    




}

$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG , $YZTOKEN );