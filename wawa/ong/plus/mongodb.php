<?php //

$PLUSmongodb = 'mongodb';

class mongodb{

       var $data = false ;
       var $table = 'db.txtcc';
       var $db = '';
       var $fenjies = 1;
       var $tablejg = array();
       var $paixu =null;
       var $lismt =null;
       var $ktpyp =null;
       var $sql=null; 
       var $where=null;


public function __construct($servers,$table='db.txtcc',$fenjies = 1){
           
           if( ini_get( 'mongodb.debug' ) === false ) return false;
           if( ! $this -> data) $this -> data = new MongoDB\Driver\Manager( $servers);
           $this -> fenjies = $fenjies;
           if($table) $this -> table = $table;
           else       $this -> table = 'db.txtcc';
           return $this;
}


public function fenjie($table,$ykey=''){

           if( $this -> fenjies == 1 && strpos( $ykey , '/') !== false ){

               $hash = explode('/',$ykey);
               $this -> table =  'O'. implode( '.' , $hash). 'S';
                         
           }

           return  $this;
}


function db( $data = '' ){
 
       
         return $this->setbiao( $data );
 
}


function order($data=''){

          /*数据排序*/

          if($data != ''){

             $this -> paixu = null ;

             $data =  str_ireplace(array('desc','asc'),array('-1','1'),$data);
             $tdhis = explode(',',trim($data));
             $wode = null;

             foreach($tdhis as $zhi){

                 if($zhi == '')continue;

                     $wo  = explode(' ',$zhi);

                     $wode[trim($wo['0'])] = (int)trim($wo['1']);
             }

             if($wode ) $this -> paixu = $wode;
             else $this -> paixu = false;

          }


          return $this;


}


function  wherezuhe( $data = ''){
    
          $x= null;

          if( is_array( $data ) ){

               $zhsss = count($data);

               if($zhsss < 1)return;

               $XXZ = json_encode( $data );

                foreach($data as $k=>$v){
                    
                    $k = $this->zifuzhuan($k);

                    if( ! is_array( $v)) $v = (string)$this->zifuzhuan($v);

                    if(strstr($k,'>=')){

                        $k= trim(str_replace('>=','',$k));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$gte'=>$v));

                        }else $x[$k]  = array('$gte'=>$v);

                    }else if(strstr($k,'>')){

                        $k= trim(str_replace('>','',$k));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$gt'=>$v));

                        }else  $x[$k]  = array('$gt'=>$v);

                    }else if(strstr($k,'(')){

                        if($v == 'and') $v='and';
                        else            $v ='OR';
                        ;
                    }else if(strstr($k,')')){
                        ;
                    }else if(strstr($k,'<=')){

                        $k= trim(str_replace('<=','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$lte'=>$v));

                        }else $x[$k]  = array('$lte'=>$v);

                    }else if(strstr($k,'<')){

                        $k= trim(str_replace('<','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$lt'=>$v));

                        }else  $x[$k]  = array('$lt'=>$v);

                    }else if(strstr($k,'!=')){

                        $k= trim(str_replace('!=','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$ne'=>$v));

                        }else $x[$k]  = array('$ne'=>$v);

                    }else if(strstr($k,'OLK')){

                        $k= trim(str_replace('OLK','',$k));

                        $x['$or'][]  = array($k => array('$regex'=> $v) );

                    }else if(strstr($k,'LIKE')){

                        $k= trim(str_replace('LIKE','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k =>  array('$regex'=>$v));

                        }else $x[$k]  = array('$regex'=> $v);

                    }else if(strstr($k,'OR')){

                        $k= trim(str_replace('OR','',$k));

                        $x['$or'][]  = array($k => $v);

                    }else if(strstr($k,'IN')){

                        $k= trim(str_replace('IN','',$k));
                        if(is_array($v))  $amen  = array('$in'=>$v);
                        else $amen = array('$in'=> array($v));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array($k => $amen);

                        }else $x[$k]  = $amen;

                    }else if(strstr($k,'DAYD')){

                        $k= trim(str_replace('DAYD','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array('$where' =>"this.$k >= this.$v");

                        }else $x['$where'] ="this.$k >= this.$v";
                        

                    }else if(strstr($k,'DAY')){

                        $k= trim(str_replace('DAY','',$k));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array('$where' =>"this.$k > this.$v");

                        }else $x['$where'] ="this.$k > this.$v";

                    }else if(strstr($k,'XIYD')){

                        $k= trim(str_replace('XIYD','',$k));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array('$where' =>"this.$k <= this.$v");

                        }else $x['$where'] ="this.$k <= this.$v";

                    }else if(strstr($k,'XIY')){

                        $k= trim(str_replace('XIY','',$k));
                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array('$where' =>"this.$k <= this.$v");

                        }else $x['$where'] ="this.$k < this.$v";

                    }else if(strstr($k,'DEY')){

                        $k= trim(str_replace('DEY','',$k));

                        if(strstr($XXZ,'OR') || strstr($XXZ,'OLK')){

                           $x['$or'][]  = array('$where' =>"this.$k = this.$v");

                        }else $x['$where'] ="this.$k = this.$v";

                    }else{ 

                          if(strstr($XXZ,'OR')|| strstr($XXZ,'OLK') ){

                             $x['$or'][]  = array($k => $v);

                          }else $x[$k]  = $v;

                    }

               }

            return $x;
         }else return false;


         


}

