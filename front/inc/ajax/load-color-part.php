<?php
$post = isset( $_POST['post'] ) ?  $_POST['post']  : '';
$variation = isset( $_POST['variation'] ) ?  $_POST['variation'] : '';

$CV = get_post_meta( $post, 'ps_colors_variations_dp', true );

if($CV){
    $variations = [];
    foreach ( $CV as $value ) {
        if( $value['variation'] == $variation ){
            $variations[] = $value;
        }
    }
    $r['variations'] = $variations;
}
$r['r'] = true;