(function () {
  var urlField = document.getElementById("buildpro-link-url");
  var textField = document.getElementById("buildpro-link-text");
  var targetToggle = document.getElementById("buildpro-link-target");
  var searchField = document.getElementById("buildpro-link-search");
  var results = document.getElementById("buildpro-link-results");
  var applyBtn = document.getElementById("buildpro-link-apply");
  var closeBtn = document.getElementById("buildpro-link-close");
  function hasInitialResults() {
    if (!results) return false;
    var n = parseInt(results.getAttribute("data-initial-count") || "0", 10);
    return n > 0;
  }
  function normalizeTitle(t) {
    if (!t) return "";
    if (typeof t === "string") return t;
    if (t.rendered) return t.rendered;
    return "";
  }
  function fetchAll(base) {
    var per = 50;
    function one(page) {
      return fetch(base + "&per_page=" + per + "&page=" + page, {
        credentials: "same-origin",
      })
        .then(function (r) {
          var total = parseInt(r.headers.get("X-WP-TotalPages") || "1", 10);
          return r.json().then(function (data) {
            return { data: data, totalPages: total };
          });
        })
        .catch(function () {
          return { data: [], totalPages: 1 };
        });
    }
    return one(1).then(function (res1) {
      var all = res1.data || [];
      var total = res1.totalPages;
      if (total <= 1) {
        return all;
      }
      var maxPages = total;
      var tasks = [];
      for (var i = 2; i <= maxPages; i++) {
        tasks.push(one(i));
      }
      return Promise.all(tasks).then(function (rs) {
        rs.forEach(function (res) {
          all = all.concat(res.data || []);
        });
        return all;
      });
    });
  }
  function renderResults(items) {
    if (!results) return;
    if (!items || !items.length) {
      if (!hasInitialResults()) {
        results.innerHTML =
          "<p style='color:#888;margin:6px'>Không có kết quả</p>";
      }
      return;
    }
    results.setAttribute("data-initial-count", "0");
    results.innerHTML = items
      .map(function (it) {
        var title = normalizeTitle(it.title) || it.url || it.link || "";
        var url = it.url || it.link || "";
        var type = it.type || it.subtype || "";
        var chip = type
          ? '<span class="chip">' + String(type).toUpperCase() + "</span>"
          : "";
        return (
          '<div class="result"><div><div>' +
          title +
          chip +
          '</div><div class="meta">' +
          url +
          '</div></div><div><button type="button" class="button buildpro-link-pick" data-url="' +
          url +
          '" data-title="' +
          (title || "") +
          '">Chọn</button></div></div>'
        );
      })
      .join("");
  }
  function resolveRestBase(slug) {
    return fetch("/wp-json/wp/v2/types", { credentials: "same-origin" })
      .then(function (r) {
        return r.json();
      })
      .then(function (types) {
        var t = types && types[slug];
        var base = t && t.rest_base ? t.rest_base : slug + "s";
        return base;
      })
      .catch(function () {
        return slug + "s";
      });
  }
  function loadDefault() {
    Promise.all([
      fetchAll("/wp-json/wp/v2/pages?_fields=title,link").then(function (list) {
        return list.map(function (d) {
          return { title: d.title, url: d.link, type: "page" };
        });
      }),
      fetchAll("/wp-json/wp/v2/posts?_fields=title,link").then(function (list) {
        return list.map(function (d) {
          return { title: d.title, url: d.link, type: "post" };
        });
      }),
      resolveRestBase("project").then(function (base) {
        return fetchAll("/wp-json/wp/v2/" + base + "?_fields=title,link")
          .then(function (list) {
            return list.map(function (d) {
              return { title: d.title, url: d.link, type: "project" };
            });
          })
          .catch(function () {
            return [];
          });
      }),
      resolveRestBase("material").then(function (base) {
        return fetchAll("/wp-json/wp/v2/" + base + "?_fields=title,link")
          .then(function (list) {
            return list.map(function (d) {
              return { title: d.title, url: d.link, type: "material" };
            });
          })
          .catch(function () {
            return [];
          });
      }),
    ])
      .then(function (groups) {
        var merged = [];
        groups.forEach(function (g) {
          merged = merged.concat(g || []);
        });
        renderResults(merged);
      })
      .catch(function () {
        renderResults([]);
      });
  }
  function performSearch(q) {
    var query = q || "";
    if (!query) {
      loadDefault();
      return;
    }
    fetch(
      "/wp-json/wp/v2/search?search=" +
        encodeURIComponent(query) +
        "&per_page=50",
      { credentials: "same-origin" },
    )
      .then(function (r) {
        return r.json();
      })
      .then(function (data) {
        var items = (data || []).map(function (d) {
          return {
            title: d.title,
            url: d.url,
            type: d.subtype || d.type || "",
          };
        });
        renderResults(items);
      })
      .catch(function () {
        renderResults([]);
      });
  }
  function setupWhenReady() {
    if (window._buildproLinkBound) return;
    urlField = document.getElementById("buildpro-link-url");
    textField = document.getElementById("buildpro-link-text");
    targetToggle = document.getElementById("buildpro-link-target");
    searchField = document.getElementById("buildpro-link-search");
    results = document.getElementById("buildpro-link-results");
    applyBtn = document.getElementById("buildpro-link-apply");
    closeBtn = document.getElementById("buildpro-link-close");
    if (!urlField || !textField || !results || !applyBtn || !closeBtn) return;
    window._buildproLinkBound = true;
    var debounce2;
    if (searchField) {
      searchField.addEventListener("input", function () {
        var q = searchField.value || "";
        clearTimeout(debounce2);
        debounce2 = setTimeout(function () {
          performSearch(q);
        }, 250);
      });
      searchField.addEventListener("change", function () {
        if (!searchField.value) {
          loadDefault();
        }
      });
    }
    results.addEventListener("click", function (e) {
      var t = e.target;
      if (t && t.classList && t.classList.contains("buildpro-link-pick")) {
        var url = t.getAttribute("data-url") || "";
        var title = t.getAttribute("data-title") || "";
        if (urlField) urlField.value = url;
        if (textField) textField.value = title;
      }
    });
    if (applyBtn) {
      applyBtn.addEventListener("click", function (e) {
        e.preventDefault();
        applySelection();
      });
    }
    if (closeBtn) {
      closeBtn.addEventListener("click", function (e) {
        e.preventDefault();
        if (
          window.wp &&
          wp.customize &&
          typeof wp.customize.panel === "function"
        ) {
          var p = wp.customize.panel("buildpro_tools_panel");
          if (p && typeof p.collapse === "function") {
            p.collapse();
          }
        }
      });
    }
    loadDefault();
  }
  var mo = new MutationObserver(function () {
    setupWhenReady();
  });
  try {
    mo.observe(document.documentElement || document.body, {
      childList: true,
      subtree: true,
    });
  } catch (e) {}
  if (window.wp && wp.customize && typeof wp.customize.section === "function") {
    var sec = wp.customize.section("buildpro_link_picker_section");
    if (sec && sec.expanded && typeof sec.expanded.bind === "function") {
      sec.expanded.bind(function (expanded) {
        if (expanded) setupWhenReady();
      });
    }
  }
  setupWhenReady();
  var debounce;
  if (searchField) {
    searchField.addEventListener("input", function () {
      var q = searchField.value || "";
      clearTimeout(debounce);
      debounce = setTimeout(function () {
        performSearch(q);
      }, 250);
    });
    searchField.addEventListener("change", function () {
      if (!searchField.value) {
        loadDefault();
      }
    });
  }
  if (results) {
    results.addEventListener("click", function (e) {
      var t = e.target;
      if (t && t.classList && t.classList.contains("buildpro-link-pick")) {
        var url = t.getAttribute("data-url") || "";
        var title = t.getAttribute("data-title") || "";
        if (urlField) {
          urlField.value = url;
        }
        if (textField) {
          textField.value = title;
        }
      }
    });
  }
  function applySelection() {
    var url = urlField ? urlField.value || "" : "";
    var title = textField ? textField.value || "" : "";
    var targetBlank = targetToggle ? !!targetToggle.checked : false;
    if (window.buildproLinkTarget) {
      var u = window.buildproLinkTarget.urlInput;
      var ti = window.buildproLinkTarget.titleInput;
      var sel = window.buildproLinkTarget.targetSelect;
      var sectionId = window.buildproLinkTarget.sectionId || "";
      if (u) {
        u.value = url;
        u.dispatchEvent(new Event("input"));
      }
      if (ti) {
        ti.value = title;
        ti.dispatchEvent(new Event("input"));
      }
      if (sel) {
        sel.value = targetBlank ? "_blank" : "";
        sel.dispatchEvent(new Event("change"));
      }
      window.buildproLinkTarget = null;
      if (
        window.wp &&
        wp.customize &&
        typeof wp.customize.section === "function"
      ) {
        if (sectionId) {
          var s = wp.customize.section(sectionId);
          if (s && typeof s.expand === "function") {
            s.expand();
          }
        }
        if (typeof wp.customize.panel === "function") {
          var p = wp.customize.panel("buildpro_tools_panel");
          if (p && typeof p.collapse === "function") {
            p.collapse();
          }
        }
      }
    } else {
      try {
        localStorage.setItem(
          "buildpro_link_selection",
          JSON.stringify({
            url: url,
            title: title,
            targetBlank: targetBlank,
            selectedAt: Date.now(),
          }),
        );
      } catch (e) {}
    }
  }
  if (applyBtn) {
    applyBtn.addEventListener("click", function (e) {
      e.preventDefault();
      applySelection();
    });
  }
  if (closeBtn) {
    closeBtn.addEventListener("click", function (e) {
      e.preventDefault();
      if (
        window.wp &&
        wp.customize &&
        typeof wp.customize.panel === "function"
      ) {
        var p = wp.customize.panel("buildpro_tools_panel");
        if (p && typeof p.collapse === "function") {
          p.collapse();
        }
      }
    });
  }
  loadDefault();
})();
