/* global jQuery */
(function ($) {
  function init(el) {
    var wrap = el.find(".buildpro-about-core-values-repeater");
    if (!wrap.length) return;
    var list = wrap.find(".buildpro-about-core-values-list");
    var input = wrap.find(".buildpro-about-core-values-input");
    var frame = null;
    var didFetch = false;
    var api = window.wp && window.wp.customize ? window.wp.customize : null;
    function getItems() {
      try {
        var v = input.val();
        if (!v) return [];
        var parsed = JSON.parse(v);
        return Array.isArray(parsed) ? parsed : [];
      } catch (e) {
        return [];
      }
    }
    function setItems(items) {
      input.val(JSON.stringify(items || []));
      input.trigger("change");
    }
    function render() {
      var items = getItems();
      list.empty();
      if (
        (!items || items.length === 0) &&
        !didFetch &&
        window.BuildProAboutCoreValues
      ) {
        didFetch = true;
        $.ajax({
          url: BuildProAboutCoreValues.ajax_url,
          method: "POST",
          dataType: "json",
          data: {
            action: "buildpro_get_about_core_values",
            nonce: BuildProAboutCoreValues.nonce,
            page_id: BuildProAboutCoreValues.default_page_id || 0,
          },
        })
          .done(function (resp) {
            if (resp && resp.success && resp.data) {
              var d = resp.data || {};
              if (Array.isArray(d.items) && d.items.length) {
                setItems(d.items);
                items = d.items;
              }
              if (api) {
                if (typeof d.title === "string") {
                  api("buildpro_about_core_values_title").set(d.title);
                }
                if (typeof d.description === "string") {
                  api("buildpro_about_core_values_description").set(
                    d.description,
                  );
                }
                if (typeof d.enabled !== "undefined") {
                  api("buildpro_about_core_values_enabled").set(
                    !!parseInt(d.enabled, 10),
                  );
                }
              }
              list.empty();
            }
          })
          .always(function () {
            // after attempt, render whatever we have
            render();
          });
        return;
      }
      items.forEach(function (it, idx) {
        var row = $('<div class="core-value-item"/>');
        var cvHeader = $(
          '<div class="cv-accordion-header"><span class="cv-accordion-label">' +
            (it.title || "Item " + (idx + 1)) +
            '</span><span class="cv-accordion-arrow">&#9660;</span></div>',
        );
        var cvBody = $(
          '<div class="cv-accordion-body" style="display:none"></div>',
        );
        row.append(cvHeader).append(cvBody);
        cvHeader.on("click", function () {
          var isOpen = cvBody.css("display") !== "none";
          cvBody.css("display", isOpen ? "none" : "block");
          cvHeader
            .find(".cv-accordion-arrow")
            .css("transform", isOpen ? "rotate(-90deg)" : "rotate(0deg)");
        });
        var previewUrl = it.icon_url || "";
        var preview = $(
          '<div class="cv-icon-preview">' +
            (previewUrl
              ? '<img src="' +
                previewUrl +
                '" style="max-width:2.75rem;height:auto;border-radius:0.625rem;border:1px solid #e5e7eb;" />'
              : '<div class="cv-icon-empty">No image</div>') +
            "</div>",
        );
        var imgControls =
          '<div class="cv-icon-controls">' +
          '<input type="hidden" class="cv-icon-id" value="' +
          (it.icon_id || 0) +
          '">' +
          '<button type="button" class="button button-secondary cv-select-icon">Select Image</button> ' +
          '<button type="button" class="button cv-remove-icon">Remove</button>' +
          "</div>";
        cvBody.append("<p><label>Icon Image</label></p>");
        cvBody.append(preview);
        cvBody.append(imgControls);
        cvBody.append(
          '<p><label>Title<br><input type="text" class="widefat cv-title" value="' +
            (it.title || "") +
            '"></label></p>',
        );
        cvBody.append(
          '<p><label>Description<br><textarea class="widefat cv-desc" rows="3">' +
            (it.description || "") +
            "</textarea></label></p>",
        );
        cvBody.append(
          '<p><label>URL<br><input type="text" class="widefat cv-url" value="' +
            (it.url || "") +
            '"></label></p>',
        );
        cvBody.append(
          '<p><button type="button" class="button remove-core-value">Remove</button></p>',
        );
        row.on("click", ".cv-select-icon", function (e) {
          e.preventDefault();
          if (frame) {
            frame.off("select");
          }
          frame = wp.media({
            title: "Select Image",
            button: { text: "Use image" },
            multiple: false,
          });
          frame.on("select", function () {
            var att = frame.state().get("selection").first().toJSON();
            var url =
              att.sizes && att.sizes.thumbnail
                ? att.sizes.thumbnail.url
                : att.url;
            var id = att.id || 0;
            var items2 = getItems();
            var cur = items2[idx] || {};
            cur.icon_id = id;
            cur.icon_url = url;
            items2[idx] = cur;
            setItems(items2);
            render();
          });
          frame.open();
        });
        row.on("click", ".cv-remove-icon", function (e) {
          e.preventDefault();
          var items2 = getItems();
          var cur = items2[idx] || {};
          cur.icon_id = 0;
          cur.icon_url = "";
          items2[idx] = cur;
          setItems(items2);
          render();
        });
        row.on("input change", "input,textarea", function () {
          var items2 = getItems();
          var cur = items2[idx] || {};
          // keep icon fields as they are, updated via media handlers
          cur.title = row.find(".cv-title").val();
          cur.description = row.find(".cv-desc").val();
          cur.url = row.find(".cv-url").val();
          items2[idx] = cur;
          setItems(items2);
          var t = row.find(".cv-title").val();
          if (t) cvHeader.find(".cv-accordion-label").text(t);
        });
        row.on("click", ".remove-core-value", function (e) {
          e.preventDefault();
          var items2 = getItems();
          items2.splice(idx, 1);
          setItems(items2);
          render();
        });
        list.append(row);
      });
    }
    wrap.on("click", ".buildpro-about-core-values-add", function (e) {
      e.preventDefault();
      var items = getItems();
      items.push({
        icon_id: 0,
        icon_url: "",
        title: "",
        description: "",
        url: "",
      });
      setItems(items);
      render();
    });
    render();
  }
  $(function () {
    $(".customize-control").each(function () {
      init($(this));
    });
  });
})(jQuery);
