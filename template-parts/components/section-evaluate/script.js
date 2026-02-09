document.addEventListener("DOMContentLoaded", function () {
  var container = document.querySelector(".swiper-container_evaluate");
  if (!container || typeof Swiper === "undefined") return;
  var pagination = container.querySelector(".swiper-pagination");
  var wrapper = container.querySelector(".swiper-wrapper_evaluate");

  if (
    wrapper &&
    wrapper.children.length === 0 &&
    typeof window.evaluateData !== "undefined" &&
    Array.isArray(window.evaluateData.items)
  ) {
    var textEl = document.querySelector(".section-evaluate__text");
    var titleEl = document.querySelector(".section-evaluate__title");
    var descEl = document.querySelector(".section-evaluate__description");
    var textHasMeta = textEl && textEl.getAttribute("data-has-meta") === "1";
    var titleHasMeta = titleEl && titleEl.getAttribute("data-has-meta") === "1";
    var descHasMeta = descEl && descEl.getAttribute("data-has-meta") === "1";
    if (textEl && !textHasMeta && window.evaluateData.evaluateText) {
      textEl.textContent = String(window.evaluateData.evaluateText);
    }
    if (titleEl && !titleHasMeta && window.evaluateData.evaluateTitle) {
      titleEl.textContent = String(window.evaluateData.evaluateTitle);
    }
    if (descEl && !descHasMeta && window.evaluateData.evaluateDescription) {
      descEl.textContent = String(window.evaluateData.evaluateDescription);
    }
    window.evaluateData.items.forEach(function (it) {
      var slide = document.createElement("div");
      slide.className = "swiper-slide section-evaluate__swiper-slide";
      var item = document.createElement("div");
      item.className = "section-evaluate__item";
      var p = document.createElement("p");
      p.className = "section-evaluate__item-description";
      p.textContent = it.description || "";
      var content = document.createElement("div");
      content.className = "section-evaluate__item-content";
      var avatarWrap = document.createElement("div");
      avatarWrap.className = "section-evaluate__item-avatar";
      if (it.avatar) {
        var img = document.createElement("img");
        img.src = it.avatar;
        img.alt = it.name || "";
        avatarWrap.appendChild(img);
      }
      var info = document.createElement("div");
      info.className = "section-evaluate__item-info";
      var h3 = document.createElement("h3");
      h3.className = "section-evaluate__item-name";
      h3.textContent = it.name || "";
      var pos = document.createElement("p");
      pos.className = "section-evaluate__item-position";
      pos.textContent = it.position || "";
      info.appendChild(h3);
      info.appendChild(pos);
      content.appendChild(avatarWrap);
      content.appendChild(info);
      item.appendChild(p);
      item.appendChild(content);
      slide.appendChild(item);
      wrapper.appendChild(slide);
    });
  }

  new Swiper(container, {
    slidesPerView: 3,
    centeredSlides: true,
    // spaceBetween: 20,
    loop: true,
    autoplay: { delay: 3000, disableOnInteraction: false },
    pagination: pagination ? { el: pagination, clickable: true } : undefined,
    breakpoints: {
      0: { slidesPerView: 1, centeredSlides: true },
      640: { slidesPerView: 2, centeredSlides: true },
      1024: { slidesPerView: 2.25, centeredSlides: true },
    },
  });
});
