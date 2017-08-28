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

    $PAGE = (int)( isset( $_POST['page'] ) ? $_POST['page'] : 1 );
    $NUM  = (int)( isset( $_POST['num']  ) ? $_POST['num']  : 8 );
    $CPID = (int)( isset( $_POST['cpid'] ) ? $_POST['cpid'] : 1 );

    if( $PAGE < 1) $PAGE = 1;

    if( $NUM < 8 ) $NUM = 8;
    if( $NUM > 88) $NUM = 88;

  

    $DATAS = neirlist( $TJ = array( 'cid'=> xjcid($CPID)  ,'page' => $PAGE,'num'=> $NUM,'total'=>1) , 'center' , '' ); 
                
    if( $DATAS['date'] ){

        foreach( $DATAS['date'] as $ong ){

                if($ong['canshu'] !='') $ong['canshu'] = unserialize( $ong['canshu'] );
                else $ong['canshu'] =  array();

                $shuju = isset( $ong['canshu']['shuju'] ) ? reset( $ong['canshu']['shuju'] ) : array();
                $jiage = isset( $ong['canshu']['jiage'] ) ? (float)reset( $ong['canshu']['jiage'] ) : $ong['jiage'] ;

                $SHUJU[] = array(
                            'link' => $ong['link'] ,
                            'name' => $ong['name'] ,
                          'tupian' => pichttp($ong['tupian']) ,
                              'id' => $ong['id'],
                          'huobi'  => $HUOBIICO[$ong['huobi']],
                          'canshu' => $ong['canshu']  ? $shuju['name'].'：'.$shuju['0']['canshu']:'',
                           'jiage' => $jiage <=0? $ong['jiage']: $jiage,
                        );


        }


        $CODE = 1;

    }else $CODE = -1;




}else if( $MOD == 'post' ){
    /*新增数据*/


}else if( $MOD == 'put' ){
    /*修改数据*/

}else if( $MOD == 'delete' ){
    /*删除数据*/

}


$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG );