document.addEventListener("DOMContentLoaded", function () {
  var list = document.querySelector(".section-portfolio__list");
  var titleEl = document.querySelector(".section-portfolio__title");
  var descEl = document.querySelector(".section-portfolio__description");
  var titleHasMeta = titleEl && titleEl.getAttribute("data-has-meta") === "1";
  var descHasMeta = descEl && descEl.getAttribute("data-has-meta") === "1";
  if (
    list &&
    list.children.length === 0 &&
    typeof window.projectsData !== "undefined" &&
    Array.isArray(window.projectsData.items)
  ) {
    if (titleEl && !titleHasMeta && window.projectsData.projectTitle) {
      titleEl.textContent = String(window.projectsData.projectTitle);
    }
    if (descEl && !descHasMeta && window.projectsData.projectDescription) {
      descEl.textContent = String(window.projectsData.projectDescription);
    }
    window.projectsData.items.slice(0, 3).forEach(function (it) {
      var link = document.createElement("a");
      link.className = "section-portfolio__item";
      link.href = "#";
      var imgWrap = document.createElement("div");
      imgWrap.className = "section-portfolio__item-image";
      var bg = document.createElement("div");
      bg.className = "section-portfolio__item-bg";
      if (it.image) {
        bg.style.backgroundImage = "url('" + it.image + "')";
      }
      imgWrap.appendChild(bg);
      var content = document.createElement("div");
      content.className = "section-portfolio__item-content";
      var text = document.createElement("p");
      text.className = "section-portfolio__item-text";
      text.textContent = "";
      var h3 = document.createElement("h3");
      h3.className = "section-portfolio__item-name";
      h3.textContent = it.title || "";
      var locWrap = document.createElement("div");
      locWrap.className = "section-portfolio__item-location-wrapper";
      var locIcon = document.createElement("img");
      locIcon.src =
        "/wp-content/themes/buildpro/assets/images/icon/icon_location.png";
      locIcon.alt = "location";
      locIcon.className = "section-portfolio__item-location-icon";
      var loc = document.createElement("p");
      loc.className = "section-portfolio__item-location";
      loc.textContent = it.location || "";
      locWrap.appendChild(locIcon);
      locWrap.appendChild(loc);
      content.appendChild(text);
      content.appendChild(h3);
      content.appendChild(locWrap);
      link.appendChild(imgWrap);
      link.appendChild(content);
      list.appendChild(link);
    });
  }
});
