(function (wp) {
  if (typeof window === "undefined") return;
  (function () {
    var tabs = document.querySelectorAll(".nav-tab-wrapper .nav-tab");
    var sections = document.querySelectorAll(".buildpro-footer-section");
    Array.prototype.forEach.call(tabs, function (tab) {
      tab.addEventListener("click", function (e) {
        e.preventDefault();
        Array.prototype.forEach.call(tabs, function (t) {
          t.classList.remove("nav-tab-active");
        });
        tab.classList.add("nav-tab-active");
        var id = tab.getAttribute("href");
        Array.prototype.forEach.call(sections, function (sec) {
          sec.classList.remove("active");
        });
        var target = document.querySelector(id);
        if (target) {
          target.classList.add("active");
        }
      });
    });
    var frame;
    function selectImage(buttonId, inputId, previewId) {
      var btn = document.getElementById(buttonId);
      var removeBtnId = buttonId.replace("select_", "remove_");
      var removeBtn = document.getElementById(removeBtnId);
      var input = document.getElementById(inputId);
      var preview = document.getElementById(previewId);
      if (btn) {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          if (!frame) {
            frame = wp.media({
              title: "Choose image",
              button: { text: "Use image" },
              multiple: false,
            });
          }
          if (typeof frame.off === "function") {
            frame.off("select");
          }
          frame.on("select", function () {
            var attachment = frame.state().get("selection").first().toJSON();
            if (input) input.value = attachment.id;
            var url =
              attachment.sizes && attachment.sizes.thumbnail
                ? attachment.sizes.thumbnail.url
                : attachment.url;
            if (preview) {
              preview.innerHTML =
                "<img src='" + url + "' style='max-height:80px;'>";
            }
          });
          frame.open();
        });
      }
      if (removeBtn) {
        removeBtn.addEventListener("click", function (e) {
          e.preventDefault();
          if (input) input.value = "";
          if (preview)
            preview.innerHTML =
              "<span style='color:#888'>No image selected</span>";
        });
      }
    }
    selectImage(
      "select_footer_banner_image",
      "footer_banner_image_id",
      "footer_banner_preview",
    );
    selectImage(
      "select_footer_information_logo",
      "footer_information_logo_id",
      "footer_information_logo_preview",
    );
    var customCtx = { urlInput: null, titleInput: null, targetSelect: null };
    function showCustom() {
      var b = document.getElementById("buildpro-custom-link-backdrop");
      var m = document.getElementById("buildpro-custom-link-modal");
      if (b) b.style.display = "block";
      if (m) m.style.display = "block";
      fetchRecent();
    }
    function hideCustom() {
      var b = document.getElementById("buildpro-custom-link-backdrop");
      var m = document.getElementById("buildpro-custom-link-modal");
      if (b) b.style.display = "none";
      if (m) m.style.display = "none";
    }
    function openCustomLinkPicker(urlInput, titleInput, targetSelect) {
      customCtx.urlInput = urlInput;
      customCtx.titleInput = titleInput;
      customCtx.targetSelect = targetSelect;
      var urlEl = document.getElementById("buildpro_custom_link_url");
      var titleEl = document.getElementById("buildpro_custom_link_title");
      var targetEl = document.getElementById("buildpro_custom_link_target");
      if (urlEl) urlEl.value = urlInput && urlInput.value ? urlInput.value : "";
      if (titleEl)
        titleEl.value = titleInput && titleInput.value ? titleInput.value : "";
      if (targetEl)
        targetEl.checked = targetSelect && targetSelect.value === "_blank";
      showCustom();
    }
    function applyCustom() {
      var urlEl = document.getElementById("buildpro_custom_link_url");
      var titleEl = document.getElementById("buildpro_custom_link_title");
      var targetEl = document.getElementById("buildpro_custom_link_target");
      if (customCtx.urlInput && urlEl)
        customCtx.urlInput.value = urlEl.value || "";
      if (customCtx.titleInput && titleEl)
        customCtx.titleInput.value = titleEl.value || "";
      if (customCtx.targetSelect && targetEl)
        customCtx.targetSelect.value = targetEl.checked ? "_blank" : "";
      hideCustom();
    }
    function fetchJSON(u) {
      try {
        if (window.wp && window.wp.apiFetch) {
          var p = u.replace(/^\/wp-json\//, "");
          return window.wp.apiFetch({ path: p }).catch(function () {
            return [];
          });
        }
      } catch (e) {}
      return fetch(u, { credentials: "same-origin" })
        .then(function (r) {
          return r.ok ? r.json() : [];
        })
        .catch(function () {
          return [];
        });
    }
    function renderItems(items) {
      var results = document.getElementById("buildpro_custom_link_results");
      if (results) results.innerHTML = "";
      items.forEach(function (m) {
        var div = document.createElement("div");
        div.className = "buildpro-custom-link-item";
        div.textContent = m.title + " (" + m.type + ")";
        div.addEventListener("click", function () {
          var urlEl = document.getElementById("buildpro_custom_link_url");
          var titleEl = document.getElementById("buildpro_custom_link_title");
          if (urlEl) urlEl.value = m.url;
          if (titleEl) titleEl.value = m.title;
        });
        if (results) results.appendChild(div);
      });
    }
    function fetchRecent() {
      var qpages = "/wp-json/wp/v2/pages?per_page=20&orderby=date&order=desc";
      var qposts = "/wp-json/wp/v2/posts?per_page=20&orderby=date&order=desc";
      Promise.all([fetchJSON(qpages), fetchJSON(qposts)]).then(function (res) {
        var pages = res[0].map(function (it) {
          return {
            title:
              it.title && it.title.rendered
                ? it.title.rendered
                : it.slug || "Page",
            url: it.link,
            type: "PAGE",
            date: new Date(it.date),
          };
        });
        var posts = res[1].map(function (it) {
          return {
            title:
              it.title && it.title.rendered
                ? it.title.rendered
                : it.slug || "Post",
            url: it.link,
            type: "POST",
            date: new Date(it.date),
          };
        });
        var all = pages.concat(posts).sort(function (a, b) {
          return b.date - a.date;
        });
        renderItems(all);
      });
    }
    function searchContent(q, source) {
      var qparam = q ? "&search=" + encodeURIComponent(q) : "";
      if (source === "page") {
        fetchJSON("/wp-json/wp/v2/pages?per_page=20" + qparam).then(
          function (items) {
            renderItems(
              items.map(function (it) {
                return {
                  title:
                    it.title && it.title.rendered
                      ? it.title.rendered
                      : it.slug || "Page",
                  url: it.link,
                  type: "PAGE",
                };
              }),
            );
          },
        );
      } else if (source === "post") {
        fetchJSON("/wp-json/wp/v2/posts?per_page=20" + qparam).then(
          function (items) {
            renderItems(
              items.map(function (it) {
                return {
                  title:
                    it.title && it.title.rendered
                      ? it.title.rendered
                      : it.slug || "Post",
                  url: it.link,
                  type: "POST",
                };
              }),
            );
          },
        );
      } else {
        fetchJSON(
          "/wp-json/wp/v2/search?per_page=20" +
            (q ? "&search=" + encodeURIComponent(q) : ""),
        ).then(function (items) {
          renderItems(
            items.map(function (it) {
              return {
                title: it.title || it.url,
                url: it.url,
                type:
                  it.type === "post"
                    ? (it.subtype || "POST").toUpperCase()
                    : "LINK",
              };
            }),
          );
        });
      }
    }
    var cancelBtn = document.getElementById("buildpro_custom_link_cancel");
    var applyBtn = document.getElementById("buildpro_custom_link_apply");
    var searchInput = document.getElementById("buildpro_custom_link_search");
    var sourceSel = document.getElementById("buildpro_custom_link_source");
    if (cancelBtn) cancelBtn.addEventListener("click", hideCustom);
    if (applyBtn) applyBtn.addEventListener("click", applyCustom);
    if (searchInput)
      searchInput.addEventListener("input", function (e) {
        var q = e.target.value;
        if (q) {
          searchContent(q, sourceSel ? sourceSel.value : "all");
        } else {
          fetchRecent();
        }
      });
    if (sourceSel)
      sourceSel.addEventListener("change", function () {
        var q = searchInput ? searchInput.value : "";
        if (q) {
          searchContent(q, sourceSel.value);
        } else {
          fetchRecent();
        }
      });
    fetchRecent();
    window.buildproOpenCustom = function (btn) {
      var row = btn.closest(".buildpro-block");
      var urlInput = row ? row.querySelector("input[name$='[url]']") : null;
      var titleInput = row ? row.querySelector("input[name$='[title]']") : null;
      var targetSelect = row
        ? row.querySelector("select[name$='[target]']")
        : null;
      openCustomLinkPicker(urlInput, titleInput, targetSelect);
      return false;
    };
    document.addEventListener(
      "click",
      function (e) {
        var t = e.target;
        if (!t) return;
        if (t.classList && t.classList.contains("choose-link")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          var urlInput = row ? row.querySelector("input[name$='[url]']") : null;
          var titleInput = row
            ? row.querySelector("input[name$='[title]']")
            : null;
          var targetSelect = row
            ? row.querySelector("select[name$='[target]']")
            : null;
          openCustomLinkPicker(urlInput, titleInput, targetSelect);
        }
      },
      true,
    );
    function bindRow(row) {
      var linkBtn = row.querySelector(".choose-link");
      var urlInput = row.querySelector("input[name$='[url]']");
      var titleInput = row.querySelector("input[name$='[title]']");
      var targetSelect = row.querySelector("select[name$='[target]']");
      var removeRowBtn = row.querySelector(".remove-row");
      var selectIconBtn = row.querySelector(".select-contact-icon");
      var removeIconBtn = row.querySelector(".remove-contact-icon");
      var iconInput = row.querySelector("input[name$='[icon_id]']");
      var iconPreview = row.querySelector(".contact-icon-preview");
      var iconFrame;
      if (linkBtn)
        linkBtn.addEventListener("click", function (e) {
          e.preventDefault();
          openCustomLinkPicker(urlInput, titleInput, targetSelect);
        });
      if (urlInput)
        urlInput.addEventListener("click", function (e) {
          e.preventDefault();
          openCustomLinkPicker(urlInput, titleInput, targetSelect);
        });
      if (removeRowBtn)
        removeRowBtn.addEventListener("click", function (e) {
          e.preventDefault();
          row.parentNode.removeChild(row);
        });
      if (selectIconBtn) {
        selectIconBtn.addEventListener("click", function (e) {
          e.preventDefault();
          if (!iconFrame) {
            iconFrame = wp.media({
              title: "Select Image",
              button: { text: "Use Image" },
              multiple: false,
            });
          }
          if (typeof iconFrame.off === "function") {
            iconFrame.off("select");
          }
          iconFrame.on("select", function () {
            var attachment = iconFrame
              .state()
              .get("selection")
              .first()
              .toJSON();
            if (iconInput) iconInput.value = attachment.id;
            var url =
              attachment.sizes && attachment.sizes.thumbnail
                ? attachment.sizes.thumbnail.url
                : attachment.url;
            if (iconPreview)
              iconPreview.innerHTML =
                "<img src='" + url + "' style='max-height:80px;'>";
          });
          iconFrame.open();
        });
      }
      if (removeIconBtn) {
        removeIconBtn.addEventListener("click", function (e) {
          e.preventDefault();
          if (iconInput) iconInput.value = "";
          if (iconPreview)
            iconPreview.innerHTML =
              "<span style='color:#888'>No Image Selected</span>";
        });
      }
    }
    Array.prototype.forEach.call(
      document.querySelectorAll("#footer-list-pages-wrapper .buildpro-block"),
      bindRow,
    );
    Array.prototype.forEach.call(
      document.querySelectorAll(
        "#footer-contact-links-wrapper .buildpro-block",
      ),
      bindRow,
    );
    var addLP = document.getElementById("footer-list-pages-add");
    if (addLP) {
      addLP.addEventListener("click", function (e) {
        e.preventDefault();
        var wrapper = document.getElementById("footer-list-pages-wrapper");
        var idx = wrapper.querySelectorAll(".buildpro-block").length;
        var html =
          "" +
          "<div class='buildpro-block' data-index='" +
          idx +
          "'>" +
          "  <p class='buildpro-field'><label>Link URL</label><input type='url' name='footer_list_pages[" +
          idx +
          "][url]' class='regular-text' value='' placeholder='https://...'> <button type='button' class='button choose-link'>Choose Link</button></p>" +
          "  <p class='buildpro-field'><label>Link Title</label><input type='text' name='footer_list_pages[" +
          idx +
          "][title]' class='regular-text' value=''></p>" +
          "  <p class='buildpro-field'><label>Link Target</label><select name='footer_list_pages[" +
          idx +
          "][target]'><option value=''>Same Tab</option><option value='_blank'>Open New Tab</option></select></p>" +
          "  <div class='buildpro-actions'><button type='button' class='button remove-row'>Remove Item</button></div>" +
          "</div>";
        var temp = document.createElement("div");
        temp.innerHTML = html;
        var row = temp.firstElementChild;
        wrapper.appendChild(row);
        bindRow(row);
      });
    }
    var addCL = document.getElementById("footer-contact-links-add");
    if (addCL) {
      addCL.addEventListener("click", function (e) {
        e.preventDefault();
        var wrapper = document.getElementById("footer-contact-links-wrapper");
        var idx = wrapper.querySelectorAll(".buildpro-block").length;
        var html =
          "" +
          "<div class='buildpro-block' data-index='" +
          idx +
          "'>" +
          "  <p class='buildpro-field'><label>Icon</label><input type='hidden' name='footer_contact_links[" +
          idx +
          "][icon_id]' value=''> <button type='button' class='button select-contact-icon'>Selected photo</button> <button type='button' class='button remove-contact-icon'>Remove photo</button></p>" +
          "  <div class='image-preview contact-icon-preview'><span style='color:#888'>No Image Selected</span></div>" +
          "  <p class='buildpro-field'><label>Link URL</label><input type='url' name='footer_contact_links[" +
          idx +
          "][url]' class='regular-text' value='' placeholder='https://...'> <button type='button' class='button choose-link'>Choose Link</button></p>" +
          "  <p class='buildpro-field'><label>Link Title</label><input type='text' name='footer_contact_links[" +
          idx +
          "][title]' class='regular-text' value=''></p>" +
          "  <p class='buildpro-field'><label>Link Target</label><select name='footer_contact_links[" +
          idx +
          "][target]'><option value=''>Same Tab</option><option value='_blank'>Open New Tab</option></select></p>" +
          "  <div class='buildpro-actions'><button type='button' class='button remove-row'>Remove Item</button></div>" +
          "</div>";
        var temp = document.createElement("div");
        temp.innerHTML = html;
        var row = temp.firstElementChild;
        wrapper.appendChild(row);
        bindRow(row);
      });
    }
    Array.prototype.forEach.call(
      document.querySelectorAll(".choose-link-single"),
      function (btn) {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          var urlSel = btn.getAttribute("data-url");
          var titleSel = btn.getAttribute("data-title");
          var targetSel = btn.getAttribute("data-target");
          var urlInput = document.querySelector(urlSel);
          var titleInput = document.querySelector(titleSel);
          var targetSelect = document.querySelector(targetSel);
          openCustomLinkPicker(urlInput, titleInput, targetSelect);
        });
      },
    );
  })();

  if (wp && wp.customize) {
    wp.customize("footer_information_title", function (value) {
      value.bind(function (to) {
        var el = document.querySelector(".footer__title");
        if (!el) return;
        var v = (to == null ? "" : String(to)).trim();
        el.textContent = v ? v : "";
      });
    });
    wp.customize("footer_information_sub_title", function (value) {
      value.bind(function (to) {
        var el = document.querySelector(".footer__subtitle");
        if (!el) return;
        var v = (to == null ? "" : String(to)).trim();
        el.textContent = v ? v : "";
      });
    });
    wp.customize("footer_information_description", function (value) {
      value.bind(function (to) {
        var el = document.querySelector(".footer__description");
        if (!el) return;
        var v = (to == null ? "" : String(to)).trim();
        el.textContent = v ? v : "";
      });
    });
    wp.customize("footer_information_logo_id", function (value) {
      value.bind(function () {
        if (wp.customize.selectiveRefresh) {
          wp.customize.selectiveRefresh.requestFullRefresh();
        }
      });
    });
  }
})(window.wp);
