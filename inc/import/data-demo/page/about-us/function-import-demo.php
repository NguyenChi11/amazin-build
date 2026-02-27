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

function buildpro_admin_maybe_import_about_leader()
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
    $force = isset($_GET['buildpro_reimport']) && $_GET['buildpro_reimport'] === 'about_leader';
    $leader_items = get_post_meta($post_id, 'buildpro_about_leader_items', true);
    if (!$force && is_array($leader_items) && !empty($leader_items)) {
        return;
    }
    $demo_file = get_theme_file_path('/inc/import/data-demo/page/about-us/leader-about-us.php');
    if (file_exists($demo_file)) {
        require_once $demo_file;
        if (function_exists('buildpro_import_about_us_leader_demo')) {
            buildpro_import_about_us_leader_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_about_leader');

function buildpro_admin_maybe_import_about_policy()
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
    $force = isset($_GET['buildpro_reimport']) && $_GET['buildpro_reimport'] === 'about_policy';
    $items = get_post_meta($post_id, 'buildpro_about_policy_items', true);
    $certs = get_post_meta($post_id, 'buildpro_about_policy_certifications', true);
    if (!$force && ((is_array($items) && !empty($items)) || (is_array($certs) && !empty($certs)))) {
        return;
    }
    $demo_file = get_theme_file_path('/inc/import/data-demo/page/about-us/policy-about-us.php');
    if (file_exists($demo_file)) {
        require_once $demo_file;
        if (function_exists('buildpro_import_about_us_policy_demo')) {
            buildpro_import_about_us_policy_demo($post_id);
        }
    }
}
add_action('current_screen', 'buildpro_admin_maybe_import_about_policy');

function buildpro_admin_maybe_import_about_contact()
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
    $force = isset($_GET['buildpro_reimport']) && $_GET['buildpro_reimport'] === 'about_contact';
    $contact_items = get_post_meta($post_id, 'buildpro_about_contact_items', true);
    if (!$force && is_array($contact_items) && !empty($contact_items)) {
        return;
    }
    $demo_file = get_theme_file_path('/inc/import/data-demo/page/about-us/contact-about-us.php');
    if (file_exists($demo_file)) {
        require_once $demo_file;
        if (function_exists('buildpro_import_about_us_contact_demo')) {
            buildpro_import_about_us_contact_demo($post_id);
        }
    }
}

add_action('current_screen', 'buildpro_admin_maybe_import_about_contact');
