<?php
    $parentAttribute = isset( $value['nameAttribute'] ) ? $value['nameAttribute'] : '';

    $name   = isset( $variation['name'] ) ? $variation['name'] : '';
    $price  = isset( $variation['price'] ) ? $variation['price'] : '';
    $icon   = isset( $variation['icon'] ) ? $variation['icon'] : '';
    $svg    = isset( $variation['svg'] ) ? $variation['svg'] : '';
    $stock  = isset( $variation['stock'] ) ? bwd_checked( $variation['stock'] ) : '';
?>

<tr class="variation_dp" parent-attribute="<?php echo $parentAttribute ?>">
    <td>
        <div class="input-group">
            <input type="text" class="form-control" value="<?php echo $name ?>" name="variationName" placeholder="Variations Name">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" value="<?php echo $price ?>" name="variationPrice" class="form-control">
        </div>
    </td>
    <td class="align-middle text-center">
        <button type="button" class="button button-primary button-large add_svg_or_icon" context="add_icon" onclick="load_image(this)"><?php esc_html_e('Add', bwd_plugin_data( 'TextDomain' ) ) ?></button>
        <input type="hidden" name="add_icon" value="<?php echo $icon ?>">
    </td>
    <td class="align-middle text-center">
        <button type="button" class="button button-primary button-large add_svg_or_icon" context="add_svg" onclick="load_image(this)"><?php esc_html_e('Add', bwd_plugin_data( 'TextDomain' ) ) ?></button>
        <input type="hidden" name="add_svg" value="<?php echo $svg ?>">
    </td>
    <td class="align-middle text-center">
        <input class="form-check-input" type="checkbox" name="variationStock" <?php echo $stock ?>>
    </td>
    <td class="align-middle text-center">
        <span class="dashicons dashicons-dismiss" onclick="delete_items(this)"></span>
    </td>
</tr>