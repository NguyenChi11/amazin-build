/**
 * customizer-section-focus.js
 * Runs in the Customizer CONTROL PANE (parent window).
 * When a section is expanded/collapsed, sends a native postMessage
 * directly to the preview iframe's contentWindow.
 */
(function () {
  if (!window.wp || !wp.customize) return;

  var api = wp.customize;

  function getPreviewWin() {
    var frame = document.querySelector("#customize-preview iframe");
    return frame ? frame.contentWindow : null;
  }

  function notify(type, sectionId) {
    var win = getPreviewWin();
    if (!win) return;
    win.postMessage({ _buildpro: true, type: type, sectionId: sectionId }, "*");
  }

  function watchSection(section) {
    section.expanded.bind(function (isExpanded) {
      notify(isExpanded ? "section-focus" : "section-blur", section.id);
    });
  }

  api.bind("ready", function () {
    api.section.each(function (section) {
      watchSection(section);
    });
    api.section.bind("add", function (section) {
      watchSection(section);
    });
  });
})();
