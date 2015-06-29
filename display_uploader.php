<?php

if(!defined('RUNNING')) exit(-1);

function get_uploader_html() {
return <<<EOB
<style>
/* css monkey patch */
.dropzone { min-height: 0; padding: 0; }
</style>

<div id="display_upload-dropzone" class="display_more-content dropzone">
    <div class="dz-default dz-message">drag &amp; drop, click, touch...</div>
</div>

<div id="preview-template" style="display: none;">
    <div class="dz-preview dz-file-preview">
        <div class="dz-details">
            <div class="dz-filename"><span data-dz-name></span></div>
            <div class="dz-size" data-dz-size></div>
            <img data-dz-thumbnail />
        </div>
        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
        <div class="dz-success-mark"><span>&#x2714;</span></div>
        <div class="dz-error-mark"><span>&#x2573;</span></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
    </div>
</div>

<script>
// TODO Also remove files from server when removeLink is clicked?
jQuery(document).ready(function(){
    Dropzone.autoDiscover = false;
    var droparea = new Dropzone("#display_upload-dropzone", {
        maxFileSize: 5,
        addRemoveLinks: true,
        autoProcessQueue: true,
        init: function() {
            this.on('complete', function(file) {
                file.previewElement.addEventListener('click', function(e) {
                    if(typeof file.server_file_name != 'undefined') {
                        quill_remote_insert_image('/data/' + file.server_file_name);
                    }
                });
            });
        },
        success: function(file, response) {
            var response_struct = JSON.parse(response);
            var key = Object.keys(response_struct.data);
            if(response_struct.data[key].success) {
                // Man, I wish file has a prototype... other than ephemeral __proto__
                file.server_file_name = response_struct.data[key].file_name;
            }
        },
        url: "/ajax/"});
});
</script>
EOB;

}

function get_uploader_header() {
return <<<EOB
<link rel="stylesheet" href="/thirdparty/dropzonejs/dropzone.css" />
<script src="/thirdparty/dropzonejs/dropzone.js"></script>
EOB;

}
