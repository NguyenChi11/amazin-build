<?php
$data = isset($data) && is_array($data) ? $data : array();
$title = isset($data['title']) ? sanitize_text_field($data['title']) : '';
$desc  = isset($data['description']) ? sanitize_textarea_field($data['description']) : '';
?>
<input type="hidden" id="buildpro-projects-title-data" <?php $this->link(); ?>
    value="<?php echo esc_attr(wp_json_encode(array('title' => $title, 'description' => $desc))); ?>">
<div id="buildpro-projects-title-wrapper">
    <div class="buildpro-projects-title-block">
        <h4>Projects Title</h4>
        <p class="buildpro-projects-title-field">
            <label>Title</label>
            <input type="text" class="regular-text" data-field="title" value="<?php echo esc_attr($title); ?>">
        </p>
        <h4>Description</h4>
        <p class="buildpro-projects-title-field">
            <label>Description</label>
            <textarea rows="4" class="large-text" data-field="description"><?php echo esc_textarea($desc); ?></textarea>
        </p>
    </div>
    <p class="description">Thay đổi hiển thị ngay trong preview. Publish để lưu.</p>
</div>