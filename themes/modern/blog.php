<article id="post-19" class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="entry-inner">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name"><?=$this->get('title')?></h1>
        </header>
        <div class="entry-meta entry-meta-top">
            <time datetime="2008-10-17T04:33:51+00:00" class="entry-date entry-meta-element published" title="October 17, 2008 | 4:33 am" itemprop="datePublished"><?=$this->get('formatted_publish_date')?></time>
            <span class="cat-links entry-meta-element">
                <a href="https://wp-themes.com/?cat=1" rel="category">Uncategorized</a></span>
            <span class="author vcard entry-meta-element" itemscope itemtype="http://schema.org/Person"><a href="https://wp-themes.com/?author=1" class="url fn n" rel="author" itemprop="author">Chris Ravenscroft</a></span>
        </div>
        <div class="entry-content" itemprop="articleBody">
<?php
    $content_header = '';
    if($this->get('content_header') !== false) {
        if($this->get('content_logo') !== false) {
            $content_header_1 = "<img src='" . $this->get('content_logo') ."' class='cfr-nav-logo'>&nbsp;";
        }
        else {
            $content_header_1 = '';
        }
        $content_header = '<p>' . $content_header_1 . '<a href="' . $this->get('ref_url') . '">' . $this->get('content_header') .'</a></p>';
    }
?>

<?=$content_header?>

<?=$this->get('content')?>

<div id="comments">
<h3>Comments</h3>


<div id="disqus_thread"></div>
<script>
var disqus_config = function () {
    this.page.remote_auth_s3 = '';
    this.page.api_key = '';
}
</script>

<script>
    var disqus_developer = 'False' == 'True';
    var disqus_url = '<?=$this->get('short_url')?>';
    var disqus_title = '<?=$this->get('title')?>';
    var disqus_identifier = 'BlogPost-<?=$this->get('id')?>';
  (function() {
   var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
   dsq.src = 'http://nexuszteo.disqus.com/embed.js';
   (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
  })();
</script>

</div>

        </div>
    </div>
