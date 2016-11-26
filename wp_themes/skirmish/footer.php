<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'skirmish_credits' ); ?>
			&copy; 2010-<?php echo date("Y"); ?> <a href="https://favorbook.com"><?php bloginfo( 'name' ); ?></a>
			<span class="sep"> | </span>
				<a href="https://favorbook.com/sitemap.xml" target="_blank">Google Map</a>
			<span class="sep"> | </span>
				<a href="http://favorbook.com/sitemap.html" target="_blank"> Baidu Map</a> 
			<span class="sep"> | </span>
				<a href="http://favorbook.com/sitemap_baidu.xml" target="_blank">Baidu Map</a>
			<span class="sep"> | </span>
				<a href="https://favorbook.com/feed/" target="_blank">RSS</a>
			<br />
		</div><!-- .site-info -->
	</footer><!-- .site-footer .site-footer -->

</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<!--Add jquery-->
<script type="text/javascript">
jQuery(document).ready(function($){
 //===================================存档页面 jQ伸缩
     (function(){
         $('#al_expand_collapse,#archives span.al_mon').css({cursor:"s-resize"});
         $('#archives span.al_mon').each(function(){
             var num=$(this).next().children('li').size();
             var text=$(this).text();
             $(this).html(text+'<em> ( '+num+' 篇文章 )</em>');
         });
         var $al_post_list=$('#archives ul.al_post_list'),
             $al_post_list_f=$('#archives ul.al_post_list:first');
         $al_post_list.hide(1,function(){
             $al_post_list_f.show();
         });
         $('#archives span.al_mon').click(function(){
             $(this).next().slideToggle(400);
             return false;
         });
         $('#al_expand_collapse').toggle(function(){
             $al_post_list.show();
         },function(){
             $al_post_list.hide();
         });
     })();
 });
</script>

<!--clicki-->
<div id="clicki_widget_5705" ></div>
<script type='text/javascript'>
(function() {
	var c = document.createElement('script'); 
	c.type = 'text/javascript';
	c.async = true;
	c.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.clicki.cn/boot/48938';
	var h = document.getElementsByTagName('script')[0];
	h.parentNode.insertBefore(c, h);
})();
</script> 

<!--Google
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31463860-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
-->

</body>
</html>
