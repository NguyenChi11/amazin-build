document.addEventListener("DOMContentLoaded", function () {
  var list = document.querySelector(".section-product__list");
  var titleEl = document.querySelector(".section-product__title");
  var descEl = document.querySelector(".section-product__description");
  var titleHasMeta = titleEl && titleEl.getAttribute("data-has-meta") === "1";
  var descHasMeta = descEl && descEl.getAttribute("data-has-meta") === "1";
  // Demo injection removed; materialsData is used only for initial import
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
