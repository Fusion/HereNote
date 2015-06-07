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
});
</script>
