<?php
$cod = isset( $_POST['error'] ) ?  $_POST['error']  : '';

if( empty( $cod ) ){
    $attributes = isset( $_POST['dataSave'] ) ? $_POST['dataSave'] : array();
    $post_id    = isset( $_POST['post'] ) ? $_POST['post'] : 0;
    
    if($attributes){
        
        $sanitized_attributes = [];
        foreach( $attributes as $attribute )
        { 
            $sanitized_variations = [];
            if( !empty($attribute['variations']) ){
                foreach( $attribute['variations'] as $variation )
                { 
                    $sanitized_variations[] = [
                        'name'  => sanitize_text_field( $variation['variationName'] ),
                        'price' => sanitize_text_field( $variation['price'] ),
                        'icon'  => sanitize_url( $variation['icon'] ),
                        'svg'   => sanitize_url( $variation['svg'] ),
                        'stock' => dp_convert_string_to_boolean( $variation['stock'] )
                    ];
                }
            }
            $sanitized_attributes[] = [
                'attributeName' => sanitize_text_field( $attribute['attributeName'] ),
                'variations'    => $sanitized_variations
            ];
        }
        $update = update_post_meta( $post_id, 'ps_variations_dp', $sanitized_attributes );
        if( $update ) $r['r'] = true;
    }
}else{
    $r['m'] = dp_error_messages( $cod );
}
