<?php

$cod = isset( $_POST['error'] ) ?  $_POST['error']  : '';

if( empty( $cod ) ){

    $attributes     = isset( $_POST['dataSave'] ) ?  $_POST['dataSave']  : array();
    $post_id        = isset( $_POST['post'] ) ?  $_POST['post']  : 0;
    $sanitized_attributes = [];
    if($attributes){
        foreach( $attributes as $attribute )
        { 
            $sanitized_attributes[] = [
                'nameAttribute'  => sanitize_text_field( trim( $attribute[0] ) ), 
                'svgAttribute'   => dp_convert_string_to_boolean( $attribute[1] ),
                'colorAttribute' => dp_convert_string_to_boolean( $attribute[2] )
            ];
        }
    }
    $update = update_post_meta( $post_id, 'ps_attributes_dp', $sanitized_attributes );
    if( $update ) $r['r'] = true;
}else{
    $r['m'] = dp_error_messages( $cod );
}

