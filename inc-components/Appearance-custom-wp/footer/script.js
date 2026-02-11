;(function () {
  function bindListPages() {
    var wrap = document.getElementById("customizer-footer-list-pages-wrapper");
    var input = document.querySelector(".footer-list-pages-json");
    var addBtn = document.getElementById("customizer-footer-list-pages-add");
    if (!wrap || !input || wrap.getAttribute("data-bound") === "1") return;
    wrap.setAttribute("data-bound", "1");
    function collect() {
      var rows = wrap.querySelectorAll(".buildpro-block");
      var out = [];
      Array.prototype.forEach.call(rows, function (row) {
        var url = row.querySelector("[data-field='url']");
        var title = row.querySelector("[data-field='title']");
        var target = row.querySelector("[data-field='target']");
        out.push({
          url: url ? url.value : "",
          title: title ? title.value : "",
          target: target ? target.value : "",
        });
      });
      input.value = JSON.stringify(out);
      input.dispatchEvent(new Event("input"));
      input.dispatchEvent(new Event("change"));
    }
    wrap.addEventListener("input", collect, true);
    wrap.addEventListener("change", collect, true);
    wrap.addEventListener(
      "click",
      function (e) {
        var t = e.target;
        if (!t || !t.classList) return;
        if (t.classList.contains("remove-row")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (row) {
            row.parentNode.removeChild(row);
            collect();
          }
        } else if (t.classList.contains("choose-link")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (!row) return;
          var url = row.querySelector("[data-field='url']");
          var title = row.querySelector("[data-field='title']");
          var target = row.querySelector("[data-field='target']");
          window.buildproLinkTarget = {
            urlInput: url,
            titleInput: title,
            targetSelect: target,
            sectionId: "buildpro_footer_section",
          };
          if (window.wp && wp.customize && typeof wp.customize.section === "function") {
            var s = wp.customize.section("buildpro_link_picker_section");
            if (s && typeof s.expand === "function") {
              s.expand();
              return;
            }
          }
        }
      },
      true,
    );
    if (addBtn && addBtn.getAttribute("data-bound") !== "1") {
      addBtn.setAttribute("data-bound", "1");
      addBtn.addEventListener("click", function (e) {
        e.preventDefault();
        var html =
          "" +
          "<div class='buildpro-block'>" +
          "<p class='buildpro-field'><label>Link URL</label><input type='url' class='regular-text' data-field='url' value='' placeholder='https://...'> <button type='button' class='button choose-link'>Choose link</button></p>" +
          "<p class='buildpro-field'><label>Link Title</label><input type='text' class='regular-text' data-field='title' value=''></p>" +
          "<p class='buildpro-field'><label>Link Target</label><select data-field='target'><option value=''>Same Tab</option><option value='_blank'>Open New Tab</option></select></p>" +
          "<div class='buildpro-actions'><button type='button' class='button remove-row'>Remove Item</button></div>" +
          "</div>";
        var temp = document.createElement("div");
        temp.innerHTML = html;
        var row = temp.firstElementChild;
        wrap.appendChild(row);
        collect();
      });
    }
    collect();
  }
  function bindContactLinks() {
    var wrap = document.getElementById("customizer-footer-contact-links-wrapper");
    var input = document.querySelector(".footer-contact-links-json");
    var addBtn = document.getElementById("customizer-footer-contact-links-add");
    if (!wrap || !input || wrap.getAttribute("data-bound") === "1") return;
    wrap.setAttribute("data-bound", "1");
    function collect() {
      var rows = wrap.querySelectorAll(".buildpro-block");
      var out = [];
      Array.prototype.forEach.call(rows, function (row) {
        var icon = row.querySelector("[data-field='icon_id']");
        var url = row.querySelector("[data-field='url']");
        var title = row.querySelector("[data-field='title']");
        var target = row.querySelector("[data-field='target']");
        out.push({
          icon_id: icon ? parseInt(icon.value || "0", 10) : 0,
          url: url ? url.value : "",
          title: title ? title.value : "",
          target: target ? target.value : "",
        });
      });
      input.value = JSON.stringify(out);
      input.dispatchEvent(new Event("input"));
      input.dispatchEvent(new Event("change"));
    }
    wrap.addEventListener("input", collect, true);
    wrap.addEventListener("change", collect, true);
    wrap.addEventListener(
      "click",
      function (e) {
        var t = e.target;
        if (!t || !t.classList) return;
        if (t.classList.contains("remove-row")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (row) {
            row.parentNode.removeChild(row);
            collect();
          }
        } else if (t.classList.contains("choose-link")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (!row) return;
          var url = row.querySelector("[data-field='url']");
          var title = row.querySelector("[data-field='title']");
          var target = row.querySelector("[data-field='target']");
          window.buildproLinkTarget = {
            urlInput: url,
            titleInput: title,
            targetSelect: target,
            sectionId: "buildpro_footer_section",
          };
          if (window.wp && wp.customize && typeof wp.customize.section === "function") {
            var s = wp.customize.section("buildpro_link_picker_section");
            if (s && typeof s.expand === "function") {
              s.expand();
              return;
            }
          }
        } else if (t.classList.contains("select-contact-icon")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (!row) return;
          var idInput = row.querySelector("[data-field='icon_id']");
          var preview = row.querySelector(".contact-icon-preview");
          if (window.wp && wp.media) {
            var frame = wp.media({
              title: "Select Icon",
              multiple: false,
              library: { type: "image" },
            });
            frame.on("select", function () {
              var file = frame.state().get("selection").first().toJSON();
              if (idInput) {
                idInput.value = String(file.id || 0);
                idInput.dispatchEvent(new Event("input"));
              }
              if (preview) {
                var url =
                  (file &&
                    file.sizes &&
                    file.sizes.thumbnail &&
                    file.sizes.thumbnail.url) ||
                  file.url ||
                  "";
                preview.innerHTML = url
                  ? "<img src='" + url + "' style='max-height:80px;'>"
                  : "<span style='color:#888'>No Image Selected</span>";
              }
              collect();
            });
            frame.open();
          }
        } else if (t.classList.contains("remove-contact-icon")) {
          e.preventDefault();
          var row = t.closest(".buildpro-block");
          if (!row) return;
          var idInput = row.querySelector("[data-field='icon_id']");
          var preview = row.querySelector(".contact-icon-preview");
          if (idInput) {
            idInput.value = "0";
            idInput.dispatchEvent(new Event("input"));
          }
          if (preview) {
            preview.innerHTML = "<span style='color:#888'>No Image Selected</span>";
          }
          collect();
        }
      },
      true,
    );
    if (addBtn && addBtn.getAttribute("data-bound") !== "1") {
      addBtn.setAttribute("data-bound", "1");
      addBtn.addEventListener("click", function (e) {
        e.preventDefault();
        var html =
          "" +
          "<div class='buildpro-block'>" +
          "<p class='buildpro-field'><label>Icon</label><input type='hidden' class='regular-text' data-field='icon_id' value='0'> <button type='button' class='button select-contact-icon'>Selected photo</button> <button type='button' class='button remove-contact-icon'>Remove photo</button></p>" +
          "<div class='image-preview contact-icon-preview'><span style='color:#888'>No Image Selected</span></div>" +
          "<p class='buildpro-field'><label>Link URL</label><input type='url' class='regular-text' data-field='url' value='' placeholder='https://...'> <button type='button' class='button choose-link'>Choose link</button></p>" +
          "<p class='buildpro-field'><label>Link Title</label><input type='text' class='regular-text' data-field='title' value=''></p>" +
          "<p class='buildpro-field'><label>Link Target</label><select data-field='target'><option value=''>Same Tab</option><option value='_blank'>Open New Tab</option></select></p>" +
          "<div class='buildpro-actions'><button type='button' class='button remove-row'>Remove Item</button></div>" +
          "</div>";
        var temp = document.createElement("div");
        temp.innerHTML = html;
        var row = temp.firstElementChild;
        wrap.appendChild(row);
        collect();
      });
    }
    collect();
  }
  function tryBind() {
    bindListPages();
    bindContactLinks();
  }
  var mo = new MutationObserver(function () {
    tryBind();
  });
  try {
    mo.observe(document.documentElement || document.body, {
      childList: true,
      subtree: true,
    });
  } catch (e) {}
  if (document.readyState === "complete" || document.readyState === "interactive") {
    tryBind();
  } else {
    document.addEventListener("DOMContentLoaded", tryBind, false);
  }
})(); 
