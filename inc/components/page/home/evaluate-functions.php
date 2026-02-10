<?php
function buildpro_evaluate_add_meta_box($post_type, $post)
{
    if ($post_type !== 'page') {
        return;
    }
    $template = get_page_template_slug($post->ID);
    $front_id = (int) get_option('page_on_front');
    if ($template !== 'home-page.php' && (int)$post->ID !== $front_id) {
        return;
    }
    add_meta_box(
        'buildpro_evaluate_meta',
        'Evaluate',
        'buildpro_evaluate_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_evaluate_add_meta_box', 10, 2);

function buildpro_evaluate_render_meta_box($post)
{
    wp_nonce_field('buildpro_evaluate_meta_save', 'buildpro_evaluate_meta_nonce');
    wp_enqueue_media();
    $title = get_post_meta($post->ID, 'buildpro_evaluate_title', true);
    $text = get_post_meta($post->ID, 'buildpro_evaluate_text', true);
    $desc = get_post_meta($post->ID, 'buildpro_evaluate_desc', true);
    $items = get_post_meta($post->ID, 'buildpro_evaluate_items', true);
    $items = is_array($items) ? $items : array();
    echo '<style>
    .buildpro-evaluate-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
    .buildpro-evaluate-field{margin:10px 0}
    .buildpro-evaluate-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
    .buildpro-evaluate-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-evaluate-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-evaluate-row{border:1px solid #e5e7eb;padding:12px;margin:12px 0;background:#fff;border-radius:10px}
    .buildpro-evaluate-grid{display:grid;grid-template-columns:200px 1fr;gap:16px;align-items:start}
    .buildpro-evaluate-col{background:#f7f7f7;padding:10px;border-radius:8px}
    .buildpro-evaluate-actions{margin-top:10px;text-align:right}
    .evaluate-avatar-preview{margin-top:8px;min-height:120px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px}
    </style>';
    echo '<div id="buildpro_evaluate_meta" class="buildpro-evaluate-block">';
    echo '<p class="buildpro-evaluate-field"><label>Title</label><input type="text" name="buildpro_evaluate_title" class="regular-text" value="' . esc_attr($title) . '" placeholder="Title"></p>';
    echo '<p class="buildpro-evaluate-field"><label>Text</label><input type="text" name="buildpro_evaluate_text" class="regular-text" value="' . esc_attr($text) . '" placeholder="Text"></p>';
    echo '<p class="buildpro-evaluate-field"><label>Description</label><textarea name="buildpro_evaluate_desc" rows="4" class="large-text" placeholder="Description">' . esc_textarea($desc) . '</textarea></p>';
    echo '</div>';
    echo '<div id="buildpro_evaluate_items_wrap" class="buildpro-evaluate-block">';
    $index = 0;
    foreach ($items as $item) {
        $name = isset($item['name']) ? sanitize_text_field($item['name']) : '';
        $position = isset($item['position']) ? sanitize_text_field($item['position']) : '';
        $description = isset($item['description']) ? sanitize_textarea_field($item['description']) : '';
        $avatar_id = isset($item['avatar_id']) ? (int)$item['avatar_id'] : 0;
        $thumb = $avatar_id ? wp_get_attachment_image_url($avatar_id, 'thumbnail') : '';
        echo '<div class="buildpro-evaluate-row" data-index="' . esc_attr($index) . '">';
        echo '<div class="buildpro-evaluate-grid">';
        echo '<div class="buildpro-evaluate-col">';
        echo '<p class="buildpro-evaluate-field"><label>Avatar</label><input type="hidden" class="evaluate-avatar-id" name="buildpro_evaluate_items[' . esc_attr($index) . '][avatar_id]" value="' . esc_attr($avatar_id) . '"> <button type="button" class="button evaluate-select-avatar">Chọn ảnh</button> <button type="button" class="button evaluate-remove-avatar">Xóa ảnh</button></p>';
        echo '<div class="evaluate-avatar-preview">' . ($thumb ? '<img src="' . esc_url($thumb) . '" style="max-height:112px">' : '<span style="color:#888">No photo selected yet</span>') . '</div>';
        echo '</div>';
        echo '<div class="buildpro-evaluate-col">';
        echo '<p class="buildpro-evaluate-field"><label>Name</label><input type="text" name="buildpro_evaluate_items[' . esc_attr($index) . '][name]" class="regular-text" value="' . esc_attr($name) . '" placeholder="Name"></p>';
        echo '<p class="buildpro-evaluate-field"><label>Position</label><input type="text" name="buildpro_evaluate_items[' . esc_attr($index) . '][position]" class="regular-text" value="' . esc_attr($position) . '" placeholder="Position"></p>';
        echo '<p class="buildpro-evaluate-field"><label>Description</label><textarea name="buildpro_evaluate_items[' . esc_attr($index) . '][description]" rows="4" class="large-text" placeholder="Description">' . esc_textarea($description) . '</textarea></p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="buildpro-evaluate-actions"><button type="button" class="button evaluate-remove-row">Xóa</button></div>';
        echo '</div>';
        $index++;
    }
    echo '<button type="button" class="button button-primary" id="buildpro_evaluate_add_row">Add a row</button>';
    echo '</div>';
    echo '<script>
    (function(){
        var wrap = document.getElementById("buildpro_evaluate_items_wrap");
        var addBtn = document.getElementById("buildpro_evaluate_add_row");
        function bindRow(row){
            var rmRow = row.querySelector(".evaluate-remove-row");
            if(rmRow){ rmRow.addEventListener("click", function(e){ e.preventDefault(); row.parentNode.removeChild(row); }); }
            var selBtn = row.querySelector(".evaluate-select-avatar");
            var rmBtn = row.querySelector(".evaluate-remove-avatar");
            var input = row.querySelector(".evaluate-avatar-id");
            var prev = row.querySelector(".evaluate-avatar-preview");
            if(selBtn){
                selBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    var frame = wp.media({ title: "Select a photo", button: { text: "Use this photo" }, multiple: false, library: { type: "image" } });
                    frame.on("select", function(){
                        var a = frame.state().get("selection").first().toJSON();
                        input.value = a.id;
                        var url = (a.sizes && a.sizes.thumbnail) ? a.sizes.thumbnail.url : a.url;
                        prev.innerHTML = "<img src=\'"+url+"\' style=\'max-height:112px\'>";
                    });
                    frame.open();
                });
            }
            if(rmBtn){
                rmBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    input.value = "";
                    prev.innerHTML = "<span style=\\"color:#888\\">No photo selected yet</span>";
                });
            }
        }
        Array.prototype.forEach.call(wrap.querySelectorAll(".buildpro-evaluate-row"), bindRow);
        if(addBtn){
            addBtn.addEventListener("click", function(e){
                e.preventDefault();
                var idx = wrap.querySelectorAll(".buildpro-evaluate-row").length;
                var html = "<div class=\\"buildpro-evaluate-row\\" data-index=\\""+idx+"\\">"
                    + "<div class=\\"buildpro-evaluate-grid\\">"
                    + "<div class=\\"buildpro-evaluate-col\\">"
                    + "<p class=\\"buildpro-evaluate-field\\"><label>Avatar</label><input type=\\"hidden\\" class=\\"evaluate-avatar-id\\" name=\\"buildpro_evaluate_items["+idx+"][avatar_id]\\" value=\\"\\"> <button type=\\"button\\" class=\\"button evaluate-select-avatar\\">Select photo</button> <button type=\\"button\\" class=\\"button evaluate-remove-avatar\\">Remove photo</button></p>"
                    + "<div class=\\"evaluate-avatar-preview\\"><span style=\\"color:#888\\">Chưa chọn ảnh</span></div>"
                    + "</div>"
                    + "<div class=\\"buildpro-evaluate-col\\">"
                    + "<p class=\\"buildpro-evaluate-field\\"><label>Name</label><input type=\\"text\\" name=\\"buildpro_evaluate_items["+idx+"][name]\\" class=\\"regular-text\\" value=\\"\\"></p>"
                    + "<p class=\\"buildpro-evaluate-field\\"><label>Position</label><input type=\\"text\\" name=\\"buildpro_evaluate_items["+idx+"][position]\\" class=\\"regular-text\\" value=\\"\\"></p>"
                    + "<p class=\\"buildpro-evaluate-field\\"><label>Description</label><textarea name=\\"buildpro_evaluate_items["+idx+"][description]\\" rows=\\"4\\" class=\\"large-text\\"></textarea></p>"
                    + "</div>"
                    + "</div>"
                    + "<div class=\\"buildpro-evaluate-actions\\"><button type=\\"button\\" class=\\"button evaluate-remove-row\\">Xóa</button></div>"
                    + "</div>";
                var temp = document.createElement("div");
                temp.innerHTML = html;
                var row = temp.firstElementChild;
                wrap.appendChild(row);
                bindRow(row);
            });
        }
    })();
    </script>';
}

