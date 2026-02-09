<?php
$paths = array(
    'inc/components/cpt/metarials',
    'inc/components/cpt/post',
    'inc/components/cpt/project',
);
foreach ($paths as $rel) {
    $dir = get_theme_file_path($rel);
    if (is_dir($dir)) {
        $files = glob($dir . '/*.php');
        if (is_array($files)) {
            foreach ($files as $file) {
                require_once $file;
            }
        }
    }
}