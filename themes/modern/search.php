<section id="search-results" class="search-results">
<header class="page-header">
<h1 class="page-title">
<?php
    if(!empty($this->get('error_msg'))) {
?>
<?=$this->get('error_msg')?>
</h1>
</header>
<form method="get" class="form-search" action="/search/">
    <label for="search-field" class="screen-reader-text">Search</label>
    <input type="search" value="" placeholder="Search field: type and press enter" name="q" class="search-field" id="search-field" />
</form>
<?php

    }
    else {
?>
Search results for: <span><?=$this->get('search_term')?></span>
</h1>
</header>
<div id="posts" class="posts posts-list clearfix" itemscope itemtype="http://schema.org/ItemList">
<?php
$results = $this->get('results');
foreach($results['pages'] as $result) {
?>
<article class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
<div class="entry-inner"><header class="entry-header">
<div class="entry-meta">page
</div>
<h1 class="entry-title" itemprop="name">
<a href='/<?=$result['slug']?>/'><?=$result['title']?></a>
</h1>
</div>
</article>
<?php
}
foreach($results['posts'] as $result) {
?>
<article class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
<div class="entry-inner"><header class="entry-header">
<div class="entry-meta">post
</div>
<h1 class="entry-title" itemprop="name">
<a href='/blog/<?=$result['slug']?>/'><?=$result['title']?></a>
</h1>
</div>
</article>
<?php
}
}
?>
</div>
</section>
