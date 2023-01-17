<?php

 /*
  * value for the function bwd_plugin_data()
  * Name
  * PluginURI
  * Version
  * Description
  * Author
  * AuthorURI
  * TextDomain
  * DomainPath
  * Network
  * RequiresWP
  * RequiresPHP
  * UpdateURI
  * Title
  * AuthorName
  */
if ( !function_exists( 'bwd_plugin_data' ) )
{
    function bwd_plugin_data( $value )
    {
        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $data = get_plugin_data(MAIN_FILE_PATH, false, false );

        return $data[$value];
    }
}

if ( !function_exists( 'bwd_checked' ) )
{
    function bwd_checked( $bool )
    {
        if( $bool === true ) return 'checked';
    }
}

if ( !function_exists( 'dp_get_variations_by_attribute' ) )
{
    function dp_get_variations_by_attribute( $product_id, $attributeName )
    {
        $attributes = get_post_meta( $product_id, 'ps_variations_dp', true );

        $variations = [];

        foreach ( $attributes as $attribute )
        {
            if( $attribute['attributeName'] === $attributeName )
            {
                if( isset( $attribute['variations'] ) )
                {
                    foreach ( $attribute['variations'] as $variation )
                    {
                        $variations[] = $variation;
                    }
                }
                break; 
            }
        }
        return $variations;
    }
}

if ( !function_exists( 'dp_get_all_variations' ) )
{
    function dp_get_all_variations( $product_id )
    {
        $attributes = get_post_meta( $product_id, 'ps_variations_dp', true );

        $variations = [];

        foreach ( $attributes as $attribute )
        {
            if( isset( $attribute['variations'] ) )
            {
                foreach ( $attribute['variations'] as $variation )
                {
                    $variations[] = $variation;
                }
            }
        }
        return $variations;
    }
}

if ( !function_exists( 'dp_get_attributes' ) )
{
    function dp_get_attributes( $product_id )
    {
        $attributes = get_post_meta( $product_id, 'ps_attributes_dp', true );

        $attr = [];
        if( $attributes ){
            foreach ( $attributes as $attribute )
            {
                $attr[] = $attribute;
            }
        }
        return $attr;
    }
}

if ( !function_exists( 'dp_convert_string_to_boolean' ) )
{
    function dp_convert_string_to_boolean( $string )
    {
        if( 'true' === $string ) return true;
        return false;
    }
}

if ( !function_exists( 'dp_error_messages' ) )
{
    function dp_error_messages( $error )
    {
        switch ( $error ) {

            case 'invalidCharacters':
                $msg = 'You are entering invalid characters. please correct them.';
                break;
    
            case 'emptyField':
                $msg = 'There should be no empty fields.';
                break;

            case 'noPermissions':
                $msg = 'You do not have permissions';
                break;

            case 'error':
                $msg = 'An error has occurred.';
                break;

            case 'invalidDigits':
                $msg = 'The digits are not valid.';
                break;

            case 'invalidColor':
                $msg = 'The hexadecimal code is not correct.';
                break;
        }
        return 'Error:'.esc_html__( $msg, bwd_plugin_data( 'TextDomain' ) );
    }
}