<?php
function buildpro_project_about_add_meta_box($post_type, $post)
{
    if ($post_type !== 'project') {
        return;
    }
    add_meta_box('buildpro_project_tab_about', 'About Project', 'buildpro_project_about_render_meta_box', 'project', 'normal', 'default');
}
add_action('add_meta_boxes', 'buildpro_project_about_add_meta_box', 10, 2);

function buildpro_project_about_render_meta_box($post)
{
    $about = get_post_meta($post->ID, 'about_project', true);
    echo '<div id="buildpro_project_tab_about" class="buildpro-post-block">';
    ob_start();
    wp_editor($about, 'buildpro_project_about_editor', array('textarea_name' => 'about_project', 'textarea_rows' => 8, 'media_buttons' => true));
    $editor_html = ob_get_clean();
    echo $editor_html;
    echo '</div>';
}
