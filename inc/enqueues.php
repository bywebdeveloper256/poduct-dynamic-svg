<?php
function ps_enqueue_css_and_js_backend()
{
    if( get_post_type() === 'product')
    {
        wp_enqueue_style( 'PsBootstrapCss', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), bwd_plugin_data( 'Version' ) );
        wp_enqueue_script( 'PsBootstrapJs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), bwd_plugin_data( 'Version' ), true );
        wp_enqueue_script( 'PsFunctionsJs', ASSETS_FOLDER_URL . 'js/functions.js', array(), bwd_plugin_data( 'Version' ), true );
        wp_enqueue_script( 'PsDynamicProductJs', ASSETS_FOLDER_URL . 'js/dynamic-product.js', array( 'jquery', 'PsFunctionsJs' ), bwd_plugin_data( 'Version' ), true );
        wp_localize_script( 'PsDynamicProductJs', 'PsDynamicProductAjax', 
            array( 
                'url'       => admin_url( 'admin-ajax.php' ), 
                'action'    => 'ps_dynamic_product_action',
                'nonce'     => wp_create_nonce( 'ps_dynamic_product_nonce' ) 
            )
        );
    }
}
add_action( 'admin_enqueue_scripts', 'ps_enqueue_css_and_js_backend' );

function ps_enqueue_css_and_js_general()
{
    if( get_post_type() === 'product')
    {
        wp_enqueue_script( 'PsSwetAlertJs', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array( 'jquery' ), bwd_plugin_data( 'Version' ), true );
        wp_enqueue_style( 'PsGeneralCss', ASSETS_FOLDER_URL . 'css/general.css', array(), bwd_plugin_data( 'Version' ) );   
        wp_enqueue_script( 'PsGeneralJs', ASSETS_FOLDER_URL . 'js/general.js', array( 'jquery' ), bwd_plugin_data( 'Version' ), true ); 
    }
}
add_action( 'wp_enqueue_scripts', 'ps_enqueue_css_and_js_general' );
add_action( 'admin_enqueue_scripts', 'ps_enqueue_css_and_js_general' );