<?php
function buildpro_admin_maybe_import_banner()
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
    $front_id = (int) get_option('page_on_front');
    $tpl = get_page_template_slug($post_id);
    if ($post_id !== $front_id && !empty($tpl) && $tpl !== 'home-page.php') {
        return;
    }
    $items = get_post_meta($post_id, 'buildpro_banner_items', true);
    if (is_array($items) && !empty($items)) {
        return;
    }
    $banner_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/banner-home.php');
    if (file_exists($banner_demo_file)) {
        require_once $banner_demo_file;
        if (function_exists('buildpro_import_banner_demo')) {
            buildpro_import_banner_demo();
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_banner');

function buildpro_admin_maybe_import_option()
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
    $front_id = (int) get_option('page_on_front');
    $tpl = get_page_template_slug($post_id);
    if ($post_id !== $front_id && !empty($tpl) && $tpl !== 'home-page.php') {
        return;
    }
    $items = get_post_meta($post_id, 'buildpro_option_items', true);
    if (is_array($items) && !empty($items)) {
        return;
    }
    $option_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/option-home.php');
    if (file_exists($option_demo_file)) {
        require_once $option_demo_file;
        if (function_exists('buildpro_import_option_demo')) {
            buildpro_import_option_demo();
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_option');

function buildpro_admin_maybe_import_data()
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
    $front_id = (int) get_option('page_on_front');
    $tpl = get_page_template_slug($post_id);
    if ($post_id !== $front_id && !empty($tpl) && $tpl !== 'home-page.php') {
        return;
    }
    $items = get_post_meta($post_id, 'buildpro_data_items', true);
    if (is_array($items) && !empty($items)) {
        return;
    }
    $data_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/data-home.php');
    if (file_exists($data_demo_file)) {
        require_once $data_demo_file;
        if (function_exists('buildpro_import_data_demo')) {
            buildpro_import_data_demo();
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_data');

function buildpro_admin_maybe_import_services()
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
    $front_id = (int) get_option('page_on_front');
    $tpl = get_page_template_slug($post_id);
    if ($post_id !== $front_id && !empty($tpl) && $tpl !== 'home-page.php') {
        return;
    }
    $items = get_post_meta($post_id, 'buildpro_service_items', true);
    if (is_array($items) && !empty($items)) {
        return;
    }
    $service_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/service-home.php');
    if (file_exists($service_demo_file)) {
        require_once $service_demo_file;
        if (function_exists('buildpro_import_service_demo')) {
            buildpro_import_service_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_services');
