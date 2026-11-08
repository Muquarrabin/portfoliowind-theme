<?php
/**
 * Elementor Compatibility Support & Section Shortcodes
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor theme support
 */
function foliowind_elementor_support() {
	add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme', 'foliowind_elementor_support' );

/**
 * Filter page templates to include Elementor Full Width
 */
function foliowind_add_elementor_template( $templates ) {
	$templates['templates/template-elementor.php'] = __( 'Elementor Full Width (PortfolioWind)', 'portfoliowind' );
	return $templates;
}
add_filter( 'theme_page_templates', 'foliowind_add_elementor_template' );

// Load custom Elementor widgets if Elementor is available.
require_once get_template_directory() . '/inc/elementor-widgets.php';

