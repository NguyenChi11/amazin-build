<?php
if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

function buildpro_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	));

	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'buildpro'),
		)
	);
}
add_action('after_setup_theme', 'buildpro_setup');

require get_template_directory() . '/import-assets/import-css-js.php';
require get_template_directory() . '/inc/header-functions.php';
require get_template_directory() . '/inc/components/page/page-function.php';
require get_template_directory() . '/inc-components/tabs-appearance-custom-wp/page/function-pages.php';
require get_template_directory() . '/inc-components/tabs-appearance-custom-wp/function.php';
require get_template_directory() . '/inc/footer-functions.php';
require get_template_directory() . '/inc/components/cpt/cpt-function.php';
require get_template_directory() . '/inc/import/data-demo/page/home/function-import-demo.php';



function buildpro_svg_icon($name, $style = 'solid', $class = '')
{
	static $icons = null;
	if ($icons === null) {
		$icons = array();
		$paths = array(
			get_theme_file_path('/assets/svg/logo-svg-icons/icons-v6-0.php'),
			get_theme_file_path('/assets/svg/logo-svg-icons/icons-v6-1.php'),
			get_theme_file_path('/assets/svg/logo-svg-icons/icons-v6-2.php'),
			get_theme_file_path('/assets/svg/logo-svg-icons/icons-v6-3.php'),
		);
		foreach ($paths as $p) {
			if (file_exists($p)) {
				$icons = array_merge($icons, require $p);
			}
		}
	}
	if (!isset($icons[$name]['svg'][$style])) {
		return '';
	}
	$def = $icons[$name]['svg'][$style];
	$w = isset($def['width']) ? (int) $def['width'] : 512;
	$h = isset($def['height']) ? (int) $def['height'] : 512;
	$path = isset($def['path']) ? $def['path'] : '';
	$cls = $class ? ' class="' . esc_attr($class) . '"' : '';
	return '<svg' . $cls . ' width="1em" height="1em" viewBox="0 0 ' . $w . ' ' . $h . '" fill="currentColor" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="' . $path . '"></path></svg>';
}

function buildpro_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'buildpro'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'buildpro'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'buildpro_widgets_init');

if (function_exists('acf_add_options_page')) {
	// acf_add_options_page(array(
	// 	'page_title' => 'Header Settings',
	// 	'menu_title' => 'Header',
	// 	'menu_slug' => 'header-settings',
	// 	'capability' => 'edit_posts',
	// 	'redirect' => false,
	// 	'parent_slug' => 'themes.php',
	// ));
	// acf_add_options_page(array(
	// 	'page_title' => 'Footer Settings',
	// 	'menu_title' => 'Footer',
	// 	'menu_slug' => 'footer-settings',
	// 	'capability' => 'edit_posts',
	// 	'redirect' => false,
	// 	'parent_slug' => 'themes.php',
	// ));
}

function buildpro_register_project_cpt()
{
	$labels = array(
		'name' => 'Projects',
		'singular_name' => 'Project',
		'menu_name' => 'Projects',
		'name_admin_bar' => 'Project',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Project',
		'new_item' => 'New Project',
		'edit_item' => 'Edit Project',
		'view_item' => 'View Project',
		'all_items' => 'All Projects',
		'search_items' => 'Search Projects',
		'not_found' => 'No projects found',
		'not_found_in_trash' => 'No projects found in Trash',
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
		'has_archive' => true,
		'rewrite' => array('slug' => 'projects'),
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-portfolio',
	);
	register_post_type('project', $args);
}

add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
	if (isset($item->object) && $item->object === 'page' && !empty($item->object_id)) {
		$atts['data-object-id'] = (string) absint($item->object_id);
		$atts['data-object-type'] = 'page';
	}
	return $atts;
}, 10, 3);
add_action('init', 'buildpro_register_project_cpt');

function buildpro_register_project_taxonomies()
{
	$labels = array(
		'name'              => 'Project Contruction',
		'singular_name'     => 'Project Contruction',
		'search_items'      => 'Search Project Contruction',
		'all_items'         => 'All Project Contruction',
		'parent_item'       => 'Parent Project Contruction',
		'parent_item_colon' => 'Parent Project Contruction:',
		'edit_item'         => 'Edit Project Contruction',
		'update_item'       => 'Update Project Contruction',
		'add_new_item'      => 'Add New Project Contruction',
		'new_item_name'     => 'New Project Contruction Name',
		'menu_name'         => 'Project Contruction',
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'project-contruction'),
		'show_in_rest'      => true,
	);
	register_taxonomy('project-contruction', array('project'), $args);
}
add_action('init', 'buildpro_register_project_taxonomies');

