<?php
    $attributeName  = isset( $value['nameAttribute'] ) ? $value['nameAttribute'] : '';
    $svgChecked     = isset( $value['svgAttribute'] ) ? bwd_checked( $value['svgAttribute'] ) : '';
    $colorChecked   = isset( $value['colorAttribute'] ) ? bwd_checked( $value['colorAttribute'] ) : '';
?>

<tr attribute="<?php echo $attributeName ?>">
    <td>
        <div class="input-group">
            <input type="text" name="attributeName" class="form-control" value="<?php echo $attributeName ?>" placeholder="Attribute Name">
        </div>
    </td>
    <td class="align-middle text-center">
        <input type="checkbox" name="svg" class="form-check-input" <?php echo $svgChecked ?>>
    </td>
    <td class="align-middle text-center">
        <input type="checkbox" name="color" class="form-check-input" <?php echo $colorChecked ?>>
    </td>
    <td class="align-middle text-center">
        <span class="dashicons dashicons-dismiss" typeItems="attributes" onclick="delete_items(this)"></span>
    </td>
</tr>