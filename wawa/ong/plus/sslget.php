<?php //

$PLUSsslget = 'sslget';

function sslget( $url, $cacert_url = ''){

         $curl = curl_init( $url );
         curl_setopt( $curl , CURLOPT_HEADER, 0 );
         curl_setopt( $curl , CURLOPT_RETURNTRANSFER, 1);
       
         if($cacert_url != ''){

            curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER, 2);
            curl_setopt( $curl , CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt( $curl , CURLOPT_CAINFO, $cacert_url);

         }else{

            curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt( $curl , CURLOPT_SSL_VERIFYHOST, 0);

         }

         $responseText = curl_exec( $curl );
         curl_close( $curl );
         return $responseText;
}