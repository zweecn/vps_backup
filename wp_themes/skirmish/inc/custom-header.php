<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
*
 * @package skirmish
 * @since skirmish 1.8
 */

/**
 * Setup the WordPress core custom header feature.
 *
 *
 * @package skirmish
 */


$defaults = array(
	'default-image' => get_template_directory_uri() . '/img/header.jpg',
	'random-default'         => false,
	'width'                  => 1000,
	'height'                 => 300,  
	'flex-height'            => true,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => false,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $defaults );