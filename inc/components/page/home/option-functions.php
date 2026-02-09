<?php
function buildpro_option_add_meta_box()
{
    add_meta_box(
        'buildpro_option_meta',
        'Option',
        'buildpro_option_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_option_add_meta_box');

function buildpro_option_render_meta_box($post)
{
    wp_nonce_field('buildpro_option_meta_save', 'buildpro_option_meta_nonce');
    wp_enqueue_media();
    $items = get_post_meta($post->ID, 'buildpro_option_items', true);
    $items = is_array($items) ? $items : array();
    echo '<style>
    .buildpro-option-row{border:1px solid #ddd;padding:12px;margin:12px 0;background:#fff;border-radius:6px}
    .buildpro-option-grid{display:grid;grid-template-columns:220px 1fr;gap:16px;align-items:start}
    .buildpro-option-block{background:#f7f7f7;padding:10px;border-radius:6px}
    .buildpro-option-block h4{margin:0 0 8px;font-size:13px}
    .buildpro-option-field{margin:8px 0}
    .buildpro-option-field label{display:block;margin-bottom:4px}
    .buildpro-option-actions{margin-top:10px;text-align:right}
    </style>';
    echo '<div id="buildpro-option-wrapper">';
    $index = 0;
    foreach ($items as $item) {
        $icon_id = isset($item['icon_id']) ? (int)$item['icon_id'] : 0;
        $text = isset($item['text']) ? sanitize_text_field($item['text']) : '';
        $desc = isset($item['description']) ? sanitize_textarea_field($item['description']) : '';
        $thumb = $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : '';
        echo '<div class="buildpro-option-row" data-index="' . esc_attr($index) . '"><div class="buildpro-option-grid">';
        echo '<div class="buildpro-option-block">';
        echo '<h4>Icon</h4>';
        echo '<div class="buildpro-option-field"><input type="hidden" class="option-icon-id" name="buildpro_option_items[' . esc_attr($index) . '][icon_id]" value="' . esc_attr($icon_id) . '"> <button type="button" class="button select-option-icon">Chọn icon</button> <button type="button" class="button remove-option-icon">Xóa icon</button></div>';
        echo '<div class="option-icon-preview" style="margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px">' . ($thumb ? '<img src="' . esc_url($thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn icon</span>') . '</div>';
        echo '</div>';
        echo '<div class="buildpro-option-block">';
        echo '<h4>Nội dung</h4>';
        echo '<p class="buildpro-option-field"><label>Text</label><input type="text" name="buildpro_option_items[' . esc_attr($index) . '][text]" class="regular-text" value="' . esc_attr($text) . '"></p>';
        echo '<p class="buildpro-option-field"><label>Mô tả</label><textarea name="buildpro_option_items[' . esc_attr($index) . '][description]" rows="4" class="large-text">' . esc_textarea($desc) . '</textarea></p>';
        echo '</div>';
        echo '</div><div class="buildpro-option-actions"><button type="button" class="button remove-option-row">Xóa mục</button></div></div>';
        $index++;
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" id="buildpro-option-add">Thêm mục</button>';
    echo '<script>
	(function(){
		var wrapper = document.getElementById("buildpro-option-wrapper");
		var addBtn = document.getElementById("buildpro-option-add");
		var frame;
		function bindRow(row){
			var selectBtn = row.querySelector(".select-option-icon");
			var removeIconBtn = row.querySelector(".remove-option-icon");
			var input = row.querySelector(".option-icon-id");
			var preview = row.querySelector(".option-icon-preview");
			var removeRowBtn = row.querySelector(".remove-option-row");
			if(selectBtn){
				selectBtn.addEventListener("click", function(e){
					e.preventDefault();
					if(!frame){ frame = wp.media({ title: "Chọn icon", button: { text: "Sử dụng" }, multiple: false }); }
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
					preview.innerHTML = "";
				});
			}
			if(removeRowBtn){
				removeRowBtn.addEventListener("click", function(e){
					e.preventDefault();
					row.parentNode.removeChild(row);
				});
			}
		}
		Array.prototype.forEach.call(wrapper.querySelectorAll(".buildpro-option-row"), bindRow);
		if(addBtn){
			addBtn.addEventListener("click", function(e){
				e.preventDefault();
				var idx = wrapper.querySelectorAll(".buildpro-option-row").length;
                var html = \'\' 
                + \'<div class="buildpro-option-row" data-index="\' + idx + \'">\'
                + \'  <div class="buildpro-option-grid">\'
                + \'    <div class="buildpro-option-block">\'
                + \'      <h4>Icon</h4>\'
                + \'      <div class="buildpro-option-field">\'
                + \'        <input type="hidden" class="option-icon-id" name="buildpro_option_items[\' + idx + \'][icon_id]" value="">\'
                + \'        <button type="button" class="button select-option-icon">Chọn icon</button>\'
                + \'        <button type="button" class="button remove-option-icon">Xóa icon</button>\'
                + \'      </div>\'
                + \'      <div class="option-icon-preview" style="margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px"><span style="color:#888">Chưa chọn icon</span></div>\'
                + \'    </div>\'
                + \'    <div class="buildpro-option-block">\'
                + \'      <h4>Nội dung</h4>\'
                + \'      <p class="buildpro-option-field"><label>Text</label><input type="text" name="buildpro_option_items[\' + idx + \'][text]" class="regular-text" value=""></p>\'
                + \'      <p class="buildpro-option-field"><label>Mô tả</label><textarea name="buildpro_option_items[\' + idx + \'][description]" rows="4" class="large-text"></textarea></p>\'
                + \'    </div>\'
                + \'  </div>\'
                + \'  <div class="buildpro-option-actions"><button type="button" class="button remove-option-row">Xóa mục</button></div>\'
                + \'</div>\';
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

function buildpro_option_admin_enqueue($hook)
{
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'buildpro_option_admin_enqueue');

function buildpro_save_option_meta($post_id)
{
    if (!isset($_POST['buildpro_option_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_option_meta_nonce'], 'buildpro_option_meta_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    $template = get_page_template_slug($post_id);
    if ($template !== 'page.php') {
        return;
    }
    $items = isset($_POST['buildpro_option_items']) && is_array($_POST['buildpro_option_items']) ? $_POST['buildpro_option_items'] : array();
    $clean = array();
    foreach ($items as $item) {
        $clean[] = array(
            'icon_id' => isset($item['icon_id']) ? absint($item['icon_id']) : 0,
            'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
            'description' => isset($item['description']) ? sanitize_textarea_field($item['description']) : '',
        );
    }
    update_post_meta($post_id, 'buildpro_option_items', $clean);
}
add_action('save_post_page', 'buildpro_save_option_meta');
