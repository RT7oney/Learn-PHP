<?php //

$PLUScoucc = 'coucc';

class coucc{

        function __construct($servers){

                   $this->md= new Couchbase($servers['0'],$servers['1'],$servers['2'],$servers['3']);
        }


        public function s( $key, $value, $time=0){ 
         
               return $this -> md -> set($key, $value,$time);
        }


        public function g( $key){ 
            
               return $this -> md -> get( $key);
        }


        public function f($kss=''){ 

               return $this -> md -> flush();
        }


        public function j( $key, $num=1, $time=0){

                $shuju = $this -> g( $key );
                if( ! $shuju ) $shuju = 0;
                $shuju -= $num;
                $this -> s( $key , (float)$shuju , $time );
                return $shuju;
        }


        public function ja( $key, $num=1,$time=0){

                $shuju = $this -> g( $key );
                if( ! $shuju ) $shuju = $num;
                else           $shuju += $num;
                $this -> s( $key , (float)$shuju , $time );
                return $shuju;

        }


        public function d( $key){  

               return $this -> md -> delete($key); 
        }


}