<?php
function buildpro_post_section_add_meta_box($post_type, $post)
{
    if ($post_type !== 'page') {
        return;
    }
    $template = get_page_template_slug($post->ID);
    $front_id = (int) get_option('page_on_front');
    if ($template !== 'home-page.php' && (int)$post->ID !== $front_id) {
        return;
    }
    add_meta_box(
        'buildpro_post_section_meta',
        'Post Section',
        'buildpro_post_section_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_post_section_add_meta_box', 10, 2);

function buildpro_post_section_render_meta_box($post)
{
    wp_nonce_field('buildpro_post_section_meta_save', 'buildpro_post_section_meta_nonce');
    $title = get_post_meta($post->ID, 'title_post', true);
    $desc = get_post_meta($post->ID, 'description_post', true);
    echo '<style>
    .buildpro-post-section-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
    .buildpro-post-section-field{margin:10px 0}
    .buildpro-post-section-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
    .buildpro-post-section-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-post-section-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
    </style>';
    echo '<div class="buildpro-post-section-block">';
    echo '<p class="buildpro-post-section-field"><label>Title</label><input type="text" name="title_post" class="regular-text" value="' . esc_attr($title) . '" placeholder="LATEST POSTS"></p>';
    echo '<p class="buildpro-post-section-field"><label>Description</label><textarea name="description_post" rows="4" class="large-text" placeholder="Mô tả ngắn">' . esc_textarea($desc) . '</textarea></p>';
    echo '</div>';
}

function buildpro_save_post_section_meta($post_id)
{
    if (!isset($_POST['buildpro_post_section_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_post_section_meta_nonce'], 'buildpro_post_section_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $title = isset($_POST['title_post']) ? sanitize_text_field($_POST['title_post']) : '';
    $desc = isset($_POST['description_post']) ? sanitize_textarea_field($_POST['description_post']) : '';
    update_post_meta($post_id, 'title_post', $title);
    update_post_meta($post_id, 'description_post', $desc);
    set_theme_mod('title_post', $title);
    set_theme_mod('description_post', $desc);
}
add_action('save_post_page', 'buildpro_save_post_section_meta');
function buildpro_enqueue_posts_data_script()
{
    if (is_page_template('home-page.php')) {
        wp_enqueue_script('buildpro-posts-data', get_template_directory_uri() . '/assets/data/post-data.js', array(), _S_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'buildpro_enqueue_posts_data_script');
