<?php
function buildpro_import_material_demo($target_id = 0)
{
    $home_id = (int) $target_id;
    if ($home_id <= 0 && function_exists('buildpro_banner_find_home_id')) {
        $home_id = buildpro_banner_find_home_id();
    }
    if ($home_id <= 0) {
        $home_id = (int) get_option('page_on_front');
    }
    if ($home_id <= 0) {
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'home-page.php', 'number' => 1));
        if (!empty($pages)) {
            $home_id = (int) $pages[0]->ID;
        }
    }
    if ($home_id <= 0) {
        return;
    }
    $existing = new WP_Query(array(
        'post_type'      => 'material',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'fields'         => 'ids',
    ));
    if ($existing->have_posts()) {
        wp_reset_postdata();
    } else {
        wp_reset_postdata();
        if (function_exists('buildpro_import_parse_js')) {
            $data = buildpro_import_parse_js('/assets/data/product-data.js', 'materialsData');
            if (is_array($data)) {
                $title = isset($data['materialsTitle']) ? (string) $data['materialsTitle'] : '';
                $desc  = isset($data['materialsDescription']) ? (string) $data['materialsDescription'] : '';
                if (isset($data['items']) && is_array($data['items'])) {
                    foreach ($data['items'] as $it) {
                        if (function_exists('buildpro_import_create_material')) {
                            buildpro_import_create_material($it);
                        }
                    }
                }
                if ($title !== '') {
                    update_post_meta($home_id, 'materials_title', $title);
                    set_theme_mod('materials_title', $title);
                }
                if ($desc !== '') {
                    update_post_meta($home_id, 'materials_description', $desc);
                    set_theme_mod('materials_description', $desc);
                }
            }
        }
    }
    update_post_meta($home_id, 'materials_enabled', 1);
    set_theme_mod('materials_enabled', 1);
}
