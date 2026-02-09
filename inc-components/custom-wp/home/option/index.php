<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<template id="buildpro-option-row-template">
    <div class="buildpro-option-row" data-index="__INDEX__">
        <div class="buildpro-option-grid">
            <div class="buildpro-option-block">
                <h4>Icon</h4>
                <div class="buildpro-option-field">
                    <input type="hidden" class="option-icon-id" name="buildpro_option_items[__INDEX__][icon_id]"
                        value="">
                    <button type="button" class="button select-option-icon">Chọn icon</button>
                    <button type="button" class="button remove-option-icon">Xóa icon</button>
                </div>
                <div class="option-icon-preview"
                    style="margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px">
                    <span style="color:#888">Chưa chọn icon</span>
                </div>
            </div>
            <div class="buildpro-option-block">
                <h4>Nội dung</h4>
                <p class="buildpro-option-field"><label>Text</label><input type="text"
                        name="buildpro_option_items[__INDEX__][text]" class="regular-text" value=""></p>
                <p class="buildpro-option-field"><label>Mô tả</label><textarea
                        name="buildpro_option_items[__INDEX__][description]" rows="4" class="large-text"></textarea></p>
            </div>
        </div>
        <div class="buildpro-option-actions"><button type="button" class="button remove-option-row">Xóa mục</button>
        </div>
    </div>
</template>
<div id="buildpro-option-wrapper"></div>
<button type="button" class="button button-primary" id="buildpro-option-add">Thêm mục</button>