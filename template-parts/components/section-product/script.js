document.addEventListener("DOMContentLoaded", function () {
  var list = document.querySelector(".section-product__list");
  var titleEl = document.querySelector(".section-product__title");
  var descEl = document.querySelector(".section-product__description");
  var titleHasMeta = titleEl && titleEl.getAttribute("data-has-meta") === "1";
  var descHasMeta = descEl && descEl.getAttribute("data-has-meta") === "1";
  if (
    list &&
    list.children.length === 0 &&
    typeof materialsData !== "undefined" &&
    Array.isArray(materialsData.items)
  ) {
    if (titleEl && !titleHasMeta && materialsData.materialsTitle) {
      titleEl.textContent = String(materialsData.materialsTitle);
    }
    if (descEl && !descHasMeta && materialsData.materialsDescription) {
      descEl.textContent = String(materialsData.materialsDescription);
    }
    materialsData.items.forEach(function (it) {
      var link = document.createElement("a");
      link.className = "section-product__item";
      link.href = it.link || "#";
      var imgWrap = document.createElement("div");
      imgWrap.className = "section-product__item-image";
      if (it.image) {
        var img = document.createElement("img");
        img.src = it.image;
        img.alt = it.title || "";
        imgWrap.appendChild(img);
      }
      var content = document.createElement("div");
      content.className = "section-product__item-content";
      var h3 = document.createElement("h3");
      h3.className = "section-product__item-title";
      h3.textContent = it.title || "";
      var bottom = document.createElement("div");
      bottom.className = "section-product__item-bottom";
      var p = document.createElement("p");
      p.className = "section-product__item-price";
      var priceVal = document.createTextNode(String(it.price || ""));
      var spanDollar = document.createElement("span");
      spanDollar.textContent = "$";
      var spanUnit = document.createElement("span");
      spanUnit.textContent = "/ton";
      p.appendChild(spanDollar);
      p.appendChild(priceVal);
      p.appendChild(spanUnit);
      var btn = document.createElement("button");
      btn.className = "section-product__item-cta";
      btn.textContent = "Request a Quote";
      bottom.appendChild(p);
      bottom.appendChild(btn);
      content.appendChild(h3);
      content.appendChild(bottom);
      link.appendChild(imgWrap);
      link.appendChild(content);
      list.appendChild(link);
    });
  }
  if (typeof gsap === "undefined") return;
  var cards = document.querySelectorAll(".section-product__item");
  cards.forEach(function (card) {
    var img = card.querySelector(".section-product__item-image img");
    var btn = card.querySelector(".section-product__item-cta");
    var tlImg = gsap.timeline({ paused: true });
    if (img) tlImg.to(img, { scale: 1.06, duration: 0.25, ease: "power2.out" });
    var tlCard = gsap.timeline({ paused: true });
    tlCard.to(card, {
      y: -4,
      boxShadow: "0 8px 24px rgba(7,59,111,0.20)",
      duration: 0.25,
      ease: "power2.out",
    });
    card.addEventListener("mouseenter", function () {
      tlImg.play();
      tlCard.play();
    });
    card.addEventListener("mouseleave", function () {
      tlImg.reverse();
      tlCard.reverse();
    });
    if (btn) {
      var tlBtn = gsap.timeline({ paused: true });
      tlBtn.to(btn, {
        scale: 1.05,
        backgroundColor: "#0b5ed7",
        duration: 0.2,
        ease: "power2.out",
      });
      btn.addEventListener("mouseenter", function () {
        tlBtn.play();
      });
      btn.addEventListener("mouseleave", function () {
        tlBtn.reverse();
      });
    }
  });
});
