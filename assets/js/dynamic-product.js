jQuery( document ).ready( function( $ )
{
    let context, post;
    $('.add_items_dp').on('click', function(){
        context = $(this).attr('context');
        add_items( context, $(this) );
    });

    $('.save_items_dp').on('click', function(){
        context = $(this).attr('context');
        post    = $(this).attr('post');
        dp_save_items( context, post );
    });

    $('a[href="#ps_variations_dp_options"]').on( 'click', function(){
        dp_start_preloader('#woocommerce-product-data');
        post = dp_get_parameter_url('post');
        dp_load_variations( post );
    });
});