function where($data=''){

         $this->where = null;
         if($data !='') $this->where = $this->wherezuhe($data);
         return $this;

}


function pwhere(){

        p($this->where);

        return $this;
}


function limit($data=''){  

         $this -> lismt =null;
         $this -> ktpyp =null;

         if($data!=''){

             $shuju = explode(',',$data);

             if(isset($shuju['1'])) {

                 $meiye = ((int)$shuju['0']/(int)$shuju['1'])+1;
                 $kais =  ((int)$shuju['0']+(int)$shuju['1']-$meiye);
                 $this->lismt = $meiye;
                 if($kais > 0) $this->ktpyp = $kais ;

             }else $this->lismt = (int)$shuju['0'];

         }

         
         return $this;

}


function total($data=''){

        if($data !='') $this->where = $this->wherezuhe($data);

         $filter  = array (  );
         $options = array ();

         if( $this-> tablejg && is_array( $this-> tablejg )){

                $duqu = array();

                foreach($this-> tablejg  as $k => $v){

                      $duqu[$k] = 1;
                }

                $filter  = array ();
                if($this->where) $filter = $this->where;

                $options = array ( 'projection' => $duqu,
                                   
                                    'count' => true
                   
                      
                            );
               
         }

        $query = new MongoDB\Driver\Query( $filter, $options); 
        $cursor = $this -> data -> executeQuery ( $this->table , $query);
        return count( $cursor -> toArray()) ;

}


function qurey($data='',$moth='other'){ 

         return $this;
} 


function query($data='',$moth='other'){ 

         return $this;
}


function update( $data = '' ){


        $bulk = new MongoDB\Driver\BulkWrite;

        if( is_array( $data ) ){

            if( $this-> tablejg && is_array( $this-> tablejg )){
            
                $newshuju = array();

                foreach( $this-> tablejg as $k => $v ){

                         if( isset($data[  $k ])){

                             if( $v == 'weiyi') continue;
                             $newshuju['$set'][$k] = $data[$k];
                         
                         
                        }else if(isset($data[$k.' +']))
                           $newshuju['$inc'][$k] =  (float)$this->zifuzhuan($data[$k.' +']); 
                        else if(isset($data[$k.' -']))
                           $newshuju['$inc'] [$k] =  -(float)$this->zifuzhuan($data[$k.' -']);

                }


                         $olimit = $filter = array();

                        if($this->where) $filter = $this->where;


                             $bulk->update(  $filter ,
                                             $newshuju 
                                          
                             );

                        try {

                             $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
                             $result = $this-> data -> executeBulkWrite ( $this->table , $bulk, $writeConcern);

                             return true;
                        }catch ( MongoDB\Driver\Exception\BulkWriteException $e){ 

                         return false;

                        }


            }




        }else return false;

        

       
         return $this;
}


