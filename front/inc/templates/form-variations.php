
<!-- 'nameAttribute' => string 'Tallas' (length=6)
      'svgAttribute' => boolean true
      'colorAttribute' => boolean true -->

      <!-- 'name' => string 'XL' (length=2)
      'price' => string '' (length=0)
      'icon' => string '' (length=0)
      'svg' => string '' (length=0)
      'stock' => boolean true -->

<div id="smartwizard">
    <ul class="nav" style="margin-left:0">
        <?php 
            $attributes = dp_get_attributes( $product_id );
            if( $attributes ){
                $num = 1;
                foreach ( $attributes as $value ) 
                {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="#step-'.$num.'">';
                    echo '<span class="num">'.$num.'</span>';
                    esc_html_e( $value['nameAttribute'] );
                    echo '</a></li>';
                    $num++;
                }
            }
        ?>
    </ul>
 
    <div class="tab-content">
        <?php
            if( $attributes ){
                $n = 1;
                foreach ( $attributes as $value ) {
                    echo '<div id="step-'.$n.'" class="tab-pane" role="tabpanel" aria-labelledby="step-'.$n.'">';
                        $variations = dp_get_variations_by_attribute( $product_id, $value['nameAttribute'] );
                        $btns = $value['colorAttribute'] ? 'onclick="dp_show_btn(this)"' : '';
                        echo '<div>';
                        echo '<h5 style="text-align: center">'.esc_html__('Seleccione '.$value['nameAttribute'], bwd_plugin_data( 'TextDomain' )).'</h5>';
                        echo '</div>';

                        echo '<div class="radioVariation-'.$n.'" id="'.strtolower(sanitize_title($value['nameAttribute'])).'">';
                        if( $variations ){
                            foreach ( $variations as $variation ) 
                            {
                                if( $variation['stock'] )
                                {
                                    $svg = $variation['svg'] ? 'svg="'.$variation['svg'].'"' : ''; 
                                    echo '<label class="cont-variations">';
                                    echo '<input type="radio" name="variation-'.sanitize_title($value['nameAttribute']).'" value="'.$variation['name'].'" '.$svg.' attribute="'.$value['nameAttribute'].'" price="'.$variation['price'].'" post="'.$product_id.'" '.$btns.'>';
                                    echo '<picture>';
                                    echo '<img src="'.$variation['icon'].'" class="radioVariationImg">';
                                    echo '</picture>';
                                    echo '<span class="">'.$variation['name'].'</span>';
                                    echo '</label>';
                                }
                            }
                        }
                        echo '</div>';
                        
                        if( $n === 1 ){
                            echo '<div>';
                            echo '<h5 style="text-align: center">'.esc_html__('Añade un texto personalizado', bwd_plugin_data( 'TextDomain' )).'</h5>';
                            echo '<textarea name="text_pers" rows="3"></textarea>';
                            echo '</div>';
                        }

                        if( $value['colorAttribute'] )
                        {
                            echo '<div class="radioColor-'.$n.'" id="color-'.strtolower(sanitize_title($value['nameAttribute'])).'">';
                            
                            if( $variations ){
                                foreach ( $variations as $variation ) 
                                {
                                    $CV = get_post_meta( $product_id, 'ps_colors_variations_dp', true );
                                    if($CV){
                                        foreach ( $CV as $v ) {
                                            if( $v['variation'] == $variation['name'] ){
                                                echo '<div class="contentButtonsColor">';
                                                echo '<button class="btnColores" fill="'.$v['fill'].'" variation="'.$v['variation'].'" attribute="'.$value['nameAttribute'].'" product="'.$product_id.'">'.$v['name'].'</button>';
                                                echo '<div class="valuesColors"></div>';
                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                            }
                            echo '</div>';
                        }
                    echo '</div>';
                    $n++;
                }
            }
        ?>
        
    </div>
 
    <!-- Include optional progressbar HTML -->
    <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>  