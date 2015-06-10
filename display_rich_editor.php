<?php
function get_editor_html($prefix, $content) {
return <<<EOB
<div class='editor-wrapper'>
  <!-- Create the toolbar container -->
  <div id="{$prefix}-toolbar" class="ql-toolbar-container toolbar">
    <span class="ql-format-group">
      <span class="ql-bold ql-format-button"></span>
      <span class="ql-italic ql-format-button"></span>
      <span class="ql-strike ql-format-button"></span>
      <span class="ql-underline ql-format-button"></span>
      <span class="ql-format-separator"></span>
      <select title="Text Color" class="ql-color">
        <option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)" selected=""></option>
        <option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
        <option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
        <option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
        <option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
        <option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
        <option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
        <option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)"></option>
        <option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
        <option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
        <option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
        <option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
        <option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
        <option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
        <option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
        <option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
        <option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
        <option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
        <option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
        <option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
        <option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
        <option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
        <option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
        <option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
        <option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
        <option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
        <option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
        <option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
        <option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
        <option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
        <option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
        <option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
        <option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
        <option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
        <option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
      </select>
      <select title="Background Color" class="ql-background">
        <option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)"></option>
        <option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
        <option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
        <option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
        <option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
        <option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
        <option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
        <option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)" selected=""></option>
        <option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
        <option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
        <option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
        <option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
        <option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
        <option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
        <option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
        <option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
        <option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
        <option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
        <option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
        <option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
        <option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
        <option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
        <option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
        <option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
        <option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
        <option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
        <option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
        <option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
        <option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
        <option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
        <option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
        <option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
        <option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
        <option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
        <option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
      </select>
      <span class="ql-format-separator"></span>
      <span title="List" class="ql-format-button ql-list"></span>
      <span title="Bullet" class="ql-format-button ql-bullet"></span>
      <span class="ql-link ql-format-button"></span>
      <span title="Image" class="ql-format-button ql-image"></span>
      <span title="code" class="ql-format-button ql-code"><i class="fa fa-code"></i></span>
      <span title="undo" class="ql-format-button ql-undo"><i class="fa fa-code"></i></span>
      <span title="redo" class="ql-format-button ql-redo"><i class="fa fa-code"></i></span>
      <span class="ql-format-separator"></span>
      <select title="Text Alignment" class="ql-align">
        <option value="left" label="Left" selected=""></option>
        <option value="center" label="Center"></option>
        <option value="right" label="Right"></option>
        <option value="justify" label="Justify"></option>
      </select>
      <span class="ql-format-separator"></span>
      <select title="Font" class="ql-font">
        <option value="sans-serif" selected="">Sans Serif</option>
        <option value="serif">Serif</option>
        <option value="monospace">Monospace</option>
      </select>
      <select class="ql-size">
        <option value="small">Small</option>
        <option value="normal">Normal</option>
        <option value="large">Large</option>
      </select>
    </span>
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
        'image-tooltip': true,
        'link-tooltip': true,
        'tbcode': true,
        'tbundo': true
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
<script src="/static/js/cfrquill.js"></script>
EOB;

}
