<?php
// $items is provided by the including scope (BuildPro_Banner_Repeater_Control::render_content)
// $this is WP_Customize_Control instance; we use $this->link() to bind the hidden input
if (!is_array($items)) {
    $items = array();
}
?>
<input type="hidden" id="buildpro-banner-data" <?php $this->link(); ?>
    value="<?php echo esc_attr(wp_json_encode($items)); ?>">
<div id="buildpro-banner-wrapper">
    <?php
    $index = 0;
    foreach ($items as $item) {
        $image_id   = isset($item['image_id']) ? (int) $item['image_id'] : 0;
        $type       = isset($item['type']) ? sanitize_text_field($item['type']) : '';
        $text       = isset($item['text']) ? sanitize_text_field($item['text']) : '';
        $desc       = isset($item['description']) ? sanitize_textarea_field($item['description']) : '';
        $link_url   = isset($item['link_url']) ? esc_url_raw($item['link_url']) : '';
        $link_title = isset($item['link_title']) ? sanitize_text_field($item['link_title']) : '';
        $link_target = isset($item['link_target']) ? sanitize_text_field($item['link_target']) : '';
        $thumb = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
        ?>
    <div class="buildpro-banner-row" data-index="<?php echo esc_attr($index); ?>">
        <div class="buildpro-banner-grid">
            <div class="buildpro-banner-block">
                <h4>Hình ảnh</h4>
                <div class="buildpro-banner-field">
                    <input type="hidden" class="banner-image-id" data-field="image_id"
                        value="<?php echo esc_attr($image_id); ?>">
                    <button type="button" class="button select-banner-image">Chọn ảnh</button>
                    <button type="button" class="button remove-banner-image">Xóa ảnh</button>
                </div>
                <div class="banner-image-preview"
                    style="margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px">
                    <?php echo $thumb ? '<img src="' . esc_url($thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn ảnh</span>'; ?>
                </div>
            </div>
            <div class="buildpro-banner-block">
                <h4>Nội dung</h4>
                <p class="buildpro-banner-field"><label>Type</label><input type="text" class="regular-text"
                        data-field="type" value="<?php echo esc_attr($type); ?>"></p>
                <p class="buildpro-banner-field"><label>Text</label><input type="text" class="regular-text"
                        data-field="text" value="<?php echo esc_attr($text); ?>"></p>
                <p class="buildpro-banner-field"><label>Mô tả</label><textarea rows="4" class="large-text"
                        data-field="description"><?php echo esc_textarea($desc); ?></textarea></p>
                <h4>Liên kết</h4>
                <p class="buildpro-banner-field"><label>Link URL</label><input type="url" class="regular-text"
                        data-field="link_url" value="<?php echo esc_attr($link_url); ?>" placeholder="https://...">
                    <button type="button" class="button choose-link">Chọn link</button></p>
                <p class="buildpro-banner-field"><label>Link Target</label><select data-field="link_target">
                        <option value="" <?php selected($link_target, '', true); ?>>Mặc định</option>
                        <option value="_blank" <?php selected($link_target, '_blank', true); ?>>Mở tab mới</option>
                    </select></p>
                <div class="buildpro-link-panel" style="display:none;margin-top:8px">
                    <div class="buildpro-banner-block" style="background:#fff">
                        <h4>Chọn liên kết</h4>
                        <p class="buildpro-banner-field"><label>Tìm kiếm trang/bài viết</label><input type="text"
                                class="regular-text buildpro-link-search" placeholder="Nhập từ khóa..."></p>
                        <div class="buildpro-link-results"
                            style="max-height:190px;overflow:auto;border:1px solid #eee;border-radius:6px;background:#fafafa;padding:6px">
                        </div>
                        <p class="buildpro-banner-field"><label><input type="checkbox" class="buildpro-link-target"> Mở
                                tab mới (_blank)</label></p>
                        <div class="buildpro-banner-actions"><button type="button"
                                class="button buildpro-link-close">Đóng</button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="buildpro-banner-actions"><button type="button" class="button remove-banner-row">Xóa mục</button>
        </div>
    </div>
    <?php
        $index++;
    }
    ?>
</div>
<button type="button" class="button button-primary" id="buildpro-banner-add">Thêm mục</button>