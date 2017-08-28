<?php //

$PLUSmysqlcc = 'mysqlcc';

class mysqlcc{

    function __construct( $CC = '', $zhiding = '', $dbname = 'memcached' ){

        global $Mem , $DBCO;

        if( $Mem == '' ) $Mem = new txtcc;


        if( $zhiding == '' ) $zhiding = $DBCO;

        if( $CC == '' ) $CC  = db( $dbname , $zhiding );
        else  $CC -> setbiao( $dbname );

        $this -> mysql = $CC -> setshiwu('0');
        return $this -> mysql;



    }


    public function s( $key, $value, $time = 0){

        if( $time > 0) $time = time()+ $time;

        $fan = $this -> mysql -> insert( array( 'name' => $key ,'keval' => serialize($value),'atime' => $time ));
        if( !$fan )$this-> mysql -> where( array('name' => $key ) )-> update(array( 'keval' => serialize($value),'atime' => $time) );
        return true;

          
    }


    public function g( $key){

        $data = $this -> mysql -> where( array( 'name' => $key ) )-> find();

        if( $data ){

            if( $data['atime'] > 0 ){

                if( $data['atime'] < time() ){
                
                    $this -> d( $key );
                    return false;

                }
            }

            return unserialize($data['keval']);

        }else return false;
    }


    public function d( $key){

        return $this-> mysql -> delete( $key );
    }


    public function f(){ 

        return $this-> mysql -> delete( );

    }


    public function j( $key, $num=1,$time = 0){

                $shuju = (float)$this -> g( $key );
                if( ! $shuju ) $shuju = 0;
                $shuju -= $num;
                $this -> s( $key , $shuju , $time );
                return $shuju;
    }


    public function ja( $key, $num = 1 , $time = 0){

                $shuju = (float)$this -> g( $key );
                if( ! $shuju ) $shuju = $num;
                else           $shuju += $num;
                $this -> s( $key , $shuju , $time );
                return $shuju;
    }


}