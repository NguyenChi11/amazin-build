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

function buildpro_admin_maybe_import_evaluate()
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
    $items = get_post_meta($post_id, 'buildpro_evaluate_items', true);
    if (is_array($items) && !empty($items)) {
        return;
    }
    $evaluate_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/evaluate-home.php');
    if (file_exists($evaluate_demo_file)) {
        require_once $evaluate_demo_file;
        if (function_exists('buildpro_import_evaluate_demo')) {
            buildpro_import_evaluate_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_evaluate');

function buildpro_admin_maybe_import_product()
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
    $wc_active = class_exists('WooCommerce') || function_exists('wc_get_product');
    if (!$wc_active) {
        return;
    }
    $existing = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'fields' => 'ids',
    ));
    if ($existing->have_posts()) {
        wp_reset_postdata();
        return;
    }
    wp_reset_postdata();
    $product_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/product-home.php');
    if (file_exists($product_demo_file)) {
        require_once $product_demo_file;
        if (function_exists('buildpro_import_product_demo')) {
            buildpro_import_product_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_product');

function buildpro_admin_maybe_import_project()
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
    $existing = new WP_Query(array(
        'post_type' => 'project',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'fields' => 'ids',
    ));
    if ($existing->have_posts()) {
        wp_reset_postdata();
        return;
    }
    wp_reset_postdata();
    $project_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/project-home.php');
    if (file_exists($project_demo_file)) {
        require_once $project_demo_file;
        if (function_exists('buildpro_import_project_demo')) {
            buildpro_import_project_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_project');

function buildpro_admin_maybe_import_post()
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
    $existing = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'no_found_rows' => true,
        'fields' => 'ids',
    ));
    if ($existing->have_posts()) {
        wp_reset_postdata();
        return;
    }
    wp_reset_postdata();
    $post_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/post-home.php');
    if (file_exists($post_demo_file)) {
        require_once $post_demo_file;
        if (function_exists('buildpro_import_post_demo')) {
            buildpro_import_post_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_post');

function buildpro_admin_maybe_import_header()
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
    $logo = (int) get_theme_mod('header_logo', 0);
    $title = (string) get_theme_mod('buildpro_header_title', '');
    $desc = (string) get_theme_mod('buildpro_header_description', '');
    if ($title === '') {
        $title = (string) get_theme_mod('header_text', '');
    }
    if ($desc === '') {
        $desc = (string) get_theme_mod('header_description', '');
    }
    if ($logo || $title !== '' || $desc !== '') {
        return;
    }
    $header_demo_file = get_theme_file_path('/inc/import/data-demo/header-demo.php');
    if (file_exists($header_demo_file)) {
        require_once $header_demo_file;
        if (function_exists('buildpro_import_header_demo')) {
            buildpro_import_header_demo();
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_header');
