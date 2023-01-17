function delete_items(elem)
{
    jQuery( elem ).parents('tr').remove();
}

function add_items( context, elem )
{
    let xhr;
    let parentAttribute = jQuery( elem ).attr('parent-attribute');

    if( xhr && xhr.readystate != 1 )
    { 
        xhr.abort(); 
    }

    xhr = jQuery.ajax({

        type: "POST",
        dataType: 'json',
        url: PsDynamicProductAjax.url,
        data: {
            action      : PsDynamicProductAjax.action,
            nonce       : PsDynamicProductAjax.nonce,
            context     : context
        },
        success:  function ( obj ){   
        
            if( obj.r )
            {
                switch ( context )
                {
                    case 'addAttributes':
                        jQuery("#ps_list_attributes_dp tbody").append( obj.html );
                        break;

                    case 'addVariations':
                        let parent;
                        parent = jQuery( elem ).parents('div.attribute_dp');
                        parent.find('tbody').append( obj.html );
                        parent.find('tr.variation_dp').attr('parent-attribute', parentAttribute);
                        break;

                    case 'addColors':
                        jQuery("#ps_list_colors_dp tbody").append( obj.html );
                        break;

                    case 'addIdsColor':
                        jQuery("#ps_list_colors_variations_dp tbody").append( obj.html );
                        break;
                }
            }
        },
    });
}

