<?php
function ps_enqueue_css_and_js_front()
{
    if( get_post_type() === 'product' )
    {
        wp_enqueue_style( 'PsSmartWizardCss', 'https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css', array(), bwd_plugin_data( 'Version' ) );
        wp_enqueue_style( 'PsDynamicProductFrontCss', FRONT_FOLDER_URL . 'assets/css/dynamic-product.css', array(), bwd_plugin_data( 'Version' ) );
        
        wp_enqueue_script( 'PsSmartWizardJs', 'https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js', array( 'jquery' ), bwd_plugin_data( 'Version' ), true );
        wp_enqueue_script( 'PsFunctionsFrontJs', FRONT_FOLDER_URL . 'assets/js/functions.js', array( 'jquery' ), bwd_plugin_data( 'Version' ), true );
        wp_enqueue_script( 'PsDynamicProductFrontJs', FRONT_FOLDER_URL . 'assets/js/dynamic-product.js', array( 'jquery', 'PsFunctionsFrontJs' ), bwd_plugin_data( 'Version' ), true );
        wp_localize_script( 'PsDynamicProductFrontJs', 'PsDynamicProductFrontAjax', 
            array( 
                'url'    => admin_url( 'admin-ajax.php' ), 
                'action' => 'ps_dynamic_product_front_action',
                'nonce'  => wp_create_nonce( 'ps_dynamic_product_front_nonce' ) 
            )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'ps_enqueue_css_and_js_front' );