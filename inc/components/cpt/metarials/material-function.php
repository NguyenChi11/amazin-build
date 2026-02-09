<?php
function buildpro_register_material_cpt()
{
	$labels = array(
		'name' => 'Materials',
		'singular_name' => 'Material',
		'menu_name' => 'Materials',
		'name_admin_bar' => 'Material',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Material',
		'new_item' => 'New Material',
		'edit_item' => 'Edit Material',
		'view_item' => 'View Material',
		'all_items' => 'All Materials',
		'search_items' => 'Search Materials',
		'not_found' => 'No materials found',
		'not_found_in_trash' => 'No materials found in Trash',
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
		'rewrite' => array('slug' => 'materials'),
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-hammer',
	);
	register_post_type('material', $args);
}
add_action('init', 'buildpro_register_material_cpt');

function buildpro_register_material_taxonomies()
{
	$labels = array(
		'name'              => 'Material Categories',
		'singular_name'     => 'Material Category',
		'search_items'      => 'Search Material Categories',
		'all_items'         => 'All Material Categories',
		'parent_item'       => 'Parent Material Category',
		'parent_item_colon' => 'Parent Material Category:',
		'edit_item'         => 'Edit Material Category',
		'update_item'       => 'Update Material Category',
		'add_new_item'      => 'Add New Material Category',
		'new_item_name'     => 'New Material Category Name',
		'menu_name'         => 'Material Categories',
	);
	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'material-category'),
		'show_in_rest'      => true,
	);
	register_taxonomy('material-category', array('material'), $args);
}
add_action('init', 'buildpro_register_material_taxonomies');

function buildpro_save_material_meta($post_id)
{
	if (!isset($_POST['buildpro_material_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_material_meta_nonce'], 'buildpro_material_meta_save')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
	if (get_post_type($post_id) !== 'material') {
		return;
	}
	$price = isset($_POST['price_material']) ? sanitize_text_field($_POST['price_material']) : '';
	$banner_id = isset($_POST['material_banner_id']) ? absint($_POST['material_banner_id']) : 0;
	$gallery_raw = isset($_POST['material_gallery_ids']) ? $_POST['material_gallery_ids'] : '';
	$desc = isset($_POST['material_description']) ? sanitize_textarea_field($_POST['material_description']) : '';
	$gallery_ids = array();
	if (is_array($gallery_raw)) {
		foreach ($gallery_raw as $gid) {
			$gallery_ids[] = absint($gid);
		}
	} elseif (is_string($gallery_raw)) {
		$gallery_ids = array_filter(array_map('absint', explode(',', $gallery_raw)));
	}
	update_post_meta($post_id, 'price_material', $price);
	update_post_meta($post_id, 'material_banner_id', $banner_id);
	update_post_meta($post_id, 'material_gallery_ids', $gallery_ids);
	update_post_meta($post_id, 'material_description', $desc);
}
add_action('save_post_material', 'buildpro_save_material_meta');