function delete( $data = '' ){

         if($data !='') $this->where = $this->wherezuhe($data);

         $bulk = new MongoDB\Driver\BulkWrite;

         $olimit = $filter = array();

         if($this->where) $filter = $this->where;

         if( $this -> lismt)  $olimit['limit'] = $this -> lismt;

         $bulk-> delete( $filter, $olimit );

         $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

         try {

           $result = $this-> data -> executeBulkWrite( $this->table , $bulk, $writeConcern);

           return true;

         }catch ( MongoDB\Driver\Exception\BulkWriteException $e){ 

           return false;
                                 
         }


}


function biao(){
         /*读取器表的几个*/



        return $this->table;
}


function insert($data =''){

        /*插入数据库*/

        $bulk = new MongoDB\Driver\BulkWrite;

        if( is_array( $data ) ){

            if( $this-> tablejg && is_array( $this-> tablejg )){

                $newshuju = array();

                foreach( $this-> tablejg as $k => $v ){

                         if( isset($data[  $k ])){

                             if($v == 'weiyi') $newshuju['_id'] = (string)$data[$k];
                             else              $newshuju[$k]    = $data[$k];
                         }
                }

                $bulk -> insert ( $newshuju );

            }else $bulk -> insert ( $data );

         
        }else return false;

        try { 

                $fan = $this -> data -> executeBulkWrite( $this->table , $bulk);
                return true;

        }catch ( MongoDB\Driver\Exception\BulkWriteException  $e){  

                return false;

        }

        
        return  $this;
}


function select ($data=''){


        if($data !='') $this->where = $this->wherezuhe($data);

         /*读取多条数据*/

         $filter  = array (  );
         $options = array ();

         if( $this-> tablejg && is_array( $this-> tablejg )){

                 $duqu = array();

                 foreach($this-> tablejg  as $k => $v){

                      $duqu[$k] = 1;
                 }

         
                             $filter  = array (  );
                            if($this->where) $filter = $this->where;
                             $options = array ( 'projection' => $duqu,
                                               
                  
                                        );
                             if( $this -> lismt)  $options['limit'] = $this -> lismt;
                             if( $this -> ktpyp)  $options['skip'] = $this -> ktpyp;

         
                             if($this -> paixu) $options['sort'] = $this -> paixu;

         }

         
         $query = new MongoDB\Driver\Query( $filter, $options);
         $cursor = $this -> data -> executeQuery ( $this->table , $query);
         $fanhui = $cursor -> toArray();

         if($fanhui) return $fanhui ;
         else return false;

}


function find($data=''){

         /*读取一条数据*/

         if($data !='') $this->where = $this->wherezuhe($data);

         $filter  = array (  );
         $options = array ('limit' => 1);

         if( $this-> tablejg && is_array( $this-> tablejg )){

                $duqu = array();

                foreach($this-> tablejg  as $k => $v){

                      $duqu[$k] = 1;
                }

                $filter  = array ();
                if($this->where) $filter = $this->where;
                $options = array ( 'projection' => $duqu,
                                    'limit' => 1,
                      
                            );
                if($this -> paixu) $options['sort'] = $this -> paixu;
         }

        $query = new MongoDB\Driver\Query( $filter, $options); 
        $cursor = $this -> data -> executeQuery ( $this->table , $query);
        $fanhui = $cursor -> toArray();

        if($fanhui){

           $shuju = (array)$fanhui['0'];
           if( isset( $shuju['_id'] ) ) $shuju['_id'] = (string)$shuju['_id'];
           return $shuju;

         }else return false;

}



function setbiao( $data = '' ){
 
         if($data != '')$this-> fenjie ( $this -> table, '/'.$data);
         return $this;
 
}


function zhicha( $data = ''){

         /*设置表的结构*/
       
         if(is_array( $data ) ) $this-> tablejg = $data;
         else if($data != ''){

           $shuju = explode(',',$data);

           if($shuju){
               $newshuju = array();

               foreach($shuju as $zhi){
                     
                     if($zhi == '')continue;

                     $wo  = explode('#',$zhi);

                     $newshuju[$wo['0']] = isset($wo['1'])? $wo['1'] : '';

               }

               $this-> tablejg = $newshuju;
           
           }
        
        
         }

        return $this;
         


}


public function zifuzhuan( $data ){

      if(!get_magic_quotes_gpc()) return addslashes(str_replace(array('0xbf27','0xbf5c27'),"'",$data));else return $data;
}



}