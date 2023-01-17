<?php
$cod = isset( $_POST['error'] ) ?  $_POST['error']  : '';

if( empty( $cod ) ){
    $colors  = isset( $_POST['dataSave'] ) ? $_POST['dataSave'] : array();
    $post_id = isset( $_POST['post'] ) ? $_POST['post'] : 0;

    if($colors){
        $sanitized_colors = [];
        foreach ( $colors as $color ) {
            $sanitized_colors[] = [
                'name'  => sanitize_text_field( $color[0] ),
                'price' => sanitize_text_field( $color[1] ),
                'color' => sanitize_hex_color( $color[2] ),
                'stock' => dp_convert_string_to_boolean( $color[3] )
            ];
        }
    }
    $update  = update_post_meta( $post_id, 'ps_colors_dp', $sanitized_colors );
    if($update) $r['r'] = true;
}else{
    $r['m'] = dp_error_messages( $cod );
}