function buildpro_import_parse_js($rel_file, $const_name)
{
	$path = get_theme_file_path($rel_file);
	if (!file_exists($path)) {
		return array();
	}
	$s = file_get_contents($path);
	if (!is_string($s) || $s === '') {
		return array();
	}
	$re = '/const\s+' . preg_quote($const_name, '/') . '\s*=\s*(\{[\s\S]*?\});/m';
	if (!preg_match($re, $s, $m)) {
		return array();
	}
	$obj = $m[1];
	$obj = rtrim($obj, ';');
	$json = preg_replace('/([,{]\s*)([A-Za-z_][A-Za-z0-9_]*)\s*:/', '$1"$2":', $obj);
	$json = preg_replace('/,\s*]/', ']', $json);
	$json = preg_replace('/,\s*}/', '}', $json);
	$data = json_decode($json, true);
	return is_array($data) ? $data : array();
}

function buildpro_import_resolve_theme_path($url)
{
	$rel = preg_replace('#^/wp-content/themes/buildpro#', '', $url);
	$rel = '/' . ltrim($rel, '/');
	$path = get_theme_file_path($rel);
	return $path;
}

function buildpro_import_find_attachment_by_source($src)
{
	$q = new WP_Query(array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
		'meta_query' => array(
			array('key' => 'buildpro_source_file', 'value' => $src, 'compare' => '='),
		),
		'fields' => 'ids',
		'no_found_rows' => true,
	));
	if ($q->have_posts()) {
		$ids = $q->posts;
		return isset($ids[0]) ? (int)$ids[0] : 0;
	}
	return 0;
}

function buildpro_import_copy_to_uploads($src_path)
{
	if (!file_exists($src_path)) {
		return 0;
	}
	$uploads = wp_upload_dir();
	$base = trailingslashit($uploads['basedir']) . 'buildpro-imports';
	if (!is_dir($base)) {
		wp_mkdir_p($base);
	}
	$name = basename($src_path);
	$dest = trailingslashit($base) . $name;
	$i = 1;
	while (file_exists($dest)) {
		$pi = pathinfo($name);
		$alt = $pi['filename'] . '-' . $i . (isset($pi['extension']) ? '.' . $pi['extension'] : '');
		$dest = trailingslashit($base) . $alt;
		$i++;
	}
	if (!copy($src_path, $dest)) {
		return 0;
	}
	$ft = wp_check_filetype($dest, null);
	$att = array(
		'post_mime_type' => $ft['type'],
		'post_title' => sanitize_file_name(basename($dest)),
		'post_content' => '',
		'post_status' => 'inherit',
	);
	$attach_id = wp_insert_attachment($att, $dest);
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$meta = wp_generate_attachment_metadata($attach_id, $dest);
	wp_update_attachment_metadata($attach_id, $meta);
	update_post_meta($attach_id, 'buildpro_source_file', $src_path);
	return (int)$attach_id;
}

function buildpro_import_image_id($url)
{
	if (!is_string($url) || $url === '') {
		return 0;
	}
	$src = buildpro_import_resolve_theme_path($url);
	$exist = buildpro_import_find_attachment_by_source($src);
	if ($exist) {
		return $exist;
	}
	return buildpro_import_copy_to_uploads($src);
}

function buildpro_import_slug_from_link($link)
{
	$p = parse_url($link);
	$path = isset($p['path']) ? $p['path'] : '';
	$slug = basename($path);
	return sanitize_title($slug);
}

