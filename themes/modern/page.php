<article id="post-19" class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="entry-inner">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name"><?=$this->get('title')?></h1>
        </header>
<?php
if($this->get('edit_menu')) {
?>
        <span style='float:right'>
<?php
    $this->fragment('ctx_menu');
?>
        </span>
<?php
}
?>
        <div class="entry-content" itemprop="articleBody">

<?=$this->get('content')?>

        </div>
    </div>

<script>
ctx_menu_click(function(action) {
    if(action == 'action_edit') {
        window.location = window.location + '/edit/';
    }
    else if(action == 'action_publish_toggle') {
        if(<?=$this->get('status')?> == 2)
            var ajax_action = 'unpublish';
        else
            var ajax_action = 'publish';
        ajax_send({
            route: 'page',
            action: ajax_action,
            slug: '<?=$this->get('slug')?>'
            }, function(success, data) {
        });
    }
});
</script>
