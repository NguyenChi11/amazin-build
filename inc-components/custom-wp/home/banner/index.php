<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<template id="buildpro-banner-row-template">
    <div class="buildpro-banner-row" data-index="__INDEX__">
        <div class="buildpro-banner-grid">
            <div class="buildpro-banner-block">
                <h4>Hình ảnh</h4>
                <div class="buildpro-banner-field">
                    <input type="hidden" class="banner-image-id" name="buildpro_banner_items[__INDEX__][image_id]"
                        value="">
                    <button type="button" class="button select-banner-image">Chọn ảnh</button>
                    <button type="button" class="button remove-banner-image">Xóa ảnh</button>
                </div>
                <div class="banner-image-preview"
                    style="margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px">
                    <span style="color:#888">Chưa chọn ảnh </span>
                </div>
            </div>
            <div class="buildpro-banner-block">
                <h4>Nội dung</h4>
                <p class="buildpro-banner-field"><label>Type</label><input type="text"
                        name="buildpro_banner_items[__INDEX__][type]" class="regular-text" value=""></p>
                <p class="buildpro-banner-field"><label>Text</label><input type="text"
                        name="buildpro_banner_items[__INDEX__][text]" class="regular-text" value=""></p>
                <p class="buildpro-banner-field"><label>Mô tả</label><textarea
                        name="buildpro_banner_items[__INDEX__][description]" rows="4" class="large-text"></textarea></p>
                <h4>Liên kết</h4>
                <p class="buildpro-banner-field"><label>Link URL</label><input type="url"
                        name="buildpro_banner_items[__INDEX__][link_url]" class="regular-text" value=""
                        placeholder="https://..."> <button type="button" class="button choose-link">Chọn link</button>
                </p>
                <p class="buildpro-banner-field"><label>Link Title</label><input type="text"
                        name="buildpro_banner_items[__INDEX__][link_title]" class="regular-text" value=""
                        placeholder="Text nút"></p>
                <p class="buildpro-banner-field"><label>Link Target</label><select
                        name="buildpro_banner_items[__INDEX__][link_target]">
                        <option value="">Mặc định</option>
                        <option value="_blank">Mở tab mới</option>
                    </select></p>
            </div>
        </div>
        <div class="buildpro-banner-actions"><button type="button" class="button remove-banner-row">Xóa mục</button>
        </div>
    </div>
</template>
<div id="buildpro-banner-wrapper"></div>
<button type="button" class="button button-primary" id="buildpro-banner-add">Thêm mục</button>