function buildpro_import_create_material($item)
{
	$title = isset($item['title']) ? $item['title'] : '';
	$slug = isset($item['link']) ? buildpro_import_slug_from_link($item['link']) : sanitize_title($title);
	if ($slug) {
		$exists = get_page_by_path($slug, OBJECT, 'material');
		if ($exists) {
			return (int)$exists->ID;
		}
	}
	$post_id = wp_insert_post(array(
		'post_type' => 'material',
		'post_status' => 'publish',
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => isset($item['description']) ? $item['description'] : '',
	));
	$img = isset($item['image']) ? buildpro_import_image_id($item['image']) : 0;
	if ($img) {
		set_post_thumbnail($post_id, $img);
	}
	$banner = 0;
	if (isset($item['banner']) && is_array($item['banner']) && !empty($item['banner'])) {
		$banner = buildpro_import_image_id($item['banner'][0]);
	}
	update_post_meta($post_id, 'price_material', isset($item['price']) ? $item['price'] : '');
	update_post_meta($post_id, 'material_banner_id', $banner);
	$gids = array();
	if (isset($item['gallery']) && is_array($item['gallery'])) {
		foreach ($item['gallery'] as $g) {
			$id = buildpro_import_image_id($g);
			if ($id) {
				$gids[] = $id;
			}
		}
	}
	update_post_meta($post_id, 'material_gallery_ids', $gids);
	update_post_meta($post_id, 'material_description', isset($item['description']) ? $item['description'] : '');
	return (int)$post_id;
}

function buildpro_import_create_post($item)
{
	$title = isset($item['title']) ? $item['title'] : '';
	$slug = isset($item['link']) ? buildpro_import_slug_from_link($item['link']) : sanitize_title($title);
	if ($slug) {
		$exists = get_page_by_path($slug, OBJECT, 'post');
		if ($exists) {
			return (int)$exists->ID;
		}
	}
	$date = isset($item['date']) ? $item['date'] : '';
	$postarr = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => isset($item['description']) ? $item['description'] : '',
	);
	if ($date) {
		$postarr['post_date'] = $date;
		$postarr['post_date_gmt'] = get_gmt_from_date($date);
	}
	$post_id = wp_insert_post($postarr);
	$img = isset($item['image']) ? buildpro_import_image_id($item['image']) : 0;
	if ($img) {
		set_post_thumbnail($post_id, $img);
	}
	$banner = 0;
	if (isset($item['banner']) && is_array($item['banner']) && !empty($item['banner'])) {
		$banner = buildpro_import_image_id($item['banner'][0]);
	}
	update_post_meta($post_id, 'buildpro_post_banner_id', $banner);
	update_post_meta($post_id, 'buildpro_post_description', isset($item['description']) ? $item['description'] : '');
	$gids = array();
	if (isset($item['gallery']) && is_array($item['gallery'])) {
		foreach ($item['gallery'] as $g) {
			$id = buildpro_import_image_id($g);
			if ($id) {
				$gids[] = $id;
			}
		}
	}
	update_post_meta($post_id, 'buildpro_post_quote_gallery', $gids);
	return (int)$post_id;
}

function buildpro_import_create_project($item)
{
	$title = isset($item['title']) ? $item['title'] : '';
	$slug = sanitize_title($title);
	if ($slug) {
		$exists = get_page_by_path($slug, OBJECT, 'project');
		if ($exists) {
			return (int)$exists->ID;
		}
	}
	$post_id = wp_insert_post(array(
		'post_type' => 'project',
		'post_status' => 'publish',
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => isset($item['about']) ? $item['about'] : '',
	));
	$img = isset($item['image']) ? buildpro_import_image_id($item['image']) : 0;
	if ($img) {
		set_post_thumbnail($post_id, $img);
	}
	$banner = 0;
	if (isset($item['gallery']) && is_array($item['gallery']) && !empty($item['gallery'])) {
		$banner = buildpro_import_image_id($item['gallery'][0]);
	}
	update_post_meta($post_id, 'project_banner_id', $banner);
	update_post_meta($post_id, 'location_project', isset($item['location']) ? $item['location'] : '');
	update_post_meta($post_id, 'about_project', isset($item['about']) ? $item['about'] : '');
	update_post_meta($post_id, 'price_project', isset($item['price']) ? $item['price'] : '');
	update_post_meta($post_id, 'date_time_project', isset($item['dateTime']) ? $item['dateTime'] : '');
	$gids = array();
	if (isset($item['gallery']) && is_array($item['gallery'])) {
		foreach ($item['gallery'] as $g) {
			$id = buildpro_import_image_id($g);
			if ($id) {
				$gids[] = $id;
			}
		}
	}
	update_post_meta($post_id, 'project_gallery_ids', $gids);
	$standards = array();
	if (isset($item['standards']) && is_array($item['standards'])) {
		foreach ($item['standards'] as $st) {
			$iid = isset($st['image']) ? buildpro_import_image_id($st['image']) : 0;
			$standards[] = array(
				'image_id' => $iid,
				'title' => isset($st['title']) ? $st['title'] : '',
				'description' => isset($st['description']) ? $st['description'] : '',
			);
		}
	}
	update_post_meta($post_id, 'project_standards', $standards);
	return (int)$post_id;
}

