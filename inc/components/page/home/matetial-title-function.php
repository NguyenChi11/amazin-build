<?php
function buildpro_materials_add_meta_box()
{
    add_meta_box(
        'buildpro_materials_meta',
        'Materials',
        'buildpro_materials_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_materials_add_meta_box');

function buildpro_materials_render_meta_box($post)
{
    wp_nonce_field('buildpro_materials_meta_save', 'buildpro_materials_meta_nonce');
    $materials_title = get_post_meta($post->ID, 'materials_title', true);
    $materials_description = get_post_meta($post->ID, 'materials_description', true);
    echo '<style>
    .buildpro-materials-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
    .buildpro-materials-field{margin:10px 0}
    .buildpro-materials-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
    .buildpro-materials-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-materials-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
    </style>';
    echo '<div class="buildpro-materials-block" id="buildpro-materials-meta-box">';
    echo '<p class="buildpro-materials-field"><label>Tiêu đề Materials</label><input type="text" name="materials_title" class="regular-text" value="' . esc_attr($materials_title) . '" placeholder="MATERIALS"></p>';
    echo '<p class="buildpro-materials-field"><label>Mô tả</label><textarea name="materials_description" rows="4" class="large-text" placeholder="Mô tả ngắn">' . esc_textarea($materials_description) . '</textarea></p>';
    echo '</div>';
}

function buildpro_save_materials_meta($post_id)
{
    if (!isset($_POST['buildpro_materials_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_materials_meta_nonce'], 'buildpro_materials_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $materials_title = isset($_POST['materials_title']) ? sanitize_text_field($_POST['materials_title']) : '';
    $materials_description = isset($_POST['materials_description']) ? sanitize_textarea_field($_POST['materials_description']) : '';
    update_post_meta($post_id, 'materials_title', $materials_title);
    update_post_meta($post_id, 'materials_description', $materials_description);
}
add_action('save_post_page', 'buildpro_save_materials_meta');
