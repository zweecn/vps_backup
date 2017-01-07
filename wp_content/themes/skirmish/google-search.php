<?php
/*
Template Name: google-search
*/
?>

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */

get_header(); ?>

		<div id="primary" class="site-content">
		<div id="cse" style="width: 100%;">Loading</div>
		<script src="http://www.google.com.hk/jsapi" type="text/javascript"></script>
		<script type="text/javascript">
		  google.load('search', '1', {language : 'zh-CN'});
		  google.setOnLoadCallback(function(){
				var customSearchControl = new google.search.CustomSearchControl('013863871797750565431:jdxtfh3pdrg');
				customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
				customSearchControl.draw('cse');
				var match = location.search.match(/q=([^&]*)(&|$)/);
				if(match && match[1]){
					var search = decodeURIComponent(match[1]); 
					customSearchControl.execute(search);
				}
			});
		</script>
		<link rel="stylesheet" href="http://www.google.com.hk/cse/style/look/shiny.css" type="text/css" />
		<?php get_footer(); ?>

		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
