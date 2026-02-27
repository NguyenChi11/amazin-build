(function () {
  function initTabs() {
    var box = document.getElementById("buildpro_about_contact_meta");
    if (!box) return;

    var tabs = box.querySelectorAll(".buildpro-about-contact-tabs");

    function show(targetId) {
      var tabIds = [
        "buildpro_about_contact_tab_content",
        "buildpro_about_contact_tab_contact",
      ];

      tabIds.forEach(function (id) {
        var el = box.querySelector("#" + id);
        if (el) {
          el.style.display = id === targetId ? "block" : "none";
        }
      });

      tabs.forEach(function (btn) {
        var isActive = btn.getAttribute("data-tab") === targetId;
        btn.classList.toggle("is-active", isActive);
      });
    }

    // Mở tab Content mặc định
    show("buildpro_about_contact_tab_content");

    tabs.forEach(function (btn) {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        var target = btn.getAttribute("data-tab");
        if (target) show(target);
      });
    });
  }

  // Khởi chạy khi DOM sẵn sàng
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
      initTabs();
    });
  } else {
    initTabs();
  }
})();
