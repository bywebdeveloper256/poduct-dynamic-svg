<?php

add_filter( 'woocommerce_get_item_data', 'dp_display_qty_cards_in_cart_item_data', 21, 2 );
function dp_display_qty_cards_in_cart_item_data( $cart_data, $cart_item )
{
    $v = get_post_meta( $cart_item['product_id'], 'dp_all_values', true );
    $datos = json_decode($v);
    
    if($datos){
        $i = 0;
        foreach ( $datos as $value ) {
            
            if($i === 0){
                if( $value->txtp ){
                    $cart_data[] = array( 
                        'name' => __('Texto Personalizado'), 
                        'value' => $value->txtp
                    );
                }
            }

            $cart_data[] = array( 
                'name' => __($value->attribute), 
                'value' => $value->value
            );

            if($value->colors){
                foreach( $value->colors as $v ){
                    $cart_data[] = array( 
                        'name' => __($v->button), 
                        'value' => $v->color
                    );
                }
            }
            $i++;
        }
    }
    return $cart_data;
}

add_filter( 'woocommerce_add_cart_item_data', 'dp_save_qty_cards_in_the_cart', 21, 2 );
function dp_save_qty_cards_in_the_cart( $cart_item_data, $product_id )
{
    if( isset($_POST['dp_allValues']) ){
        update_post_meta( $product_id, 'dp_all_values', $_POST['dp_allValues'] );
        $cart_item_data['dp_allValues'] = $_POST['dp_allValues'];
    }
    return $cart_item_data;
}

add_action( 'woocommerce_new_order_item', 'dp_save_qty_cards_in_new_order_item', 21, 3 );
function dp_save_qty_cards_in_new_order_item( $item_id, $item, $order_id )
{
    $v = get_post_meta( $item['product_id'], 'dp_all_values', true );
    $datos = json_decode($v);

    if($datos){
        $i = 0;
        foreach ( $datos as $value ) {
            if($i === 0){
                if( $value->txtp ){
                    wc_add_order_item_meta( $item_id, __('Texto Personalizado'), $value->txtp );
                }
            }
            wc_add_order_item_meta( $item_id, __($value->attribute), $value->value );

            if($value->colors){
                foreach( $value->colors as $v ){
                    wc_add_order_item_meta( $item_id, __($v->button), $v->color );
                }
            }
            $i++;
        }
    }
}

add_filter( 'woocommerce_add_cart_item_data', 'dp_extra_data_to_cart_item', 20, 2 );
function dp_extra_data_to_cart_item( $cart_item_data, $product_id ){
    if( ! isset($_POST['dp_price_variations']) ) return $cart_item_data;

    $extra_price = (float)$_POST['dp_price_variations'];

    if ( ! $extra_price ) return $cart_item_data;

    $product = wc_get_product($product_id);
    $base_price = (float) $product->get_price();

    $new_price =$base_price + $extra_price;

    $cart_item_data['dp_price_variations'] = array(
        'extra_price' => $extra_price,
        'new_price' => (float) $new_price,
    );
 
    return $cart_item_data;
}

add_action('woocommerce_before_calculate_totals', 'dp_custom_cart_item_price', 20, 1);
function dp_custom_cart_item_price( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;

    foreach (  $cart->get_cart() as $cart_item ) {
        if ( isset( $cart_item['dp_price_variations']['new_price'] ) )
            $cart_item['data']->set_price( $cart_item['dp_price_variations']['new_price'] );
    }
}