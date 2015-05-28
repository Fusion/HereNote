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
<?php
    if($this->get('edit_menu')) {
?>
<span class='selector-wrapper'>
<span class='selector'>
  <ul>
<?php
        $menu = $this->get('edit_menu');
        foreach($menu as $item) {
?>
    <li>
        <input id="<?=$item['id']?>" type='checkbox'>
        <label for="<?=$item['id']?>"><i class="fa fa-<?=$item['icon']?>"></i></label>
    </li>
<?php
        }
?>
  </ul>
  <button><i class="fa fa-navicon"></i></button>
</span>
</span>
<?php
/*
?>
            <span class="cfr-menu entry-meta-element">
                    <a href="#" class="trigger-overlay">Edit</a>
            </span>
<?php
*/
    }
?>
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

    // This is how we are going to add a class to non-img style links
    $content = preg_replace('/<a((.*)href=(")?([a-zA-Z]+)"? ?(.*))>([^<](.*))<\/a>/', '<a$1 class="tipoverlay">$6</a>', $this->get('content'));
?>

<?=$content_header?>

<section class="link-tipoverlay">
<p>
<?=$content?>
</p>
</section>

<script>
var nbOptions = 8;
var angleStart = -360;

// jquery rotate animation
function rotate(li,d) {
    jQuery({d:angleStart}).animate({d:d}, {
        step: function(now) {
            jQuery(li)
               .css({ transform: 'rotate('+now+'deg)' })
               .find('label')
                  .css({ transform: 'rotate('+(-now)+'deg)' });
        }, duration: 0
    });
}

// show / hide the options
function toggleOptions(s) {
    jQuery(s).toggleClass('open');
    var li = jQuery(s).find('li');
    var deg = jQuery(s).hasClass('half') ? 180/(li.length-1) : 360/li.length;
    for(var i=0; i<li.length; i++) {
        var d = jQuery(s).hasClass('half') ? (i*deg)-90 : i*deg;
        jQuery(s).hasClass('open') ? rotate(li[i],d) : rotate(li[i],angleStart);
    }
}

jQuery('.selector button').click(function(e) {
    toggleOptions(jQuery(this).parent());
});

jQuery('.selector li').click(function() {
    var action = jQuery(this).find('input').attr('id');
    if(action == 'action_edit') {
        window.location = window.location + '/edit/';
    }
});

function toggleOverlay() {
    if(jQuery('.overlay').hasClass('open')) {
        jQuery('.overlay').removeClass('open');
        jQuery('.page').removeClass('overlay-open');
        jQuery('.overlay').addClass('close');
    }
    else if(!jQuery('.overlay').hasClass('close')) {
        jQuery('.overlay').addClass('open');
        jQuery('.page').addClass('overlay-open');
    }
}

jQuery('.trigger-overlay').click(function() { toggleOverlay(); });
jQuery('.overlay-close').click(function() { toggleOverlay(); });
</script>

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
