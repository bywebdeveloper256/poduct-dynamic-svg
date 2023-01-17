<?php
    if( isset( $value['nameAttribute'] ) )
    {
        $title_Attribute = $value['nameAttribute'];
        
    }else{
        $title_Attribute = isset( $_POST['attributeName'] ) ?  esc_html__( trim( $_POST['attributeName'] ) ) : '';
    }
    
    $id_Attribute = sanitize_title( $title_Attribute );
?>

<div class="accordion-item attribute_dp" id="<?php echo $id_Attribute ?>">
    <h2 class="accordion-header" id="heading-<?php echo $id_Attribute ?>">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $id_Attribute ?>" aria-expanded="true" aria-controls="collapse-<?php echo $id_Attribute ?>">
        <?php echo $title_Attribute ?>
    </button>
    </h2>
    <div id="collapse-<?php echo $id_Attribute ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $id_Attribute ?>" data-bs-parent="#ps_list_variations_dp">
        <div class="accordion-body">
            <div class="table-responsive">
                <table class="table">
                    <colgroup>
                        <col span="1" style="min-width:150px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col"><?php esc_html_e('Name', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                            <th scope="col" class="text-center"><?php esc_html_e('Price', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                            <th scope="col" class="text-center"><?php esc_html_e('Icons', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                            <th scope="col" class="text-center"><?php esc_html_e('SVG', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                            <th scope="col" class="text-center"><?php esc_html_e('Stock', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                            <th scope="col" class="text-center"><?php esc_html_e('Delete', bwd_plugin_data( 'TextDomain' ) ) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $variations = dp_get_variations_by_attribute( $post_id, $title_Attribute );
                        
                            if( !empty($variations) )
                            {
                                foreach ( $variations as $variation )
                                { 
                                    require INC_FOLDER_PATH . 'templates/items/items-variations.php';
                                
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <button type="button" typeItems="variations" context="addVariations" class="button button-primary button-large add_items_dp" parent-attribute="<?php echo $title_Attribute ?>"><?php esc_html_e('Add', bwd_plugin_data( 'TextDomain' ) ) ?> <?php echo $title_Attribute ?></button>
            </div>
        </div>
    </div>
</div>