function buildpro_schedule_default_import()
{
	if (!get_option('buildpro_default_content_imported')) {
		update_option('buildpro_do_import', '1');
	}
}
add_action('after_switch_theme', 'buildpro_schedule_default_import');

function buildpro_maybe_import_default_content()
{
	if (get_option('buildpro_do_import') === '1') {
		$wc_active = class_exists('WooCommerce') || function_exists('wc_get_product');
		$materials = buildpro_import_parse_js('/assets/data/product-data.js', 'materialsData');
		if (isset($materials['items']) && is_array($materials['items'])) {
			foreach ($materials['items'] as $it) {
				buildpro_import_create_material($it);
			}
		}
		$posts = buildpro_import_parse_js('/assets/data/post-data.js', 'postsData');
		if (isset($posts['items']) && is_array($posts['items'])) {
			foreach ($posts['items'] as $it) {
				buildpro_import_create_post($it);
			}
		}
		$projects = buildpro_import_parse_js('/assets/data/project-data.js', 'projectsData');
		if (isset($projects['items']) && is_array($projects['items'])) {
			foreach ($projects['items'] as $it) {
				buildpro_import_create_project($it);
			}
		}
		$banner_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/banner-home.php');
		if (file_exists($banner_demo_file)) {
			require_once $banner_demo_file;
			if (function_exists('buildpro_import_banner_demo')) {
				buildpro_import_banner_demo();
			}
		}
		$option_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/option-home.php');
		if (file_exists($option_demo_file)) {
			require_once $option_demo_file;
			if (function_exists('buildpro_import_option_demo')) {
				buildpro_import_option_demo();
			}
		}
		$footer_demo_file = get_theme_file_path('/inc/import/data-demo/footer-demo.php');
		if (file_exists($footer_demo_file)) {
			require_once $footer_demo_file;
			if (function_exists('buildpro_import_footer_demo')) {
				buildpro_import_footer_demo();
			}
		}
		$service_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/service-home.php');
		if (file_exists($service_demo_file)) {
			require_once $service_demo_file;
			if (function_exists('buildpro_import_service_demo')) {
				$home_id = 0;
				if (function_exists('buildpro_services_find_home_id')) {
					$home_id = buildpro_services_find_home_id();
				}
				if ($home_id <= 0 && function_exists('buildpro_banner_find_home_id')) {
					$home_id = buildpro_banner_find_home_id();
				}
				if ($home_id <= 0) {
					$home_id = (int) get_option('page_on_front');
				}
				buildpro_import_service_demo($home_id);
			}
		}
		$data_demo_file = get_theme_file_path('/inc/import/data-demo/page/home/data-home.php');
		if (file_exists($data_demo_file)) {
			require_once $data_demo_file;
			if (function_exists('buildpro_import_data_demo')) {
				buildpro_import_data_demo();
			}
		}
		if ($wc_active) {
			$wcProducts = buildpro_import_parse_js('/assets/data/woocommerce-product-data.js', 'woocommerceProductData');
			if (isset($wcProducts['items']) && is_array($wcProducts['items'])) {
				foreach ($wcProducts['items'] as $it) {
					buildpro_import_create_wc_product($it);
				}
			}
			update_option('buildpro_wc_default_content_imported', '1');
		} else {
			update_option('buildpro_wc_do_import', '1');
		}
		update_option('buildpro_do_import', '0');
		update_option('buildpro_default_content_imported', '1');
	}
}
add_action('init', 'buildpro_maybe_import_default_content');

