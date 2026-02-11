<?php

function buildpro_footer_admin_menu()
{
    add_theme_page('Footer', 'Footer', 'edit_theme_options', 'buildpro-footer', 'buildpro_footer_admin_page');
}
add_action('admin_menu', 'buildpro_footer_admin_menu');

function buildpro_footer_admin_enqueue($hook)
{
    if ($hook !== 'appearance_page_buildpro-footer') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('wplink');
    wp_enqueue_style('wp-link');
    wp_enqueue_script('wp-api-fetch');
    wp_enqueue_style(
        'buildpro-footer-style',
        get_theme_file_uri('inc-components/custom-wp/footer/style.css'),
        array(),
        null
    );
    wp_enqueue_script(
        'buildpro-footer-script',
        get_theme_file_uri('inc-components/custom-wp/footer/script.js'),
        array(),
        null,
        true
    );
}
add_action('admin_enqueue_scripts', 'buildpro_footer_admin_enqueue');

function buildpro_footer_admin_page()
{
    $banner_image_id = get_theme_mod('footer_banner_image_id', 0);
    $banner_thumb = $banner_image_id ? wp_get_attachment_image_url($banner_image_id, 'thumbnail') : '';
    $info_logo_id = get_theme_mod('footer_information_logo_id', 0);
    $info_logo_thumb = $info_logo_id ? wp_get_attachment_image_url($info_logo_id, 'thumbnail') : '';
    $info_title = get_theme_mod('footer_information_title', '');
    $info_sub_title = get_theme_mod('footer_information_sub_title', '');
    $info_description = get_theme_mod('footer_information_description', '');
    $list_pages = get_theme_mod('footer_list_pages', array());
    $list_pages = is_array($list_pages) ? $list_pages : array();
    $contact_location = get_theme_mod('footer_contact_location', '');
    $contact_phone = get_theme_mod('footer_contact_phone', '');
    $contact_email = get_theme_mod('footer_contact_email', '');
    $contact_time = get_theme_mod('footer_contact_time', '');
    $contact_links = get_theme_mod('footer_contact_links', array());
    $contact_links = is_array($contact_links) ? $contact_links : array();
    $create_build_text = get_theme_mod('footer_create_build_text', '');
    $policy_text = get_theme_mod('footer_policy_text', '');
    $policy_link = get_theme_mod('footer_policy_link', array('url' => '', 'title' => '', 'target' => ''));
    $policy_link = is_array($policy_link) ? $policy_link : array('url' => '', 'title' => '', 'target' => '');
    $servicer_text = get_theme_mod('footer_servicer_text', '');
    $servicer_link = get_theme_mod('footer_servicer_link', array('url' => '', 'title' => '', 'target' => ''));
    $servicer_link = is_array($servicer_link) ? $servicer_link : array('url' => '', 'title' => '', 'target' => '');
?>
    <div class="wrap">
        <h1>Footer</h1>
        <h2 class="nav-tab-wrapper">
            <a href="#tab-banner" class="nav-tab nav-tab-active">Banner</a>
            <a href="#tab-information" class="nav-tab">Information</a>
            <a href="#tab-list-page" class="nav-tab">List Page</a>
            <a href="#tab-contact" class="nav-tab">Contact</a>
            <a href="#tab-contact-link" class="nav-tab">Contact Link</a>
            <a href="#tab-create-build" class="nav-tab">Create Build</a>
            <a href="#tab-policy" class="nav-tab">Policy</a>
            <a href="#tab-servicer" class="nav-tab">Servicer</a>
        </h2>
        <form method="post" action="<?= esc_url(admin_url('admin-post.php')) ?>">
            <input type="hidden" name="action" value="buildpro_save_footer" />
            <?php wp_nonce_field('buildpro_footer_save'); ?>
            <div id="buildpro-footer-sections">
                <div id="tab-banner" class="buildpro-footer-section active">
                    <div class="buildpro-block">
                        <h3>Banner</h3>
                        <div class="buildpro-field">
                            <input type="hidden" id="footer_banner_image_id" name="footer_banner_image_id"
                                value="<?= esc_attr($banner_image_id) ?>">
                            <button type="button" class="button" id="select_footer_banner_image">Select Image</button>
                            <button type="button" class="button" id="remove_footer_banner_image">Remove Image</button>
                        </div>
                        <div id="footer_banner_preview" class="image-preview">
                            <?= $banner_thumb ? '<img src="' . esc_url($banner_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn ảnh</span>' ?>
                        </div>
                    </div>
                </div>
                <div id="tab-information" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Information</h3>
                        <div class="buildpro-grid">
                            <div>
                                <div class="buildpro-field">
                                    <input type="hidden" id="footer_information_logo_id" name="footer_information_logo_id"
                                        value="<?= esc_attr($info_logo_id) ?>">
                                    <button type="button" class="button" id="select_footer_information_logo">Select
                                        image</button>
                                    <button type="button" class="button" id="remove_footer_information_logo">Remove
                                        image</button>
                                </div>
                                <div id="footer_information_logo_preview" class="image-preview">
                                    <?= $info_logo_thumb ? '<img src="' . esc_url($info_logo_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn logo</span>' ?>
                                </div>
                            </div>
                            <div>
                                <p class="buildpro-field">
                                    <label>Title</label>
                                    <input type="text" name="footer_information_title" class="regular-text"
                                        value="<?= esc_attr($info_title) ?>">
                                </p>
                                <p class="buildpro-field">
                                    <label>Sub Title</label>
                                    <input type="text" name="footer_information_sub_title" class="regular-text"
                                        value="<?= esc_attr($info_sub_title) ?>">
                                </p>
                                <p class="buildpro-field">
                                    <label>Description</label>
                                    <textarea name="footer_information_description" rows="4"
                                        class="large-text"><?= esc_textarea($info_description) ?></textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-list-page" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>List Page</h3>
                        <div id="footer-list-pages-wrapper">
                            <?php $lp_index = 0;
                            foreach ($list_pages as $lp):
                                $lp_url = isset($lp['url']) ? esc_url($lp['url']) : '';
                                $lp_title = isset($lp['title']) ? sanitize_text_field($lp['title']) : '';
                                $lp_target = isset($lp['target']) ? sanitize_text_field($lp['target']) : '';
                            ?>
                                <div class="buildpro-block" data-index="<?= esc_attr($lp_index) ?>">
                                    <p class="buildpro-field">
                                        <label>Link URL</label>
                                        <input type="url" name="footer_list_pages[<?= esc_attr($lp_index) ?>][url]"
                                            class="regular-text" value="<?= esc_attr($lp_url) ?>" placeholder="https://...">
                                        <button type="button" class="button choose-link">Choose link</button>
                                    </p>
                                    <p class="buildpro-field">
                                        <label>Link Title</label>
                                        <input type="text" name="footer_list_pages[<?= esc_attr($lp_index) ?>][title]"
                                            class="regular-text" value="<?= esc_attr($lp_title) ?>">
                                    </p>
                                    <p class="buildpro-field">
                                        <label>Link Target</label>
                                        <select name="footer_list_pages[<?= esc_attr($lp_index) ?>][target]">
                                            <option value="" <?= selected($lp_target, '', false) ?>>Same tab</option>
                                            <option value="_blank" <?= selected($lp_target, '_blank', false) ?>>Open new tabs
                                            </option>
                                        </select>
                                    </p>
                                    <div class="buildpro-actions">
                                        <button type="button" class="button remove-row">Remove item</button>
                                    </div>
                                </div>
                            <?php $lp_index++;
                            endforeach; ?>
                        </div>
                        <button type="button" class="button button-primary" id="footer-list-pages-add">Add item</button>
                    </div>
                </div>
                <div id="tab-contact" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Contact</h3>
                        <p class="buildpro-field">
                            <label>Location</label>
                            <input type="text" name="footer_contact_location" class="regular-text"
                                value="<?= esc_attr($contact_location) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Phone</label>
                            <input type="text" name="footer_contact_phone" class="regular-text"
                                value="<?= esc_attr($contact_phone) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Email</label>
                            <input type="email" name="footer_contact_email" class="regular-text"
                                value="<?= esc_attr($contact_email) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Time</label>
                            <input type="text" name="footer_contact_time" class="regular-text"
                                value="<?= esc_attr($contact_time) ?>">
                        </p>
                    </div>
                </div>
                <div id="tab-contact-link" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Contact Link</h3>
                        <div id="footer-contact-links-wrapper">
                            <?php $cl_index = 0;
                            foreach ($contact_links as $cl):
                                $cl_icon_id = isset($cl['icon_id']) ? absint($cl['icon_id']) : 0;
                                $cl_icon_thumb = $cl_icon_id ? wp_get_attachment_image_url($cl_icon_id, 'thumbnail') : '';
                                $cl_url = isset($cl['url']) ? esc_url($cl['url']) : '';
                                $cl_title = isset($cl['title']) ? sanitize_text_field($cl['title']) : '';
                                $cl_target = isset($cl['target']) ? sanitize_text_field($cl['target']) : '';
                            ?>
                                <div class="buildpro-block" data-index="<?= esc_attr($cl_index) ?>">
                                    <p class="buildpro-field">
                                        <label>Icon</label>
                                        <input type="hidden" name="footer_contact_links[<?= esc_attr($cl_index) ?>][icon_id]"
                                            value="<?= esc_attr($cl_icon_id) ?>">
                                        <button type="button" class="button select-contact-icon">Select photo</button>
                                        <button type="button" class="button remove-contact-icon">Remove photo</button>
                                    </p>
                                    <div class="image-preview contact-icon-preview">
                                        <?= $cl_icon_thumb ? '<img src="' . esc_url($cl_icon_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">No photo selected yet</span>' ?>
                                    </div>
                                    <p class="buildpro-field">
                                        <label>Link URL</label>
                                        <input type="url" name="footer_contact_links[<?= esc_attr($cl_index) ?>][url]"
                                            class="regular-text" value="<?= esc_attr($cl_url) ?>" placeholder="https://...">
                                        <button type="button" class="button choose-link">Choose link</button>
                                    </p>
                                    <p class="buildpro-field">
                                        <label>Link Title</label>
                                        <input type="text" name="footer_contact_links[<?= esc_attr($cl_index) ?>][title]"
                                            class="regular-text" value="<?= esc_attr($cl_title) ?>">
                                    </p>
                                    <p class="buildpro-field">
                                        <label>Link Target</label>
                                        <select name="footer_contact_links[<?= esc_attr($cl_index) ?>][target]">
                                            <option value="" <?= selected($cl_target, '', false) ?>>Default</option>
                                            <option value="_blank" <?= selected($cl_target, '_blank', false) ?>>Open new tabs
                                            </option>
                                        </select>
                                    </p>
                                    <div class="buildpro-actions">
                                        <button type="button" class="button remove-row">Remove item</button>
                                    </div>
                                </div>
                            <?php $cl_index++;
                            endforeach; ?>
                        </div>
                        <button type="button" class="button button-primary" id="footer-contact-links-add">Add item</button>
                    </div>
                </div>
                <div id="tab-create-build" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Create Build</h3>
                        <p class="buildpro-field">
                            <label>Text</label>
                            <input type="text" name="footer_create_build_text" class="regular-text"
                                value="<?= esc_attr($create_build_text) ?>">
                        </p>
                    </div>
                </div>
                <div id="tab-policy" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Policy</h3>
                        <p class="buildpro-field">
                            <label>Text</label>
                            <input type="text" name="footer_policy_text" class="regular-text"
                                value="<?= esc_attr($policy_text) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Link URL</label>
                            <input type="url" id="footer_policy_link_url" name="footer_policy_link[url]"
                                class="regular-text" value="<?= esc_attr($policy_link['url']) ?>" placeholder="https://...">
                            <button type="button" class="button choose-link-single" data-url="#footer_policy_link_url"
                                data-title="#footer_policy_link_title" data-target="#footer_policy_link_target">Choose
                                link</button>
                        </p>
                        <p class="buildpro-field">
                            <label>Link Title</label>
                            <input type="text" id="footer_policy_link_title" name="footer_policy_link[title]"
                                class="regular-text" value="<?= esc_attr($policy_link['title']) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Link Target</label>
                            <select id="footer_policy_link_target" name="footer_policy_link[target]">
                                <option value="" <?= selected($policy_link['target'], '', false) ?>>Default</option>
                                <option value="_blank" <?= selected($policy_link['target'], '_blank', false) ?>>Open new
                                    tabs</option>
                            </select>
                        </p>
                    </div>
                </div>
                <div id="tab-servicer" class="buildpro-footer-section">
                    <div class="buildpro-block">
                        <h3>Servicer</h3>
                        <p class="buildpro-field">
                            <label>Text</label>
                            <input type="text" name="footer_servicer_text" class="regular-text"
                                value="<?= esc_attr($servicer_text) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Link URL</label>
                            <input type="url" id="footer_servicer_link_url" name="footer_servicer_link[url]"
                                class="regular-text" value="<?= esc_attr($servicer_link['url']) ?>"
                                placeholder="https://...">
                            <button type="button" class="button choose-link-single" data-url="#footer_servicer_link_url"
                                data-title="#footer_servicer_link_title" data-target="#footer_servicer_link_target">Choose
                                link</button>
                        </p>
                        <p class="buildpro-field">
                            <label>Link Title</label>
                            <input type="text" id="footer_servicer_link_title" name="footer_servicer_link[title]"
                                class="regular-text" value="<?= esc_attr($servicer_link['title']) ?>">
                        </p>
                        <p class="buildpro-field">
                            <label>Link Target</label>
                            <select id="footer_servicer_link_target" name="footer_servicer_link[target]">
                                <option value="" <?= selected($servicer_link['target'], '', false) ?>>Default</option>
                                <option value="_blank" <?= selected($servicer_link['target'], '_blank', false) ?>>Open new
                                    tabs</option>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
            <?php submit_button('submit change'); ?>
            <div id="buildpro-custom-link-backdrop"></div>
            <div id="buildpro-custom-link-modal">
                <div class="buildpro-custom-link-header">Choose link</div>
                <div class="buildpro-custom-link-body">
                    <div class="buildpro-custom-link-grid">
                        <div>
                            <p class="buildpro-custom-link-row"><label>URL</label><input type="url"
                                    id="buildpro_custom_link_url" class="regular-text" placeholder="https://..."></p>
                            <p class="buildpro-custom-link-row"><label>Link Text</label><input type="text"
                                    id="buildpro_custom_link_title" class="regular-text" placeholder=""></p>
                            <p class="buildpro-custom-link-row"><label><input type="checkbox"
                                        id="buildpro_custom_link_target"> Open new tabs</label></p>
                        </div>
                        <div>
                            <p class="buildpro-custom-link-row"><label>Search</label><input type="search"
                                    id="buildpro_custom_link_search" class="regular-text" placeholder="Enter keyword...">
                            </p>
                            <p class="buildpro-custom-link-row"><label>Source</label><select
                                    id="buildpro_custom_link_source">
                                    <option value="all">All</option>
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                </select></p>
                            <div id="buildpro_custom_link_results"></div>
                        </div>
                    </div>
                </div>
                <div class="buildpro-custom-link-actions">
                    <button type="button" class="button" id="buildpro_custom_link_cancel">Cancel</button>
                    <button type="button" class="button button-primary" id="buildpro_custom_link_apply">Apply</button>
                </div>
            </div>
        </form>
    </div>
<?php
}

function buildpro_handle_footer_save()
{
    if (!current_user_can('edit_theme_options')) {
        wp_die('Not allowed');
    }
    check_admin_referer('buildpro_footer_save');
    $banner_image_id = isset($_POST['footer_banner_image_id']) ? absint($_POST['footer_banner_image_id']) : 0;
    $info_logo_id = isset($_POST['footer_information_logo_id']) ? absint($_POST['footer_information_logo_id']) : 0;
    $info_title = isset($_POST['footer_information_title']) ? sanitize_text_field($_POST['footer_information_title']) : '';
    $info_sub_title = isset($_POST['footer_information_sub_title']) ? sanitize_text_field($_POST['footer_information_sub_title']) : '';
    $info_description = isset($_POST['footer_information_description']) ? sanitize_textarea_field($_POST['footer_information_description']) : '';
    $list_pages = isset($_POST['footer_list_pages']) && is_array($_POST['footer_list_pages']) ? $_POST['footer_list_pages'] : array();
    $clean_lp = array();
    foreach ($list_pages as $lp) {
        $clean_lp[] = array(
            'url' => isset($lp['url']) ? esc_url_raw($lp['url']) : '',
            'title' => isset($lp['title']) ? sanitize_text_field($lp['title']) : '',
            'target' => isset($lp['target']) ? sanitize_text_field($lp['target']) : '',
        );
    }
    $contact_location = isset($_POST['footer_contact_location']) ? sanitize_text_field($_POST['footer_contact_location']) : '';
    $contact_phone = isset($_POST['footer_contact_phone']) ? sanitize_text_field($_POST['footer_contact_phone']) : '';
    $contact_email = isset($_POST['footer_contact_email']) ? sanitize_email($_POST['footer_contact_email']) : '';
    $contact_time = isset($_POST['footer_contact_time']) ? sanitize_text_field($_POST['footer_contact_time']) : '';
    $contact_links = isset($_POST['footer_contact_links']) && is_array($_POST['footer_contact_links']) ? $_POST['footer_contact_links'] : array();
    $clean_cl = array();
    foreach ($contact_links as $cl) {
        $clean_cl[] = array(
            'icon_id' => isset($cl['icon_id']) ? absint($cl['icon_id']) : 0,
            'url' => isset($cl['url']) ? esc_url_raw($cl['url']) : '',
            'title' => isset($cl['title']) ? sanitize_text_field($cl['title']) : '',
            'target' => isset($cl['target']) ? sanitize_text_field($cl['target']) : '',
        );
    }
    $create_build_text = isset($_POST['footer_create_build_text']) ? sanitize_text_field($_POST['footer_create_build_text']) : '';
    $policy_text = isset($_POST['footer_policy_text']) ? sanitize_text_field($_POST['footer_policy_text']) : '';
    $policy_link = isset($_POST['footer_policy_link']) && is_array($_POST['footer_policy_link']) ? $_POST['footer_policy_link'] : array();
    $clean_policy_link = array(
        'url' => isset($policy_link['url']) ? esc_url_raw($policy_link['url']) : '',
        'title' => isset($policy_link['title']) ? sanitize_text_field($policy_link['title']) : '',
        'target' => isset($policy_link['target']) ? sanitize_text_field($policy_link['target']) : '',
    );
    $servicer_text = isset($_POST['footer_servicer_text']) ? sanitize_text_field($_POST['footer_servicer_text']) : '';
    $servicer_link = isset($_POST['footer_servicer_link']) && is_array($_POST['footer_servicer_link']) ? $_POST['footer_servicer_link'] : array();
    $clean_servicer_link = array(
        'url' => isset($servicer_link['url']) ? esc_url_raw($servicer_link['url']) : '',
        'title' => isset($servicer_link['title']) ? sanitize_text_field($servicer_link['title']) : '',
        'target' => isset($servicer_link['target']) ? sanitize_text_field($servicer_link['target']) : '',
    );
    set_theme_mod('footer_banner_image_id', $banner_image_id);
    set_theme_mod('footer_information_logo_id', $info_logo_id);
    set_theme_mod('footer_information_title', $info_title);
    set_theme_mod('footer_information_sub_title', $info_sub_title);
    set_theme_mod('footer_information_description', $info_description);
    set_theme_mod('footer_list_pages', $clean_lp);
    set_theme_mod('footer_contact_location', $contact_location);
    set_theme_mod('footer_contact_phone', $contact_phone);
    set_theme_mod('footer_contact_email', $contact_email);
    set_theme_mod('footer_contact_time', $contact_time);
    set_theme_mod('footer_contact_links', $clean_cl);
    set_theme_mod('footer_create_build_text', $create_build_text);
    set_theme_mod('footer_policy_text', $policy_text);
    set_theme_mod('footer_policy_link', $clean_policy_link);
    set_theme_mod('footer_servicer_text', $servicer_text);
    set_theme_mod('footer_servicer_link', $clean_servicer_link);
    wp_redirect(admin_url('themes.php?page=buildpro-footer&updated=1'));
    exit;
}
add_action('admin_post_buildpro_save_footer', 'buildpro_handle_footer_save');
