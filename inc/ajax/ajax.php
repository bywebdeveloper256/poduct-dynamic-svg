<?php

function ps_dynamic_product_ajax()
{
    $r = array( "r" => false, "m" => "" );

    $nonce  = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : false;

    $context  = isset( $_POST['context'] ) ? sanitize_text_field( $_POST['context'] ) : '';
   
    if ( wp_verify_nonce( $nonce, 'ps_dynamic_product_nonce' ) )
    {
        switch ( $context )
        {
            case 'addAttributes':
                require 'add-attribute.php';
                break;

            case 'saveAttributes':
                require 'save-attribute.php';
                break;

            case 'addVariations':
                require 'add-variations.php';
                break;
                
            case 'saveVariations':
                require 'save-variations.php';
                break;

            case 'addColors':
                require 'add-colors.php';
                break;

            case 'saveColors':
                require 'save-colors.php';
                break;

            case 'loadVariations':
                require 'load-variations.php';
                break;

            case 'addIdsColor':
                require 'add-ids-colors.php';
                break;

            case 'saveIdsColor':
                require 'save-ids-colors.php';
                break;
        }
    }else{
        $r['m'] = dp_error_messages('noPermissions'); 
    }

    echo json_encode( $r );

    wp_die();
}
add_action( 'wp_ajax_ps_dynamic_product_action', 'ps_dynamic_product_ajax' );