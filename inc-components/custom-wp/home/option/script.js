(function () {
  var wrapper = document.getElementById("buildpro-option-wrapper");
  var addBtn = document.getElementById("buildpro-option-add");
  var frame;
  function bindRow(row) {
    var selectBtn = row.querySelector(".select-option-icon");
    var removeIconBtn = row.querySelector(".remove-option-icon");
    var input = row.querySelector(".option-icon-id");
    var preview = row.querySelector(".option-icon-preview");
    var removeRowBtn = row.querySelector(".remove-option-row");
    if (selectBtn) {
      selectBtn.addEventListener("click", function (e) {
        e.preventDefault();
        if (!frame) {
          frame = wp.media({
            title: "Chọn icon",
            button: { text: "Sử dụng" },
            multiple: false,
          });
        }
        if (typeof frame.off === "function") {
          frame.off("select");
        }
        frame.on("select", function () {
          var attachment = frame.state().get("selection").first().toJSON();
          input.value = attachment.id;
          var url =
            attachment.sizes && attachment.sizes.thumbnail
              ? attachment.sizes.thumbnail.url
              : attachment.url;
          preview.innerHTML = "<img src='" + url + "'>";
        });
        frame.open();
      });
    }
    if (removeIconBtn) {
      removeIconBtn.addEventListener("click", function (e) {
        e.preventDefault();
        input.value = "";
        preview.innerHTML = "";
      });
    }
    if (removeRowBtn) {
      removeRowBtn.addEventListener("click", function (e) {
        e.preventDefault();
        row.parentNode.removeChild(row);
      });
    }
  }
  if (wrapper) {
    Array.prototype.forEach.call(
      wrapper.querySelectorAll(".buildpro-option-row"),
      bindRow,
    );
  }
  if (addBtn) {
    addBtn.addEventListener("click", function (e) {
      e.preventDefault();
      var idx = wrapper.querySelectorAll(".buildpro-option-row").length;
      var html =
        "" +
        '<div class="buildpro-option-row" data-index="' +
        idx +
        '">' +
        '  <div class="buildpro-option-grid">' +
        '    <div class="buildpro-option-block">' +
        "      <h4>Icon</h4>" +
        '      <div class="buildpro-option-field">' +
        '        <input type="hidden" class="option-icon-id" name="buildpro_option_items[' +
        idx +
        '][icon_id]" value="">' +
        '        <button type="button" class="button select-option-icon">Chọn icon</button>' +
        '        <button type="button" class="button remove-option-icon">Xóa icon</button>' +
        "      </div>" +
        '      <div class="option-icon-preview"><span class="option-icon-placeholder">Chưa chọn icon</span></div>' +
        "    </div>" +
        '    <div class="buildpro-option-block">' +
        "      <h4>Nội dung</h4>" +
        '      <p class="buildpro-option-field"><label>Text</label><input type="text" name="buildpro_option_items[' +
        idx +
        '][text]" class="regular-text" value=""></p>' +
        '      <p class="buildpro-option-field"><label>Mô tả</label><textarea name="buildpro_option_items[' +
        idx +
        '][description]" rows="4" class="large-text"></textarea></p>' +
        "    </div>" +
        "  </div>" +
        '  <div class="buildpro-option-actions"><button type="button" class="button remove-option-row">Xóa mục</button></div>' +
        "</div>";
      var temp = document.createElement("div");
      temp.innerHTML = html;
      var row = temp.firstElementChild;
      wrapper.appendChild(row);
      bindRow(row);
    });
  }
})();