function load_image( elem )
{
    let context = jQuery(elem).attr('context');
    var mediaUploader;
    if ( mediaUploader )
    {
        mediaUploader.open();
        return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Choose Image',
        button: {
            text: 'Choose Image'
        }, 
        multiple: false 
    });
    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on( 'select', function()
    {
        attachment = mediaUploader.state().get('selection').first().toJSON();
        jQuery(elem).siblings('input[name="'+context+'"]').val(attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
}

function validate_fields( elem, value )
{
    let type, cod="";
    
        type = elem.attr('type');
        switch ( type ) 
        {
            case 'text':
                value = value.replace(/\s/g, "");
                let reg = value.match(/\W/g);
                if( reg ){
                    elem.css('border','solid red 1px');
                    cod = 'invalidCharacters';
                }else if( value === ''){
                    elem.css('border','solid red 1px');
                    cod =  'emptyField';
                }else{
                    elem.css('border','solid #8c8f94 1px');
                }
                break;

            case 'number':
                if( !value.match(/^[0-9]+(,[0-9]+)?$/g) && value !== "" ){
                    elem.css('border','solid red 1px');
                    cod = 'invalidDigits';
                }else{
                    elem.css('border','solid #8c8f94 1px');
                }
                break;

            case 'color':
                if( !value.match(/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/g) ){
                    elem.css('border','solid red 1px');
                    cod = 'invalidColor';
                }else{
                    elem.css('border','solid #8c8f94 1px');
                }
                break;
        }
   
    return cod;
}

function dp_save_items( context, post )
{
    jQuery(document).ready(function($){
        let xhr, attributeName, svg, color, msg, dataSave = [];

        switch ( context ) {
            case 'saveAttributes':

                $('#ps_list_attributes_dp tbody tr').each( function()
                {
                    attributeName   = $( this ).find( 'input[name="attributeName"]' ).val();
                    svg             = $( this ).find( 'input[name="svg"]' ).is(':checked');
                    color           = $( this ).find( 'input[name="color"]' ).is(':checked');

                    $( this ).attr( 'attribute', attributeName );

                    msg = validate_fields( $( this ).find( 'input[name="attributeName"]' ), attributeName );

                    let rowAttributes = [ attributeName, svg, color ];

                    dataSave.push( rowAttributes );
                });

                break;

            case 'saveVariations':

                $('#ps_list_attributes_dp tbody tr').each( function()
                {
                    let rowAttributes, variations = [];

                    attributeName   = $( this ).attr( 'attribute' );
                   
                    $('tr.variation_dp').each( function()
                    {
                        let parentAttribute, variationIcon, variationSvg, variationParent;

                        parentAttribute = $( this ).attr('parent-attribute');

                        if( attributeName === parentAttribute ){
                            let variationName, variationPrice, variationStock, rowVariations;
                            variationName   = $( this ).find( 'input[name="variationName"]' ).val();
                            variationPrice  = $( this ).find( 'input[name="variationPrice"]' ).val();
                            variationIcon   = $( this ).find( 'input[name="add_icon"]' ).val();
                            variationSvg    = $( this ).find( 'input[name="add_svg"]' ).val();
                            variationStock  = $( this ).find( 'input[name="variationStock"]' ).is(':checked');
                            variationParent = parentAttribute;
                            
                            msg = validate_fields( $( this ).find( 'input[name="variationPrice"]' ), variationPrice );
                            if(!msg){
                                msg = validate_fields( $( this ).find( 'input[name="variationName"]' ), variationName );
                            }

                            rowVariations = { 
                                variationName:variationName, parent:variationParent, price:variationPrice, icon:variationIcon, svg:variationSvg, stock:variationStock
                            };
                            variations.push( rowVariations );
                        }
                    });

                    rowAttributes = { 
                        attributeName:attributeName, variations:variations 
                    };

                    dataSave.push( rowAttributes );
                });
                break;

            case 'saveColors':

                $('#ps_list_colors_dp tbody tr').each( function()
                {
                    let colorName, colorPrice, colorColor, colorStock;
                    colorName   = $( this ).find( 'input[name="colorName"]' ).val();
                    colorPrice  = $( this ).find( 'input[name="priceColor"]' ).val();
                    colorColor  = $( this ).find( 'input[name="colorColor"]' ).val();
                    colorStock  = $( this ).find( 'input[name="stockColor"]' ).is(':checked');

                    msg = validate_fields( $( this ).find( 'input[name="colorColor"]' ), colorColor );
                    if(!msg){
                        msg = validate_fields( $( this ).find( 'input[name="priceColor"]' ), colorPrice );
                        if(!msg){
                            msg = validate_fields( $( this ).find( 'input[name="colorName"]' ), colorName );
                        }
                    }
                    let rowColors = [ colorName, colorPrice, colorColor, colorStock ];

                    dataSave.push( rowColors );
                });
                break;

            case 'saveIdsColor':

                $('#ps_list_colors_variations_dp tbody tr').each( function()
                {
                    let VCName, VCFill, VCVariations;
                    VCName          = $( this ).find( 'input[name="VCName"]' ).val();
                    VCFill          = $( this ).find( 'input[name="VCFill"]' ).val();
                    VCVariations    = $( this ).find( 'input[name="VCVariations"]' ).val();

                    msg = validate_fields( $( this ).find( 'input[name="VCName"]' ), VCName );
                    if(!msg){
                         msg = validate_fields( $( this ).find( 'input[name="VCVariations"]' ), VCVariations );
                    }
                    let rowVC = [ VCName, VCFill, VCVariations ];

                    dataSave.push( rowVC );
                });
                break;
        }

        if( xhr && xhr.readystate != 1 ) xhr.abort();

        xhr = $.ajax({

            type: "POST",
            dataType: 'json',
            url: PsDynamicProductAjax.url,
            data: {
                action          : PsDynamicProductAjax.action,
                nonce           : PsDynamicProductAjax.nonce,
                context         : context,
                dataSave        : dataSave,
                post            : post,
                attributeName   : attributeName,
                error           : msg
            },
            success:  function ( obj ){  
                dp_show_messages( obj.m );
            },
        });
    });
}

function dp_load_variations( post )
{
    jQuery(document).ready(function($){
        let xhr;

        if( xhr && xhr.readystate != 1 ) xhr.abort();

        xhr = $.ajax({

            type: "POST",
            dataType: 'json',
            url: PsDynamicProductAjax.url,
            data: {
                action  : PsDynamicProductAjax.action,
                nonce   : PsDynamicProductAjax.nonce,
                post    : post,
                context : 'loadVariations'
            },
            beforeSend: function(){
                
            },
            success:  function ( obj ){  
                
               if( obj.r ){
                    $("#ps_list_variations_dp").html( obj.html );
                    $('.add_items_dp').on('click', function(){
                        add_items( 'addVariations', $(this) );
                    });
               }
            },
            complete: function (){
                dp_end_preloader();
            }
        });
    });
}

function dp_get_parameter_url( name )
{
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function dp_show_messages(msg)
{
    let icon="";
    if(msg){
        if( msg.match(/^Error:/) )
        {
            msg.replace("Error:", "");
            icon = "error";
        }
    }else{
        icon = "success";
    }
    Swal.fire( "", msg, icon );
}
