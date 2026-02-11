<?php
if (!class_exists('BuildPro_Footer_List_Pages_Control') && class_exists('WP_Customize_Control')) {
    class BuildPro_Footer_List_Pages_Control extends WP_Customize_Control
    {
        public $type = 'buildpro_footer_list_pages';
        public function render_content()
        {
            $items = $this->value();
            $items = is_array($items) ? $items : array();
            echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            if (!empty($this->description)) {
                echo '<p class="description">' . esc_html($this->description) . '</p>';
            }
            echo '<input type="hidden" class="footer-list-pages-json" ' . $this->get_link() . ' value="' . esc_attr(wp_json_encode($items)) . '">';
            echo '<div id="customizer-footer-list-pages-wrapper">';
            $index = 0;
            foreach ($items as $lp) {
                $lp_url = isset($lp['url']) ? esc_url($lp['url']) : '';
                $lp_title = isset($lp['title']) ? sanitize_text_field($lp['title']) : '';
                $lp_target = isset($lp['target']) ? sanitize_text_field($lp['target']) : '';
                echo '<div class="buildpro-block" data-index="' . esc_attr($index) . '">';
                echo '<p class="buildpro-field"><label>Link URL</label><input type="url" class="regular-text" data-field="url" value="' . esc_attr($lp_url) . '" placeholder="https://..."> <button type="button" class="button choose-link">Choose link</button></p>';
                echo '<p class="buildpro-field"><label>Link Title</label><input type="text" class="regular-text" data-field="title" value="' . esc_attr($lp_title) . '"></p>';
                echo '<p class="buildpro-field"><label>Link Target</label><select data-field="target"><option value="" ' . selected($lp_target, '', false) . '>Same Tab</option><option value="_blank" ' . selected($lp_target, '_blank', false) . '>Open New Tab</option></select></p>';
                echo '<div class="buildpro-actions"><button type="button" class="button remove-row">Remove Item</button></div>';
                echo '</div>';
                $index++;
            }
            echo '</div>';
            echo '<button type="button" class="button button-primary" id="customizer-footer-list-pages-add">Add item</button>';
            echo '<script>(function(){var wrap=document.getElementById("customizer-footer-list-pages-wrapper");if(!wrap)return;var input=document.querySelector(".footer-list-pages-json");function collect(){var rows=wrap.querySelectorAll(".buildpro-block");var out=[];rows.forEach(function(row){var url=row.querySelector("[data-field=\\\"url\\\"]");var title=row.querySelector("[data-field=\\\"title\\\"]");var target=row.querySelector("[data-field=\\\"target\\\"]");out.push({url:url?url.value:\"\",title:title?title.value:\"\",target:target?target.value:\"\"});});if(input){input.value=JSON.stringify(out);} }wrap.addEventListener(\"input\",collect,true);wrap.addEventListener(\"change\",collect,true);wrap.addEventListener(\"click\",function(e){var t=e.target;if(!t||!t.classList)return;if(t.classList.contains(\"remove-row\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(row){row.parentNode.removeChild(row);collect();}}if(t.classList.contains(\"choose-link\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(!row)return;var url=row.querySelector(\"[data-field=\\\\\"url\\\\\"]\");var title=row.querySelector(\"[data-field=\\\\\"title\\\\\"]\");var target=row.querySelector(\"[data-field=\\\\\"target\\\\\"]\");window.buildproLinkTarget={urlInput:url,titleInput:title,targetSelect:target,sectionId:\"buildpro_footer_section\"};if(window.wp&&wp.customize&&typeof wp.customize.section===\"function\"){var s=wp.customize.section(\"buildpro_link_picker_section\");if(s&&typeof s.expand===\"function\"){s.expand();return;}}} });var addBtn=document.getElementById(\"customizer-footer-list-pages-add\");if(addBtn){addBtn.addEventListener(\"click\",function(e){e.preventDefault();var html=\"\"+\"<div class=\\\"buildpro-block\\\">\"+\"<p class=\\\"buildpro-field\\\"><label>Link URL</label><input type=\\\"url\\\" class=\\\"regular-text\\\" data-field=\\\"url\\\" value=\\\"\\\" placeholder=\\\"https://...\\\"> <button type=\\\"button\\\" class=\\\"button choose-link\\\">Choose link</button></p>\"+\"<p class=\\\"buildpro-field\\\"><label>Link Title</label><input type=\\\"text\\\" class=\\\"regular-text\\\" data-field=\\\"title\\\" value=\\\"\\\"></p>\"+\"<p class=\\\"buildpro-field\\\"><label>Link Target</label><select data-field=\\\"target\\\"><option value=\\\"\\\">Same Tab</option><option value=\\\"_blank\\\">Open New Tab</option></select></p>\"+\"<div class=\\\"buildpro-actions\\\"><button type=\\\"button\\\" class=\\\"button remove-row\\\">Remove Item</button></div>\"+\"</div>\";var temp=document.createElement(\"div\");temp.innerHTML=html;var row=temp.firstElementChild;wrap.appendChild(row);collect();});}})();</script>';
        }
    }
}
if (!class_exists('BuildPro_Footer_Contact_Links_Control') && class_exists('WP_Customize_Control')) {
    class BuildPro_Footer_Contact_Links_Control extends WP_Customize_Control
    {
        public $type = 'buildpro_footer_contact_links';
        public function render_content()
        {
            $items = $this->value();
            $items = is_array($items) ? $items : array();
            echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
            if (!empty($this->description)) {
                echo '<p class="description">' . esc_html($this->description) . '</p>';
            }
            echo '<input type="hidden" class="footer-contact-links-json" ' . $this->get_link() . ' value="' . esc_attr(wp_json_encode($items)) . '">';
            echo '<div id="customizer-footer-contact-links-wrapper">';
            $index = 0;
            foreach ($items as $cl) {
                $icon_id = isset($cl['icon_id']) ? absint($cl['icon_id']) : 0;
                $thumb = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
                $url = isset($cl['url']) ? esc_url($cl['url']) : '';
                $title = isset($cl['title']) ? sanitize_text_field($cl['title']) : '';
                $target = isset($cl['target']) ? sanitize_text_field($cl['target']) : '';
                echo '<div class="buildpro-block" data-index="' . esc_attr($index) . '">';
                echo '<p class="buildpro-field"><label>Icon</label><input type="hidden" class="regular-text" data-field="icon_id" value="' . esc_attr($icon_id) . '"> <button type="button" class="button select-contact-icon">Selected photo</button> <button type="button" class="button remove-contact-icon">Remove photo</button></p>';
                echo '<div class="image-preview contact-icon-preview">' . ($thumb ? '<img src="' . esc_url($thumb) . '" style="max-height:80px;">' : '<span style="color:#888">No Image Selected</span>') . '</div>';
                echo '<p class="buildpro-field"><label>Link URL</label><input type="url" class="regular-text" data-field="url" value="' . esc_attr($url) . '" placeholder="https://..."> <button type="button" class="button choose-link">Choose link</button></p>';
                echo '<p class="buildpro-field"><label>Link Title</label><input type="text" class="regular-text" data-field="title" value="' . esc_attr($title) . '"></p>';
                echo '<p class="buildpro-field"><label>Link Target</label><select data-field="target"><option value="" ' . selected($target, '', false) . '>Same Tab</option><option value="_blank" ' . selected($target, '_blank', false) . '>Open New Tab</option></select></p>';
                echo '<div class="buildpro-actions"><button type="button" class="button remove-row">Remove Item</button></div>';
                echo '</div>';
                $index++;
            }
            echo '</div>';
            echo '<button type="button" class="button button-primary" id="customizer-footer-contact-links-add">Add item</button>';
            echo '<script>(function(){var wrap=document.getElementById(\"customizer-footer-contact-links-wrapper\");if(!wrap)return;var input=document.querySelector(\".footer-contact-links-json\");function collect(){var rows=wrap.querySelectorAll(\".buildpro-block\");var out=[];rows.forEach(function(row){var icon=row.querySelector(\"[data-field=\\\\\"icon_id\\\\\"]\");var url=row.querySelector(\"[data-field=\\\\\"url\\\\\"]\");var title=row.querySelector(\"[data-field=\\\\\"title\\\\\"]\");var target=row.querySelector(\"[data-field=\\\\\"target\\\\\"]\");out.push({icon_id:icon?parseInt(icon.value||0,10):0,url:url?url.value:\"\",title:title?title.value:\"\",target:target?target.value:\"\"});});if(input){input.value=JSON.stringify(out);} }wrap.addEventListener(\"input\",collect,true);wrap.addEventListener(\"change\",collect,true);wrap.addEventListener(\"click\",function(e){var t=e.target;if(!t||!t.classList)return;if(t.classList.contains(\"remove-row\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(row){row.parentNode.removeChild(row);collect();}}if(t.classList.contains(\"choose-link\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(!row)return;var url=row.querySelector(\"[data-field=\\\\\"url\\\\\"]\");var title=row.querySelector(\"[data-field=\\\\\"title\\\\\"]\");var target=row.querySelector(\"[data-field=\\\\\"target\\\\\"]\");window.buildproLinkTarget={urlInput:url,titleInput:title,targetSelect:target,sectionId:\"buildpro_footer_section\"};if(window.wp&&wp.customize&&typeof wp.customize.section===\"function\"){var s=wp.customize.section(\"buildpro_link_picker_section\");if(s&&typeof s.expand===\"function\"){s.expand();return;}}}if(t.classList.contains(\"select-contact-icon\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(!row)return;var idInput=row.querySelector(\"[data-field=\\\\\"icon_id\\\\\"]\");var preview=row.querySelector(\".contact-icon-preview\");if(window.wp && wp.media){var frame=wp.media({title:\"Select Icon\",multiple:false,library:{type:\"image\"}});frame.on(\"select\",function(){var file=frame.state().get(\"selection\").first().toJSON();if(idInput){idInput.value = String(file.id||0);idInput.dispatchEvent(new Event(\"input\"));}if(preview){var url=(file && file.sizes && file.sizes.thumbnail && file.sizes.thumbnail.url)||file.url||\"\";preview.innerHTML=url?\"<img src=\\\\\"\"+url+\"\\\\\" style=\\\\\"max-height:80px;\\\\\">\":\"<span style=\\\\\"color:#888\\\\\">No Image Selected</span>\";}collect();});frame.open();}}if(t.classList.contains(\"remove-contact-icon\")){e.preventDefault();var row=t.closest(\".buildpro-block\");if(!row)return;var idInput=row.querySelector(\"[data-field=\\\\\"icon_id\\\\\"]\");var preview=row.querySelector(\".contact-icon-preview\");if(idInput){idInput.value=\"0\";idInput.dispatchEvent(new Event(\"input\"));}if(preview){preview.innerHTML=\"<span style=\\\\\"color:#888\\\\\">No Image Selected</span>\";}collect();}});var addBtn=document.getElementById(\"customizer-footer-contact-links-add\");if(addBtn){addBtn.addEventListener(\"click\",function(e){e.preventDefault();var html=\"\"+\"<div class=\\\\\"buildpro-block\\\\\">\"+\"<p class=\\\\\"buildpro-field\\\\\"><label>Icon</label><input type=\\\\\"hidden\\\\\" class=\\\\\"regular-text\\\\\" data-field=\\\\\"icon_id\\\\\" value=\\\\\"0\\\\\"> <button type=\\\\\"button\\\\\" class=\\\\\"button select-contact-icon\\\\\">Selected photo</button> <button type=\\\\\"button\\\\\" class=\\\\\"button remove-contact-icon\\\\\">Remove photo</button></p>\"+\"<div class=\\\\\"image-preview contact-icon-preview\\\\\"><span style=\\\\\"color:#888\\\\\">No Image Selected</span></div>\"+\"<p class=\\\\\"buildpro-field\\\\\"><label>Link URL</label><input type=\\\\\"url\\\\\" class=\\\\\"regular-text\\\\\" data-field=\\\\\"url\\\\\" value=\\\\\"\\\\\" placeholder=\\\\\"https://...\\\\\"> <button type=\\\\\"button\\\\\" class=\\\\\"button choose-link\\\\\">Choose link</button></p>\"+\"<p class=\\\\\"buildpro-field\\\\\"><label>Link Title</label><input type=\\\\\"text\\\\\" class=\\\\\"regular-text\\\\\" data-field=\\\\\"title\\\\\" value=\\\\\"\\\\\"></p>\"+\"<p class=\\\\\"buildpro-field\\\\\"><label>Link Target</label><select data-field=\\\\\"target\\\\\"><option value=\\\\\"\\\\\">Same Tab</option><option value=\\\\\"_blank\\\\\">Open New Tab</option></select></p>\"+\"<div class=\\\\\"buildpro-actions\\\\\"><button type=\\\\\"button\\\\\" class=\\\\\"button remove-row\\\\\">Remove Item</button></div>\"+\"</div>\";var temp=document.createElement(\"div\");temp.innerHTML=html;var row=temp.firstElementChild;wrap.appendChild(row);collect();});}})();</script>';
        }
    }
}
if (!function_exists('buildpro_footer_sanitize_list_pages')) {
    function buildpro_footer_sanitize_list_pages($value)
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
        foreach ($value as $lp) {
            $clean[] = array(
                'url' => isset($lp['url']) ? esc_url_raw($lp['url']) : '',
                'title' => isset($lp['title']) ? sanitize_text_field($lp['title']) : '',
                'target' => isset($lp['target']) ? sanitize_text_field($lp['target']) : '',
            );
        }
        return $clean;
    }
}
if (!function_exists('buildpro_footer_sanitize_contact_links')) {
    function buildpro_footer_sanitize_contact_links($value)
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
        foreach ($value as $cl) {
            $clean[] = array(
                'icon_id' => isset($cl['icon_id']) ? absint($cl['icon_id']) : 0,
                'url' => isset($cl['url']) ? esc_url_raw($cl['url']) : '',
                'title' => isset($cl['title']) ? sanitize_text_field($cl['title']) : '',
                'target' => isset($cl['target']) ? sanitize_text_field($cl['target']) : '',
            );
        }
        return $clean;
    }
}
if (!function_exists('buildpro_footer_sanitize_link')) {
    function buildpro_footer_sanitize_link($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = $decoded;
            }
        }
        if (!is_array($value)) {
            $value = array();
        }
        return array(
            'url' => isset($value['url']) ? esc_url_raw($value['url']) : '',
            'title' => isset($value['title']) ? sanitize_text_field($value['title']) : '',
            'target' => isset($value['target']) ? sanitize_text_field($value['target']) : '',
        );
    }
}
function buildpro_footer_customize_register($wp_customize)
{
    $wp_customize->add_section('buildpro_footer_section', array(
        'title' => __('Footer', 'buildpro'),
        'priority' => 40,
    ));
    $wp_customize->add_setting('footer_banner_image_id', array(
        'default' => 0,
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'footer_banner_image_id', array(
        'label' => __('Banner Background', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'mime_type' => 'image',
    )));
    $wp_customize->add_setting('footer_information_logo_id', array(
        'default' => 0,
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'footer_information_logo_id', array(
        'label' => __('Brand Logo', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'mime_type' => 'image',
    )));
    $wp_customize->add_setting('footer_information_title', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_information_title', array(
        'label' => __('Title', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_information_sub_title', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_information_sub_title', array(
        'label' => __('Sub Title', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_information_description', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_information_description', array(
        'label' => __('Description', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'textarea',
    ));
    $wp_customize->add_setting('footer_contact_location', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_contact_location', array(
        'label' => __('Contact Location', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_contact_phone', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_contact_phone', array(
        'label' => __('Contact Phone', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_contact_email', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('footer_contact_email', array(
        'label' => __('Contact Email', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'email',
    ));
    $wp_customize->add_setting('footer_contact_time', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_contact_time', array(
        'label' => __('Contact Time', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_list_pages', array(
        'default' => array(),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_footer_sanitize_list_pages',
    ));
    if (class_exists('BuildPro_Footer_List_Pages_Control')) {
        $wp_customize->add_control(new BuildPro_Footer_List_Pages_Control($wp_customize, 'footer_list_pages', array(
            'label' => __('Footer Pages', 'buildpro'),
            'description' => __('Add/Edit footer pages links.', 'buildpro'),
            'section' => 'buildpro_footer_section',
        )));
    }
    $wp_customize->add_setting('footer_contact_links', array(
        'default' => array(),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_footer_sanitize_contact_links',
    ));
    if (class_exists('BuildPro_Footer_Contact_Links_Control')) {
        $wp_customize->add_control(new BuildPro_Footer_Contact_Links_Control($wp_customize, 'footer_contact_links', array(
            'label' => __('Footer Contact Links', 'buildpro'),
            'description' => __('Add/Edit contact links with icons.', 'buildpro'),
            'section' => 'buildpro_footer_section',
        )));
    }
    $wp_customize->add_setting('footer_create_build_text', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_create_build_text', array(
        'label' => __('Create Build Text', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_policy_text', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_policy_text', array(
        'label' => __('Policy Text', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_policy_link', array(
        'default' => array('url' => '', 'title' => '', 'target' => ''),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_footer_sanitize_link',
    ));
    $wp_customize->add_control('footer_policy_link', array(
        'label' => __('Policy Link', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
        'description' => __('Store as JSON: url/title/target via control UI', 'buildpro'),
    ));
    $wp_customize->add_setting('footer_servicer_text', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_servicer_text', array(
        'label' => __('Servicer Text', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('footer_servicer_link', array(
        'default' => array('url' => '', 'title' => '', 'target' => ''),
        'transport' => 'postMessage',
        'sanitize_callback' => 'buildpro_footer_sanitize_link',
    ));
    $wp_customize->add_control('footer_servicer_link', array(
        'label' => __('Servicer Link', 'buildpro'),
        'section' => 'buildpro_footer_section',
        'type' => 'text',
        'description' => __('Store as JSON: url/title/target via control UI', 'buildpro'),
    ));
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('buildpro_footer_all', array(
            'selector' => '.site-footer',
            'settings' => array(
                'footer_banner_image_id',
                'footer_information_logo_id',
                'footer_information_title',
                'footer_information_sub_title',
                'footer_information_description',
                'footer_list_pages',
                'footer_contact_location',
                'footer_contact_phone',
                'footer_contact_email',
                'footer_contact_time',
                'footer_contact_links',
                'footer_create_build_text',
                'footer_policy_text',
                'footer_policy_link',
                'footer_servicer_text',
                'footer_servicer_link'
            ),
            'render_callback' => function () {
                ob_start();
                get_template_part('template-parts/footer/footer');
                return ob_get_clean();
            },
        ));
    }
}
add_action('customize_register', 'buildpro_footer_customize_register');

function buildpro_footer_customize_preview_js()
{
    wp_enqueue_script(
        'buildpro-footer-preview',
        get_theme_file_uri('inc-components/custom-wp/footer/script.js'),
        array('customize-preview'),
        null,
        true
    );
}
add_action('customize_preview_init', 'buildpro_footer_customize_preview_js');

function buildpro_footer_customize_controls_enqueue()
{
    wp_enqueue_media();
    wp_enqueue_script('wplink');
    wp_enqueue_style('wp-link');
    wp_enqueue_script('wp-api-fetch');
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
    wp_enqueue_script(
        'buildpro-footer-controls-script',
        get_theme_file_uri('inc-components/Appearance-custom-wp/footer/script.js'),
        array('customize-controls'),
        null,
        true
    );
}
add_action('customize_controls_enqueue_scripts', 'buildpro_footer_customize_controls_enqueue');
