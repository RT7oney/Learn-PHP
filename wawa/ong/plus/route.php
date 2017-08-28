<?php //

$PLUSroute = 'route';

/* $HTTP 分解说明
0  分解   前缀
1  $CHAID id 查询的id
2  $PAGE  分页页码
3  $CHENGSHI 城市id
*/
function route_cptype( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                      /*产品列表*/
                       $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                       $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                       $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );


                      $D = db('chanpintype');
                      $DATA = $D ->where(array( 'id' => $CHAID , 'off' => 2 ))-> find();

                      if( $DATA || $CHAID == '0' ){

                            if( $DATA['http'] !=''){
                            
                                 header('HTTP/1.1 301 Moved Permanently');
                                 header("Location: ".$DATA['http']);
                                 exit();
                            }
                              
                            $NTPL = QTPL. anquanqu( $DATA['liebiaomb']== ''? $CONN['route_cptypem']: $DATA['liebiaomb']). '.php';

                            if( file_exists( $NTPL))
                                     include $NTPL;
                            else   error404( $LANG['mobanno'].$NTPL, 1);

                      }else        error404( $LANG['leirongno'], 1);
}

function route_cpcenr( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                      /*产品内容*/
                      $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                      $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                      $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

                      $D = db('chanpin');
                      $DATA = $D ->where(array( 'id' => $CHAID ))-> find();

                      if( $DATA && ( $DATA['off'] == 0 || $DATA['off'] == 2 ) ){

                            if( $DATA['http'] !=''){
                            
                                 header('HTTP/1.1 301 Moved Permanently');
                                 header("Location: ".$DATA['http']);
                                 exit();
                            }
                       
                             
                            if( $DATA['type'] > 0){

                               
                                $SDATA = $D -> setbiao('chanpintype') ->where(array( 'id' => $DATA['type'] , 'off' => 2 ))-> find();

                            }

                            if( $DATA['zhiding'] != '')
                                  $NTPL = QTPL. anquanqu( $DATA['zhiding'] ). '.php'; 
                            else  $NTPL = QTPL. anquanqu( ( !isset( $SDATA) || isset( $SDATA) && $SDATA['neirongmb'] == '')? $CONN['route_cpcenrm']: $SDATA['neirongmb']). '.php';
    
                            if( file_exists( $NTPL)  )
                                     include $NTPL;
                            else   error404( $LANG['mobanno'].$NTPL, 1);

                      }else        error404( $LANG['leirongno'], 1);
}

function route_type( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                    /*分类列表*/
                    $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                    $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                    $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

                    $D = db('xitongtype');
                    $DATA = $D ->where(array( 'id' => $CHAID , 'off' => 2 ))-> find();

                    if( $DATA || $CHAID == '0'){

                        if( $DATA['http'] !=''){
                        
                             header('HTTP/1.1 301 Moved Permanently');
                             header("Location: ".$DATA['http']);
                             exit();
                        }
                    
                       if( $DATA['leixing'] == 1) 
                            $NTPL  = QTPL. anquanqu( $DATA['liebiaomb']== ''? $CONN['route_typem']: $DATA['liebiaomb']). '.php';
                       else $NTPL  = QTPL. anquanqu( $DATA['neirongmb']== ''? $CONN['route_cenrm']: $DATA['neirongmb']). '.php';

                       if( file_exists( $NTPL))
                                include $NTPL;
                       else   error404( $LANG['mobanno'].$NTPL, 1);
                       
                    }else     error404( $LANG['leirongno'], 1);
}

function route_cenr( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                    /*分类内容*/

                    $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                    $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                    $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );
                   

                    $D = db('xitongneirong');
                    $DATA = $D ->where(array( 'id' => $CHAID , 'off' => 2 ))-> find();
                      

                    if($DATA){
                         

                        if( $DATA['http'] !=''){
                        
                             header('HTTP/1.1 301 Moved Permanently');
                             header("Location: ".$DATA['http']);
                             exit();
                        }
                        
                        if( $DATA['type'] > 0){

                           
                            $SDATA = $D -> setbiao('xitongtype') ->where(array( 'id' => $DATA['type'] , 'off' => 2 ))-> find();

                            if( ! $SDATA) return error404( $LANG['leirongno'], 1);
                        }

                        if( $DATA['zhiding'] != '')
                             $NTPL = QTPL. anquanqu( $DATA['zhiding'] ). '.php'; 
                        else $NTPL = QTPL. anquanqu( ( !isset( $SDATA) || isset( $SDATA) && $SDATA['neirongmb'] == '')? $CONN['route_cenrm']: $SDATA['neirongmb']). '.php';


                       
    
                        if( file_exists( $NTPL))
                                 include $NTPL;
                        else   error404( $LANG['mobanno'].$NTPL, 1);

                    }else      error404( $LANG['leirongno'], 1);
}

