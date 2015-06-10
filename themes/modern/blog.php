<article id="post-19" class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
    <div class="entry-inner">
        <header class="entry-header">
            <h1 class="entry-title" itemprop="name"><?=$this->get('title')?></h1>
        </header>
        <div class="entry-meta entry-meta-top">
            <time datetime="2008-10-17T04:33:51+00:00" class="entry-date entry-meta-element published" title="October 17, 2008 | 4:33 am" itemprop="datePublished"><?=$this->get('formatted_publish_date')?></time>
            <span class="cat-links entry-meta-element">
                <a href="https://wp-themes.com/?cat=1" rel="category">Uncategorized</a></span>
            <span class="author vcard entry-meta-element" itemscope itemtype="http://schema.org/Person"><a href="https://wp-themes.com/?author=1" class="url fn n" rel="author" itemprop="author"><?=$this->get('realname')?></a></span>

<?php
    if($this->get('edit_menu')) {
        $this->fragment('ctx_menu');
?>
<div class="menu-wrapper">

    <ul class="navigation">
        <li><a href="#" class="escape">X</a></li>
      </ul>
</div>
<?php
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
            route: 'blog',
            action: ajax_action,
            slug: '<?=$this->get('slug')?>'
            }, function(success, data) {
        });
    }
    else if(action == 'action_source') {
        jQuery('.menu-wrapper .navigation .dyn_item').remove();
        jQuery('.menu-wrapper .navigation').append('<li class="dyn_item"><a href="#" class="clickable" id="choice_blog">Blog</a></li>');
        jQuery('.menu-wrapper .navigation').append('<li class="dyn_item"><a href="#" class="clickable" id="choice_gplus">G+</a></li>');
        jQuery('.menu-wrapper .navigation').append('<li class="dyn_item"><a href="#" class="clickable" id="choice_github">Github</a></li>');
        jQuery('.menu-wrapper').addClass('show-menu');
        jQuery('.menu-wrapper .navigation').fadeIn();
        jQuery('.menu-wrapper .navigation li').addClass('small-padding');
        jQuery(document).keydown(function(e) {
            // ESCAPE key pressed
            if (e.keyCode == 27) {
                jQuery('.menu-wrapper').removeClass('show-menu');
                jQuery('.menu-wrapper .navigation').hide();
                jQuery('.menu-wrapper .navigation li').removeClass('small-padding');                
            }
        });
        jQuery('.menu-wrapper .navigation .clickable').click(function(e) {
            e.preventDefault();
            ajax_send({
                route: 'blog',
                action: 'choose_source_type',
                choice: e.toElement.id,
                slug: '<?=$this->get('slug')?>'
                }, function(success, data) {
            });
        });
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
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = '<?=$this->get('disqus_shortname')?>';
    var disqus_title = '<?=$this->get('title')?>';
    var disqus_url = '<?=$this->get('short_url')?>';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>

</div>

        </div>
    </div>
