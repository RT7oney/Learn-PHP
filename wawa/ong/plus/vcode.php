<?php //

$PLUSvcode = 'vcode';

function vcode($sizes='0',$code="0123456789",$shu =4,$width=130,$height=40,$zadian=100,$xiaos = 10){

        ob_clean();
        header("Content-type: image/png");
        global $CONN;

        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255,245));

        if( $code == '' ) $code = "0123456789"; 

        $ascii='';
        if($sizes == '0') $ZITI =rand(1,10);
        else              $ZITI = $sizes;

        $size = rand(20,28);

        imagesetthickness($image,rand(0,50)) ;

        $zhufu = explode(',',$CONN['vcode']);

        for( $i = 0 ; $i < $shu ; $i++ ){

            if($sizes < 0 ) $ZITI = rand( 1 , 10 );

            if($sizes == -2){

                $char = $zhufu[$i].'                                ....__-$%#$^^6634'.rand(1,999999);
                $ZITI = 11;

            }else $char = $code{rand(0,strlen($code)-1)};

            $COLOR = imagecolorallocate($image, rand(0,200), rand(0,200), rand(0,200));

            $shus = $i*($width/$height)*$xiaos ;
            $tux = $shus+rand(5,10);
            $tuy =  (int)($height/2)+rand(5,$size);

            $coordinates = imagefttext($image,$size ,rand(-10,20), $shus+rand(5,20), $tuy ,$COLOR  , ONGPHP.'../tpl/font/'.$ZITI.'.ttf' ,$char, array('character_spacing' => 20));

            if(rand(0,3) == 1  ) imagearc( $image, $tux+rand(-10,20), $tuy-rand(1,20), 5, 5, 1, rand(0,$ZITI), $COLOR );

            for($z=0; $z<=$i*$zadian; $z++) imagesetpixel($image,rand($tux-30,$tux+30),rand($tuy-30,$tuy+30),$COLOR);

            $ascii.=$char;
        }

        if(rand(0,2) == 1) imagearc($image, $tux+rand(10,20), $tuy-rand(1,10), 5, 5, 1, rand(0,$ZITI), $COLOR);

        $_SESSION['code'] = isset( $CONN['sicode'] ) && $CONN['sicode'] == 1 ? $ascii : strtolower( $ascii );

        $_SESSION['codetime'] = time();
        imagepng( $image );
        imagedestroy( $image );
}