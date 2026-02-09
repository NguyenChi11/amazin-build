<?php
$items = isset($items) && is_array($items) ? $items : array();
?>
<div id="buildpro-option-wrapper">
    <?php
    $index = 0;
    foreach ($items as $item) {
        $icon_id = isset($item['icon_id']) ? (int)$item['icon_id'] : 0;
        $text = isset($item['text']) ? sanitize_text_field($item['text']) : '';
        $desc = isset($item['description']) ? sanitize_textarea_field($item['description']) : '';
        $thumb = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
    ?>
    <div class="buildpro-option-row" data-index="<?php echo esc_attr($index); ?>">
        <div class="buildpro-option-grid">
            <div class="buildpro-option-block">
                <h4>Icon</h4>
                <div class="buildpro-option-field">
                    <input type="hidden" class="option-icon-id"
                        name="buildpro_option_items[<?php echo esc_attr($index); ?>][icon_id]"
                        value="<?php echo esc_attr($icon_id); ?>">
                    <button type="button" class="button select-option-icon">Chọn icon</button>
                    <button type="button" class="button remove-option-icon">Xóa icon</button>
                </div>
                <div class="option-icon-preview">
                    <?php
                        if ($thumb) {
                            echo '<img src="' . esc_url($thumb) . '">';
                        } else {
                            echo '<span class="option-icon-placeholder">Chưa chọn icon</span>';
                        }
                        ?>
                </div>
            </div>
            <div class="buildpro-option-block">
                <h4>Nội dung</h4>
                <p class="buildpro-option-field">
                    <label>Text</label>
                    <input type="text" name="buildpro_option_items[<?php echo esc_attr($index); ?>][text]"
                        class="regular-text" value="<?php echo esc_attr($text); ?>">
                </p>
                <p class="buildpro-option-field">
                    <label>Mô tả</label>
                    <textarea name="buildpro_option_items[<?php echo esc_attr($index); ?>][description]" rows="4"
                        class="large-text"><?php echo esc_textarea($desc); ?></textarea>
                </p>
            </div>
        </div>
        <div class="buildpro-option-actions">
            <button type="button" class="button remove-option-row">Xóa mục</button>
        </div>
    </div>
    <?php
        $index++;
    }
    ?>
</div>
<button type="button" class="button button-primary" id="buildpro-option-add">Thêm mục</button>