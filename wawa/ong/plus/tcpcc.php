<?php //
$PLUStcpcc = 'tcpcc';
class tcpcc{

    var $data = false ;

    function __construct($servers){
          
            if(!$this->data){

               if (! (  $this->data = socket_create( AF_INET,  SOCK_STREAM , SOL_TCP))){
            
                   return false;
           
                }else socket_connect($this->data, $servers['0'], $servers['1']);
           }
    }

    public function fass( $leix , $key = '', $value = '', $time = 0){ 

                    $ykey = $key;
                    $nerong = serialize( $value);
                    $key = md5( $key);
                    $wode =  strlen( $nerong);

                    if( $leix == 'add' || $leix == 'set'){

                        $wodz = intval( $key, 10);

                        $wodz = $wodz % 30;
                          
                        $array = "set $key $wodz $time $wode\r\n";
                        $length = strlen($array);

                        $sent = socket_write( $this -> data , $array , $length);

                        $nerong .= "\r\n";

                        $nron = strlen( $nerong);

                        $accept = socket_write( $this -> data, $nerong , $nron);
            
                        $accept = socket_read( $this -> data , 80);
                        
                        if( trim( $accept) == 'STORED' && $nron < 1025) return true;
                        else return false;

                     }else if( $leix == 'delete'){

                        $array = "delete $key\r\n";
                        $length = strlen( $array);
                        $sent = socket_write( $this -> data ,$array ,$length);
                        $accept = socket_read($this -> data , 100);

                        if(trim( $accept) == 'END') return false;
                        else if(trim($accept) == 'NOT_FOUND') return false;
                        else if(trim($accept) == 'DELETED') return true;
                        else return false;

                     }else if( $leix == 'get'){

                        $array = "get $key\r\n";
                        $length = strlen( $array);
                        $sent = socket_write( $this -> data,$array,$length);

                        $accept = socket_read($this -> data, 9000);

                        
                          
                        if( trim( $accept) == 'END')return false;
                        else if( trim( $accept) == 'NOT_FOUND')return false;
                        else{
                        
                            $fan =  explode( chr(13), str_replace( array( "\r\n" , "\n", "\r"),chr(13),$accept));
                            $zif = explode(' ', $fan['0']);

                           
   
                            if( (float)( $zif['3'] ) == strlen( $fan['1'] )){

                                if( strpos( $fan['1']  ,':') !== false)
                                     return  unserialize( $fan['1']);
                                else return $fan['1'];

                            }else return false;

                        
                            
                        }

                    }else if( $leix == 'flush_all'){
                           
                        $array = "flush_all\r\n";
                        $length = strlen($array);
                        $sent = socket_write( $this -> data,$array,$length);
                        $accept = socket_read( $this -> data , 100);
                        if( trim( $accept) == 'END')return false;
                        else if( trim( $accept) == 'NOT_FOUND')return false;
                        else if( trim( $accept) == 'OK')return true;
                        else return false;

                    }else if( $leix == 'incr'){

                        $num = (float)$value;
                        $shuju = $this ->g( $ykey );
                        if( ! $shuju ) $shuju = $num;
                        else           $shuju += $num;
                        $this -> s( $ykey , (float)$shuju , $time );
                        return $shuju;

                    
                    }else if( $leix == 'decr'){

                        $num = (float) $value;
                        $shuju = $this ->g( $ykey );
                        if( ! $shuju ) $shuju = 0;
                        $shuju -= $num;
                        $this -> s( $ykey , (float)$shuju , $time );
                        return $shuju;

                    }

    }


    public function s( $key , $value , $time = 0){  

           return  $this -> fass('set', $key , $value , $time );
    }


    public function g( $key ){  

           return  $this -> fass( 'get', $key);
    }



    public function d( $key ){  
           
           return  $this -> fass( 'delete', $key);
    }


    public function f(){ 

           return  $this -> fass( 'flush_all' );
    }
    

    public function j( $key, $num = 1, $time = 0){ 
            
            return  $this -> fass('decr', $key , (float)$num , $time);
    }


    public function ja( $key, $num = 1 ,$time = 0){

           return  $this -> fass( 'incr' , $key , (float)$num , $time );
    }


}
