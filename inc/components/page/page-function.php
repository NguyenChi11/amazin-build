<?php
$dir = get_theme_file_path('inc/components/page/home');
if (is_dir($dir)) {
    $files = glob($dir . '/*.php');
    if (is_array($files)) {
        foreach ($files as $file) {
            require_once $file;
        }
    }
}