<?php
function buildpro_material_banner_add_meta_box($post_type, $post)
{
    if ($post_type !== 'material') {
        return;
    }
    add_meta_box('buildpro_material_tab_banner', 'Banner', 'buildpro_material_banner_render_meta_box', 'material', 'normal', 'default');
}
add_action('add_meta_boxes', 'buildpro_material_banner_add_meta_box', 10, 2);

function buildpro_material_banner_render_meta_box($post)
{
    wp_enqueue_media();
    $banner_id = (int) get_post_meta($post->ID, 'material_banner_id', true);
    $thumb = $banner_id ? wp_get_attachment_image_url($banner_id, 'medium') : '';
    echo '<style>
	.buildpro-post-block{background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);padding:16px;margin-top:8px}
	.buildpro-post-field{margin:10px 0}
	.buildpro-post-field label{display:block;font-weight:600;margin-bottom:6px;color:#374151}
	.image-banner-preview{margin-top:8px;min-height:120px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px}
	</style>';
    echo '<div id="buildpro_material_tab_banner" class="buildpro-post-block">';
    echo '<p class="buildpro-post-field"><label>Banner Image</label><input type="hidden" id="buildpro_material_banner_id" name="material_banner_id" value="' . esc_attr($banner_id) . '"> <button type="button" class="button" id="buildpro_material_select_banner">Chọn ảnh</button> <button type="button" class="button" id="buildpro_material_remove_banner">Xóa ảnh</button></p>';
    echo '<div class="image-banner-preview" id="buildpro_material_banner_preview">' . ($thumb ? '<img src="' . esc_url($thumb) . '">' : '<span style="color:#888">Chưa chọn ảnh</span>') . '</div>';
    echo '</div>';
    echo '<script>
	(function(){
		var selectBtn = document.getElementById("buildpro_material_select_banner");
		var removeBtn = document.getElementById("buildpro_material_remove_banner");
		var input = document.getElementById("buildpro_material_banner_id");
		var preview = document.getElementById("buildpro_material_banner_preview");
		var frame;
		if(selectBtn){
			selectBtn.addEventListener("click", function(e){
				e.preventDefault();
				if(!frame){ frame = wp.media({ title: "Chọn ảnh", button: { text: "Sử dụng" }, multiple: false, library: { type: "image" } }); }
				if(typeof frame.off === "function"){ frame.off("select"); }
				frame.on("select", function(){
					var attachment = frame.state().get("selection").first().toJSON();
					input.value = attachment.id;
					var url = (attachment.sizes && attachment.sizes.medium) ? attachment.sizes.medium.url : attachment.url;
					preview.innerHTML = "<img src=\'"+url+"\'>";
				});
				frame.open();
			});
		}
		if(removeBtn){
			removeBtn.addEventListener("click", function(e){
				e.preventDefault();
				input.value = "";
				preview.innerHTML = "<span style=\\"color:#888\\">Chưa chọn ảnh</span>";
			});
		}
	})();
	</script>';
}