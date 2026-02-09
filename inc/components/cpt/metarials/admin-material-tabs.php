<?php
function buildpro_material_group_meta_box_add($post_type, $post)
{
    if ($post_type !== 'material') {
        return;
    }
    add_meta_box('buildpro_material_group', 'Material Details', 'buildpro_material_group_meta_box_render', 'material', 'normal', 'high');
}
add_action('add_meta_boxes', 'buildpro_material_group_meta_box_add', 10, 2);

function buildpro_material_group_meta_box_render($post)
{
    wp_nonce_field('buildpro_material_meta_save', 'buildpro_material_meta_nonce');
    echo '<div class="buildpro-admin-tabs" style="margin:0;padding:8px 0;">'
        . '<button type="button" class="button buildpro-admin-tab is-active" data-target="buildpro_material_tab_banner">Banner</button> '
        . '<button type="button" class="button buildpro-admin-tab" data-target="buildpro_material_tab_info">Info</button> '
        . '<button type="button" class="button buildpro-admin-tab" data-target="buildpro_material_tab_gallery">Gallery</button>'
        . '</div>';
    echo '<script>
	(function(){
		function init(){
			var tabs = document.querySelectorAll(".buildpro-admin-tab");
			function show(id){
				["buildpro_material_tab_banner","buildpro_material_tab_info","buildpro_material_tab_gallery"].forEach(function(x){
					var el = document.getElementById(x);
					if(el){ el.style.display = (x === id) ? "block" : "none"; }
				});
				tabs.forEach(function(b){ b.classList.toggle("is-active", b.getAttribute("data-target") === id); });
			}
			show("buildpro_material_tab_banner");
			tabs.forEach(function(b){ b.addEventListener("click", function(){ show(b.getAttribute("data-target")); }); });
		}
		if(document.readyState === "loading"){
			document.addEventListener("DOMContentLoaded", init);
		} else {
			init();
		}
	})();
	</script>';
    echo '<style>.buildpro-admin-tabs .button{margin-right:6px;background:#f3f4f6;border-color:#e5e7eb}.buildpro-admin-tabs .button.is-active{background:#2563eb;color:#fff;border-color:#2563eb}</style>';
}
