<?php
$product_id = isset( $_POST['product'] ) ?  $_POST['product']  : '';
$attribute = isset( $_POST['attribute'] ) ?  $_POST['attribute'] : '';
$colors = get_post_meta( $product_id, 'ps_colors_dp', true );
if( $colors ){
    ob_start();
    foreach ( $colors as $color )
    {
        if( $color['stock'] )
        { ?>

            <div class="content-colors">
            <input type="radio" name="color-<?php echo $attribute ?>" value="<?php echo $color['name'] ?>" color="<?php echo $color['color'] ?>" price="<?php echo $color['price'] ?>" post="<?php echo $product_id ?>">
            <picture class="tooltip top">
            <div style="background-color:<?php echo $color['color'] ?>"></div>
            <span class="tiptext"><?php echo $color['name'] ?></span>
            </picture>
            </div>
        <? }
    }
    $html = ob_get_clean();
} 

$r['html'] = $html;