function buildpro_import_create_wc_product($item)
{
	if (!(class_exists('WooCommerce') || function_exists('wc_get_product'))) {
		return 0;
	}
	$title = isset($item['title']) ? $item['title'] : '';
	$slug = isset($item['link']) ? buildpro_import_slug_from_link($item['link']) : sanitize_title($title);
	if ($slug) {
		$exists = get_page_by_path($slug, OBJECT, 'product');
		if ($exists) {
			return (int)$exists->ID;
		}
	}
	$post_id = wp_insert_post(array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'post_title' => $title,
		'post_name' => $slug,
		'post_content' => isset($item['description']) ? $item['description'] : '',
		'post_excerpt' => isset($item['shortDescription']) ? $item['shortDescription'] : '',
	));
	$img = isset($item['image']) ? buildpro_import_image_id($item['image']) : 0;
	if ($img) {
		set_post_thumbnail($post_id, $img);
	}
	$gids = array();
	if (isset($item['gallery']) && is_array($item['gallery'])) {
		foreach ($item['gallery'] as $g) {
			$id = buildpro_import_image_id($g);
			if ($id) {
				$gids[] = $id;
			}
		}
	}
	if (!empty($gids)) {
		update_post_meta($post_id, '_product_image_gallery', implode(',', array_map('intval', $gids)));
	}
	$reg = isset($item['regularPrice']) ? (string)$item['regularPrice'] : '';
	$sale = isset($item['salePrice']) ? (string)$item['salePrice'] : '';
	if ($sale !== '') {
		update_post_meta($post_id, '_sale_price', $sale);
		update_post_meta($post_id, '_price', $sale);
	}
	if ($reg !== '') {
		update_post_meta($post_id, '_regular_price', $reg);
		if ($sale === '') {
			update_post_meta($post_id, '_price', $reg);
		}
	}
	wp_set_object_terms($post_id, 'simple', 'product_type', false);
	wp_set_object_terms($post_id, 'visible', 'product_visibility', false);
	$cat = isset($item['category']) ? $item['category'] : '';
	if ($cat !== '') {
		$term = term_exists($cat, 'product_cat');
		if (!$term || is_wp_error($term)) {
			$term = wp_insert_term($cat, 'product_cat');
		}
		if (is_array($term) && isset($term['term_id'])) {
			wp_set_object_terms($post_id, (int)$term['term_id'], 'product_cat', false);
		} elseif (is_numeric($term)) {
			wp_set_object_terms($post_id, (int)$term, 'product_cat', false);
		}
	}
	$attrs = isset($item['attributes']) && is_array($item['attributes']) ? $item['attributes'] : array();
	$meta_attrs = array();
	$pos = 0;
	foreach ($attrs as $name => $value) {
		$key = sanitize_title($name);
		$meta_attrs[$key] = array(
			'name' => $name,
			'value' => is_array($value) ? implode(' | ', $value) : (string)$value,
			'position' => $pos,
			'is_visible' => 1,
			'is_variation' => 0,
			'is_taxonomy' => 0,
		);
		$pos++;
	}
	if (!empty($meta_attrs)) {
		update_post_meta($post_id, '_product_attributes', $meta_attrs);
	}
	$typical = isset($item['typicalRange']) ? $item['typicalRange'] : '';
	if ($typical !== '') {
		update_post_meta($post_id, 'typical_range', $typical);
	}
	return (int)$post_id;
}

function buildpro_maybe_import_wc_products()
{
	$need = get_option('buildpro_wc_do_import') === '1';
	$active = class_exists('WooCommerce') || function_exists('wc_get_product');
	if ($need && $active) {
		$wcProducts = buildpro_import_parse_js('/assets/data/woocommerce-product-data.js', 'woocommerceProductData');
		if (isset($wcProducts['items']) && is_array($wcProducts['items'])) {
			foreach ($wcProducts['items'] as $it) {
				buildpro_import_create_wc_product($it);
			}
		}
		update_option('buildpro_wc_do_import', '0');
		update_option('buildpro_wc_default_content_imported', '1');
	}
}
add_action('init', 'buildpro_maybe_import_wc_products', 20);
if (function_exists('add_action')) {
	add_action('woocommerce_init', 'buildpro_maybe_import_wc_products');
}

function buildpro_run_wc_import_now()
{
	$active = class_exists('WooCommerce') || function_exists('wc_get_product');
	if (!$active) {
		return;
	}
	$wcProducts = buildpro_import_parse_js('/assets/data/woocommerce-product-data.js', 'woocommerceProductData');
	if (isset($wcProducts['items']) && is_array($wcProducts['items'])) {
		foreach ($wcProducts['items'] as $it) {
			buildpro_import_create_wc_product($it);
		}
	}
	update_option('buildpro_wc_do_import', '0');
	update_option('buildpro_wc_default_content_imported', '1');
}

function buildpro_on_plugin_activated($plugin)
{
	if ($plugin === 'woocommerce/woocommerce.php') {
		buildpro_run_wc_import_now();
	}
}
add_action('activated_plugin', 'buildpro_on_plugin_activated', 10, 1);
