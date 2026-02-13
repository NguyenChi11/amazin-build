 (function () {
   var data = window.buildproProjectTitleData || {};
   var t = document.querySelector('.project--section-title__title');
   var d = document.querySelector('.project--section-title__desc');
   if (t && typeof data.title === 'string') t.textContent = data.title;
   if (d && typeof data.description === 'string') d.textContent = data.description;
 })();
