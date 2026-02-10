<?php
function buildpro_portfolio_add_meta_box($post_type, $post)
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
        'buildpro_portfolio_meta',
        'Portfolio',
        'buildpro_portfolio_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_portfolio_add_meta_box', 10, 2);

function buildpro_portfolio_render_meta_box($post)
{
    wp_nonce_field('buildpro_portfolio_meta_save', 'buildpro_portfolio_meta_nonce');
    $title = get_post_meta($post->ID, 'projects_title', true);
    $desc = get_post_meta($post->ID, 'projects_description', true);
    echo '<style>
    .buildpro-portfolio-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
    .buildpro-portfolio-field{margin:10px 0}
    .buildpro-portfolio-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
    .buildpro-portfolio-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-portfolio-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
    </style>';
    echo '<div id="buildpro_portfolio_meta" class="buildpro-portfolio-block">';
    echo '<p class="buildpro-portfolio-field"><label>Portfolio Title</label><input type="text" name="projects_title" class="regular-text" value="' . esc_attr($title) . '" placeholder="PROJECTS"></p>';
    echo '<p class="buildpro-portfolio-field"><label>Description</label><textarea name="projects_description" rows="4" class="large-text" placeholder="Short Description">' . esc_textarea($desc) . '</textarea></p>';
    echo '</div>';
}

function buildpro_save_portfolio_meta($post_id)
{
    if (!isset($_POST['buildpro_portfolio_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_portfolio_meta_nonce'], 'buildpro_portfolio_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $template = get_page_template_slug($post_id);
    $front_id = (int) get_option('page_on_front');
    if ($template !== 'home-page.php' && (int)$post_id !== $front_id) {
        return;
    }
    $title = isset($_POST['projects_title']) ? sanitize_text_field($_POST['projects_title']) : '';
    $desc = isset($_POST['projects_description']) ? sanitize_textarea_field($_POST['projects_description']) : '';
    update_post_meta($post_id, 'projects_title', $title);
    update_post_meta($post_id, 'projects_description', $desc);
    set_theme_mod('projects_title', $title);
    set_theme_mod('projects_description', $desc);
}
add_action('save_post_page', 'buildpro_save_portfolio_meta');
