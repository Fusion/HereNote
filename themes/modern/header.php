<!doctype html>
<html class="no-js" lang="en-US">

<head>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<title><?=$this->site_name?></title>
<meta name='robots' content='noindex,follow' />
<link rel='stylesheet' id='wm-google-fonts-css'  href='//fonts.googleapis.com/css?family=Fira+Sans%3A400%2C300&#038;ver=1.4.4#038;subset' type='text/css' media='all' />
<link rel='stylesheet' id='wm-genericons-css'  href='/assets/css/genericons.css' type='text/css' media='all' />
<link rel='stylesheet' id='wm-slick-css'  href='/assets/css/slick.css' type='text/css' media='all' />
<link rel='stylesheet' id='wm-starter-css'  href='/assets/css/starter.css' type='text/css' media='all' />
<link rel='stylesheet' id='wm-stylesheet-css'  href='/assets/css/style.css' type='text/css' media='all' />
<link rel='stylesheet' id='wm-colors-css'  href='/assets/css/colors.css' type='text/css' media='all' />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel='stylesheet' id='wm-colors-css'  href='/assets/css/overlay.css' type='text/css' media='all' />
<style id='wm-colors-inline-css' type='text/css'>

body{background-color:#1a1c1e}.site-banner-media:before,.banner-images:before {background:transparent;background:-webkit-linear-gradient(  top, rgba(26,28,30,0) 0%, #1a1c1e 100% );background:  linear-gradient( to bottom, rgba(26,28,30,0) 0%, #1a1c1e 100% );}.site-header,.site-header .social-links,.page-title,.taxonomy-description,.page-title,.error-404,.not-found {color:#ffffff;border-color:#ffffff;}a,.accent-color{color:#0aac8e}mark,ins,.highlight,pre:before,.pagination a,.pagination span,.label-sticky,.button,button,input[type="button"],input[type="reset"],input[type="submit"],.taxonomy-links a,.format-quote,.posts .format-quote,.format-status,.posts .format-status,.entry-content div.sharedaddy .sd-content ul li a.sd-button:not(.no-text),.post-navigation .nav-previous,.post-navigation .nav-next,.bypostauthor > .comment-body .comment-author:before,.comment-navigation a,.widget_calendar tbody a,.widget .tagcloud a:hover,body #infinite-handle span,.menu-toggle:before,.format-gallery .slick-prev,.format-gallery .slick-next {background-color:#0aac8e;color:#ffffff;}.entry-content div.sharedaddy .sd-content ul li a.sd-button:not(.no-text){color:#ffffff !important}mark,ins,.highlight {-webkit-box-shadow:.38em 0 0 #0aac8e, -.38em 0 0 #0aac8e;  box-shadow:.38em 0 0 #0aac8e, -.38em 0 0 #0aac8e;}.infinite-loader .spinner > div > div{background:#0aac8e !important}.label-sticky:before,.label-sticky:after {border-top-color:#0aac8e;border-right-color:#0aac8e;}input:focus,select:focus,textarea:focus,.widget .tagcloud a:hover{border-color:#0aac8e}.post-navigation .has-post-thumbnail:before {background:#0aac8e;background:-webkit-linear-gradient(  right, rgba(10,172,142,0) 19%, #0aac8e 81% );background:  linear-gradient( to left, rgba(10,172,142,0) 19%, #0aac8e 81% );}.post-navigation .nav-next.has-post-thumbnail:before {background:#0aac8e;background:-webkit-linear-gradient( left, rgba(10,172,142,0) 19%, #0aac8e 81% );background:  linear-gradient( to right, rgba(10,172,142,0) 19%, #0aac8e 81% );}body {font-family:'Fira Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:16px;}h1, h2, h3, h4, h5, h6,.h1, .h2, .h3, .h4, .h5, .h6{font-family:'Fira Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif}.site-title{font-family:'Fira Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif}

</style>

<!-- This section common to all themes -->
    <script src='/thirdparty/jquery/jquery.js'></script>
    <script src='/thirdparty/jquery/jquery-migrate.min.js'></script>
    <link rel='stylesheet'  href='/thirdparty/jquery/jquery-ui.min.css' type='text/css' media='all' />
    <Script src='/thirdparty/jquery/jquery-ui.min.js'></script>

    <script src='/thirdparty/modernizr/custom-modernizr.js'></script>

    <link rel="stylesheet" href="/thirdparty/highlight/styles/agate.css" />
    <script src="/thirdparty/highlight/highlight.pack.js"></script>

    <link rel="stylesheet" href="/thirdparty/notifyme/notifyme.css" />
    <Script src='/thirdparty/notifyme/notifyme.js'></script>
<!-- End of common section -->

<!-- Big video -->
    <link rel='stylesheet' href='/assets/css/video-js.min.css' type='text/css' media='all' />
    <link rel='stylesheet' href='/assets/css/bigvideo.css' type='text/css' media='all' />

    <script src='/assets/js/video.js'></script>
    <script src='/assets/js/imagesloaded.pkgd.min.js'></script>
    <script src='/assets/js/bigvideo.js'></script>
<!-- End of big videos -->

<script src='/static/js/cfr.js'></script>

<?=$this->header_extra?>
</head>


<?php
if($this->get('is_home')) {
?>
<body id="top" class="blog downscroll-enabled home is-not-singular">
<?php
} else {
?>
<body id="top" class="downscroll-enabled is-singular not-front-page postid-19 single single-format-standard single-post">
<?php
}
?>

<div id="page" class="page hfeed site">
	<div class="site-inner">


<header id="masthead" class="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

<nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement"><span class="screen-reader-text"><?=$this->site_title?>: Navigation</span><a class="skip-link screen-reader-text" href="#content">Skip to content</a><div class="main-navigation-inner"><div class="menu"><ul>
<li class="page_item page-item-2">
<a href="/">Home</a>
</li>
<?php
    $menu = $this->get('main_menu');
    foreach($menu as $menu_item) {
        if(isset($menu_item['title'])) {
?>
<li class="page_item page-item-2">
<a href="/<?=$menu_item['slug']?>/"><?=$menu_item['title']?></a>
<?php
            if(!empty($menu_item['children'])) {
?>
    <ul class='children'>
<?php
                foreach($menu_item['children'] as $child) {
                    $ending_char = (false === strpos($child['slug'], '?') ? '/' : '');
?>
    <li class="page_item page-item-2">
    <a href="/<?=$child['slug']?><?=$ending_char?>"><?=$child['title']?></a>
    </li>
<?php
                }
?>
    </ul>
<?php
            }
?>
</li>
<?php
        }
    }
?>
</ul></div>
<div id="nav-search-form" class="nav-search-form"><a href="#" id="search-toggle" class="search-toggle"><span class="screen-reader-text">Search</span></a>
<form method="get" class="form-search" action="/search/">
	<label for="search-field" class="screen-reader-text">Search</label>
	<input type="search" value="" placeholder="Search field: type and press enter" name="q" class="search-field" id="search-field" />
</form></div></div><button id="menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">Menu</button></nav>
<div class="site-branding"><h1 class="site-title logo type-text"><a href="<?=$this->site_root?>" title="<?=$this->site_title?> Home"><span class="text-logo"><?=$this->site_name?></span></a></h1><h2 class="site-description"><?=$this->site_desc?></h2></div>
<div id="site-banner" class="site-banner no-slider">

	<div class="site-banner-inner">

		
<div class="site-banner-content">

	
	<div class="site-banner-media">

		<figure class="site-banner-thumbnail">

			<img src="/assets/img/169.jpg" width="1920" height="1080" alt="" />
		</figure>

	</div>

	
</div>
	</div>

</div>

</header>



<div id="content" class="site-content">


	<div id="primary" class="content-area">
		<main id="main" class="site-main clearfix" role="main">

