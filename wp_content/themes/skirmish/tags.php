<?php
/*
Template Name: tags
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
			<div id="content" role="main">
			<?php wp_tag_cloud('smallest=8&largest=24&number=50'); ?> 
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>