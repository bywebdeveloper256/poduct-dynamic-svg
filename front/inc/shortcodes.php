<?php
function dp_show_form_attributes_dinamyc_product($atts){
    global $product;

    $parameters = shortcode_atts( array (
        'product_id' => get_the_ID(),
    ), $atts );

    $html = '';

    $product_id = $parameters['product_id']; 

    if( $product_id )
    { 
        if ( 'dynamic_product' == $product->get_type() )
        {
            ob_start();
            require FRONT_FOLDER_PATH . 'inc/templates/form-variations.php';
            $html = ob_get_clean();
        }
    }
    return $html;
}
add_shortcode('dp_show_variations','dp_show_form_attributes_dinamyc_product');