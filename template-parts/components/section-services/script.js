document.addEventListener("DOMContentLoaded", function () {
  var section = document.querySelector(".section-services");
  if (!section || typeof gsap === "undefined") return;

  var title = section.querySelector(".section-services__title");
  var desc = section.querySelector(".section-services__description");
  var container = section.querySelector(".section-services__container");
  var items = section.querySelectorAll(".section-services__item");

  if (
    container &&
    items.length === 0 &&
    typeof window.servicesData !== "undefined" &&
    Array.isArray(window.servicesData.items)
  ) {
    var titleHasMeta = title && title.getAttribute("data-has-meta") === "1";
    var descHasMeta = desc && desc.getAttribute("data-has-meta") === "1";
    if (title && !titleHasMeta && window.servicesData.serviceTitle) {
      title.textContent = String(window.servicesData.serviceTitle);
    }
    if (desc && !descHasMeta && window.servicesData.serviceDescription) {
      desc.textContent = String(window.servicesData.serviceDescription);
    }
    window.servicesData.items.forEach(function (it) {
      var item = document.createElement("div");
      item.className = "section-services__item";
      var iconWrap = document.createElement("div");
      iconWrap.className = "section-services__item-icon";
      if (it.icon_url) {
        var img = document.createElement("img");
        img.src = it.icon_url;
        img.alt = it.title || "";
        img.className = "section-services__item-icon-image";
        iconWrap.appendChild(img);
      }
      var h3 = document.createElement("h3");
      h3.className = "section-services__item-title";
      h3.textContent = it.title || "";
      var p = document.createElement("p");
      p.className = "section-services__item-description";
      p.textContent = it.description || "";
      item.appendChild(iconWrap);
      item.appendChild(h3);
      item.appendChild(p);
      if (it.link_url) {
        var a = document.createElement("a");
        a.className = "section-services__item-link";
        a.href = it.link_url;
        if (it.link_target === "_blank") {
          a.target = "_blank";
          a.rel = "noopener";
        }
        a.textContent = it.link_title || "View Details";
        var right = document.createElement("img");
        right.src =
          "/wp-content/themes/buildpro/assets/images/icon/Arrow_Right_blue.png";
        right.alt = "right arrow";
        right.className = "section-services__item-link-icon";
        a.appendChild(right);
        item.appendChild(a);
      }
      container.appendChild(item);
    });
    items = section.querySelectorAll(".section-services__item");
  }

  function runIntro() {
    if (title)
      gsap.fromTo(
        title,
        { y: 30, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.6, ease: "power2.out" },
      );
    if (desc)
      gsap.fromTo(
        desc,
        { y: 20, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.6, ease: "power2.out", delay: 0.1 },
      );
    if (items.length)
      gsap.from(items, {
        opacity: 0,
        y: 20,
        duration: 0.5,
        ease: "power2.out",
        stagger: 0.1,
        delay: 0.2,
      });
  }

  if ("IntersectionObserver" in window) {
    var triggered = false;
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting && !triggered) {
            triggered = true;
            runIntro();
            io.disconnect();
          }
        });
      },
      { threshold: 0.2 },
    );
    io.observe(section);
  } else {
    runIntro();
  }

  items.forEach(function (item) {
    var icon = item.querySelector(".section-services__item-icon-image");
    var link = item.querySelector(".section-services__item-link");
    var linkIcon = item.querySelector(".section-services__item-link-icon");
    item.addEventListener("mouseenter", function () {
      gsap.to(item, { y: -6, duration: 0.2, ease: "power2.out" });
      if (icon)
        gsap.to(icon, { scale: 1.05, duration: 0.2, ease: "power2.out" });
      if (link) {
        gsap.killTweensOf(link);
        gsap.to(link, { x: 12, duration: 0.3, ease: "power2.out" });
      }
      if (linkIcon) {
        gsap.killTweensOf(linkIcon);
        gsap.to(linkIcon, { x: 6, duration: 0.3, ease: "power2.out" });
      }
    });
    item.addEventListener("mouseleave", function () {
      gsap.to(item, { y: 0, duration: 0.2, ease: "power2.out" });
      if (icon) gsap.to(icon, { scale: 1, duration: 0.2, ease: "power2.out" });
      if (link) {
        gsap.killTweensOf(link);
        gsap.to(link, { x: 0, duration: 0.2, ease: "power2.out" });
      }
      if (linkIcon) {
        gsap.killTweensOf(linkIcon);
        gsap.to(linkIcon, { x: 0, duration: 0.2, ease: "power2.out" });
      }
    });
  });
});
