<?php
$post_id        = isset( $_POST['post'] ) ?  $_POST['post']  : 0;
$getAttributes  = get_post_meta( $post_id , 'ps_attributes_dp', true );
if( !empty($getAttributes)){
    ob_start();
    foreach ( $getAttributes as $value )
    {  
        require INC_FOLDER_PATH . 'templates/items/items-accordion-variations.php';
    }
    $r['html'] = ob_get_clean();
    $r['r'] = true;
}
