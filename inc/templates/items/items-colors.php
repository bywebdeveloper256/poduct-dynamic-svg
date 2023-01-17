<?php
    $colorName  = isset( $value['name'] ) ? $value['name'] : '';
    $price      = isset( $value['price'] ) ? $value['price'] : '';
    $color      = isset( $value['color'] ) ? $value['color'] : '#ffffff';
    $stock      = isset( $value['stock'] ) ? bwd_checked( $value['stock'] ) : '';
?>

<tr>
    <td>
        <div class="input-group">
            <input type="text" name="colorName" class="form-control" value="<?php echo $colorName ?>" placeholder="Color Name">
        </div>
    </td>
    <td>
        <div class="input-group">
            <input type="number" name="priceColor" class="form-control" value="<?php echo $price ?>">
        </div>
    </td>
    <td class="align-middle text-center" style="min-width: 100px">
        <div class="input-group">
            <input type="color" name="colorColor" class="form-control" value="<?php echo $color ?>" style="height: 33px">
        </div>
    </td>
    <td class="align-middle text-center" style="min-width: 70px;">
        <input type="checkbox" name="stockColor" class="form-check-input" <?php echo $stock ?>>
    </td>
    <td class="align-middle text-center" style="min-width: 70px;">
        <span class="dashicons dashicons-dismiss" onclick="delete_items(this)"></span>
    </td>
</tr>