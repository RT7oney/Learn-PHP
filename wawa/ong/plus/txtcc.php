<?php //

$PLUStxtcc = 'txtcc';

class txtcc{

    var $DB=null; 

    function __construct( $data = ''){

            if( $data == '') $this-> DB = Txpath;
            else $this -> DB = $data;
    }


    public function ja( $key, $num = 1, $time = ''){ 

           $pat = $this -> DB .str_replace( '../', '', $key).'.php';
           jianli( $pat );
           if( file_exists( $pat))$value = include $pat;
           else  $value =  0;

           $value = (float)($value * 1 + $num);
           x($pat , $value, $time);
           return $value;
    }


    public function j( $key , $num = 1, $time = ''){ 

           $pat = $this -> DB .str_replace( '../', '', $key).'.php';

           jianli( $pat );

           if( file_exists( $pat))$value = include $pat;
           else  $value =  0;

           $value = (float)($value * 1 - $num);
           x( $pat , $value, $time);
           return $value;
    }


    public function g( $key){ 

            $pat = $this -> DB .str_replace( '../', '', $key).'.php';
            if( file_exists( $pat)){

               $kkk = include $pat;

                if( $kkk != ''){
                   
                    if( isset( $time)){

                        clearstatcache();
                        $guoqitime = filemtime($pat)+$time; 
                        $dangqtime = time();
                       
                        if( $dangqtime > $guoqitime){
                            @unlink($pat);
                            return false;
                        }else return  $kkk;
                   
                    }else return $kkk;

                }else return true;

            }else return false;

    }


    public function d( $key){ 

            $pat = $this -> DB .str_replace( '../', '', $key).'.php';

            if( file_exists( $pat)){
                @unlink( $pat);
                return true;
            }else return false;
    }


    public function f( $key = ''){

           if($key == '')  $key = $this -> DB;
           return shanchu( $key );
    }


    public function s( $key , $value , $time = ''){ 

            $pat = $this -> DB . str_replace( '../', '', $key).'.php';
            jianli( $pat);
            if(! $value ) $value = '0';
            if( $value != ''){
               if( ! is_array( $value)) $value = "'". zifuzhuan( $value )."'";
            }

            x( $pat , $value , $time );
            return $value;
    }


}