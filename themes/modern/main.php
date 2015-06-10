<div id="posts" class="posts posts-list clearfix" itemscope itemtype="http://schema.org/ItemList">
<?php
    $posts = $this->get('posts');
    foreach($posts as $post) {
        list($desc,) = explode('<br />', $post->description);
?>
<article class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

<?php
if(!empty($post->featured_image)) {
?>
<div class="entry-media">
<figure class="post-thumbnail">
<?php
    if(substr($post->featured_image, 0, 4) == 'http') {
?>
<img class="featured-thumb" src="<?=$post->featured_image?>">
<?php
    }
    else {
?>
<img class="featured-thumb" src="/static/media/<?=$post->featured_image?>">
<?php
    }
?>
</figure>
</div>
<?php
}
?>

	<div class="entry-inner"><header class="entry-header"><h1 class="entry-title" itemprop="name"><a href="<?=$post->short_url?>" rel="bookmark"><?=$post->title?></a></h1></header><div class="entry-content" itemprop="description"><p class="post-excerpt"><?=$desc?></p>
<div class="link-more"><a href="<?=$post->short_url?>">Continue reading<span class="screen-reader-text"> "<?=$post->title?>"</span>&hellip;</a></div></div><div class="entry-meta"><time datetime="2008-10-17T04:33:51+00:00" class="entry-date entry-meta-element published" title="October 17, 2008 | 4:33 am" itemprop="datePublished"><?=$post->formatted_publish_date?></time> </div></div>
</article>
<?php
    }
?>
<div class="pagination">
<ul>
<li>
    <a href="<?=$this->get('prev_offset')?>">&lt;</a>
</li>
<li>
    <a href="<?=$this->get('next_offset')?>">&gt;</a>
</li>
</ul>
</div>
