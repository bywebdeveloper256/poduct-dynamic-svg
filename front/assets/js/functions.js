function dp_get_input_value( element ){
    let allValues = [];
    let i = 0;
   
    if(jQuery(element).is(':checked')){
        let name  = jQuery(element).attr('name');
        let textp = '';
        let colors = [];
        let svg     = jQuery(element).attr('svg') ? jQuery(element).attr('svg') : '';
        let value   = jQuery(element).val();
        let attribute = jQuery(element).attr('attribute');
        let price   = jQuery(element).attr('price');
        if( i === 0){
            textp = jQuery('textarea[name="text_pers"]').val();
        }
        
        if(svg){
            jQuery( 'input[name="dp_variation_color"]' ).each( function(){
                
                let variation = jQuery(this).attr('variation');
                
                if( variation === value ){

                    let color = jQuery(this).attr('colorname');
                    let button = jQuery(this).attr('button');
                    let price = jQuery(this).attr('price');
                    let rowColors = {
                        color:color, button:button, price:price
                    };
                    colors.push( rowColors );
                }
            })
        }
        let rowValues = {
            txtp: textp, svg:svg, name:name, value:value, attribute:attribute, price:price, colors:colors
        };
        allValues.push( rowValues );
    }
    i++;
    return allValues;
}

/* function dp_combine_svg(allSvg) {
    
    let xhr;

    if( xhr && xhr.readystate != 1 ) xhr.abort();

    xhr = jQuery.ajax({

        type: "POST",
        dataType: 'json',
        url: PsDynamicProductFrontAjax.url,
        data: {
            action  : PsDynamicProductFrontAjax.action,
            nonce   : PsDynamicProductFrontAjax.nonce,
            context : 'combineSvg',
            svgs    : allSvg
        },
        success:  function ( obj ){  
            
            if( obj.r ){
                console.log(obj.r)
            }
        },
        complete: function(r){
            //console.log(r.responseJSON)
        },
    });
    
} */

function dp_bundle_svg(allValues){
    let allSvg = [];
    for (let i = 0; i < allValues.length; i++) {
        allSvg.push( allValues[i].svg );
    }
    return allSvg;
}

function dp_load_views_svg(allValues){
    let i=0;
    
    allValues.forEach( element => {
        if(element.svg !== "" ){
            let a = i+1;
            if ( jQuery('#'+element.name).length == 0 ) {
                jQuery('figure.woocommerce-product-gallery__wrapper a').prepend(
                    '<div id="'+element.name+'" style="position:absolute; width: 100%; height:100%; z-index:'+a+'"></div>'
                );
            }
            jQuery('#'+element.name).prepend(
                '<object style="display:none" id="odj-'+element.name+'" data="'+element.svg+'" type="image/svg+xml"></object>'
            );

            jQuery('#'+element.name+' #odj-'+element.name).first().fadeIn('slow');
            if( jQuery('#'+element.name+' #odj-'+element.name).length > 1 ){
                jQuery('#'+element.name+' #odj-'+element.name).last().remove()
            }

            let codeAttr = element.name;
            let nameAttr = codeAttr.replace("variation-", "");
            let nameVariation;
            
            jQuery( '#'+nameAttr+' input' ).each( function(){
                if(jQuery(this).is(':checked')){
                    nameVariation = jQuery(this).val();
                }
            })
            jQuery('input[name=color-'+nameAttr+']').attr('nameVariation', nameVariation);
        }
        i++;
    });
    dp_change_price()
}

function dp_show_btn(element){
    let variation = jQuery(element).val();
    jQuery('button.btnColores').hide();
    jQuery('button.btnColores[variation="'+variation+'"]').fadeIn('slow');
}

function dp_show_colores(element){

    let attribute = jQuery(element).attr('attribute');
    let variation = jQuery(element).attr('variation');
    let product_id = jQuery(element).attr('product');
    let fill = jQuery(element).attr('fill');

    jQuery.ajax({
        url: PsDynamicProductFrontAjax.url,
        type: "POST",
        dataType: "text json",
        data: {
            action: PsDynamicProductFrontAjax.action,
            nonce: PsDynamicProductFrontAjax.nonce,
            context: 'showColor',
            product: product_id,
            attribute: attribute,
            fill: fill,
            variation: variation
        },
        success: function(obj){
            Swal.fire({
                html: obj.html,
                title: 'Añada el color para ' + variation,
                text: product_id,
            }) 
        }
    });
}

