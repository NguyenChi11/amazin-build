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
