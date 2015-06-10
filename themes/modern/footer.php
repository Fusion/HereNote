	</div><!-- /#primary -->
</div><!-- /#content -->


	</div><!-- /.site-inner -->
</div><!-- /#page -->


<footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
<div class="site-footer-area footer-area-site-info">
    <div class="site-info-container">
        <div class="site-info" role="contentinfo">&copy; 2015 chris f. ravenscroft &mdash; powered by my hand rolled aggregation engine &mdash; <a href="https://wordpress.org/themes/modern/">(heavy) theme inspiration</a> &mdash; <?php if($this->user->is_auth) echo 'Hello, ' . $this->user->real_name . " &mdash; <a href='/logout/'>sign out</a> &mdash; "; else echo "<a href='/login/'>sign in</a> &mdash; "; ?><?php if($this->user->get('display', 'unpublished')) echo '(showing unpublished) &mdash; ' ?><a href="#top" id="back-to-top" class="back-to-top">back to top &uarr;</a>
        </div>
    </div>
</div>
</footer>

<div class="overlay overlay-contentscale">
        <button type="button" class="overlay-close">Close</button>
        <nav>
                <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Work</a></li>
                        <li><a href="#">Clients</a></li>
                        <li><a href="#">Contact</a></li>
                </ul>
        </nav>
</div>

<script type='text/javascript' src='/assets/js/imagesloaded.pkgd.min.js'></script>
<script type='text/javascript' src='/assets/js/slick.min.js'></script>
<script type='text/javascript' src='/assets/js/scripts-global.js'></script>
<script type='text/javascript' src='/assets/js/skip-link-focus-fix.js'></script>

<script>
(function( $ ) {
  $(function() {
    var clip_path = 'http://www.archive.org/download/LakeOntario/LakeOntarioHdr.mp4';
    var BV = new $.BigVideo({forceAutoplay:Modernizr.touch});
    BV.init();
    BV.show(clip_path, {ambient:true});
  });
})(jQuery);
</script>

<?=$this->footer_extra?>

</body>

</html>
