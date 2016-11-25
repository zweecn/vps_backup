<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta name="baidu-site-verification" content="wl2QJqjQfL" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'skirmish' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico" />

<?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" role="banner">
		<div class="site-header">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		<nav role="navigation" class="site-navigation main-navigation">
			<h1 class="assistive-text"><?php _e( 'Menu', 'skirmish' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'skirmish' ); ?>"><?php _e( 'Skip to content', 'skirmish' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav>
		
			<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
			<img src="<?php header_image(); ?>" alt="" class="headerimg" />
	<?php } // if ( ! empty( $header_image ) ) ?>
</div><!-- .site-header -->
	</header><!-- #masthead .site-header -->

	<div id="main">
