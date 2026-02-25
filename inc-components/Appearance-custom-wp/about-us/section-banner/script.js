(function ($, api) {
  function init(container) {
    var $root = $(container);
    var $list = $root.find(".buildpro-about-facts-list");
    var $input = $root.find(".buildpro-about-facts-input");
    var $addBtn = $root.find(".buildpro-about-facts-add");
    var MAX = 4;
    var $limitNote = $root.find(".buildpro-about-facts-limit");
    if ($limitNote.length === 0) {
      $limitNote = $(
        '<p class="description buildpro-about-facts-limit" style="display:none">Chỉ lưu tối đa 4 mục; mục vượt quá sẽ không được lưu.</p>',
      );
      $limitNote.insertBefore($addBtn.closest("p"));
    }
    function getItems() {
      try {
        var v = $input.val();
        var arr = JSON.parse(v);
        return Array.isArray(arr) ? arr : [];
      } catch (e) {
        return [];
      }
    }
    (function ensureValidJSON() {
      var initItems = getItems();
      if (!Array.isArray(initItems)) {
        initItems = [];
      }
      $input.val(JSON.stringify(initItems));
    })();
    function setItems(items, opts) {
      var options = opts || {};
      var notify = options.notify !== false;
      $input.val(JSON.stringify(items));
      if (
        api &&
        typeof api === "function" &&
        api.has &&
        api.has("buildpro_about_banner_facts")
      ) {
        try {
          api("buildpro_about_banner_facts").set(items);
        } catch (e) {}
      }
      if (notify) {
        $input.trigger("change");
      }
    }
    function updateAddState(count) {
      var over = count > MAX;
      $addBtn.prop("disabled", false);
      $limitNote.toggle(over);
    }
    function render() {
      var items = getItems();
      $list.empty();
      updateAddState(items.length);
      items.forEach(function (it, idx) {
        var $item = $(
          '<div class="buildpro-about-fact" style="border:1px solid #e5e7eb;padding:8px;margin-bottom:8px;border-radius:4px"></div>',
        );
        var $label = $(
          '<p><label>Label<br><input type="text" class="widefat"></label></p>',
        );
        var $value = $(
          '<p><label>Value<br><input type="text" class="widefat"></label></p>',
        );
        var $remove = $(
          '<p><button type="button" class="button remove-fact">Remove</button></p>',
        );
        $label.find("input").val(it.label || "");
        $value.find("input").val(it.value || "");
        $item.append($label).append($value).append($remove);
        $list.append($item);
        $label.find("input").on("input", function () {
          var items2 = getItems();
          items2[idx] = items2[idx] || { label: "", value: "" };
          items2[idx].label = String($(this).val() || "");
          setItems(items2, { notify: false });
        });
        $label.find("input").on("blur", function () {
          $input.trigger("change");
        });
        $value.find("input").on("input", function () {
          var items2 = getItems();
          items2[idx] = items2[idx] || { label: "", value: "" };
          items2[idx].value = String($(this).val() || "");
          setItems(items2, { notify: false });
        });
        $value.find("input").on("blur", function () {
          $input.trigger("change");
        });
      });
      $list
        .off("click.buildproFactsRemove")
        .on("click.buildproFactsRemove", ".remove-fact", function (e) {
          e.preventDefault();
          var $it = $(this).closest(".buildpro-about-fact");
          var index = $it.index();
          var items2 = getItems();
          if (index >= 0) {
            items2.splice(index, 1);
            setItems(items2);
            render();
          }
        });
    }
    $root
      .off("click.buildproFactsAdd")
      .on("click.buildproFactsAdd", ".buildpro-about-facts-add", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var items = getItems();
        items.push({ label: "", value: "" });
        setItems(items);
        render();
      });
    render();
    $input.off("change").on("change", function () {});
  }
  $(document).on("ready", function () {
    $(".buildpro-about-facts-repeater").each(function () {
      init(this);
    });
  });
  if (api && api.control) {
    api.control("buildpro_about_banner_facts", function (ctrl) {
      var setting =
        api && api.has && api.has("buildpro_about_banner_facts")
          ? api("buildpro_about_banner_facts")
          : null;
      function boot() {
        var el = ctrl.container.find(".buildpro-about-facts-repeater")[0];
        if (el) init(el);
      }
      boot();
      if (setting && setting.bind) {
        setting.bind(function (val) {
          try {
            var arr = Array.isArray(val) ? val.slice(0) : [];
            var $wrap = ctrl.container.find(".buildpro-about-facts-repeater");
            var $inp = $wrap.find(".buildpro-about-facts-input");
            $inp.val(JSON.stringify(arr));
            render();
          } catch (e) {}
        });
      }
      var sec = api.section && api.section("buildpro_about_banner_section");
      function fetchAndPopulateFromMeta() {
        try {
          var pid = 0;
          if (api && api.has && api.has("buildpro_preview_page_id")) {
            pid = parseInt(api("buildpro_preview_page_id").get() || 0, 10) || 0;
          }
          if (
            !pid &&
            window.BuildProAboutFacts &&
            BuildProAboutFacts.default_page_id
          ) {
            pid = parseInt(BuildProAboutFacts.default_page_id, 10) || 0;
          }
          if (!pid) return;
          if (
            !window.BuildProAboutFacts ||
            !BuildProAboutFacts.ajax_url ||
            !BuildProAboutFacts.nonce
          )
            return;
          var $wrap = ctrl.container.find(".buildpro-about-facts-repeater");
          var $inp = $wrap.find(".buildpro-about-facts-input");
          var cur = [];
          try {
            cur = JSON.parse($inp.val() || "[]");
          } catch (e) {
            cur = [];
          }
          if (Array.isArray(cur) && cur.length > 0) return;
          $.ajax({
            url: BuildProAboutFacts.ajax_url,
            method: "GET",
            data: {
              action: "buildpro_get_about_facts",
              nonce: BuildProAboutFacts.nonce,
              page_id: pid,
            },
          }).done(function (resp) {
            if (
              resp &&
              resp.success &&
              resp.data &&
              Array.isArray(resp.data.facts)
            ) {
              $inp.val(JSON.stringify(resp.data.facts)).trigger("change");
              if (
                api &&
                typeof api === "function" &&
                api.has &&
                api.has("buildpro_about_banner_facts")
              ) {
                try {
                  api("buildpro_about_banner_facts").set(resp.data.facts);
                } catch (e) {}
              }
            }
          });
        } catch (e) {}
      }
      fetchAndPopulateFromMeta();
      if (sec && sec.expanded) {
        sec.expanded.bind(function (exp) {
          if (exp) {
            boot();
            fetchAndPopulateFromMeta();
          }
        });
      }
    });
  }
})(jQuery, wp.customize);
