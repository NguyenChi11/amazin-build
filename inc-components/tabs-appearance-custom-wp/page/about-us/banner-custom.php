<?php
function buildpro_about_banner_customize_register($wp_customize)
{
    if (!class_exists('BuildPro_About_Facts_Repeater_Control') && class_exists('WP_Customize_Control')) {
        class BuildPro_About_Facts_Repeater_Control extends WP_Customize_Control
        {
            public $type = 'buildpro_about_facts_repeater';
            public function render_content()
            {
                $items = $this->value();
                $items = is_array($items) ? $items : array();
                echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
                if (!empty($this->description)) {
                    echo '<p class="description">' . esc_html($this->description) . '</p>';
                }
                include get_theme_file_path('inc-components/Appearance-custom-wp/about-us/section-banner/index.php');
                return;
            }
        }
    }
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
                    echo '<p>' . esc_html__('Không tìm thấy trang About Us dùng template about-page.php', 'buildpro') . '</p>';
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
    $wp_customize->add_section('buildpro_about_banner_section', array(
        'title' => __('About Us: Banner', 'buildpro'),
        'priority' => 30,
        'active_callback' => 'buildpro_customizer_is_about_preview',
    ));
    $wp_customize->add_setting('buildpro_about_banner_enabled', array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control('buildpro_about_banner_enabled', array(
        'label' => __('Enable Banner', 'buildpro'),
        'section' => 'buildpro_about_banner_section',
        'type' => 'checkbox',
    ));
    $wp_customize->add_setting('buildpro_about_banner_edit_link', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
    ));
    if (class_exists('BuildPro_Customize_Button_Control')) {
        $wp_customize->add_control(new BuildPro_Customize_Button_Control($wp_customize, 'buildpro_about_banner_edit_link', array(
            'label' => __('Edit About Us Page', 'buildpro'),
            'description' => __('Mở trang About Us để chỉnh sửa meta box.', 'buildpro'),
            'section' => 'buildpro_about_banner_section',
            'button_url' => $edit_url,
            'button_text' => __('Edit About Us', 'buildpro'),
        )));
    }
    $wp_customize->add_setting('buildpro_about_banner_text', array(
        'default' => 'Who We Are',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('buildpro_about_banner_text', array(
        'label' => __('Text', 'buildpro'),
        'section' => 'buildpro_about_banner_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('buildpro_about_banner_title', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('buildpro_about_banner_title', array(
        'label' => __('Title', 'buildpro'),
        'section' => 'buildpro_about_banner_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('buildpro_about_banner_description', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('buildpro_about_banner_description', array(
        'label' => __('Description', 'buildpro'),
        'section' => 'buildpro_about_banner_section',
        'type' => 'textarea',
    ));
    $facts_default = array();
    $default_page_id = 0;
    if (isset($wp_customize) && $wp_customize instanceof WP_Customize_Manager) {
        $sel = $wp_customize->get_setting('buildpro_preview_page_id');
        if ($sel) {
            $default_page_id = absint($sel->value());
        }
    }
    if ($default_page_id <= 0) {
        $default_page_id = $about_id;
    }
    if ($default_page_id) {
        $facts_meta = get_post_meta($default_page_id, 'buildpro_about_banner_facts', true);
        if (is_array($facts_meta)) {
            $facts_default = $facts_meta;
        }
    }
    $wp_customize->add_setting('buildpro_about_banner_facts', array(
        'default' => $facts_default,
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_about_banner_sanitize_facts',
    ));
    if (class_exists('BuildPro_About_Facts_Repeater_Control')) {
        $wp_customize->add_control(new BuildPro_About_Facts_Repeater_Control($wp_customize, 'buildpro_about_banner_facts', array(
            'label' => __('Facts', 'buildpro'),
            'description' => __('Quản lý các cặp Label/Value hiển thị ở About Us.', 'buildpro'),
            'section' => 'buildpro_about_banner_section',
        )));
    }
    $wp_customize->add_setting('buildpro_about_banner_image_id', array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));
    if (class_exists('WP_Customize_Media_Control')) {
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'buildpro_about_banner_image_id', array(
            'label' => __('Banner Image', 'buildpro'),
            'section' => 'buildpro_about_banner_section',
            'mime_type' => 'image',
        )));
    } else {
        $wp_customize->add_control('buildpro_about_banner_image_id', array(
            'label' => __('Banner Image ID', 'buildpro'),
            'section' => 'buildpro_about_banner_section',
            'type' => 'number',
        ));
    }
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('buildpro_about_banner_partial', array(
            'selector' => '.about-us__section-banner',
            'settings' => array_merge(
                array('buildpro_about_banner_enabled', 'buildpro_about_banner_text', 'buildpro_about_banner_title', 'buildpro_about_banner_description', 'buildpro_about_banner_image_id', 'buildpro_about_banner_facts')
            ),
            'render_callback' => function () {
                ob_start();
                get_template_part('template-parts/about_us/section-banner/index');
                return ob_get_clean();
            },
        ));
    }
    // CSS outline hover đã được chuyển sang template-parts/about_us/section-banner/style.css
    add_action('customize_controls_enqueue_scripts', function () {
        wp_enqueue_style(
            'buildpro-about-banner-facts-style',
            get_theme_file_uri('inc-components/Appearance-custom-wp/about-us/section-banner/style.css'),
            array(),
            null
        );
        wp_enqueue_script(
            'buildpro-about-banner-facts-script',
            get_theme_file_uri('inc-components/Appearance-custom-wp/about-us/section-banner/script.js'),
            array('customize-controls', 'jquery'),
            null,
            true
        );
        $default_about = 0;
        $pages = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
        if (!empty($pages)) {
            $default_about = (int) $pages[0]->ID;
        }
        wp_localize_script('buildpro-about-banner-facts-script', 'BuildProAboutFacts', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('buildpro_customizer_nonce'),
            'default_page_id' => $default_about,
        ));
    });
    $pages_about = get_pages(array('meta_key' => '_wp_page_template', 'meta_value' => 'about-page.php', 'number' => 1));
    $about_preview_url = '';
    if (!empty($pages_about)) {
        $p = $pages_about[0];
        $about_preview_url = get_permalink($p->ID);
    }
    if ($about_preview_url && $about_id) {
        add_action('customize_controls_print_footer_scripts', function () use ($about_preview_url, $about_id) {
            $url = esc_js($about_preview_url);
            $pid = (int) $about_id;
            echo "<script>(function(api){try{var s=api&&api.section&&api.section('buildpro_about_banner_section');if(!s)return;s.expanded.bind(function(exp){if(!exp)return;function addCS(u){try{var uuid=api&&api.settings&&api.settings.changeset&&api.settings.changeset.uuid;if(!uuid)return u;var t=new URL(u,window.location.origin);if(!t.searchParams.get('customize_changeset_uuid')){t.searchParams.set('customize_changeset_uuid',uuid);}return t.toString();}catch(e){return u;}}var target=addCS('{$url}');var did=false;if(api&&api.previewer){if(api.previewer.previewUrl&&typeof api.previewer.previewUrl.set==='function'){api.previewer.previewUrl.set(target);did=true;}else if(typeof api.previewer.previewUrl==='function'){api.previewer.previewUrl(target);did=true;}else if(api.previewer.url&&typeof api.previewer.url.set==='function'){api.previewer.url.set(target);did=true;}if(!did){var frame=window.parent&&window.parent.document&&window.parent.document.querySelector('#customize-preview iframe');if(frame){frame.src=target;did=true;}}if(did){setTimeout(function(){try{if(api.previewer.refresh){api.previewer.refresh();}}catch(e){}},100);}try{if(api&&api.has&&api.has('buildpro_preview_page_id')){var cur=parseInt(api('buildpro_preview_page_id').get()||0,10)||0;if(!cur){api('buildpro_preview_page_id').set({$pid});}}}catch(e){}}});}catch(e){}})(wp.customize);</script>";
        });
    }
}
add_action('customize_register', 'buildpro_about_banner_customize_register');

