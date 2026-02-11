<?php
function buildpro_customize_register($wp_customize)
{
    $wp_customize->add_section('buildpro_header_section', array(
        'title' => __('Header', 'buildpro'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('header_logo', array(
        'default' => 0,
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ));
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_logo', array(
        'label' => __('Logo', 'buildpro'),
        'section' => 'buildpro_header_section',
        'mime_type' => 'image',
    )));
    $wp_customize->add_setting('buildpro_header_title', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('buildpro_header_title', array(
        'label' => __('Title', 'buildpro'),
        'section' => 'buildpro_header_section',
        'type' => 'text',
    ));
    $wp_customize->add_setting('buildpro_header_description', array(
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('buildpro_header_description', array(
        'label' => __('Description', 'buildpro'),
        'section' => 'buildpro_header_section',
        'type' => 'textarea',
    ));
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('header_logo', array(
            'selector' => '.header-logo',
            'settings' => array('header_logo'),
            'render_callback' => function () {
                $logo_id = get_theme_mod('header_logo', 0);
                if ($logo_id) {
                    return wp_get_attachment_image($logo_id, 'full', false, array('class' => ''));
                }
                return '<img src="' . esc_url(get_theme_file_uri('/assets/images/logo.png')) . '" alt="Logo" />';
            },
        ));
    }
}
add_action('customize_register', 'buildpro_customize_register');

function buildpro_header_customize_preview_js()
{
    wp_enqueue_script(
        'buildpro-header',
        get_theme_file_uri('inc-components/custom-wp/header/script.js'),
        array('customize-preview'),
        null,
        true
    );
}
add_action('customize_preview_init', 'buildpro_header_customize_preview_js');
