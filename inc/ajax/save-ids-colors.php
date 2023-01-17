<?php
$cod = isset( $_POST['error'] ) ?  $_POST['error']  : '';

if( empty( $cod ) ){
    $vc  = isset( $_POST['dataSave'] ) ? $_POST['dataSave'] : array();
    $post_id = isset( $_POST['post'] ) ? $_POST['post'] : 0;

    if($vc){
        $sanitized_vc = [];
        foreach ( $vc as $v ) {
            $sanitized_vc[] = [
                'name'  => sanitize_text_field( $v[0] ),
                'fill' => sanitize_text_field( $v[1] ),
                'variation' => sanitize_text_field( $v[2] ),
            ];
        }
    }
    $update  = update_post_meta( $post_id, 'ps_colors_variations_dp', $sanitized_vc );
    if($update) $r['r'] = true;
}else{
    $r['m'] = dp_error_messages( $cod );
}