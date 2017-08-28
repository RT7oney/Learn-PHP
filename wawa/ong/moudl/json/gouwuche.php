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



if( $USERID > 0 )
     $GWC  = $Mem -> g( 'gouwuche/'. $USERID );
else $GWC  = isset( $_SESSION['gouwuche'] ) ? $_SESSION['gouwuche']: array() ;

if( ! is_array( $GWC ) ) $GWC = array();


usleep( rand( 5000 , 50000 ));

if( $MOD == 'get' ){

    /*读取数据*/


}else if( $MOD == 'post' ){

    /*新增数据*/
    

    $CPID = ( int )( isset($_POST['cpid']) ? $_POST['cpid']: 0 );
    $NUM  = ( int )( isset($_POST['num'] ) ? $_POST['num'] : 1 );
    $CSU  = isset( $_POST['cansu'] ) ? trim( $_POST['cansu'] ) : '';



    if( ! (mb_detect_encoding($CSU, 'UTF-8') === 'UTF-8')   ){ 

        $CSU = iconv( "gb2312" , "UTF-8//IGNORE" ,$CSU );
    
    }

    if( $CPID < 1 )exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法产品id' ) ) );
    if( $NUM  < 1 )exit( json_encode( apptongxin( array()  ,'415', '-1' , '购买数量错误' ) ) );
   

    $shuju = danye( $CPID , '' , '1' );

    if( $shuju ){

        if( $shuju['off'] != 2 ) exit( json_encode( apptongxin( array( )  ,'415', '-1' , '产品关闭' ) ) );

        if( $shuju['canshu'] != '') $shuju['canshu'] = unserialize( $shuju['canshu'] );

        $JIAGE = isset( $shuju['canshu']['jiage'] ) ? $shuju['canshu']['jiage'] : array() ;

        $jiage = $shuju['jiage'];


        if( $CSU == '' ) $CSU = key($JIAGE);

        if(isset( $JIAGE[ $CSU ]) )  $jiage = (float)$JIAGE[ $CSU ];
        else{

            $CSU = '';
        }

        if($jiage < 0 ) exit( json_encode( apptongxin( array( )  ,'415', '-1' , str_replace('_',' ',$CSU) .' 缺货 ') ) );


        $ZUHE = md5( $CPID.$CSU );
        $CPNUM = array();
        $zs = 0;
        if( $GWC ){

            foreach($GWC as $ZGC ){
                $zs += count( $ZGC );
            }
        }

        if($zs >= 30) exit( json_encode( apptongxin( array( )  ,'415', '-1' , '购物车已满,请先购买一波' ) ) );

        

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


            if( $jiage < 0.001 ) {

                $shuju['xgtype']  = 2;
                if($shuju['xiangou'] < 1 || $CONN['xiangou0'] == 1 ) $shuju['xiangou'] = 1 ;

                $shuju['xgdata'] = $shuju['xiangou'];

                $CPNUM[$shuju['id']] =   isset( $GWC[$shuju['shid']][$ZUHE]['num'] ) ? $GWC[$shuju['shid']][$ZUHE]['num'] : 0 ;

            }

            $XGTYPE = logac('xgtype');

            if( ! isset( $CPNUM[$shuju['id']] )) $CPNUM[$shuju['id']] = 0;

            if( $CPNUM[$shuju['id']] >= $shuju['xiangou'] ) exit( json_encode( apptongxin( array( )  ,'415', '-1' , $XGTYPE[$shuju['xgtype']].$shuju['xgdata'].' 超过数量 '.$shuju['xiangou'] ) ) );

            

            $yigou = xiangou( $USERID  , $shuju );
            $zuida = $shuju['xiangou'] - $yigou - $CPNUM[$shuju['id']];

            if( $zuida <= 0 )exit( json_encode( apptongxin( array( )  ,'415', '-1' , $XGTYPE[$shuju['xgtype']].$shuju['xgdata'].' 超过数量 '.$shuju['xiangou'] ) ) );

            if( $NUM > $zuida ){ 

                $GWC[$shuju['shid']][$ZUHE]['num'] = 0;
                $NUM = $zuida;
            }
        }


        if( isset( $GWC[$shuju['shid']][$ZUHE] )){

                $GWC[$shuju['shid']][$ZUHE] =   array( 'cpid' => $shuju['id'] , 
                                                     'canshu' => $CSU , 
                                                      'jiage' => $jiage , 
                                                        'num' => $GWC[$shuju['shid']][$ZUHE]['num']+ $NUM,
                                                       'name' => $shuju['name'],
                                                     'tupian' => pichttp( $shuju['tupian'] ),
                                                       'link' => $shuju['link'],
                                                      'huobi' => $shuju['huobi'],
                                                       'type' => $shuju['type'] ,
                                                     'beizhu' => $shuju['beizhu'],
                                                      'yunid' => $shuju['yunid'],
                                                   'jinzhong' => $shuju['jinzhong'],

                                                );


        }else{   
                $GWC[$shuju['shid']][$ZUHE] =   array(   'cpid' => $shuju['id'] ,
                                                       'canshu' => $CSU , 
                                                        'jiage' => $jiage ,
                                                          'num' => $NUM ,
                                                         'name' => $shuju['name'],
                                                       'tupian' => pichttp( $shuju['tupian'] ),
                                                         'link' => $shuju['link'],
                                                        'huobi' => $shuju['huobi'],
                                                         'type' => $shuju['type'],
                                                       'beizhu' => $shuju['beizhu'],
                                                        'yunid' => $shuju['yunid'],
                                                     'jinzhong' => $shuju['jinzhong'],
                                                );
        }

      

        if( $USERID > 0 )
            $Mem -> s( 'gouwuche/'. $USERID ,$GWC);
        else
            $_SESSION['gouwuche'] = $GWC;

    }else exit( json_encode( apptongxin( array( )  ,'415', '-1' , '没有产品' ) ) );


}else if( $MOD == 'put' ){

    /*修改数据*/

    $CSU  = isset( $_POST['cansu'] ) ? trim( $_POST['cansu'] ) : '';
    $NUM  = ( int )( isset($_POST['num'] ) ? $_POST['num'] : 1 ) ;

    if( $NUM  < 1 )exit( json_encode( apptongxin( array()  ,'415', '-1' , '购买数量错误' ) ) );

    $CG = false;

    if( $GWC ){

       

        foreach($GWC as $DK => $DV ){

            if( $DV ){


                if( isset( $DV [$CSU ])){

                    $shuju = danye( $DV[ $CSU ]['cpid'] , '' , '1' );

                    $CPNUM = array();

                    $jiage = $DV[ $CSU ]['jiage'];

                    if( $jiage < 0 ){

                        unset( $GWC[$DK][$CSU] );

                        if( !$GWC ) $GWC = array();

                        if( $USERID > 0 )
                            $Mem -> s( 'gouwuche/'. $USERID ,$GWC);
                        else
                            $_SESSION['gouwuche'] = $GWC;

                        
                        exit( json_encode( apptongxin( array( )  ,'415', '-1' , str_replace('_',' ',$CSU) .' 缺货 ') ) );

                    }

                    if( $jiage < 0.001 ) {

                        $shuju['xgtype']  = 2;

                        if( $shuju['xiangou'] < 1 || $CONN['xiangou0'] == 1 ) $shuju['xiangou']= 1;

                        $shuju['xgdata'] = $shuju['xiangou'];

                        $CPNUM[$shuju['id']]=  $GWC[$DK][ $CSU ]['num'];

                    }

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

                        $XGTYPE = logac('xgtype');

                        if( ! isset( $CPNUM[$shuju['id']] )) $CPNUM[$shuju['id']] = 0;

                        if( $CPNUM[$shuju['id']] >= $shuju['xiangou'] && $shuju['xiangou'] > 0  &&   $NUM >= $GWC[$DK][ $CSU ]['num'] )
                        exit( json_encode( apptongxin( array( )  ,'415', '-1' , $XGTYPE[$shuju['xgtype']].$shuju['xgdata'].' 超过数量 '.$shuju['xiangou'] ) ) );

                        $yigou = xiangou( $USERID  , $shuju );
                        $zuida = $shuju['xiangou'] - $yigou - $CPNUM[$shuju['id']] + $GWC[$DK][ $CSU ]['num'];

                        if( $zuida <= 0 )exit( json_encode( apptongxin( array( )  ,'415', '-1' , $XGTYPE[$shuju['xgtype']].$shuju['xgdata'].' 超过数量 '.$shuju['xiangou'] ) ) );

                        if( $NUM > $zuida ){

                        $GWC[$DK][ $CSU ]['num'] = 0;
                        $NUM = $zuida ;
                        }

                    }


                     $GWC[$DK][ $CSU ]['num'] = $NUM;

                     $CG = true;
                     break;

                }

            }
        }

           
          
                
    }

    if( !$CG ) exit( json_encode( apptongxin( array( )  ,'304', '-1' , '') ) );

    if( !$GWC ) $GWC = array();

    if( $USERID > 0 )
        $Mem -> s( 'gouwuche/'. $USERID ,$GWC);
    else
        $_SESSION['gouwuche'] = $GWC;

   



}else if( $MOD == 'delete' ){


    /*删除数据*/

    $CSU  = isset( $_POST['cansu'] ) ? trim( $_POST['cansu'] ) : '';



    $CG = false;



    if( $GWC ){



        foreach($GWC as $DK => $DV ){

            if( $DV ){



                if( isset( $DV[ $CSU ] ) ){

                    unset( $GWC[$DK][$CSU] );
                    $CG = true;
                    if(!$GWC[$DK])unset($GWC[$DK]);
                    break;
                }
            }
        }
    }




    if( !$CG ) exit( json_encode( apptongxin( array( )  ,'410', '-1' , '') ) );

    if( !$GWC ) $GWC = array();

    if( $USERID > 0 )
        $Mem -> s( 'gouwuche/'. $USERID ,$GWC);
    else
        $_SESSION['gouwuche'] = $GWC;
    
}

    $lang = 0;

    foreach($GWC as $k => $v){


        if( is_array( $v ) ){

            $lang +=count($v);
        }
    
    }

    $ONLIYGWC = isset( $_POST['zgw'] ) ? false : true ;

    $SHUJU = array(  'data' => $ONLIYGWC ? $GWC : array(),
                    'count' => $lang
    
    );

$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG );