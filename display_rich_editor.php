<?php
function get_editor_html($prefix, $content) {
return <<<EOB
<div class='editor-wrapper'>
  <!-- Create the toolbar container -->
  <div id="{$prefix}-toolbar" class="ql-toolbar-container toolbar">
    <div class="ql-format-group">
      <span class="ql-bold ql-format-button"></span>
      <span class="ql-italic ql-format-button"></span>
      <span class="ql-strike ql-format-button"></span>
      <span class="ql-underline ql-format-button"></span>
      <span class="ql-link ql-format-button"></span>
      <span class="ql-format-separator"></span>
    </div>
    <select class="ql-size">
      <option value="small">Small</option>
      <option value="normal">Normal</option>
      <option value="large">Large</option>
    </select>
  </div>

  <!-- Create the editor container -->
  <div id="{$prefix}-area">
  {$content}
  </div>
</div>

<!-- Initialize Quill editor -->
<script>
function init_editor_{$prefix}() {
  var quill = new Quill(
    '#{$prefix}-area', {
      modules: {
        'toolbar': { container: '#{$prefix}-toolbar' },
        'link-tooltip': true
      },
    'theme': 'snow'});
  return quill;
}
</script>
EOB;

}

function get_editor_header() {
return <<<EOB
<link rel="stylesheet" href="/thirdparty/quill/quill.snow.css" />
<script src="/thirdparty/quill/quill.min.js"></script>
EOB;

}
