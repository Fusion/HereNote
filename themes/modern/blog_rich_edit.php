<article id="post-19" class="post-19 type-page status-publish format-standard hentry" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="entry-inner">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name">Editing: <span><?=$this->get('title')?></span></h1>
        </header>
    </div>
</article>

<form id='edit_all' action='/blog/<?=$this->get('slug')?>/edit/' method='post'>
<fieldset>
<div id="comments" class="comments-area">
       <div>
            <h3 class="comment-reply-title">Post Title</h3>
            <input style="width:100%" name="title" value="<?=$this->get('title')?>" />
       </div>
       <div>
            &nbsp;
        <div>
            <h3 class="comment-reply-title">Content</h3>
            <?=$this->get('editor')?>
        </div>
       <div>
            &nbsp;
        <div>
        <input id="html_content" type="hidden" name="content" value="" />
        <div><span><a href='/blog/<?=$this->get('slug')?>/'>Cancel</a></span>&nbsp;<span style='float:right'><input type="submit" name="Save" /></span></div>
</div>
</fieldset>
</form>

<script>
var tarea = init_editor_editor();
// this will be used to avoid losing focus when the toolbar is clicked
var blurTimeoutAction = { showBlur: true, action: null };
// *sigh* fpr whateever reason adding a class was not having any effect:
jQuery('.ql-editor').on('focus', function() {
    if(blurTimeoutAction.showBlur) {
        //clearTimeout(blurTimeoutAction);
        blurTimeoutAction.showBlur = true;
    }
    jQuery(this).parent().parent().css('border', '2px solid green');
});
jQuery('.ql-editor').on('blur', function() {
    var obj = this;
    blurTimeOutAction = { showBlur: false, action: setTimeout(function() {
        if(blurTimeoutAction.showBlur) {
            jQuery(obj).parent().parent().css('border', '');
        }
    }, 500) };
});
jQuery('#edit_all').submit(function(e) {
    jQuery('#html_content').val(tarea.getHTML());
});
</script>
