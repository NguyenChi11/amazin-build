<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<div class="buildpro-materials-block" style="margin-bottom:10px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:12px">
    <h4>Trạng thái Section Product</h4>
    <input type="hidden" id="materials_enabled" name="materials_enabled" value="<?php echo isset($materials_enabled) ? (int)$materials_enabled : 1; ?>">
    <div style="display:flex;gap:8px">
        <button type="button" class="button button-secondary" id="materials_disable_btn">Xóa Section</button>
        <button type="button" class="button button-primary" id="materials_enable_btn">Thêm Section</button>
        <span id="materials_enabled_state" style="align-self:center;color:#374151"></span>
    </div>
</div>
<div class="buildpro-materials-block" id="buildpro-materials-meta-box">
    <p class="buildpro-materials-field">
        <label>Tiêu đề Materials</label>
        <input type="text" name="materials_title" class="regular-text" value="<?php echo esc_attr($materials_title); ?>"
            placeholder="MATERIALS">
    </p>
    <p class="buildpro-materials-field">
        <label>Mô tả</label>
        <textarea name="materials_description" rows="4" class="large-text"
            placeholder="Mô tả ngắn"><?php echo esc_textarea($materials_description); ?></textarea>
    </p>
</div>