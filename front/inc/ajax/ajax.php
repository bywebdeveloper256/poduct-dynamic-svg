<?php
function ps_dynamic_product_front_ajax()
{
    $r = array( "r" => false, "m" => "" );
    $nonce  = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : false;
    $context = isset( $_POST['context'] ) ? sanitize_text_field( $_POST['context'] ) : '';
    if ( wp_verify_nonce( $nonce, 'ps_dynamic_product_front_nonce' ) )
    {
        if( $context === 'showColor' ){
            $product_id = isset( $_POST['product'] ) ?  $_POST['product']  : '';
            $attribute = isset( $_POST['attribute'] ) ?  $_POST['attribute'] : '';
            $variation = isset( $_POST['variation'] ) ?  $_POST['variation'] : '';
            $fill = isset( $_POST['fill'] ) ?  $_POST['fill'] : '';
            $colors = get_post_meta( $product_id, 'ps_colors_dp', true );
            if( $colors ){
                $count = count($colors);
                $colorsHtml = '';
                $search = array('{attribute}',"{name}", '{color}', '{price}', '{fill}', '{variation}');
                for ($i=0; $i < $count; $i++) { 
                
                    if( $colors[$i]['stock'] )
                    { 
                        $replace = [];
                        $replace[] = strtolower($attribute);
                        $replace[] = $colors[$i]['name'];
                        $replace[] = $colors[$i]['color'];
                        $replace[] = $colors[$i]['price'];
                        $replace[] = $fill;
                        $replace[] = $variation;
                        ob_start();
                        ?>
                        <label class="content-colors">
                        <input type="radio" name="color-{attribute}" value="{name}" attribute="{attribute}" fill="{fill}" color="{color}" price="{price}" variation="{variation}" onclick="dp_change_colors(this)">
                        <picture class="tooltip top">
                        <div style="background-color:{color}"></div>
                        <span class="tiptext">{name}</span>
                        </picture>
                        </label>
                    <?php  $html = ob_get_clean();
                        $colorsHtml .= str_replace($search,$replace, $html);
                    }
                }
            } 
            $r['html'] = $colorsHtml;
        }

        if( $context === 'loadSvgDefault' ){
            $post = isset( $_POST['post'] ) ? sanitize_text_field( $_POST['post'] ) : '';
            $variations = get_post_meta( $post, 'ps_variations_dp', true );
            $default=[];
            if($variations){
                foreach ( $variations as $value ) {

                    if($value['variations']){
                        foreach ($value['variations'] as $v) {
                            if( $v['svg'] && $v['stock']){

                                $default[] = [
                                    'svg' => $v['svg'],
                                    'name' => 'variation-' . strtolower($value['attributeName'])
                                ];
                                break;
                            }
                        }
                    }
                }
            }
            $r['r'] = $default;
        }
    }
    echo json_encode($r);
    wp_die();
}
add_action( 'wp_ajax_ps_dynamic_product_front_action', 'ps_dynamic_product_front_ajax' );
add_action( 'wp_ajax_nopriv_ps_dynamic_product_front_action', 'ps_dynamic_product_front_ajax' );