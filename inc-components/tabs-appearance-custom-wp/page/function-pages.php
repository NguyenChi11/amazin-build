<?php
$dirs = array(
    'inc-components/tabs-appearance-custom-wp/page/home',
    'inc-components/tabs-appearance-custom-wp/page/projects',
);
foreach ($dirs as $rel) {
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
