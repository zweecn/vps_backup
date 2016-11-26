<?php
/**
 * The template for displaying search forms in skirmish
 *
 * @package Skirmish
 * @since Skirmish 1.8
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'skirmish' ); ?></label>
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search &hellip;', 'skirmish' ); ?>" />
	</form>
