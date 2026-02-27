<?php
function buildpro_about_contact_customize_register($wp_customize)
{
    if (!class_exists('BuildPro_Customize_Button_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_Customize_Button_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_button';
            public $button_url = '';
            public $button_text = '';
            public function render_content()
            {
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                if (empty($this->button_url)) {
                    echo '<p>' . esc_html__('Không tìm thấy trang About Us dùng template about-page.php', 'buildpro') . '</p>';
                    return;
                }
                $text = $this->button_text ? $this->button_text : __('Mở trang chỉnh sửa', 'buildpro');
                echo '<a class="button button-primary" href="' . esc_url($this->button_url) . '" target="_blank" rel="noopener">' . esc_html($text) . '</a>';
            }
        }
    }
    $about_id = 0;
    $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
    if (!empty($pages)) {
        $about_id = (int) $pages[0]->ID;
    }
    $edit_url = $about_id ? admin_url('post.php?post=' . $about_id . '&action=edit') : '';
    if (!function_exists('buildpro_customizer_is_about_preview')) {
        function buildpro_customizer_is_about_preview()
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
            if ($selected_id > 0) {
                $tpl = get_page_template_slug($selected_id);
                if ($tpl === 'about-page.php') {
                    return true;
                }
            }
            if ($selected_id <= 0 && !empty($pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1)))) {
                return true;
            }
            return false;
        }
    }
    $wp_customize->add_section('buildpro_about_contact_section', array(
        'title' => __('About Us: Contact', 'buildpro'),
        'priority' => 34,
        'active_callback' => 'buildpro_customizer_is_about_preview',
    ));
    // Enabled
    $enabled_default = 1;
    if ($about_id) {
        $en_meta = get_post_meta($about_id, 'buildpro_about_contact_enabled', true);
        if ($en_meta !== '') {
            $enabled_default = (int) $en_meta;
        }
    }
    $wp_customize->add_setting('buildpro_about_contact_enabled', array(
        'default' => $enabled_default,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('buildpro_about_contact_enabled', array(
        'label' => __('Enable Contact', 'buildpro'),
        'section' => 'buildpro_about_contact_section',
        'type' => 'checkbox',
    ));
    // Edit button
    if (class_exists('BuildPro_Customize_Button_Control')) {
        $wp_customize->add_setting('buildpro_about_contact_edit_link', array(
            'default' => '',
            'transport' => 'postMessage',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new BuildPro_Customize_Button_Control($wp_customize, 'buildpro_about_contact_edit_link', array(
            'label' => __('Edit About Us Page', 'buildpro'),
            'description' => __('Mở trang About Us để chỉnh sửa meta box.', 'buildpro'),
            'section' => 'buildpro_about_contact_section',
            'button_url' => $edit_url,
            'button_text' => __('Edit About Us', 'buildpro'),
        )));
    }
    // Text fields defaults from meta
    $fields = array(
        'buildpro_about_contact_title' => array('label' => __('Title', 'buildpro'), 'sanitize' => 'sanitize_text_field'),
        'buildpro_about_contact_text' => array('label' => __('Description', 'buildpro'), 'sanitize' => 'sanitize_textarea_field', 'type' => 'textarea'),
        'buildpro_about_contact_address' => array('label' => __('Address', 'buildpro'), 'sanitize' => 'sanitize_text_field'),
        'buildpro_about_contact_phone' => array('label' => __('Phone', 'buildpro'), 'sanitize' => 'sanitize_text_field'),
        'buildpro_about_contact_email' => array('label' => __('Email', 'buildpro'), 'sanitize' => 'sanitize_email'),
    );
    foreach ($fields as $key => $cfg) {
        $def = '';
        if ($about_id) {
            $m = get_post_meta($about_id, $key, true);
            if (is_string($m) && $m !== '') {
                $def = $m;
            }
        }
        $wp_customize->add_setting($key, array(
            'default' => $def,
            'transport' => 'postMessage',
            'sanitize_callback' => $cfg['sanitize'],
        ));
        $wp_customize->add_control($key, array(
            'label' => $cfg['label'],
            'section' => 'buildpro_about_contact_section',
            'type' => isset($cfg['type']) ? $cfg['type'] : 'text',
        ));
    }
    // Selective refresh (optional template)
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('buildpro_about_contact_partial', array(
            'selector' => '.about-contact',
            'settings' => array('buildpro_about_contact_enabled', 'buildpro_about_contact_title', 'buildpro_about_contact_text', 'buildpro_about_contact_address', 'buildpro_about_contact_phone', 'buildpro_about_contact_email'),
            'render_callback' => function () {
                ob_start();
                if (function_exists('get_template_part')) {
                    get_template_part('template-parts/about_us/section-contact/index');
                }
                return ob_get_clean();
            },
        ));
    }
    add_action('customize_controls_enqueue_scripts', function () {
        wp_enqueue_style(
            'buildpro-about-contact-style',
            get_theme_file_uri('inc-components/Appearance-custom-wp/about-us/section-contact/style.css'),
            array(),
            null
        );
        wp_enqueue_script(
            'buildpro-about-contact-script',
            get_theme_file_uri('inc-components/Appearance-custom-wp/about-us/section-contact/script.js'),
            array('customize-controls', 'jquery'),
            null,
            true
        );
        $default_about = 0;
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
        if (!empty($pages)) {
            $default_about = (int)$pages[0]->ID;
        }
        wp_localize_script('buildpro-about-contact-script', 'BuildProAboutContact', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('buildpro_customizer_nonce'),
            'default_page_id' => $default_about,
        ));
    });
}
add_action('customize_register', 'buildpro_about_contact_customize_register');