function route_shangjia( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                        /*商家主页 列表读取*/
                        $D = db('shangxinxi');

                        $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                        $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                        $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

                        if( $CHAID  > 0 ){
                        
                            $DATA =  $D ->where( array( 'sid' => $CHAID , 'off' => 2  ))-> find();

                            if( $DATA ){

                                $NTPL = QTPL .'shangjia/'.anquanqu( $DATA['moban'] == '' ? $CONN['route_shangjiam'] : $DATA['moban']). '/index.php';
                                
                                if( file_exists( $NTPL ))
                                         include $NTPL;
                                else   error404( $LANG['mobanno'].$NTPL, 1);

                             }else  error404( $LANG['shangjino'], 1);

                        }else{
                            
                            $NTPL = QTPL . anquanqu( $CONN['route_shangjialm'] ). '.php'; 

                            if( file_exists( $NTPL ))
                                     include $NTPL;
                            else   error404( $LANG['mobanno'].$NTPL, 1);
                        }
}

function route_satype( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                        /*商家自定义列表*/

                        $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                        $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                        $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

                        $D = db('shangtype');

                        $DATA = $D -> where( array( 'id' => $CHAID , 'off' => 2 ))-> find();

                        if( $DATA ){

                            if( $DATA['http'] !=''){
                            
                                 header('HTTP/1.1 301 Moved Permanently');
                                 header("Location: ".$DATA['http']);
                                 exit();
                            }
                            
                           $MOREN = anquanqu( $CONN['route_shangjiam']);

                           if( $DATA['sid'] > 0){

                               

                                $SDATA =  $D -> setbiao('shangxinxi') ->where( array( 'sid' => $DATA['sid'] , 'off' => 2  ))-> find();

                                if( $SDATA ){

                                    if( $SDATA['moban'] != '' ) $MOREN = anquanqu( $SDATA['moban'] );
                
                                }else return error404( $LANG['shangjino'], 1);

                           }
                        
                           if( $DATA['leixing'] == 1) 
                                $NTPL  = QTPL . $MOREN.'/'. anquanqu( $DATA['liebiaomb']== ''? $CONN['route_satypem']: $DATA['liebiaomb']). '.php';
                           else $NTPL  = QTPL . $MOREN.'/'. anquanqu( $DATA['neirongmb']== ''? $CONN['route_sacenrm']: $DATA['neirongmb']). '.php';

                           if( file_exists( $NTPL))
                                    include $NTPL;
                           else   error404( $LANG['mobanno'].$NTPL, 1);

                        }else     error404( $LANG['leirongno'], 1);
}

function route_sacenr( $HTTP,$LANG,$CONN,$Mem,$Memsession,$FUJIAN){

                      /*商家自定义内容*/
                      $CHAID = (float) ( isset( $HTTP['1'])? $HTTP['1'] : 0 );
                      $PAGE  = (float) ( isset( $HTTP['2'])? $HTTP['2'] : 0 );
                      $CHENGSHI = (float) ( isset( $HTTP['3'])? $HTTP['3'] : 0 );

                      $D = db('shangneirong');

                      $DATA = $D -> where( array( 'id' => $CHAID , 'off' => 2  ))-> find();

                      if( $DATA ){

                          if( $DATA['http'] !=''){
                            
                                 header('HTTP/1.1 301 Moved Permanently');
                                 header("Location: ".$DATA['http']);
                                 exit();
                         }
                            
                           $MOREN = anquanqu( $CONN['route_shangjiam']);

                           if( $DATA['sid'] > 0){

                                

                                $SDATA =  $D -> setbiao('shangxinxi') ->where( array( 'sid' => $DATA['sid'] , 'off' => 2  ))-> find();

                                if( $SDATA ){

                                    if( $SDATA['moban'] != '' ) $MOREN = anquanqu( $SDATA['moban'] );
                
                                }else return error404( $LANG['shangjino'], 1);

                           }

                           if( $DATA['type']){


                                $SSDATA = $D -> setbiao('shangtype') ->where( array( 'id' => $DATA['type'] , 'off' => 2  ))-> find();

                                if( !$SSDATA )return error404( $LANG['leirongno'], 1);

                           }

                           if( $DATA['zhiding'] != '')
                                $NTPL = QTPL . $MOREN .'/'. anquanqu( $DATA['zhiding'] ). '.php'; 
                           else $NTPL = QTPL . $MOREN .'/'. anquanqu( ( !isset( $SSDATA) || isset( $SSDATA) && $SSDATA['neirongmb'] == '')? $CONN['route_sacenrm']: $SSDATA['neirongmb']). '.php';
    
                           if( file_exists( $NTPL))
                                    include $NTPL;
                           else   error404( $LANG['mobanno'].$NTPL, 1);

                      }else error404( $LANG['leirongno'], 1);
}