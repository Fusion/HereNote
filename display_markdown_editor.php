<?php

if(!defined('RUNNING')) exit(-1);

function get_editor_html($prefix, $content) {
return <<<EOB
<div class='editor-wrapper'>
<div id="{$prefix}-editor">
</div>
</div>
<textarea id="{$prefix}-editor-container" style='display:none'>
{$content}
</textarea>

<!-- Initialize markdown editor -->
<script>
function init_editor_{$prefix}() {
    var editor = new EpicEditor({
        container: '{$prefix}-editor',
        textarea: '{$prefix}-editor-container',
        basePath: '/thirdparty/epiceditor',
        theme: {
            preview: '/themes/preview/github.css',
            editor: '/themes/editor/epic-light.css'
        },
        button: {bar: "show"},
        string: {
            togglePreview: 'Preview',
            toggleEdit: 'Edit',
            toggleFullscreen: 'Distraction Free Mode'
        },
        clientSideStorage: false
    }).load();

    return editor;
}
</script>
EOB;

}

function get_editor_header() {
return <<<EOB
<script src="/thirdparty/epiceditor/js/epiceditor.min.js"></script>
EOB;

}