function buildpro_about_contact_ajax_get_data()
{
    if (!current_user_can('edit_theme_options')) {
        wp_send_json_error(array('message' => 'forbidden'), 403);
    }
    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if (!wp_verify_nonce($nonce, 'buildpro_customizer_nonce')) {
        wp_send_json_error(array('message' => 'invalid_nonce'), 400);
    }
    $page_id = isset($_REQUEST['page_id']) ? absint($_REQUEST['page_id']) : 0;
    if ($page_id <= 0) {
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
        if (!empty($pages)) {
            $page_id = (int)$pages[0]->ID;
        }
    }
    if ($page_id <= 0) {
        wp_send_json_success(array(
            'enabled' => 1,
            'title' => '',
            'text' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
        ));
    }
    $enabled = get_post_meta($page_id, 'buildpro_about_contact_enabled', true);
    $enabled = ($enabled === '' ? 1 : (int)$enabled);
    $title = get_post_meta($page_id, 'buildpro_about_contact_title', true);
    $text = get_post_meta($page_id, 'buildpro_about_contact_text', true);
    $address = get_post_meta($page_id, 'buildpro_about_contact_address', true);
    $phone = get_post_meta($page_id, 'buildpro_about_contact_phone', true);
    $email = get_post_meta($page_id, 'buildpro_about_contact_email', true);
    wp_send_json_success(array(
        'enabled' => $enabled,
        'title' => is_string($title) ? $title : '',
        'text' => is_string($text) ? $text : '',
        'address' => is_string($address) ? $address : '',
        'phone' => is_string($phone) ? $phone : '',
        'email' => is_string($email) ? $email : '',
    ));
}
add_action('wp_ajax_buildpro_get_about_contact', 'buildpro_about_contact_ajax_get_data');

function buildpro_about_contact_sync_customizer_to_meta($wp_customize_manager)
{
    $enabled_val = null;
    $title_val = null;
    $text_val = null;
    $address_val = null;
    $phone_val = null;
    $email_val = null;
    if ($wp_customize_manager instanceof WP_Customize_Manager) {
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_enabled');
        $enabled_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_title');
        $title_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_text');
        $text_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_address');
        $address_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_phone');
        $phone_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_contact_email');
        $email_val = $s ? $s->post_value() : null;
    }
    if ($enabled_val === null) {
        $enabled_val = get_theme_mod('buildpro_about_contact_enabled', 1);
    }
    if ($title_val === null) {
        $title_val = get_theme_mod('buildpro_about_contact_title', '');
    }
    if ($text_val === null) {
        $text_val = get_theme_mod('buildpro_about_contact_text', '');
    }
    if ($address_val === null) {
        $address_val = get_theme_mod('buildpro_about_contact_address', '');
    }
    if ($phone_val === null) {
        $phone_val = get_theme_mod('buildpro_about_contact_phone', '');
    }
    if ($email_val === null) {
        $email_val = get_theme_mod('buildpro_about_contact_email', '');
    }
    $enabled = absint($enabled_val);
    $title = is_string($title_val) ? $title_val : '';
    $text = is_string($text_val) ? $text_val : '';
    $address = is_string($address_val) ? $address_val : '';
    $phone = is_string($phone_val) ? $phone_val : '';
    $email = is_string($email_val) ? $email_val : '';
    $page_id = 0;
    if ($wp_customize_manager instanceof WP_Customize_Manager) {
        $setting = $wp_customize_manager->get_setting('buildpro_preview_page_id');
        if ($setting) {
            $page_id = absint($setting->value());
        }
    }
    if ($page_id <= 0) {
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
        if (!empty($pages)) {
            $page_id = (int)$pages[0]->ID;
        }
    }
    if ($page_id) {
        update_post_meta($page_id, 'buildpro_about_contact_enabled', $enabled);
        update_post_meta($page_id, 'buildpro_about_contact_title', $title);
        update_post_meta($page_id, 'buildpro_about_contact_text', $text);
        update_post_meta($page_id, 'buildpro_about_contact_address', $address);
        update_post_meta($page_id, 'buildpro_about_contact_phone', $phone);
        update_post_meta($page_id, 'buildpro_about_contact_email', $email);
    }
}
add_action('customize_save_after', 'buildpro_about_contact_sync_customizer_to_meta');
