jQuery( document ).ready( function($)
{
    let productDynamic = $( '#content-values > input[name="dp_add_to_cart"]' );
    if( productDynamic.length > 0 ){
        dp_load_svg_default();
        $('#smartwizard').smartWizard({
            selected: 0,
            theme: 'dots',
            autoAdjustHeight: false,
            enableUrlHash : false,
        });
        $('form.cart').hide();
        $('figure.woocommerce-product-gallery__wrapper img').css('opacity','0');
        $('figure.woocommerce-product-gallery__wrapper a').css('position','relative');

        $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
            let step = stepIndex+1;

            $('form.cart').hide();
            $('.sw-btn-next').attr('disabled', 'disabled');

            $('.radioVariation-'+step+' input[name^="variation-"]').on( 'change', function(){
                $('.sw-btn-next').removeAttr('disabled');
            })

            if( stepDirection === 'backward' ){
                $('.radioVariation-'+step+' input[name^="variation-"]').each( function(){
                    if($(this).is(':checked')){
                        $('.sw-btn-next').removeAttr('disabled');
                    }
                })
            }else{
                $('.radioVariation-'+step+' input[name^="variation-"]').each( function(){
                    if($(this).is(':checked')){
                        $('.sw-btn-next').removeAttr('disabled');
                    }
                })
            }
            
            if( stepPosition === 'last' ){
                $('.radioVariation-'+step+' input[name^="variation-"]').each( function(){
                    if($(this).is(':checked')){
                        $('form.cart').show();
                    }
                })
                $('.radioVariation-'+step+' input[name^="variation-"]').on( 'change', function(){
                    $('form.cart').show();
                })
            }
         });
        
        $('input[name^="variation-"]').on( 'change', function(){
            let allValues = dp_get_input_value( this );
            dp_load_views_svg(allValues);
            dp_change_price()
        })

        $('button.btnColores').on( 'click', function(){
            dp_show_colores(this)
        })
    }else{
        $('#smartwizard').hide();
    }
});
