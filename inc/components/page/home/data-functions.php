<?php
function buildpro_data_add_meta_box()
{
    add_meta_box(
        'buildpro_data_meta',
        'Data',
        'buildpro_data_render_meta_box',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'buildpro_data_add_meta_box');

function buildpro_data_render_meta_box($post)
{
    wp_nonce_field('buildpro_data_meta_save', 'buildpro_data_meta_nonce');
    $items = get_post_meta($post->ID, 'buildpro_data_items', true);
    $items = is_array($items) ? $items : array();
    echo '<style>
    .buildpro-data-row{border:1px solid #ddd;padding:12px;margin:12px 0;background:#fff;border-radius:6px}
    .buildpro-data-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start}
    .buildpro-data-block{background:#f7f7f7;padding:10px;border-radius:6px}
    .buildpro-data-block h4{margin:0 0 8px;font-size:13px}
    .buildpro-data-field{margin:8px 0}
    .buildpro-data-field label{display:block;margin-bottom:4px}
    .buildpro-data-actions{margin-top:10px;text-align:right}
    </style>';
    echo '<div id="buildpro-data-wrapper">';
    $index = 0;
    foreach ($items as $item) {
        $number = isset($item['number']) ? sanitize_text_field($item['number']) : '';
        $text = isset($item['text']) ? sanitize_text_field($item['text']) : '';
        echo '<div class="buildpro-data-row" data-index="' . esc_attr($index) . '"><div class="buildpro-data-grid">';
        echo '<div class="buildpro-data-block">';
        echo '<h4>Number</h4>';
        echo '<p class="buildpro-data-field"><label>Number</label><input type="text" name="buildpro_data_items[' . esc_attr($index) . '][number]" class="regular-text" value="' . esc_attr($number) . '" placeholder="123+"></p>';
        echo '</div>';
        echo '<div class="buildpro-data-block">';
        echo '<h4>Text</h4>';
        echo '<p class="buildpro-data-field"><label>Text</label><input type="text" name="buildpro_data_items[' . esc_attr($index) . '][text]" class="regular-text" value="' . esc_attr($text) . '" placeholder="Mô tả ngắn"></p>';
        echo '</div>';
        echo '</div><div class="buildpro-data-actions"><button type="button" class="button remove-data-row">Xóa mục</button></div></div>';
        $index++;
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" id="buildpro-data-add">Thêm mục</button>';
    echo '<script>
	(function(){
		var wrapper = document.getElementById("buildpro-data-wrapper");
		var addBtn = document.getElementById("buildpro-data-add");
		function bindRow(row){
			var removeRowBtn = row.querySelector(".remove-data-row");
			if(removeRowBtn){
				removeRowBtn.addEventListener("click", function(e){
					e.preventDefault();
					row.parentNode.removeChild(row);
				});
			}
		}
		Array.prototype.forEach.call(wrapper.querySelectorAll(".buildpro-data-row"), bindRow);
		if(addBtn){
			addBtn.addEventListener("click", function(e){
				e.preventDefault();
				var idx = wrapper.querySelectorAll(".buildpro-data-row").length;
                var html = \'\' 
                + \'<div class="buildpro-data-row" data-index="\' + idx + \'">\'
                + \'  <div class="buildpro-data-grid">\'
                + \'    <div class="buildpro-data-block">\'
                + \'      <h4>Number</h4>\'
                + \'      <p class="buildpro-data-field"><label>Number</label><input type="text" name="buildpro_data_items[\' + idx + \'][number]" class="regular-text" value="" placeholder="123+"></p>\'
                + \'    </div>\'
                + \'    <div class="buildpro-data-block">\'
                + \'      <h4>Text</h4>\'
                + \'      <p class="buildpro-data-field"><label>Text</label><input type="text" name="buildpro_data_items[\' + idx + \'][text]" class="regular-text" value="" placeholder="Mô tả ngắn"></p>\'
                + \'    </div>\'
                + \'  </div>\'
                + \'  <div class="buildpro-data-actions"><button type="button" class="button remove-data-row">Xóa mục</button></div>\'
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

function buildpro_save_data_meta($post_id)
{
    if (!isset($_POST['buildpro_data_meta_nonce']) || !wp_verify_nonce($_POST['buildpro_data_meta_nonce'], 'buildpro_data_meta_save')) {
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
    $items = isset($_POST['buildpro_data_items']) && is_array($_POST['buildpro_data_items']) ? $_POST['buildpro_data_items'] : array();
    $clean = array();
    foreach ($items as $item) {
        $clean[] = array(
            'number' => isset($item['number']) ? sanitize_text_field($item['number']) : '',
            'text' => isset($item['text']) ? sanitize_text_field($item['text']) : '',
        );
    }
    update_post_meta($post_id, 'buildpro_data_items', $clean);
    set_theme_mod('buildpro_data_items', $clean);
}
add_action('save_post_page', 'buildpro_save_data_meta');
