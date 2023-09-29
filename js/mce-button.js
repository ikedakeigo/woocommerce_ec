// ビジュアルモード時のsplitボタン--------------------------------------------------------------------------------

(function () {
  tinymce.create("tinymce.plugins.SplitTag", {
    init: function (editor, url) {
      editor.addButton("split_tag_button", {
        title: "Split Tag",
        image: url + "/split-icon.png",
        onclick: function () {
          editor.insertContent("<!--split-->");
        },
      });
    },
    createControl: function (n, cm) {
      return null;
    },
  });
  tinymce.PluginManager.add("split_tag_script", tinymce.plugins.SplitTag);
})();
