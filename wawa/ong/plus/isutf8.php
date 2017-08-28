<?php //

$PLUSisutf8 = 'isutf8';
function isutf8( $word ){
        if(function_exists( 'mb_detect_encoding' ) )
        return (mb_detect_encoding( $word , 'UTF-8') === 'UTF-8');

         if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/" , $word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/" , $word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/" , $word) == true) return true;
         else  return false;
}
