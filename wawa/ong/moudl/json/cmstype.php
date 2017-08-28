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

if( $MOD == 'get' ){

    /*读取数据*/

    $ID = (int)( isset( $_POST['id'] ) ? $_POST['id'] : 0 );

    if( $ID  > 0 ){

        $D = db('type');

        $SHUJU = $D -> where ( array( 'id' => $ID ) )-> find ();

        if( $SHUJU ){

            if( $SHUJU['off'] == 2 ){

                $SHUJU['link'] = mourl( $SHUJU['url'] , $SHUJU['http'] );

                if( $SHUJU['tupian'] != '' ) $SHUJU['tupian'] = pichttp( $SHUJU['tupian'] );

                if( $SHUJU['tupianji'] != '' ){

                    $PICT = unserialize( $SHUJU['tupianji'] );
                    $SHUJU['tupianji'] = array();

                    foreach( $PICT as $ONG ){
                        $SHUJU['tupianji'][] = pichttp( $ONG );
                    }
                }

                $SHUJU['neirongpic'] = array();

                if( $SHUJU['kuozanform'] != '' ){
                
                    $KUOZAN = unserialize( $SHUJU['kuozanform'] );
                    $KUOZHI = unserialize( $SHUJU['kuozan'] );

                    if( !$KUOZHI ) $KUOZHI = array();

                    $SHUJU['kuozan'] = array();

                    if( $KUOZAN ){

                        $ii = 0;

                        foreach($KUOZAN as   $ONGG){

                            if( $ONGG['扩展标题'] == '' ){

                                $ii++;
                                continue;
                            }
                            
                            $SHUJU['kuozan'][] = array( 
                                                   'name' => $ONGG['扩展标题'],
                                                  'value' => isset($KUOZHI[$ii]) ? $KUOZHI[$ii] : ''
                                                );
                            $ii++;
                        }
                    }

                }

                unset( $SHUJU['kuozanform'] );

                if( $SHUJU['neirong'] != '' ){

                    if( $fan = strpos( $SHUJU['neirong'] , 'img') || strpos( $SHUJU['neirong'] , 'IMG')   ){

                        $neirongimg = fenjieimg( $SHUJU['neirong'] );

                        if( $neirongimg && $neirongimg['bbao'] ){

                            $tihuan = array();

                            foreach( $neirongimg['bbao'] as $img ){

                                $img = trim( $img  ,'"');

                                if( $img == '' ) continue;

                                $tuhahs = 'a'. md5($img);

                                if( !isset( $tihuan[$tuhahs] ) )
                                    $SHUJU['neirong'] = str_replace( $img ,  pichttp( $img ) , $SHUJU['neirong'] );

                                $tihuan[$tuhahs]  = 1;
                                $SHUJU['neirongpic'][] =  pichttp( $img ) ;
                            }
                        }
                    }
                }

            }else{

                $SHUJU = array();
                $STAT = 404;
                $CODE = -1;
            }

        }else{ 

            $STAT = 415;
            $CODE = -1;
        }

    }else{ 

        $STAT = 415;
        $CODE = -1;
    }

}else if( $MOD == 'post' ){
    /*新增数据*/


}else if( $MOD == 'put' ){
    /*修改数据*/

}else if( $MOD == 'delete' ){
    /*删除数据*/

}


$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG );