<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<template id="buildpro-data-row-template">
    <div class="buildpro-data-row" data-index="__INDEX__">
        <div class="buildpro-data-grid">
            <div class="buildpro-data-block">
                <h4>Number</h4>
                <p class="buildpro-data-field"><label>Number</label><input type="text"
                        name="buildpro_data_items[__INDEX__][number]" class="regular-text" value=""></p>
            </div>
            <div class="buildpro-data-block">
                <h4>Text</h4>
                <p class="buildpro-data-field"><label>Text</label><input type="text"
                        name="buildpro_data_items[__INDEX__][text]" class="regular-text" value=""></p>
            </div>
        </div>
        <div class="buildpro-data-actions"><button type="button" class="button remove-data-row">Xóa mục</button></div>
    </div>
</template>
<div id="buildpro-data-wrapper"></div>
<button type="button" class="button button-primary" id="buildpro-data-add">Thêm mục</button>