function buildpro_about_banner_sync_customizer_to_meta($wp_customize_manager)
{
    $enabled_val = null;
    $text_val = null;
    $title_val = null;
    $desc_val = null;
    $image_id_val = null;
    $facts_val = null;
    if ($wp_customize_manager instanceof WP_Customize_Manager) {
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_enabled');
        $enabled_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_text');
        $text_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_title');
        $title_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_description');
        $desc_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_image_id');
        $image_id_val = $s ? $s->post_value() : null;
        $s = $wp_customize_manager->get_setting('buildpro_about_banner_facts');
        $facts_val = $s ? $s->post_value() : null;
    }
    if ($enabled_val === null) {
        $enabled_val = get_theme_mod('buildpro_about_banner_enabled', 1);
    }
    if ($text_val === null) {
        $text_val = get_theme_mod('buildpro_about_banner_text', '');
    }
    if ($title_val === null) {
        $title_val = get_theme_mod('buildpro_about_banner_title', '');
    }
    if ($desc_val === null) {
        $desc_val = get_theme_mod('buildpro_about_banner_description', '');
    }
    if ($image_id_val === null) {
        $image_id_val = get_theme_mod('buildpro_about_banner_image_id', 0);
    }
    if ($facts_val === null) {
        $facts_val = get_theme_mod('buildpro_about_banner_facts', array());
    }
    $enabled = absint($enabled_val);
    $text = is_string($text_val) ? $text_val : '';
    $title = is_string($title_val) ? $title_val : '';
    $desc = is_string($desc_val) ? $desc_val : '';
    $image_id = absint($image_id_val);
    $facts = $facts_val;
    if (!is_array($facts)) {
        $facts = array();
    }
    $facts = buildpro_about_banner_sanitize_facts($facts);
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
            $page_id = (int) $pages[0]->ID;
        }
    }
    if ($page_id) {
        update_post_meta($page_id, 'buildpro_about_banner_enabled', $enabled);
        update_post_meta($page_id, 'buildpro_about_banner_text', $text);
        update_post_meta($page_id, 'buildpro_about_banner_title', $title);
        update_post_meta($page_id, 'buildpro_about_banner_description', $desc);
        update_post_meta($page_id, 'buildpro_about_banner_facts', $facts);
        update_post_meta($page_id, 'buildpro_about_banner_image_id', $image_id);
    }
}
add_action('customize_save_after', 'buildpro_about_banner_sync_customizer_to_meta');
function buildpro_about_banner_sanitize_facts($value)
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
            'label' => isset($item['label']) ? sanitize_text_field($item['label']) : '',
            'value' => isset($item['value']) ? sanitize_text_field($item['value']) : '',
        );
    }
    return array_values(array_slice($clean, 0, 4));
}

function buildpro_about_banner_ajax_get_facts()
{
    if (!current_user_can('edit_theme_options')) {
        wp_send_json_error(array('message' => 'forbidden'), 403);
    }
    $nonce = isset($_REQUEST['nonce']) ? $_REQUEST['nonce'] : '';
    if (!wp_verify_nonce($nonce, 'buildpro_customizer_nonce')) {
        wp_send_json_error(array('message' => 'invalid_nonce'), 400);
    }
    $page_id = isset($_GET['page_id']) ? absint($_GET['page_id']) : 0;
    if ($page_id <= 0) {
        wp_send_json_success(array('facts' => array()));
    }
    $tpl = get_page_template_slug($page_id);
    if ($tpl !== 'about-page.php') {
        wp_send_json_success(array('facts' => array()));
    }
    $facts = get_post_meta($page_id, 'buildpro_about_banner_facts', true);
    if (!is_array($facts)) {
        $facts = array();
    }
    $facts = buildpro_about_banner_sanitize_facts($facts);
    wp_send_json_success(array('facts' => $facts));
}
add_action('wp_ajax_buildpro_get_about_facts', 'buildpro_about_banner_ajax_get_facts');