function dp_change_colors( element )
{
    let color = jQuery(element).attr('color');
    let colorName = jQuery(element).val();
    let attribute = jQuery(element).attr('attribute');
    let fill = jQuery(element).attr('fill');
    let price = jQuery(element).attr('price');
    let button = jQuery('button[fill="'+fill+'"]').text();
    let variation = jQuery(element).attr('variation');
    
    let ab = document.getElementById('odj-variation-'+attribute);
    let svgDoc = ab.contentDocument;
    let ac = svgDoc.querySelector(fill);
    ac.style.setProperty("fill", color, "");

    let valuesColors = jQuery('button[fill="'+fill+'"]').siblings('.valuesColors');

    jQuery(valuesColors).html(
        '<input type="hidden" name="dp_variation_color" color="'+color+'" colorname="'+colorName+'" button="'+button+'" price="'+price+'" variation="'+variation+'">'
    );
    dp_change_price()
}

function dp_send_values(){
    let allValues = dp_get_all_input_values( 'input[name^="variation-"]' );
   
    if ( jQuery('input[name="dp_allValues"]').length == 0 ) {
        jQuery('form.cart div.quantity').append(
            '<input type="hidden" name="dp_allValues" value="' + JSON.stringify(allValues) + '">'
        );
    }else{
        jQuery('input[name="dp_allValues"]').val( JSON.stringify(allValues) );
    }

    if ( jQuery('input[name="dp_price_variations"]').length == 0 ) {
        jQuery('form.cart div.quantity').append(
            '<input type="hidden" name="dp_price_variations" value="'+dp_sum_variations()+'">'
        );
    }else{
        jQuery('input[name="dp_price_variations"]').val(dp_sum_variations());
    }
}
function dp_sum_variations(){
    let allValues = dp_get_all_input_values( 'input[name^="variation-"]' );
    let total = 0;
    allValues.forEach( element => {

        if( element.price === "" ) element.price = 0;
        let price = parseInt(element.price);
        total += price;
        
        if( element.colors ){
            element.colors.forEach( color => {
                if( color.price === "" ) color.price = 0;
                total += parseInt(color.price);
            }
        )}
        
    });
    return total;
}

function dp_change_price(){
    let symbol = jQuery('input[name="dp_get_currency_symbol"]').val();
    let price = jQuery('input[name="dp_price"]').val();
    let total = parseInt(price) + dp_sum_variations();
    jQuery('.woocommerce-Price-amount.amount bdi').html(
        '<span class="woocommerce-Price-currencySymbol">'+symbol+'</span>'+total
    );
    dp_send_values()
}

function dp_load_svg_default(){
    let post;
    jQuery('.radioVariation-1 input[type="radio"]').each( function(){
        post = jQuery(this).attr('post');
    })

    jQuery.ajax({
        type: "POST",
        dataType: 'json',
        url: PsDynamicProductFrontAjax.url,
        data: {
            action  : PsDynamicProductFrontAjax.action,
            nonce   : PsDynamicProductFrontAjax.nonce,
            post    : post,
            context : 'loadSvgDefault'
        },
        success:  function ( obj ){ 
            if( obj.r ){
                dp_load_views_svg(obj.r);
            }
        },
        
    });
}

function dp_get_all_input_values( el ){
    let allValues = [];
    let i = 0;
    jQuery(el).each( function(){
        if(jQuery(this).is(':checked')){
            let name  = jQuery(this).attr('name');
            let textp = '';
            let colors = [];
            let svg     = jQuery(this).attr('svg') ? jQuery(this).attr('svg') : '';
            let value   = jQuery(this).val();
            let attribute = jQuery(this).attr('attribute');
            let price   = jQuery(this).attr('price');
            if( i === 0){
                textp = jQuery('textarea[name="text_pers"]').val();
            }
            
            if(svg){
                jQuery( 'input[name="dp_variation_color"]' ).each( function(){
                    
                    let variation = jQuery(this).attr('variation');
                    
                    if( variation === value ){

                        let color = jQuery(this).attr('colorname');
                        let button = jQuery(this).attr('button');
                        let price = jQuery(this).attr('price');
                        let rowColors = {
                            color:color, button:button, price:price
                        };
                        colors.push( rowColors );
                    }
                })
            }
            let rowValues = {
                txtp: textp, svg:svg, name:name, value:value, attribute:attribute, price:price, colors:colors
            };
            allValues.push( rowValues );
        }
    });
    i++;
    return allValues;
}