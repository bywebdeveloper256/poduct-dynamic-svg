<?php

ob_start();
require INC_FOLDER_PATH . 'templates/items/items-colors.php';
$html = ob_get_clean();

$r['r'] = true;
$r['html'] = $html;