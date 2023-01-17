<?php

ob_start();
require INC_FOLDER_PATH . 'templates/items/items-colors-variations.php';
$html = ob_get_clean();

$r['r'] = true;
$r['html'] = $html;