<?php
function buildpro_material_info_add_meta_box($post_type, $post)
{
	if ($post_type !== 'material') {
		return;
	}
	add_meta_box('buildpro_material_tab_info', 'Info', 'buildpro_material_info_render_meta_box', 'material', 'normal', 'default');
}
add_action('add_meta_boxes', 'buildpro_material_info_add_meta_box', 10, 2);

function buildpro_material_info_render_meta_box($post)
{
	$price = get_post_meta($post->ID, 'price_material', true);
	$desc = get_post_meta($post->ID, 'material_description', true);
	echo '<style>
	.buildpro-post-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
	.buildpro-post-field{margin:10px 0}
	.buildpro-post-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
	.buildpro-post-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
	</style>';
	echo '<div id="buildpro_material_tab_info" class="buildpro-post-block">';
	echo '<p class="buildpro-post-field"><label>Price</label><input type="text" name="price_material" class="regular-text" value="' . esc_attr($price) . '" placeholder="100"></p>';
	echo '<p class="buildpro-post-field"><label>Description</label><textarea name="material_description" rows="4" class="large-text">' . esc_textarea($desc) . '</textarea></p>';
	echo '</div>';
}
