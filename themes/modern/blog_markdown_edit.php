<article id="post-19" class="post-19 type-page status-publish format-standard hentry" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="entry-inner">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name">Editing: <span><?=$this->get('clean_title')?></span></h1>
        </header>
    </div>
</article>

<style>
#display_more-check {
    display: none;
}

<?php if($this->get('new') !== true) { ?>
#display_more-check:checked ~ div {
    opacity: 1;
    max-height: 100%;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    overflow: visible;
    transform:scale(1);
}

.display_more-content {
    opacity: 0;
    max-height: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
    overflow: hidden;
    transition: 0.5s;
    transform:scale(0);
<?php } ?>
</style>

<form id='edit_all' action='/blog/<?=$this->get('slug')?>/edit/' method='post'>
<fieldset>
<div id="comments" class="comments-area">
    <div>
        <h3 class="comment-reply-title">Content</h3>
        <?=$this->get('editor')?>
    </div>
   <div> &nbsp; </div>
    <div>
        <input type="checkbox" name="display_more" id="display_more-check" />
        <label for="display_more-check">Edit Title &amp; Description</label>
        <div class="display_more-content">
            <p></p>
            <h3 class="comment-reply-title">Post Title</h3>
             <input style="width:100%" name="title" id="post_title" value="<?=$this->get('title')?>" />
            <p></p>
            <h3 class="comment-reply-title">Front Page Description</h3>
            <?=$this->get('editor_d')?>
            <p></p>
            <h3 class="comment-reply-title">Featured Image</h3>
            <input style="width:100%" name="featured_image" id="featured_image" value="<?=$this->get('featured_image')?>" />
        </div>
    </div>
    <div> &nbsp; </div>
    <input id="html_content" type="hidden" name="content" value="" />
    <input id="html_content_d" type="hidden" name="description" value="" />
    <div>
        <span>
            <a href='<?=$this->get('parent_url')?>'>Cancel</a>
        </span>
        &nbsp;
        <span style='float:right'>
            <input type="submit" name="Save" />
        </span>
    </div>
</div>
</fieldset>
</form>

<script>
var tarea = init_editor_editor();
var tarea_d = init_editor_editor_d();
jQuery(tarea.getElement('editor').body).on('focus', function() {
    jQuery('#editor-editor iframe').css('border', '2px solid green');
});
jQuery(tarea.getElement('editor').body).on('blur', function() {
    jQuery('#editor-editor iframe').css('border', '');
});
jQuery('#edit_all').submit(function(e) {
    if(jQuery('#post_title').val() == '') {
        e.preventDefault();
        inform('Empty field', 'You need to provide a title for this post', 'error');
    }
    else {
        jQuery('#html_content').val(tarea.getElement('editor').body.innerText);
        jQuery('#html_content_d').val(tarea_d.getElement('editor').body.innerText);
    }
});
</script>
