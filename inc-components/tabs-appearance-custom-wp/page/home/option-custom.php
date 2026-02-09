<?php
function buildpro_option_customize_register($wp_customize)
{
    if (!class_exists('BuildPro_Option_Repeater_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_Option_Repeater_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_option_repeater';
            public function render_content()
            {
                $items = $this->value();
                $items = is_array($items) ? $items : array();
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                include get_theme_file_path('inc-components/Appearance-custom-wp/home/option/index.php');
                return;
            }
        }
    }
    if (!function_exists('buildpro_option_find_home_id')) {
        function buildpro_option_find_home_id()
        {
            if (function_exists('buildpro_banner_find_home_id')) {
                return buildpro_banner_find_home_id();
            }
            $selected = 0;
            if (function_exists('wp_get_current_user')) {
                global $wp_customize;
                if ($wp_customize && $wp_customize instanceof WP_Customize_Manager) {
                    $setting = $wp_customize->get_setting('buildpro_preview_page_id');
                    if ($setting) {
                        $val = $setting->value();
                        $selected = absint($val);
                    }
                }
            }
            if ($selected > 0) {
                $tpl = get_page_template_slug($selected);
                if ($tpl === 'home-page.php') {
                    return $selected;
                }
            }
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
    }
    if (!function_exists('buildpro_option_get_default_items')) {
        function buildpro_option_get_default_items()
        {
            $page_id = 0;
            if (function_exists('wp_get_current_user')) {
                global $wp_customize;
                if ($wp_customize && $wp_customize instanceof WP_Customize_Manager) {
                    $setting = $wp_customize->get_setting('buildpro_preview_page_id');
                    if ($setting) {
                        $page_id = absint($setting->value());
                    }
                }
            }
            if ($page_id <= 0) {
                $page_id = buildpro_option_find_home_id();
            }
            if ($page_id) {
                $items = get_post_meta($page_id, 'buildpro_option_items', true);
                return is_array($items) ? $items : array();
            }
            return array();
        }
    }
    if (!function_exists('buildpro_option_sanitize_items')) {
        function buildpro_option_sanitize_items($value)
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
                    'icon_id' => isset($item['icon_id']) ? absint($item['icon_id']) : 0,
                    'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
                    'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
                );
            }
            return $clean;
        }
    }
    $wp_customize->add_section('buildpro_option_section', array(
        'title' => __('Option Home', 'buildpro'),
        'priority' => 27,
        'active_callback' => 'buildpro_customizer_is_home_preview',
    ));
    $wp_customize->add_setting('buildpro_option_items', array(
        'default' => buildpro_option_get_default_items(),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_option_sanitize_items',
    ));
    if (class_exists('BuildPro_Option_Repeater_Control')) {
        $wp_customize->add_control(new BuildPro_Option_Repeater_Control($wp_customize, 'buildpro_option_items', array(
            'label' => __('Nội dung Option', 'buildpro'),
            'description' => __('Thêm/sửa các mục Option hiển thị ở Trang chủ.', 'buildpro'),
            'section' => 'buildpro_option_section',
        )));
    }
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('buildpro_option_items', array(
            'selector' => '.section-option',
            'settings' => array('buildpro_option_items'),
            'render_callback' => function () {
                ob_start();
                get_template_part('template-parts/components/section-option/index');
                return ob_get_clean();
            },
        ));
    }
}
add_action('customize_register', 'buildpro_option_customize_register');
function buildpro_option_enqueue_assets()
{
    wp_enqueue_style(
        'buildpro-option-style',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/option/style.css'),
        array(),
        null
    );
    wp_enqueue_script(
        'buildpro-option-script',
        get_theme_file_uri('inc-components/Appearance-custom-wp/home/option/script.js'),
        array('customize-controls'),
        null,
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'buildpro_option_enqueue_assets');
function buildpro_option_sync_customizer_to_meta()
{
    $page_id = 0;
    if (function_exists('wp_get_current_user')) {
        global $wp_customize;
        if ($wp_customize && $wp_customize instanceof WP_Customize_Manager) {
            $setting = $wp_customize->get_setting('buildpro_preview_page_id');
            if ($setting) {
                $page_id = absint($setting->value());
            }
        }
    }
    if ($page_id <= 0) {
        $page_id = buildpro_option_find_home_id();
    }
    if ($page_id) {
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
        update_post_meta($page_id, 'buildpro_option_items', $clean);
    }
}
add_action('customize_save_after', 'buildpro_option_sync_customizer_to_meta');
