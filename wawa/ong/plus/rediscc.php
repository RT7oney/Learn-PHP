<?php //

$PLUSrediscc = 'rediscc';

class rediscc{

    var $DB = null ;


    function __construct( $data = array( 0 ,'127.0.0.1','6379', 0 ,'') ){

            $redis = new Redis();

            if( !isset( $data['0'] ) ) $data['0'] = 0;
            if( !isset( $data['1'] ) ) $data['1'] = '127.0.0.1';
            if( !isset( $data['2'] ) ) $data['2'] = '6379';
            if( !isset( $data['3'] ) ) $data['3'] = '0';
            if( !isset( $data['4'] ) ) $data['4'] = '';

            $my = $redis -> connect( $data['1'], $data['2'] , $data['3']);

            if( $my ){

                $redis -> select( (float) $data['0'] );
                if( $data['4'] != '' ) $redis-> auth( $data['4'] );

                $redis-> setOption( Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP ); 
                $this -> DB = $redis;

            }else   $this -> DB = false;

    }


    public function ja( $key, $num = 1, $time = '0'){

        if( ! $this -> DB ) return false;

        $shuju = (float)$this -> g( $key );
        if( ! $shuju ) $shuju = $num;
        else          $shuju += $num;

        if($time > 0)
                $this -> s( $key , (float)$shuju , $time );
        else    $this -> s( $key , (float)$shuju );
        return  $shuju;

    }


    public function j( $key , $num = 1, $time = '0'){

        if( ! $this -> DB )return false;

        $shuju = (float)$this -> g( $key );
        if( ! $shuju ) $shuju = 0;
        $shuju -= $num;

        if($time > 0)
                $this -> s( $key , (float)$shuju , $time );
        else    $this -> s( $key , (float)$shuju );

        return  $shuju;

    }


    public function g( $key ){

        if( ! $this -> DB )return false;
        return $this -> DB -> get( $key );

    }


    public function d( $key ){

        if( ! $this -> DB )return false;
        return $this -> DB -> delete( $key );

    }


    public function f( $key = '' ){

        if( ! $this -> DB ) return false;
        return $this -> DB -> flushAll();

    }


    public function s( $key , $value , $time = '0' ){

        if( ! $this -> DB ) return false;
        if( $time > 0 )
                return $this -> DB -> setex ( $key , $time , $value  );
        else    return $this -> DB -> set( $key , $value  );

    }


}