<?php
    $name  = isset( $value['name'] ) ? $value['name'] : '';
    $fill  = isset( $value['fill'] ) ? $value['fill'] : '';
    $variation = isset( $value['variation'] ) ? $value['variation'] : '';
?>

<tr>
    <td>
        <div class="input-group">
            <input type="text" name="VCName" class="form-control" value="<?php echo $name ?>">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="text" name="VCFill" class="form-control" value="<?php echo $fill ?>">
        </div>
    </td>
    <td class="align-middle text-center" style="min-width: 100px">
        <div class="input-group">
            <input type="text" name="VCVariations" class="form-control" value="<?php echo $variation ?>">
        </div>
    </td>
    <td class="align-middle text-center" style="min-width: 70px;">
        <span class="dashicons dashicons-dismiss" onclick="delete_items(this)"></span>
    </td>
</tr>