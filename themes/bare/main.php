<div class="container">
<ul class="breadcrumb">
<li>Home</li>
</ul>
</div>

<div class="container mainrow">
<div class="row">

<div class="span9 middle">
<?php
    $posts = $this->get('posts');
    foreach($posts as $post) {
?>
<div class="card">
<div class="card-heading">

<h2>
    <a href="<?=$post->short_url?>"><?=$post->title?></a>
</h2>
<h6>
    Posted by
    
    <a href="/blog/author/Chris/">Chris Ravenscroft</a>
    <?=$post->formatted_publish_date?>
    &nbsp;<img src='<?=$post->type_thumbnail?>' class='cfr-nav-logo'>
</h6>

</div>

<?php
if(!empty($post->featured_image)) {
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
}
?>


<div class="card-body">

<p><?=$post->description?></p>


<p class="blog-list-detail">
    
    <a href="<?=$post->short_url?>">read more</a>
    /
    
    <a href="<?=$post->short_url?>#disqus_thread"
        data-disqus-identifier="BlogPost-<?=$post->id?>">
        Comments
    </a>
    
</p>
</div>
</div>

<?php
?>

<?php
    }
?>

<div class="pagination">
<ul>
<li>
    <a href="?offset=<?=$this->get('prev_offset')?>">&lt;</a>
</li>
<li>
    <a href="?offset=<?=$this->get('next_offset')?>">&gt;</a>
</li>
</ul>
</div>
