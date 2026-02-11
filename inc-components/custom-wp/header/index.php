<?php

function buildpro_header_admin_menu()
{
    add_theme_page('Header', 'Header', 'edit_theme_options', 'buildpro-header', 'buildpro_header_admin_page');
}
add_action('admin_menu', 'buildpro_header_admin_menu');

function buildpro_header_admin_enqueue($hook)
{
    if ($hook !== 'appearance_page_buildpro-header') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style(
        'buildpro-header-style',
        get_theme_file_uri('inc-components/custom-wp/header/style.css'),
        array(),
        null
    );
    wp_enqueue_script(
        'buildpro-header',
        get_theme_file_uri('inc-components/custom-wp/header/script.js'),
        array(),
        null,
        true
    );
}
add_action('admin_enqueue_scripts', 'buildpro_header_admin_enqueue');

function buildpro_header_admin_page()
{
    $logo_id = get_theme_mod('header_logo', 0);
    $text = get_theme_mod('buildpro_header_title', '');
    if ($text === '') {
        $text = get_theme_mod('header_text', '');
    }
    $desc = get_theme_mod('buildpro_header_description', '');
    if ($desc === '') {
        $desc = get_theme_mod('header_description', '');
    }
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'thumbnail') : '';
?>
    <div class="wrap">
        <h1>Header</h1>
        <form method="post" action="<?= esc_url(admin_url('admin-post.php')) ?>">
            <input type="hidden" name="action" value="buildpro_save_header" />
            <?php wp_nonce_field('buildpro_header_save'); ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="header_logo">Logo</label>
                        </th>
                        <td>
                            <input type="hidden" id="header_logo" name="header_logo" value="<?= esc_attr($logo_id) ?>" />
                            <button type="button" class="button" id="select_header_logo">Select Image</button>
                            <button type="button" class="button" id="remove_header_logo">Remove</button>
                            <div id="header_logo_preview">
                                <?php if ($logo_url): ?>
                                    <img src="<?= esc_url($logo_url) ?>" />
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="buildpro_header_title">Title</label>
                        </th>
                        <td>
                            <input type="text" id="buildpro_header_title" name="buildpro_header_title" class="regular-text"
                                value="<?= esc_attr($text) ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="buildpro_header_description">Description</label>
                        </th>
                        <td>
                            <textarea id="buildpro_header_description" name="buildpro_header_description" class="large-text"
                                rows="4"><?= esc_textarea($desc) ?></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button('submit change'); ?>
        </form>
    </div>
<?php
}

function buildpro_handle_header_save()
{
    if (!current_user_can('edit_theme_options')) {
        wp_die('Not allowed');
    }
    check_admin_referer('buildpro_header_save');
    $logo_raw = isset($_POST['header_logo']) ? $_POST['header_logo'] : "";
    $logo = absint($logo_raw);
    $text = isset($_POST['buildpro_header_title']) ? sanitize_text_field($_POST['buildpro_header_title']) : '';
    $desc = isset($_POST['buildpro_header_description']) ? sanitize_textarea_field($_POST['buildpro_header_description']) : '';
    if ($logo_raw === "" || $logo === 0) {
        remove_theme_mod('header_logo');
    } else {
        set_theme_mod('header_logo', $logo);
    }
    if ($text === '') {
        remove_theme_mod('buildpro_header_title');
        remove_theme_mod('header_text');
    } else {
        set_theme_mod('buildpro_header_title', $text);
        remove_theme_mod('header_text');
    }
    if ($desc === '') {
        remove_theme_mod('buildpro_header_description');
        remove_theme_mod('header_description');
    } else {
        set_theme_mod('buildpro_header_description', $desc);
        remove_theme_mod('header_description');
    }
    wp_redirect(admin_url('themes.php?page=buildpro-header&updated=1'));
    exit;
}
add_action('admin_post_buildpro_save_header', 'buildpro_handle_header_save');
