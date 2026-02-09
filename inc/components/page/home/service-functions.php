<?php
function buildpro_services_add_meta_box($post_type, $post)
{
    if ($post_type !== 'page') {
        return;
    }
    $template = get_page_template_slug($post->ID);
    if ($template !== 'home-page.php') {
        return;
    }
    add_meta_box(
        'buildpro_services_meta',
        'Services',
        'buildpro_services_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_services_add_meta_box', 10, 2);

function buildpro_services_render_meta_box($post)
{
    wp_nonce_field('buildpro_services_meta_save', 'buildpro_services_meta_nonce');
    wp_enqueue_media();
    $service_title = get_post_meta($post->ID, 'buildpro_service_title', true);
    $service_desc = get_post_meta($post->ID, 'buildpro_service_desc', true);
    $items = get_post_meta($post->ID, 'buildpro_service_items', true);
    $items = is_array($items) ? $items : array();
    echo '<style>
    .buildpro-services-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
    .buildpro-services-field{margin:10px 0}
    .buildpro-services-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
    .buildpro-services-block .regular-text{width:100%;max-width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-services-block .large-text{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
    .buildpro-service-row{border:1px solid #e5e7eb;padding:12px;margin:12px 0;background:#fff;border-radius:10px}
    .buildpro-service-grid{display:grid;grid-template-columns:260px 1fr;gap:16px;align-items:start}
    .buildpro-service-block{background:#f7f7f7;padding:10px;border-radius:8px}
    .buildpro-service-block h4{margin:0 0 8px;font-size:13px}
    .buildpro-service-field{margin:8px 0}
    .buildpro-service-actions{margin-top:10px;text-align:right}
    .service-icon-preview{margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px}
    </style>';
    echo '<div class="buildpro-services-block">';
    echo '<p class="buildpro-services-field"><label>Tiêu đề Services</label><input type="text" name="buildpro_service_title" class="regular-text" value="' . esc_attr($service_title) . '" placeholder="CORE SERVICES"></p>';
    echo '<p class="buildpro-services-field"><label>Mô tả</label><textarea name="buildpro_service_desc" rows="4" class="large-text" placeholder="Comprehensive construction solutions">' . esc_textarea($service_desc) . '</textarea></p>';
    echo '</div>';
    echo '<div id="buildpro-service-wrapper">';
    $index = 0;
    foreach ($items as $item) {
        $icon_id = isset($item['icon_id']) ? (int)$item['icon_id'] : 0;
        $title = isset($item['title']) ? sanitize_text_field($item['title']) : '';
        $desc = isset($item['description']) ? sanitize_textarea_field($item['description']) : '';
        $link_url = isset($item['link_url']) ? esc_url_raw($item['link_url']) : '';
        $link_title = isset($item['link_title']) ? sanitize_text_field($item['link_title']) : '';
        $link_target = isset($item['link_target']) ? sanitize_text_field($item['link_target']) : '';
        $thumb = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
        echo '<div class="buildpro-service-row" data-index="' . esc_attr($index) . '"><div class="buildpro-service-grid">';
        echo '<div class="buildpro-service-block">';
        echo '<h4>Icon</h4>';
        echo '<div class="buildpro-service-field"><input type="hidden" class="service-icon-id" name="buildpro_service_items[' . esc_attr($index) . '][icon_id]" value="' . esc_attr($icon_id) . '"> <button type="button" class="button select-service-icon">Chọn icon</button> <button type="button" class="button remove-service-icon">Xóa icon</button></div>';
        echo '<div class="service-icon-preview">' . ($thumb ? '<img src="' . esc_url($thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn icon</span>') . '</div>';
        echo '</div>';
        echo '<div class="buildpro-service-block">';
        echo '<h4>Nội dung</h4>';
        echo '<p class="buildpro-service-field"><label>Title</label><input type="text" name="buildpro_service_items[' . esc_attr($index) . '][title]" class="regular-text" value="' . esc_attr($title) . '"></p>';
        echo '<p class="buildpro-service-field"><label>Mô tả</label><textarea name="buildpro_service_items[' . esc_attr($index) . '][description]" rows="4" class="large-text">' . esc_textarea($desc) . '</textarea></p>';
        echo '<h4>Liên kết</h4>';
        echo '<p class="buildpro-service-field"><label>Link URL</label><input type="url" name="buildpro_service_items[' . esc_attr($index) . '][link_url]" class="regular-text" value="' . esc_attr($link_url) . '" placeholder="https://..."> <button type="button" class="button choose-link">Chọn link</button></p>';
        echo '<p class="buildpro-service-field"><label>Link Title</label><input type="text" name="buildpro_service_items[' . esc_attr($index) . '][link_title]" class="regular-text" value="' . esc_attr($link_title) . '" placeholder="View Details"></p>';
        echo '<p class="buildpro-service-field"><label>Link Target</label><select name="buildpro_service_items[' . esc_attr($index) . '][link_target]"><option value="" ' . selected($link_target, '', false) . '>Mặc định</option><option value="_blank" ' . selected($link_target, '_blank', false) . '>Mở tab mới</option></select></p>';
        echo '</div>';
        echo '</div><div class="buildpro-service-actions"><button type="button" class="button remove-service-row">Xóa mục</button></div></div>';
        $index++;
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" id="buildpro-service-add">Thêm mục</button>';
    echo '<script>
    (function(){
        var wrapper = document.getElementById("buildpro-service-wrapper");
        var addBtn = document.getElementById("buildpro-service-add");
        var frame;
        function bindRow(row){
            var selectBtn = row.querySelector(".select-service-icon");
            var removeIconBtn = row.querySelector(".remove-service-icon");
            var input = row.querySelector(".service-icon-id");
            var preview = row.querySelector(".service-icon-preview");
            var removeRowBtn = row.querySelector(".remove-service-row");
            var linkBtn = row.querySelector(".choose-link");
            var urlInput = row.querySelector("input[name$=\'[link_url]\']");
            var titleInput = row.querySelector("input[name$=\'[link_title]\']");
            var targetSelect = row.querySelector("select[name$=\'[link_target]\']");
            if(selectBtn){
                selectBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    if(!frame){ frame = wp.media({ title: "Chọn icon", button: { text: "Sử dụng" }, multiple: false, library: { type: "image" } }); }
                    if(typeof frame.off === "function"){ frame.off("select"); }
                    frame.on("select", function(){
                        var attachment = frame.state().get("selection").first().toJSON();
                        input.value = attachment.id;
                        var url = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
                        preview.innerHTML = "<img src=\'"+url+"\' style=\'max-height:80px;\'>";
                    });
                    frame.open();
                });
            }
            if(removeIconBtn){
                removeIconBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    input.value = "";
                    preview.innerHTML = "<span style=\\"color:#888\\">Chưa chọn icon</span>";
                });
            }
            function openLinkPicker(){
                if (typeof wpLink !== "undefined" && typeof wpLink.open === "function") {
                    wpLink.open();
                } else if (window.wp && window.wp.link && typeof window.wp.link.open === "function") {
                    window.wp.link.open();
                } else {
                    return;
                }
                var urlField = document.getElementById("wp-link-url");
                var textField = document.getElementById("wp-link-text");
                var targetField = document.getElementById("wp-link-target");
                if(urlField){ urlField.value = urlInput && urlInput.value ? urlInput.value : ""; }
                if(textField){ textField.value = titleInput && titleInput.value ? titleInput.value : ""; }
                if(targetField && targetSelect){ targetField.checked = targetSelect.value === "_blank"; }
                var originalUpdate = (typeof wpLink !== "undefined" && typeof wpLink.update === "function") ? wpLink.update : null;
                if(originalUpdate){
                    wpLink.update = function(){
                        if(urlField && urlInput){ urlInput.value = urlField.value || ""; }
                        if(textField && titleInput){ titleInput.value = textField.value || ""; }
                        if(targetField && targetSelect){ targetSelect.value = targetField.checked ? "_blank" : ""; }
                        wpLink.close();
                        wpLink.update = originalUpdate;
                    };
                }
                var submit = document.getElementById("wp-link-submit");
                var handler = function(ev){
                    ev.preventDefault();
                    if(ev.stopPropagation){ ev.stopPropagation(); }
                    if(ev.stopImmediatePropagation){ ev.stopImmediatePropagation(); }
                    if(urlField && urlInput){ urlInput.value = urlField.value || ""; }
                    if(textField && titleInput){ titleInput.value = textField.value || ""; }
                    if(targetField && targetSelect){ targetSelect.value = targetField.checked ? "_blank" : ""; }
                    if (typeof wpLink !== "undefined" && typeof wpLink.close === "function") { wpLink.close(); }
                    submit.removeEventListener("click", handler, true);
                };
                if(submit){ submit.addEventListener("click", handler, true); }
            }
            if(linkBtn){ linkBtn.addEventListener("click", function(e){ e.preventDefault(); openLinkPicker(); }); }
            if(urlInput){ urlInput.addEventListener("click", function(e){ e.preventDefault(); openLinkPicker(); }); }
            if(removeRowBtn){
                removeRowBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    row.parentNode.removeChild(row);
                });
            }
        }
        Array.prototype.forEach.call(wrapper.querySelectorAll(".buildpro-service-row"), bindRow);
        if(addBtn){
            addBtn.addEventListener("click", function(e){
                e.preventDefault();
                var idx = wrapper.querySelectorAll(".buildpro-service-row").length;
                var html = "" 
                + "<div class=\\"buildpro-service-row\\" data-index=\\"" + idx + "\\">"
                + "  <div class=\\"buildpro-service-grid\\">"
                + "    <div class=\\"buildpro-service-block\\">"
                + "      <h4>Icon</h4>"
                + "      <div class=\\"buildpro-service-field\\">"
                + "        <input type=\\"hidden\\" class=\\"service-icon-id\\" name=\\"buildpro_service_items[" + idx + "][icon_id]\\" value=\\"\\">"
                + "        <button type=\\"button\\" class=\\"button select-service-icon\\">Chọn icon</button>"
                + "        <button type=\\"button\\" class=\\"button remove-service-icon\\">Xóa icon</button>"
                + "      </div>"
                + "      <div class=\\"service-icon-preview\\"><span style=\\"color:#888\\">Chưa chọn icon</span></div>"
                + "    </div>"
                + "    <div class=\\"buildpro-service-block\\">"
                + "      <h4>Nội dung</h4>"
                + "      <p class=\\"buildpro-service-field\\"><label>Title</label><input type=\\"text\\" name=\\"buildpro_service_items[" + idx + "][title]\\" class=\\"regular-text\\" value=\\"\\"></p>"
                + "      <p class=\\"buildpro-service-field\\"><label>Mô tả</label><textarea name=\\"buildpro_service_items[" + idx + "][description]\\" rows=\\"4\\" class=\\"large-text\\"></textarea></p>"
                + "      <h4>Liên kết</h4>"
                + "      <p class=\\"buildpro-service-field\\"><label>Link URL</label><input type=\\"url\\" name=\\"buildpro_service_items[" + idx + "][link_url]\\" class=\\"regular-text\\" value=\\"\\" placeholder=\\"https://...\\"> <button type=\\"button\\" class=\\"button choose-link\\">Chọn link</button></p>"
                + "      <p class=\\"buildpro-service-field\\"><label>Link Title</label><input type=\\"text\\" name=\\"buildpro_service_items[" + idx + "][link_title]\\" class=\\"regular-text\\" value=\\"\\"></p>"
                + "      <p class=\\"buildpro-service-field\\"><label>Link Target</label><select name=\\"buildpro_service_items[" + idx + "][link_target]\\"><option value=\\"\\">Mặc định</option><option value=\\"_blank\\">Mở tab mới</option></select></p>"
                + "    </div>"
                + "  </div>"
                + "  <div class=\\"buildpro-service-actions\\"><button type=\\"button\\" class=\\"button remove-service-row\\">Xóa mục</button></div>"
                + "</div>";
                var temp = document.createElement("div");
                temp.innerHTML = html;
                var row = temp.firstElementChild;
                wrapper.appendChild(row);
                bindRow(row);
            });
        }
    })();
    </script>';
}

function buildpro_services_admin_enqueue($hook)
{
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('wplink');
        wp_enqueue_style('wp-link');
    }
}
add_action('admin_enqueue_scripts', 'buildpro_services_admin_enqueue');

function buildpro_save_services_meta($post_id)
{
    if (!isset($_POST['buildpro_services_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_services_meta_nonce'], 'buildpro_services_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $template = get_page_template_slug($post_id);
    if ($template !== 'home-page.php') {
        return;
    }
    $service_title = isset($_POST['buildpro_service_title']) ? sanitize_text_field($_POST['buildpro_service_title']) : '';
    $service_desc = isset($_POST['buildpro_service_desc']) ? sanitize_textarea_field($_POST['buildpro_service_desc']) : '';
    $items = isset($_POST['buildpro_service_items']) && is_array($_POST['buildpro_service_items']) ? $_POST['buildpro_service_items'] : array();
    $clean = array();
    foreach ($items as $item) {
        $clean[] = array(
            'icon_id' => isset($item['icon_id']) ? absint($item['icon_id']) : 0,
            'title' => isset($item['title']) ? sanitize_text_field($item['title']) : '',
            'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
            'link_url' => isset($item['link_url']) ? esc_url_raw($item['link_url']) : '',
            'link_title' => isset($item['link_title']) ? sanitize_text_field($item['link_title']) : '',
            'link_target' => isset($item['link_target']) ? sanitize_text_field($item['link_target']) : '',
        );
    }
    update_post_meta($post_id, 'buildpro_service_title', $service_title);
    update_post_meta($post_id, 'buildpro_service_desc', $service_desc);
    update_post_meta($post_id, 'buildpro_service_items', $clean);
}
add_action('save_post_page', 'buildpro_save_services_meta');
