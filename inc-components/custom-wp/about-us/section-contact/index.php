<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<div id="buildpro_about_contact_meta">
    <div class="buildpro-admin-tabs">
        <button type="button" class="button buildpro-about-contact-tabs is-active"
            data-tab="buildpro_about_contact_tab_content">Content</button>
        <button type="button" class="button buildpro-about-contact-tabs"
            data-tab="buildpro_about_contact_tab_contact">Contact</button>
    </div>
    <div id="buildpro_about_contact_tab_content">
        <p><label><input type="checkbox" name="buildpro_about_contact_enabled" value="1"
                    <?php checked($enabled, 1); ?>>Enable Contact</label></p>
        <p><label>Title<br><input type="text" class="widefat" name="buildpro_about_contact_title"
                    value="<?php echo esc_attr($title); ?>"></label></p>
        <p><label>Text<br><input type="text" class="widefat" name="buildpro_about_contact_text"
                    value="<?php echo esc_attr($text); ?>"></label></p>
    </div>
    <div id="buildpro_about_contact_tab_contact" style="display: none;">
        <p><label>Address<br><input type="text" class="widefat" name="buildpro_about_contact_address"
                    value="<?php echo esc_attr($address); ?>"></label></p>
        <p><label>Phone<br><input type="text" class="widefat" name="buildpro_about_contact_phone"
                    value="<?php echo esc_attr($phone); ?>"></label></p>
        <p><label>Email<br><input type="text" class="widefat" name="buildpro_about_contact_email"
                    value="<?php echo esc_attr($email); ?>"></label></p>
    </div>
</div>