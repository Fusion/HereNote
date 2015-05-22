<div class="container">
<ul class="breadcrumb">
<li><a href="/">Home</a><span class="divider">/</span></li><li><a href="/">Blog</a><span class="divider">/</span></li><li class="active"><?=$this->get('title')?></li>
</ul>
</div>

<div class="container mainrow">
<div class="row">

<div class="span9 middle">

<div class="card">
<div class="card-heading">
<h6>
    Posted by:
    
    <a href="/blog/author/Chris/">Chris Ravenscroft</a>
    
    a while ago
</h6>
</div>

<div class="card-body">

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