function buildpro_save_evaluate_meta($post_id)
{
    if (!isset($_POST['buildpro_evaluate_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_evaluate_meta_nonce'], 'buildpro_evaluate_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $template = get_page_template_slug($post_id);
    $front_id = (int) get_option('page_on_front');
    if ($template !== 'home-page.php' && (int)$post_id !== $front_id) {
        return;
    }
    $title = isset($_POST['buildpro_evaluate_title']) ? sanitize_text_field($_POST['buildpro_evaluate_title']) : '';
    $text = isset($_POST['buildpro_evaluate_text']) ? sanitize_text_field($_POST['buildpro_evaluate_text']) : '';
    $desc = isset($_POST['buildpro_evaluate_desc']) ? sanitize_textarea_field($_POST['buildpro_evaluate_desc']) : '';
    $items_raw = isset($_POST['buildpro_evaluate_items']) && is_array($_POST['buildpro_evaluate_items']) ? $_POST['buildpro_evaluate_items'] : array();
    $clean = array();
    foreach ($items_raw as $it) {
        $clean[] = array(
            'name' => isset($it['name']) ? sanitize_text_field($it['name']) : '',
            'position' => isset($it['position']) ? sanitize_text_field($it['position']) : '',
            'description' => isset($it['description']) ? sanitize_textarea_field($it['description']) : '',
            'avatar_id' => isset($it['avatar_id']) ? absint($it['avatar_id']) : 0,
        );
    }
    update_post_meta($post_id, 'buildpro_evaluate_title', $title);
    update_post_meta($post_id, 'buildpro_evaluate_text', $text);
    update_post_meta($post_id, 'buildpro_evaluate_desc', $desc);
    update_post_meta($post_id, 'buildpro_evaluate_items', $clean);
    set_theme_mod('buildpro_evaluate_title', $title);
    set_theme_mod('buildpro_evaluate_text', $text);
    set_theme_mod('buildpro_evaluate_desc', $desc);
    set_theme_mod('buildpro_evaluate_items', $clean);
}
add_action('save_post_page', 'buildpro_save_evaluate_meta');
