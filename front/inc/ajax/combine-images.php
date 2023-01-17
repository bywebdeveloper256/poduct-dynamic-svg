<?php

    $svgs = isset( $_POST['svgs'] ) ? $_POST['svgs'] : array();
    $filesPng = []; 
    if( !empty($svgs) ){
        $im    = new Imagick();
        //$im->newImage(0, 0, new ImagickPixel('transparent'), "png24");
        $i     = 0;
        foreach ( $svgs as $usmap ) 
        { 
            $fileName = date("YmdHisv").$i;
            $filePath = MAIN_FOLDER_PATH . '/imgGenerates/'.$fileName.'.png';
            $fileUrl  = MAIN_FOLDER_URL . 'imgGenerates/'.$fileName.'.png';
            $svg = file_get_contents( $svgs[0] );
            $im->readImageBlob( $svg ); 
            $im->setImageFormat( "png24" ); 
            //$im->transparentPaintImage( '#fff', 0.0, 0, false );
            //$im->despeckleimage();
            $im->writeImage( $filePath );
            $filesPng[] = $fileUrl;
            $i++;
        }
        $im->clear(); 
        $im->destroy();
    }

    /* if( !empty($filesPng) ){
        $imgCreate = [];
        foreach ( $filesPng as $value ) {
            $imgCreate[] = imagecreatefrompng( $value );
        }
    }

    if( !empty($imgCreate) ){
        $imgCopy = [];
        for ( $i=0; $i < count($imgCreate); $i++) { 
            if( $i > 0 ){
                $imgCopy[] = imagecopyresampled( $imgCreate[0], $imgCreate[$i], 0, 0, 0, 0, imagesx($imgCreate[0]), imagesy($imgCreate[0]), imagesx($imgCreate[0]), imagesy($imgCreate[0]) );
            }
            $i++;
        }
    }

    $fileName = 'comb_'.date("YmdHisvu");
    $filePath = MAIN_FOLDER_PATH . '/imgGenerates/'.$fileName.'.png';
    $fileUrl  = MAIN_FOLDER_URL . 'imgGenerates/'.$fileName.'.png';
    imagepng( $imgCreate[0], $filePath );

    if( !empty($imgCreate) ){
        for ( $i=0; $i < count($imgCreate); $i++) { 
            imagedestroy($imgCreate[$i]);
        }
    } */
    
    $r['r'] = $filesPng;