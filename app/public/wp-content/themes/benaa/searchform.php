<?php
/**
 * Template for displaying search forms in Orson
 *
 * @package WordPress
 * @subpackage Theme_Name
 * @since Theme_Version 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search in website', 'placeholder', 'benaa' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'benaa' ); ?>" />
	<button type="submit" class="search-submit"><i class="icon-search2"></i></button>
</form>
