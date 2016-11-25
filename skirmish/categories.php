<?php
/*
Template Name: categories
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
				<?php wp_list_categories('orderby=name&show_count=1&feed=RSS'); ?>
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>