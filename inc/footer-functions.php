<?php
function buildpro_footer_admin_menu()
{
    add_theme_page('Footer', 'Footer', 'edit_theme_options', 'buildpro-footer', 'buildpro_footer_admin_page');
}
add_action('admin_menu', 'buildpro_footer_admin_menu');

function buildpro_footer_admin_enqueue($hook)
{
    if ($hook !== 'appearance_page_buildpro-footer') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('wplink');
    wp_enqueue_style('wp-link');
    wp_enqueue_script('wp-api-fetch');
}
add_action('admin_enqueue_scripts', 'buildpro_footer_admin_enqueue');

function buildpro_footer_admin_page()
{
    $banner_image_id = get_theme_mod('footer_banner_image_id', 0);
    $banner_thumb = $banner_image_id ? wp_get_attachment_image_url($banner_image_id, 'thumbnail') : '';
    $info_logo_id = get_theme_mod('footer_information_logo_id', 0);
    $info_logo_thumb = $info_logo_id ? wp_get_attachment_image_url($info_logo_id, 'thumbnail') : '';
    $info_title = get_theme_mod('footer_information_title', '');
    $info_sub_title = get_theme_mod('footer_information_sub_title', '');
    $info_description = get_theme_mod('footer_information_description', '');
    $list_pages = get_theme_mod('footer_list_pages', array());
    $list_pages = is_array($list_pages) ? $list_pages : array();
    $contact_location = get_theme_mod('footer_contact_location', '');
    $contact_phone = get_theme_mod('footer_contact_phone', '');
    $contact_email = get_theme_mod('footer_contact_email', '');
    $contact_time = get_theme_mod('footer_contact_time', '');
    $contact_links = get_theme_mod('footer_contact_links', array());
    $contact_links = is_array($contact_links) ? $contact_links : array();
    $create_build_text = get_theme_mod('footer_create_build_text', '');
    $policy_text = get_theme_mod('footer_policy_text', '');
    $policy_link = get_theme_mod('footer_policy_link', array('url' => '', 'title' => '', 'target' => ''));
    $policy_link = is_array($policy_link) ? $policy_link : array('url' => '', 'title' => '', 'target' => '');
    $servicer_text = get_theme_mod('footer_servicer_text', '');
    $servicer_link = get_theme_mod('footer_servicer_link', array('url' => '', 'title' => '', 'target' => ''));
    $servicer_link = is_array($servicer_link) ? $servicer_link : array('url' => '', 'title' => '', 'target' => '');
    echo '<div class="wrap"><h1>Footer</h1>';
    echo '<h2 class="nav-tab-wrapper">';
    echo '<a href="#tab-banner" class="nav-tab nav-tab-active">Banner</a>';
    echo '<a href="#tab-information" class="nav-tab">Information</a>';
    echo '<a href="#tab-list-page" class="nav-tab">List Page</a>';
    echo '<a href="#tab-contact" class="nav-tab">Contact</a>';
    echo '<a href="#tab-contact-link" class="nav-tab">Contact Link</a>';
    echo '<a href="#tab-create-build" class="nav-tab">Create Build</a>';
    echo '<a href="#tab-policy" class="nav-tab">Policy</a>';
    echo '<a href="#tab-servicer" class="nav-tab">Servicer</a>';
    echo '</h2>';
    echo '<form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
    echo '<input type="hidden" name="action" value="buildpro_save_footer">';
    wp_nonce_field('buildpro_footer_save');
    echo '<style>
    .buildpro-footer-section{display:none;margin-top:16px}
    .buildpro-footer-section.active{display:block}
    .buildpro-block{background:#fff;border:1px solid #ddd;border-radius:6px;padding:12px;margin-bottom:16px}
    .buildpro-field{margin:8px 0}
    .buildpro-field label{display:block;margin-bottom:4px}
    .buildpro-actions{margin-top:10px}
    .buildpro-grid{display:grid;grid-template-columns:280px 1fr;gap:16px;align-items:start}
    .image-preview{margin-top:8px;min-height:84px;display:flex;align-items:center;justify-content:center;background:#fff;border:1px dashed #ddd;border-radius:6px}
    #buildpro-custom-link-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:100000;display:none}
    #buildpro-custom-link-modal{position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);background:#fff;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,.2);width:760px;max-width:95vw;z-index:100001;display:none}
    .buildpro-custom-link-header{padding:12px 16px;border-bottom:1px solid #eee;font-size:16px;font-weight:600}
    .buildpro-custom-link-body{padding:12px 16px}
    .buildpro-custom-link-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .buildpro-custom-link-row{margin:8px 0}
    #buildpro_custom_link_results{border:1px solid #eee;border-radius:6px;max-height:360px;overflow-y:auto;margin-top:8px}
    .buildpro-custom-link-item{padding:10px 12px;border-bottom:1px solid #f2f2f2;cursor:pointer}
    .buildpro-custom-link-item:hover{background:#f7f7f7}
    .buildpro-custom-link-actions{display:flex;justify-content:flex-end;gap:8px;padding:12px 16px;border-top:1px solid #eee}
    </style>';
    echo '<div id="buildpro-footer-sections">';
    echo '<div id="tab-banner" class="buildpro-footer-section active">';
    echo '<div class="buildpro-block">';
    echo '<h3>Banner</h3>';
    echo '<div class="buildpro-field"><input type="hidden" id="footer_banner_image_id" name="footer_banner_image_id" value="' . esc_attr($banner_image_id) . '"> <button type="button" class="button" id="select_footer_banner_image">Chọn ảnh</button> <button type="button" class="button" id="remove_footer_banner_image">Xóa ảnh</button></div>';
    echo '<div id="footer_banner_preview" class="image-preview">' . ($banner_thumb ? '<img src="' . esc_url($banner_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn ảnh</span>') . '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-information" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Information</h3><div class="buildpro-grid">';
    echo '<div>';
    echo '<div class="buildpro-field"><input type="hidden" id="footer_information_logo_id" name="footer_information_logo_id" value="' . esc_attr($info_logo_id) . '"> <button type="button" class="button" id="select_footer_information_logo">Chọn logo</button> <button type="button" class="button" id="remove_footer_information_logo">Xóa logo</button></div>';
    echo '<div id="footer_information_logo_preview" class="image-preview">' . ($info_logo_thumb ? '<img src="' . esc_url($info_logo_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn logo</span>') . '</div>';
    echo '</div>';
    echo '<div>';
    echo '<p class="buildpro-field"><label>Title</label><input type="text" name="footer_information_title" class="regular-text" value="' . esc_attr($info_title) . '"></p>';
    echo '<p class="buildpro-field"><label>Sub Title</label><input type="text" name="footer_information_sub_title" class="regular-text" value="' . esc_attr($info_sub_title) . '"></p>';
    echo '<p class="buildpro-field"><label>Description</label><textarea name="footer_information_description" rows="4" class="large-text">' . esc_textarea($info_description) . '</textarea></p>';
    echo '</div>';
    echo '</div></div>';
    echo '</div>';
    echo '<div id="tab-list-page" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>List Page</h3>';
    echo '<div id="footer-list-pages-wrapper">';
    $lp_index = 0;
    foreach ($list_pages as $lp) {
        $lp_url = isset($lp['url']) ? esc_url($lp['url']) : '';
        $lp_title = isset($lp['title']) ? sanitize_text_field($lp['title']) : '';
        $lp_target = isset($lp['target']) ? sanitize_text_field($lp['target']) : '';
        echo '<div class="buildpro-block" data-index="' . esc_attr($lp_index) . '">';
        echo '<p class="buildpro-field"><label>Link URL</label><input type="url" name="footer_list_pages[' . esc_attr($lp_index) . '][url]" class="regular-text" value="' . esc_attr($lp_url) . '" placeholder="https://..."> <button type="button" class="button choose-link">Chọn link</button></p>';
        echo '<p class="buildpro-field"><label>Link Title</label><input type="text" name="footer_list_pages[' . esc_attr($lp_index) . '][title]" class="regular-text" value="' . esc_attr($lp_title) . '"></p>';
        echo '<p class="buildpro-field"><label>Link Target</label><select name="footer_list_pages[' . esc_attr($lp_index) . '][target]"><option value="" ' . selected($lp_target, '', false) . '>Mặc định</option><option value="_blank" ' . selected($lp_target, '_blank', false) . '>Mở tab mới</option></select></p>';
        echo '<div class="buildpro-actions"><button type="button" class="button remove-row">Xóa mục</button></div>';
        echo '</div>';
        $lp_index++;
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" id="footer-list-pages-add">Thêm mục</button>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-contact" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Contact</h3>';
    echo '<p class="buildpro-field"><label>Location</label><input type="text" name="footer_contact_location" class="regular-text" value="' . esc_attr($contact_location) . '"></p>';
    echo '<p class="buildpro-field"><label>Phone</label><input type="text" name="footer_contact_phone" class="regular-text" value="' . esc_attr($contact_phone) . '"></p>';
    echo '<p class="buildpro-field"><label>Email</label><input type="email" name="footer_contact_email" class="regular-text" value="' . esc_attr($contact_email) . '"></p>';
    echo '<p class="buildpro-field"><label>Time</label><input type="text" name="footer_contact_time" class="regular-text" value="' . esc_attr($contact_time) . '"></p>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-contact-link" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Contact Link</h3>';
    echo '<div id="footer-contact-links-wrapper">';
    $cl_index = 0;
    foreach ($contact_links as $cl) {
        $cl_icon_id = isset($cl['icon_id']) ? absint($cl['icon_id']) : 0;
        $cl_icon_thumb = $cl_icon_id ? wp_get_attachment_image_url($cl_icon_id, 'thumbnail') : '';
        $cl_url = isset($cl['url']) ? esc_url($cl['url']) : '';
        $cl_title = isset($cl['title']) ? sanitize_text_field($cl['title']) : '';
        $cl_target = isset($cl['target']) ? sanitize_text_field($cl['target']) : '';
        echo '<div class="buildpro-block" data-index="' . esc_attr($cl_index) . '">';
        echo '<p class="buildpro-field"><label>Icon</label><input type="hidden" name="footer_contact_links[' . esc_attr($cl_index) . '][icon_id]" value="' . esc_attr($cl_icon_id) . '"> <button type="button" class="button select-contact-icon">Chọn ảnh</button> <button type="button" class="button remove-contact-icon">Xóa ảnh</button></p>';
        echo '<div class="image-preview contact-icon-preview">' . ($cl_icon_thumb ? '<img src="' . esc_url($cl_icon_thumb) . '" style="max-height:80px;">' : '<span style="color:#888">Chưa chọn ảnh</span>') . '</div>';
        echo '<p class="buildpro-field"><label>Link URL</label><input type="url" name="footer_contact_links[' . esc_attr($cl_index) . '][url]" class="regular-text" value="' . esc_attr($cl_url) . '" placeholder="https://..."> <button type="button" class="button choose-link">Chọn link</button></p>';
        echo '<p class="buildpro-field"><label>Link Title</label><input type="text" name="footer_contact_links[' . esc_attr($cl_index) . '][title]" class="regular-text" value="' . esc_attr($cl_title) . '"></p>';
        echo '<p class="buildpro-field"><label>Link Target</label><select name="footer_contact_links[' . esc_attr($cl_index) . '][target]"><option value="" ' . selected($cl_target, '', false) . '>Mặc định</option><option value="_blank" ' . selected($cl_target, '_blank', false) . '>Mở tab mới</option></select></p>';
        echo '<div class="buildpro-actions"><button type="button" class="button remove-row">Xóa mục</button></div>';
        echo '</div>';
        $cl_index++;
    }
    echo '</div>';
    echo '<button type="button" class="button button-primary" id="footer-contact-links-add">Thêm mục</button>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-create-build" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Create Build</h3>';
    echo '<p class="buildpro-field"><label>Text</label><input type="text" name="footer_create_build_text" class="regular-text" value="' . esc_attr($create_build_text) . '"></p>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-policy" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Policy</h3>';
    echo '<p class="buildpro-field"><label>Text</label><input type="text" name="footer_policy_text" class="regular-text" value="' . esc_attr($policy_text) . '"></p>';
    echo '<p class="buildpro-field"><label>Link URL</label><input type="url" id="footer_policy_link_url" name="footer_policy_link[url]" class="regular-text" value="' . esc_attr($policy_link['url']) . '" placeholder="https://..."> <button type="button" class="button choose-link-single" data-url="#footer_policy_link_url" data-title="#footer_policy_link_title" data-target="#footer_policy_link_target">Chọn link</button></p>';
    echo '<p class="buildpro-field"><label>Link Title</label><input type="text" id="footer_policy_link_title" name="footer_policy_link[title]" class="regular-text" value="' . esc_attr($policy_link['title']) . '"></p>';
    echo '<p class="buildpro-field"><label>Link Target</label><select id="footer_policy_link_target" name="footer_policy_link[target]"><option value="" ' . selected($policy_link['target'], '', false) . '>Mặc định</option><option value="_blank" ' . selected($policy_link['target'], '_blank', false) . '>Mở tab mới</option></select></p>';
    echo '</div>';
    echo '</div>';
    echo '<div id="tab-servicer" class="buildpro-footer-section">';
    echo '<div class="buildpro-block"><h3>Servicer</h3>';
    echo '<p class="buildpro-field"><label>Text</label><input type="text" name="footer_servicer_text" class="regular-text" value="' . esc_attr($servicer_text) . '"></p>';
    echo '<p class="buildpro-field"><label>Link URL</label><input type="url" id="footer_servicer_link_url" name="footer_servicer_link[url]" class="regular-text" value="' . esc_attr($servicer_link['url']) . '" placeholder="https://..."> <button type="button" class="button choose-link-single" data-url="#footer_servicer_link_url" data-title="#footer_servicer_link_title" data-target="#footer_servicer_link_target">Chọn link</button></p>';
    echo '<p class="buildpro-field"><label>Link Title</label><input type="text" id="footer_servicer_link_title" name="footer_servicer_link[title]" class="regular-text" value="' . esc_attr($servicer_link['title']) . '"></p>';
    echo '<p class="buildpro-field"><label>Link Target</label><select id="footer_servicer_link_target" name="footer_servicer_link[target]"><option value="" ' . selected($servicer_link['target'], '', false) . '>Mặc định</option><option value="_blank" ' . selected($servicer_link['target'], '_blank', false) . '>Mở tab mới</option></select></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    submit_button('submit change');
    echo '<div id="buildpro-custom-link-backdrop"></div>';
    echo '<div id="buildpro-custom-link-modal">';
    echo '<div class="buildpro-custom-link-header">Chọn link</div>';
    echo '<div class="buildpro-custom-link-body">';
    echo '<div class="buildpro-custom-link-grid">';
    echo '<div>';
    echo '<p class="buildpro-custom-link-row"><label>URL</label><input type="url" id="buildpro_custom_link_url" class="regular-text" placeholder="https://..."></p>';
    echo '<p class="buildpro-custom-link-row"><label>Link Text</label><input type="text" id="buildpro_custom_link_title" class="regular-text" placeholder=""></p>';
    echo '<p class="buildpro-custom-link-row"><label><input type="checkbox" id="buildpro_custom_link_target"> Mở tab mới</label></p>';
    echo '</div>';
    echo '<div>';
    echo '<p class="buildpro-custom-link-row"><label>Tìm kiếm</label><input type="search" id="buildpro_custom_link_search" class="regular-text" placeholder="Nhập từ khóa..."></p>';
    echo '<p class="buildpro-custom-link-row"><label>Nguồn</label><select id="buildpro_custom_link_source"><option value="all">Tất cả</option><option value="page">Trang</option><option value="post">Bài viết</option></select></p>';
    echo '<div id="buildpro_custom_link_results"></div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="buildpro-custom-link-actions">';
    echo '<button type="button" class="button" id="buildpro_custom_link_cancel">Hủy</button>';
    echo '<button type="button" class="button button-primary" id="buildpro_custom_link_apply">Chọn</button>';
    echo '</div>';
    echo '</div>';
    echo '</form>';
    echo '<script>
    (function(){
        var tabs = document.querySelectorAll(".nav-tab-wrapper .nav-tab");
        var sections = document.querySelectorAll(".buildpro-footer-section");
        Array.prototype.forEach.call(tabs, function(tab){
            tab.addEventListener("click", function(e){
                e.preventDefault();
                Array.prototype.forEach.call(tabs, function(t){ t.classList.remove("nav-tab-active"); });
                tab.classList.add("nav-tab-active");
                var id = tab.getAttribute("href");
                Array.prototype.forEach.call(sections, function(sec){ sec.classList.remove("active"); });
                var target = document.querySelector(id);
                if(target){ target.classList.add("active"); }
            });
        });
        var frame;
        function selectImage(buttonId, inputId, previewId){
            var btn = document.getElementById(buttonId);
            var removeBtnId = buttonId.replace("select_", "remove_");
            var removeBtn = document.getElementById(removeBtnId);
            var input = document.getElementById(inputId);
            var preview = document.getElementById(previewId);
            if(btn){
                btn.addEventListener("click", function(e){
                    e.preventDefault();
                    if(!frame){ frame = wp.media({ title: "Chọn ảnh", button: { text: "Sử dụng ảnh" }, multiple: false }); }
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
            if(removeBtn){
                removeBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    input.value = "";
                    preview.innerHTML = "<span style=\'color:#888\'>Chưa chọn ảnh</span>";
                });
            }
        }
        selectImage("select_footer_banner_image","footer_banner_image_id","footer_banner_preview");
        selectImage("select_footer_information_logo","footer_information_logo_id","footer_information_logo_preview");
        function openLinkPicker(urlInput, titleInput, targetSelect){
            if (typeof wpLink !== "undefined" && typeof wpLink.open === "function") {
                wpLink.open();
            } else if (window.wp && window.wp.link && typeof window.wp.link.open === "function") {
                window.wp.link.open();
            } else {
                return;
            }
            var wrap = document.getElementById("wp-link-wrap");
            var backdrop = document.getElementById("wp-link-backdrop");
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
                submit.removeEventListener("click", handler, false);
            };
            if(submit){ submit.addEventListener("click", handler, false); }
            var cancelBtn = document.getElementById("wp-link-cancel");
            if(cancelBtn){
                var cancelHandler = function(ev){
                    ev.preventDefault();
                    if (typeof wpLink !== "undefined" && typeof wpLink.close === "function") { wpLink.close(); }
                    cancelBtn.removeEventListener("click", cancelHandler, false);
                };
                cancelBtn.addEventListener("click", cancelHandler, false);
            }
        }
        var customCtx = { urlInput:null, titleInput:null, targetSelect:null };
        function showCustom(){
            var b = document.getElementById("buildpro-custom-link-backdrop");
            var m = document.getElementById("buildpro-custom-link-modal");
            if(b){ b.style.display = "block"; }
            if(m){ m.style.display = "block"; }
            fetchRecent();
        }
        function hideCustom(){
            var b = document.getElementById("buildpro-custom-link-backdrop");
            var m = document.getElementById("buildpro-custom-link-modal");
            if(b){ b.style.display = "none"; }
            if(m){ m.style.display = "none"; }
        }
        function openCustomLinkPicker(urlInput, titleInput, targetSelect){
            customCtx.urlInput = urlInput;
            customCtx.titleInput = titleInput;
            customCtx.targetSelect = targetSelect;
            var urlEl = document.getElementById("buildpro_custom_link_url");
            var titleEl = document.getElementById("buildpro_custom_link_title");
            var targetEl = document.getElementById("buildpro_custom_link_target");
            if(urlEl){ urlEl.value = urlInput && urlInput.value ? urlInput.value : ""; }
            if(titleEl){ titleEl.value = titleInput && titleInput.value ? titleInput.value : ""; }
            if(targetEl){ targetEl.checked = targetSelect && targetSelect.value === "_blank"; }
            showCustom();
        }
        function applyCustom(){
            var urlEl = document.getElementById("buildpro_custom_link_url");
            var titleEl = document.getElementById("buildpro_custom_link_title");
            var targetEl = document.getElementById("buildpro_custom_link_target");
            if(customCtx.urlInput && urlEl){ customCtx.urlInput.value = urlEl.value || ""; }
            if(customCtx.titleInput && titleEl){ customCtx.titleInput.value = titleEl.value || ""; }
            if(customCtx.targetSelect && targetEl){ customCtx.targetSelect.value = targetEl.checked ? "_blank" : ""; }
            hideCustom();
        }
        function fetchJSON(u){
            try{
                if(window.wp && window.wp.apiFetch){
                    var p = u.replace(/^\/wp-json\//,"");
                    return window.wp.apiFetch({ path: p }).catch(function(){ return []; });
                }
            }catch(e){}
            return fetch(u, { credentials: "same-origin" })
                .then(function(r){ return r.ok ? r.json() : []; })
                .catch(function(){ return []; });
        }
        function renderItems(items){
            var results = document.getElementById("buildpro_custom_link_results");
            if(results){ results.innerHTML = ""; }
            items.forEach(function(m){
                var div = document.createElement("div");
                div.className = "buildpro-custom-link-item";
                div.textContent = m.title + " (" + m.type + ")";
                div.addEventListener("click", function(){
                    var urlEl = document.getElementById("buildpro_custom_link_url");
                    var titleEl = document.getElementById("buildpro_custom_link_title");
                    if(urlEl){ urlEl.value = m.url; }
                    if(titleEl){ titleEl.value = m.title; }
                });
                if(results){ results.appendChild(div); }
            });
        }
        function fetchRecent(){
            var qpages = "/wp-json/wp/v2/pages?per_page=20&orderby=date&order=desc";
            var qposts = "/wp-json/wp/v2/posts?per_page=20&orderby=date&order=desc";
            Promise.all([fetchJSON(qpages), fetchJSON(qposts)]).then(function(res){
                var pages = res[0].map(function(it){ return { title:(it.title && it.title.rendered) ? it.title.rendered : (it.slug || "Trang"), url: it.link, type:"PAGE", date:new Date(it.date) }; });
                var posts = res[1].map(function(it){ return { title:(it.title && it.title.rendered) ? it.title.rendered : (it.slug || "Bài viết"), url: it.link, type:"POST", date:new Date(it.date) }; });
                var all = pages.concat(posts).sort(function(a,b){ return b.date - a.date; });
                renderItems(all);
            });
        }
        function searchContent(q, source){
            var qparam = q ? "&search=" + encodeURIComponent(q) : "";
            if(source === "page"){ fetchJSON("/wp-json/wp/v2/pages?per_page=20" + qparam).then(function(items){ renderItems(items.map(function(it){ return { title:(it.title && it.title.rendered)?it.title.rendered:(it.slug||"Trang"), url:it.link, type:"PAGE" }; })); }); }
            else if(source === "post"){ fetchJSON("/wp-json/wp/v2/posts?per_page=20" + qparam).then(function(items){ renderItems(items.map(function(it){ return { title:(it.title && it.title.rendered)?it.title.rendered:(it.slug||"Bài viết"), url:it.link, type:"POST" }; })); }); }
            else { fetchJSON("/wp-json/wp/v2/search?per_page=20" + (q ? ("&search="+encodeURIComponent(q)) : "")).then(function(items){ renderItems(items.map(function(it){ return { title: it.title || it.url, url: it.url, type: (it.type === "post" ? (it.subtype || "POST").toUpperCase() : "LINK") }; })); }); }
        }
        var cancelBtn = document.getElementById("buildpro_custom_link_cancel");
        var applyBtn = document.getElementById("buildpro_custom_link_apply");
        var searchInput = document.getElementById("buildpro_custom_link_search");
        var sourceSel = document.getElementById("buildpro_custom_link_source");
        if(cancelBtn){ cancelBtn.addEventListener("click", hideCustom); }
        if(applyBtn){ applyBtn.addEventListener("click", applyCustom); }
        if(searchInput){ searchInput.addEventListener("input", function(e){ var q=e.target.value; if(q){ searchContent(q, sourceSel?sourceSel.value:"all"); } else { fetchRecent(); } }); }
        if(sourceSel){ sourceSel.addEventListener("change", function(){ var q = searchInput ? searchInput.value : ""; if(q){ searchContent(q, sourceSel.value); } else { fetchRecent(); } }); }
        fetchRecent();
        window.buildproOpenCustom = function(btn){
            var row = btn.closest(".buildpro-block");
            var urlInput = row ? row.querySelector("input[name$=\'[url]\']") : null;
            var titleInput = row ? row.querySelector("input[name$=\'[title]\']") : null;
            var targetSelect = row ? row.querySelector("select[name$=\'[target]\']") : null;
            openCustomLinkPicker(urlInput, titleInput, targetSelect);
            return false;
        };
        document.addEventListener("click", function(e){
            var t = e.target;
            if(!t){ return; }
            if(t.classList && t.classList.contains("choose-link")){
                e.preventDefault();
                var row = t.closest(".buildpro-block");
                var urlInput = row ? row.querySelector("input[name$=\'[url]\']") : null;
                var titleInput = row ? row.querySelector("input[name$=\'[title]\']") : null;
                var targetSelect = row ? row.querySelector("select[name$=\'[target]\']") : null;
                openCustomLinkPicker(urlInput, titleInput, targetSelect);
            }
        }, true);
        function bindRow(row){
            var linkBtn = row.querySelector(".choose-link");
            var urlInput = row.querySelector("input[name$=\'[url]\']");
            var titleInput = row.querySelector("input[name$=\'[title]\']");
            var targetSelect = row.querySelector("select[name$=\'[target]\']");
            var removeRowBtn = row.querySelector(".remove-row");
            var selectIconBtn = row.querySelector(".select-contact-icon");
            var removeIconBtn = row.querySelector(".remove-contact-icon");
            var iconInput = row.querySelector("input[name$=\'[icon_id]\']");
            var iconPreview = row.querySelector(".contact-icon-preview");
            var iconFrame;
            if(linkBtn){ linkBtn.addEventListener("click", function(e){ e.preventDefault(); openCustomLinkPicker(urlInput, titleInput, targetSelect); }); }
            if(urlInput){ urlInput.addEventListener("click", function(e){ e.preventDefault(); openCustomLinkPicker(urlInput, titleInput, targetSelect); }); }
            if(removeRowBtn){ removeRowBtn.addEventListener("click", function(e){ e.preventDefault(); row.parentNode.removeChild(row); }); }
            if(selectIconBtn){
                selectIconBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    if(!iconFrame){ iconFrame = wp.media({ title: "Chọn ảnh", button: { text: "Sử dụng ảnh" }, multiple: false }); }
                    if(typeof iconFrame.off === "function"){ iconFrame.off("select"); }
                    iconFrame.on("select", function(){
                        var attachment = iconFrame.state().get("selection").first().toJSON();
                        if(iconInput){ iconInput.value = attachment.id; }
                        var url = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
                        if(iconPreview){ iconPreview.innerHTML = "<img src=\'"+url+"\' style=\'max-height:80px;\'>"; }
                    });
                    iconFrame.open();
                });
            }
            if(removeIconBtn){
                removeIconBtn.addEventListener("click", function(e){
                    e.preventDefault();
                    if(iconInput){ iconInput.value = ""; }
                    if(iconPreview){ iconPreview.innerHTML = "<span style=\'color:#888\'>Chưa chọn ảnh</span>"; }
                });
            }
        }
        Array.prototype.forEach.call(document.querySelectorAll("#footer-list-pages-wrapper .buildpro-block"), bindRow);
        Array.prototype.forEach.call(document.querySelectorAll("#footer-contact-links-wrapper .buildpro-block"), bindRow);
        var addLP = document.getElementById("footer-list-pages-add");
        if(addLP){
            addLP.addEventListener("click", function(e){
                e.preventDefault();
                var wrapper = document.getElementById("footer-list-pages-wrapper");
                var idx = wrapper.querySelectorAll(".buildpro-block").length;
                var html = ""
                + "<div class=\'buildpro-block\' data-index=\'"+idx+"\'>"
                + "  <p class=\'buildpro-field\'><label>Link URL</label><input type=\'url\' name=\'footer_list_pages["+idx+"][url]\' class=\'regular-text\' value=\'\' placeholder=\'https://...\'> <button type=\'button\' class=\'button choose-link\'>Chọn link</button></p>"
                + "  <p class=\'buildpro-field\'><label>Link Title</label><input type=\'text\' name=\'footer_list_pages["+idx+"][title]\' class=\'regular-text\' value=\'\'></p>"
                + "  <p class=\'buildpro-field\'><label>Link Target</label><select name=\'footer_list_pages["+idx+"][target]\'><option value=\'\'>Mặc định</option><option value=\'_blank\'>Mở tab mới</option></select></p>"
                + "  <div class=\'buildpro-actions\'><button type=\'button\' class=\'button remove-row\'>Xóa mục</button></div>"
                + "</div>";
                var temp = document.createElement("div");
                temp.innerHTML = html;
                var row = temp.firstElementChild;
                wrapper.appendChild(row);
                bindRow(row);
            });
        }
        var addCL = document.getElementById("footer-contact-links-add");
        if(addCL){
            addCL.addEventListener("click", function(e){
                e.preventDefault();
                var wrapper = document.getElementById("footer-contact-links-wrapper");
                var idx = wrapper.querySelectorAll(".buildpro-block").length;
                var html = ""
                + "<div class=\'buildpro-block\' data-index=\'"+idx+"\'>"
                + "  <p class=\'buildpro-field\'><label>Icon</label><input type=\'hidden\' name=\'footer_contact_links["+idx+"][icon_id]\' value=\'\'> <button type=\'button\' class=\'button select-contact-icon\'>Chọn ảnh</button> <button type=\'button\' class=\'button remove-contact-icon\'>Xóa ảnh</button></p>"
                + "  <div class=\'image-preview contact-icon-preview\'><span style=\'color:#888\'>Chưa chọn ảnh</span></div>"
                + "  <p class=\'buildpro-field\'><label>Link URL</label><input type=\'url\' name=\'footer_contact_links["+idx+"][url]\' class=\'regular-text\' value=\'\' placeholder=\'https://...\'> <button type=\'button\' class=\'button choose-link\'>Chọn link</button></p>"
                + "  <p class=\'buildpro-field\'><label>Link Title</label><input type=\'text\' name=\'footer_contact_links["+idx+"][title]\' class=\'regular-text\' value=\'\'></p>"
                + "  <p class=\'buildpro-field\'><label>Link Target</label><select name=\'footer_contact_links["+idx+"][target]\'><option value=\'\'>Mặc định</option><option value=\'_blank\'>Mở tab mới</option></select></p>"
                + "  <div class=\'buildpro-actions\'><button type=\'button\' class=\'button remove-row\'>Xóa mục</button></div>"
                + "</div>";
                var temp = document.createElement("div");
                temp.innerHTML = html;
                var row = temp.firstElementChild;
                wrapper.appendChild(row);
                bindRow(row);
            });
        }
        Array.prototype.forEach.call(document.querySelectorAll(".choose-link-single"), function(btn){
            btn.addEventListener("click", function(e){
                e.preventDefault();
                var urlSel = btn.getAttribute("data-url");
                var titleSel = btn.getAttribute("data-title");
                var targetSel = btn.getAttribute("data-target");
                var urlInput = document.querySelector(urlSel);
                var titleInput = document.querySelector(titleSel);
                var targetSelect = document.querySelector(targetSel);
                openCustomLinkPicker(urlInput, titleInput, targetSelect);
            });
        });
    })();
    </script>';
    echo '</div>';
}

function buildpro_handle_footer_save()
{
    if (!current_user_can('edit_theme_options')) {
        wp_die('Not allowed');
    }
    check_admin_referer('buildpro_footer_save');
    $banner_image_id = isset($_POST['footer_banner_image_id']) ? absint($_POST['footer_banner_image_id']) : 0;
    $info_logo_id = isset($_POST['footer_information_logo_id']) ? absint($_POST['footer_information_logo_id']) : 0;
    $info_title = isset($_POST['footer_information_title']) ? sanitize_text_field($_POST['footer_information_title']) : '';
    $info_sub_title = isset($_POST['footer_information_sub_title']) ? sanitize_text_field($_POST['footer_information_sub_title']) : '';
    $info_description = isset($_POST['footer_information_description']) ? sanitize_textarea_field($_POST['footer_information_description']) : '';
    $list_pages = isset($_POST['footer_list_pages']) && is_array($_POST['footer_list_pages']) ? $_POST['footer_list_pages'] : array();
    $clean_lp = array();
    foreach ($list_pages as $lp) {
        $clean_lp[] = array(
            'url' => isset($lp['url']) ? esc_url_raw($lp['url']) : '',
            'title' => isset($lp['title']) ? sanitize_text_field($lp['title']) : '',
            'target' => isset($lp['target']) ? sanitize_text_field($lp['target']) : '',
        );
    }
    $contact_location = isset($_POST['footer_contact_location']) ? sanitize_text_field($_POST['footer_contact_location']) : '';
    $contact_phone = isset($_POST['footer_contact_phone']) ? sanitize_text_field($_POST['footer_contact_phone']) : '';
    $contact_email = isset($_POST['footer_contact_email']) ? sanitize_email($_POST['footer_contact_email']) : '';
    $contact_time = isset($_POST['footer_contact_time']) ? sanitize_text_field($_POST['footer_contact_time']) : '';
    $contact_links = isset($_POST['footer_contact_links']) && is_array($_POST['footer_contact_links']) ? $_POST['footer_contact_links'] : array();
    $clean_cl = array();
    foreach ($contact_links as $cl) {
        $clean_cl[] = array(
            'icon_id' => isset($cl['icon_id']) ? absint($cl['icon_id']) : 0,
            'url' => isset($cl['url']) ? esc_url_raw($cl['url']) : '',
            'title' => isset($cl['title']) ? sanitize_text_field($cl['title']) : '',
            'target' => isset($cl['target']) ? sanitize_text_field($cl['target']) : '',
        );
    }
    $create_build_text = isset($_POST['footer_create_build_text']) ? sanitize_text_field($_POST['footer_create_build_text']) : '';
    $policy_text = isset($_POST['footer_policy_text']) ? sanitize_text_field($_POST['footer_policy_text']) : '';
    $policy_link = isset($_POST['footer_policy_link']) && is_array($_POST['footer_policy_link']) ? $_POST['footer_policy_link'] : array();
    $clean_policy_link = array(
        'url' => isset($policy_link['url']) ? esc_url_raw($policy_link['url']) : '',
        'title' => isset($policy_link['title']) ? sanitize_text_field($policy_link['title']) : '',
        'target' => isset($policy_link['target']) ? sanitize_text_field($policy_link['target']) : '',
    );
    $servicer_text = isset($_POST['footer_servicer_text']) ? sanitize_text_field($_POST['footer_servicer_text']) : '';
    $servicer_link = isset($_POST['footer_servicer_link']) && is_array($_POST['footer_servicer_link']) ? $_POST['footer_servicer_link'] : array();
    $clean_servicer_link = array(
        'url' => isset($servicer_link['url']) ? esc_url_raw($servicer_link['url']) : '',
        'title' => isset($servicer_link['title']) ? sanitize_text_field($servicer_link['title']) : '',
        'target' => isset($servicer_link['target']) ? sanitize_text_field($servicer_link['target']) : '',
    );
    set_theme_mod('footer_banner_image_id', $banner_image_id);
    set_theme_mod('footer_information_logo_id', $info_logo_id);
    set_theme_mod('footer_information_title', $info_title);
    set_theme_mod('footer_information_sub_title', $info_sub_title);
    set_theme_mod('footer_information_description', $info_description);
    set_theme_mod('footer_list_pages', $clean_lp);
    set_theme_mod('footer_contact_location', $contact_location);
    set_theme_mod('footer_contact_phone', $contact_phone);
    set_theme_mod('footer_contact_email', $contact_email);
    set_theme_mod('footer_contact_time', $contact_time);
    set_theme_mod('footer_contact_links', $clean_cl);
    set_theme_mod('footer_create_build_text', $create_build_text);
    set_theme_mod('footer_policy_text', $policy_text);
    set_theme_mod('footer_policy_link', $clean_policy_link);
    set_theme_mod('footer_servicer_text', $servicer_text);
    set_theme_mod('footer_servicer_link', $clean_servicer_link);
    wp_redirect(admin_url('themes.php?page=buildpro-footer&updated=1'));
    exit;
}
add_action('admin_post_buildpro_save_footer', 'buildpro_handle_footer_save');
