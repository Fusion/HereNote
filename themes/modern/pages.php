<div id="posts" class="posts posts-list clearfix" itemscope itemtype="http://schema.org/ItemList">
<?php
    $pages = $this->get('pages');
    foreach($pages as $page) {
?>
<article class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
	<div class="entry-inner"><header class="entry-header"><h1 class="entry-title" itemprop="name"><a href="<?=$page->short_url?>" rel="bookmark"><?=$page->title?></a></h1></header><div class="entry-content" itemprop="description">
<div class="link-more"><a href="<?=$page->short_url?>">Continue reading<span class="screen-reader-text"> "<?=$page->title?>"</span>&hellip;</a></div></div><div class="entry-meta"><time datetime="2008-10-17T04:33:51+00:00" class="entry-date entry-meta-element published" title="October 17, 2008 | 4:33 am" itemprop="datePublished"><?=$page->formatted_publish_date?></time> </div></div>
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
