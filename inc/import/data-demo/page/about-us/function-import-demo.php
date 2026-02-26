<?php
function buildpro_admin_maybe_import_about_banner()
{
    if (!is_admin()) {
        return;
    }

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
    if ($post_id <= 0) {
        return;
    }
    if (get_post_type($post_id) !== 'page') {
        return;
    }
    $tpl = get_page_template_slug($post_id);
    if (empty($tpl) || $tpl !== 'about-page.php') {
        return;
    }
    $force = isset($_GET['buildpro_reimport']) && $_GET['buildpro_reimport'] === 'about_banner';
    $banner = get_post_meta($post_id, 'buildpro_about_banner', true);
    if (!$force && is_array($banner) && !empty($banner)) {
        return;
    }
    $demo_file = get_theme_file_path('/inc/import/data-demo/page/about-us/banner-about-us.php');
    if (file_exists($demo_file)) {
        require_once $demo_file;
        if (function_exists('buildpro_import_about_us_banner_demo')) {
            buildpro_import_about_us_banner_demo($post_id);
        }
    }
}

add_action('current_screen', 'buildpro_admin_maybe_import_about_banner');



function buildpro_admin_maybe_import_about_core_values()
{
    if (!is_admin()) {
        return;
    }
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || $screen->base !== 'post') {
        return;
    }
    $post_id = isset($_GET['post']) ? absint($_GET['post']) : 0;
    if ($post_id <= 0) {
        return;
    }
    if (get_post_type($post_id) !== 'page') {
        return;
    }
    $tpl = get_page_template_slug($post_id);
    if (empty($tpl) || $tpl !== 'about-page.php') {
        return;
    }
    $force = isset($_GET['buildpro_reimport']) && $_GET['buildpro_reimport'] === 'about_core_values';
    $items = get_post_meta($post_id, 'buildpro_about_core_values_items', true);
    if (!$force && is_array($items) && !empty($items)) {
        return;
    }
    $demo_file = get_theme_file_path('/inc/import/data-demo/page/about-us/core-value-about-us.php');
    if (file_exists($demo_file)) {
        require_once $demo_file;
        if (function_exists('buildpro_import_about_us_core_values_demo')) {
            buildpro_import_about_us_core_values_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_about_core_values');
