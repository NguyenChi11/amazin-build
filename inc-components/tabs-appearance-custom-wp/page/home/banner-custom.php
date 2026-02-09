<?php
function buildpro_banner_customize_register($wp_customize)
{
    if (!class_exists('BuildPro_Customize_Button_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_Customize_Button_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_button';
            public $button_url = '';
            public $button_text = '';
            public function render_content()
            {
                if (empty($this->button_url)) {
                    echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                    echo '<p>' . esc_html__('Không tìm thấy trang Trang chủ dùng template home-page.php', 'buildpro') . '</p>';
                    return;
                }
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                $text = $this->button_text ? $this->button_text : __('Mở trang chỉnh sửa', 'buildpro');
                echo '<a class="button button-primary" href="' . esc_url($this->button_url) . '" target="_blank" rel="noopener">' . esc_html($text) . '</a>';
            }
        }
    }
    if (!class_exists('BuildPro_Link_List_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_Link_List_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_link_list';
            public function render_content()
            {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                include get_theme_file_path('inc-components/Appearance-custom-wp/home/link/index.php');
            }
        }
    }
    if (!class_exists('BuildPro_Banner_Repeater_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_Banner_Repeater_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_banner_repeater';
            public function render_content()
            {
                $items = $this->value();
                $items = is_array($items) ? $items : array();
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                include get_theme_file_path('inc-components/Appearance-custom-wp/home/banner/index.php');
                return;
            }
        }
    }
    $home_id = (int) get_option('page_on_front');
    $edit_url = '';
    if ($home_id) {
        $tpl = get_page_template_slug($home_id);
        if ($tpl === 'home-page.php') {
            $edit_url = admin_url('post.php?post=' . $home_id . '&action=edit');
        }
    }
    if (!$edit_url) {
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'home-page.php', 'number' => 1));
        if (!empty($pages)) {
            $p = $pages[0];
            $edit_url = admin_url('post.php?post=' . $p->ID . '&action=edit');
        }
    }
    if (!function_exists('buildpro_customizer_is_home_preview')) {
        function buildpro_customizer_is_home_preview()
        {
            $selected_id = 0;
            if (function_exists('wp_get_current_user')) {
                global $wp_customize;
                if ($wp_customize && $wp_customize instanceof WP_Customize_Manager) {
                    $setting = $wp_customize->get_setting('buildpro_preview_page_id');
                    if ($setting) {
                        $val = $setting->value();
                        $selected_id = absint($val);
                    }
                }
            }
            if ($selected_id <= 0) {
                $selected_id = (int) get_option('page_on_front');
            }
            if ($selected_id > 0) {
                $tpl = get_page_template_slug($selected_id);
                if ($tpl && $tpl !== '') {
                    if ($tpl === 'home-page.php') {
                        return true;
                    }
                }
                $front = (int) get_option('page_on_front');
                if ($front && $selected_id === $front) {
                    return true;
                }
            }
            return false;
        }
    }
    $wp_customize->add_section('buildpro_banner_section', array(
        'title' => __('Banner Home', 'buildpro'),
        'priority' => 25,
        'active_callback' => 'buildpro_customizer_is_home_preview',
    ));
    $wp_customize->add_setting('buildpro_banner_edit_link', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('BuildPro_Customize_Button_Control')) {
        $wp_customize->add_control(new BuildPro_Customize_Button_Control($wp_customize, 'buildpro_banner_edit_link', array(
            'label' => __('Sửa Banner', 'buildpro'),
            'description' => __('Mở trang chỉnh sửa Banner của Trang chủ.', 'buildpro'),
            'section' => 'buildpro_banner_section',
            'button_url' => $edit_url,
            'button_text' => __('Mở trang chỉnh sửa', 'buildpro'),
        )));
    }
    $wp_customize->add_setting('buildpro_banner_items', array(
        'default' => buildpro_banner_get_default_items(),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_banner_sanitize_items',
    ));
    if (class_exists('BuildPro_Banner_Repeater_Control')) {
        $wp_customize->add_control(new BuildPro_Banner_Repeater_Control($wp_customize, 'buildpro_banner_items', array(
            'label' => __('Nội dung Banner', 'buildpro'),
            'description' => __('Thêm/sửa các mục Banner hiển thị ở Trang chủ.', 'buildpro'),
            'section' => 'buildpro_banner_section',
        )));
    }
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('buildpro_banner_items', array(
            'selector' => '.section-banner',
            'settings' => array('buildpro_banner_items'),
            'render_callback' => function () {
                ob_start();
                get_template_part('template-parts/components/section-banner/index');
                return ob_get_clean();
            },
        ));
    }
    $wp_customize->add_setting('buildpro_banner_show_nav', array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('buildpro_banner_show_nav', array(
        'label' => __('Hiển thị nút điều hướng', 'buildpro'),
        'section' => 'buildpro_banner_section',
        'type' => 'checkbox',
    ));
    $wp_customize->add_section('buildpro_link_picker_section', array(
        'title' => __('Danh sách Link', 'buildpro'),
        'priority' => 26,
        'active_callback' => 'buildpro_customizer_is_home_preview',
    ));
    $wp_customize->add_setting('buildpro_link_picker_dummy', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    if (class_exists('BuildPro_Link_List_Control')) {
        $wp_customize->add_control(new BuildPro_Link_List_Control($wp_customize, 'buildpro_link_picker_dummy', array(
            'label' => __('Chọn liên kết', 'buildpro'),
            'description' => __('Danh sách trang và bài viết để chọn làm liên kết.', 'buildpro'),
            'section' => 'buildpro_link_picker_section',
        )));
    }
}
add_action('customize_register', 'buildpro_banner_customize_register');
function buildpro_link_picker_enqueue_assets()
{
    wp_enqueue_style(
        'buildpro-link-picker-style',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/link/style.css'),
        array(),
        null
    );
    wp_enqueue_script(
        'buildpro-link-picker-script',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/link/script.js'),
        array('customize-controls'),
        null,
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'buildpro_link_picker_enqueue_assets');
function buildpro_banner_enqueue_assets()
{
    wp_enqueue_style(
        'buildpro-banner-style',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/banner/style.css'),
        array(),
        null
    );
    wp_enqueue_script(
        'buildpro-banner-script',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/banner/script.js'),
        array('customize-controls'),
        null,
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'buildpro_banner_enqueue_assets');
function buildpro_banner_find_home_id()
{
    $home_id = (int) get_option('page_on_front');
    if ($home_id) {
        $tpl = get_page_template_slug($home_id);
        if ($tpl === 'home-page.php') {
            return $home_id;
        }
    }
    $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'home-page.php', 'number' => 1));
    if (!empty($pages)) {
        return (int) $pages[0]->ID;
    }
    return 0;
}
function buildpro_banner_get_default_items()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $items = get_post_meta($home, 'buildpro_banner_items', true);
        return is_array($items) ? $items : array();
    }
    return array();
}
function buildpro_banner_sync_customizer_to_meta($wp_customize_manager)
{
    $items = get_theme_mod('buildpro_banner_items', array());
    $items = buildpro_banner_sanitize_items($items);
    $home = buildpro_banner_find_home_id();
    if ($home) {
        update_post_meta($home, 'buildpro_banner_items', $items);
    }
}
add_action('customize_save_after', 'buildpro_banner_sync_customizer_to_meta');
function buildpro_services_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $title = get_theme_mod('buildpro_service_title', '');
        $desc = get_theme_mod('buildpro_service_desc', '');
        $items = get_theme_mod('buildpro_service_items', array());
        $items = is_array($items) ? $items : array();
        $clean = array();
        foreach ($items as $item) {
            $clean[] = array(
                'icon_id' => isset($item['icon_id']) ? absint($item['icon_id']) : 0,
                'title' => isset($item['title']) ? sanitize_text_field($item['title']) : '',
                'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
                'link_url' => isset($item['link_url']) ? esc_url_raw($item['link_url']) : '',
                'link_title' => isset($item['link_title']) ? sanitize_text_field($item['link_title']) : '',
                'link_target' => isset($item['link_target']) ? sanitize_text_field($item['link_target']) : '',
            );
        }
        update_post_meta($home, 'buildpro_service_title', $title);
        update_post_meta($home, 'buildpro_service_desc', $desc);
        update_post_meta($home, 'buildpro_service_items', $clean);
    }
}
add_action('customize_save_after', 'buildpro_services_sync_customizer_to_meta');
function buildpro_evaluate_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $title = get_theme_mod('buildpro_evaluate_title', '');
        $text = get_theme_mod('buildpro_evaluate_text', '');
        $desc = get_theme_mod('buildpro_evaluate_desc', '');
        $items = get_theme_mod('buildpro_evaluate_items', array());
        $items = is_array($items) ? $items : array();
        $clean = array();
        foreach ($items as $item) {
            $clean[] = array(
                'name' => isset($item['name']) ? sanitize_text_field($item['name']) : '',
                'position' => isset($item['position']) ? sanitize_text_field($item['position']) : '',
                'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
                'avatar_id' => isset($item['avatar_id']) ? absint($item['avatar_id']) : 0,
            );
        }
        update_post_meta($home, 'buildpro_evaluate_title', $title);
        update_post_meta($home, 'buildpro_evaluate_text', $text);
        update_post_meta($home, 'buildpro_evaluate_desc', $desc);
        update_post_meta($home, 'buildpro_evaluate_items', $clean);
    }
}
add_action('customize_save_after', 'buildpro_evaluate_sync_customizer_to_meta');
function buildpro_option_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $items = get_theme_mod('buildpro_option_items', array());
        $items = is_array($items) ? $items : array();
        $clean = array();
        foreach ($items as $item) {
            $clean[] = array(
                'icon_id' => isset($item['icon_id']) ? absint($item['icon_id']) : 0,
                'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
                'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
            );
        }
        update_post_meta($home, 'buildpro_option_items', $clean);
    }
}
add_action('customize_save_after', 'buildpro_option_sync_customizer_to_meta');
function buildpro_data_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $items = get_theme_mod('buildpro_data_items', array());
        $items = is_array($items) ? $items : array();
        $clean = array();
        foreach ($items as $item) {
            $clean[] = array(
                'number' => isset($item['number']) ? sanitize_text_field($item['number']) : '',
                'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
            );
        }
        update_post_meta($home, 'buildpro_data_items', $clean);
    }
}
add_action('customize_save_after', 'buildpro_data_sync_customizer_to_meta');
function buildpro_portfolio_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $title = get_theme_mod('projects_title', '');
        $desc = get_theme_mod('projects_description', '');
        update_post_meta($home, 'projects_title', $title);
        update_post_meta($home, 'projects_description', $desc);
    }
}
add_action('customize_save_after', 'buildpro_portfolio_sync_customizer_to_meta');
function buildpro_post_section_sync_customizer_to_meta()
{
    $home = buildpro_banner_find_home_id();
    if ($home) {
        $title = get_theme_mod('title_post', '');
        $desc = get_theme_mod('description_post', '');
        update_post_meta($home, 'title_post', $title);
        update_post_meta($home, 'description_post', $desc);
    }
}
add_action('customize_save_after', 'buildpro_post_section_sync_customizer_to_meta');
function buildpro_banner_sanitize_items($value)
{
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            $value = $decoded;
        }
    }
    if (!is_array($value)) {
        return array();
    }
    $clean = array();
    foreach ($value as $item) {
        $clean[] = array(
            'image_id' => isset($item['image_id']) ? absint($item['image_id']) : 0,
            'type' => isset($item['type']) ? sanitize_text_field($item['type']) : '',
            'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
            'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
            'link_url' => isset($item['link_url']) ? esc_url_raw($item['link_url']) : '',
            'link_title' => isset($item['link_title']) ? sanitize_text_field($item['link_title']) : '',
            'link_target' => isset($item['link_target']) ? sanitize_text_field($item['link_target']) : '',
        );
    }
    return $clean;
}
function buildpro_banner_customize_controls_enqueue()
{
    wp_enqueue_media();
    wp_enqueue_script('wplink');
    wp_enqueue_style('wp-link');
}
add_action('customize_controls_enqueue_scripts', 'buildpro_banner_customize_controls_enqueue');