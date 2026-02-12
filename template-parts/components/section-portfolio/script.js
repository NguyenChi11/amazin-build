document.addEventListener("DOMContentLoaded", function () {
  var list = document.querySelector(".section-portfolio__list");
  var titleEl = document.querySelector(".section-portfolio__title");
  var descEl = document.querySelector(".section-portfolio__description");
  var titleHasMeta = titleEl && titleEl.getAttribute("data-has-meta") === "1";
  var descHasMeta = descEl && descEl.getAttribute("data-has-meta") === "1";
  // Demo injection removed; projectsData is used only for initial import
});
