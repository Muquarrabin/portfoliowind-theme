<?php
/**
 * Portfolio Projects Compatibility Bridge
 *
 * Note: Under WordPress.org Theme Directory Review guidelines, Custom Post Types
 * and Taxonomies belong in plugin-territory functionality. They are now cleanly registered
 * by the companion plugin 'PortfolioWind Core' (plugins/portfoliowind-core/).
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the PortfolioWind Core plugin is active and registering project post types
 *
 * @return bool
 */
function portfoliowind_is_cpt_active() {
	return post_type_exists( 'portfoliowind_proj' ) || post_type_exists( 'portfolio_project' );
}

/**
 * Get active project post type identifiers (prefixed primary + legacy fallback)
 *
 * @return array
 */
function portfoliowind_get_project_post_types() {
	$types = array();
	if ( post_type_exists( 'portfoliowind_proj' ) ) {
		$types[] = 'portfoliowind_proj';
	}
	if ( post_type_exists( 'portfolio_project' ) ) {
		$types[] = 'portfolio_project';
	}
	return ! empty( $types ) ? $types : array( 'portfoliowind_proj', 'portfolio_project' );
}

/**
 * Get active project post type for creation
 *
 * @return string
 */
function portfoliowind_get_primary_project_post_type() {
	return post_type_exists( 'portfoliowind_proj' ) ? 'portfoliowind_proj' : 'portfolio_project';
}

/**
 * Get project post meta with legacy fallback
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key suffix (e.g. 'client', 'role', 'live_url').
 * @return mixed
 */
function portfoliowind_get_project_meta( $post_id, $key ) {
	$val = get_post_meta( $post_id, '_portfoliowind_' . $key, true );
	if ( '' === $val ) {
		$val = get_post_meta( $post_id, '_project_' . $key, true );
	}
	return $val;
}
