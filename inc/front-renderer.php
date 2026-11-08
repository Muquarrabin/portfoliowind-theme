<?php
/**
 * PortfolioWind Front-End Data Helper & Renderer
 * Provides sanitized retrieval of theme options and custom color injection.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get all theme options with defaults
 */
function portfolio_get_theme_options() {
	$defaults = array(
		'hero_name'              => get_bloginfo( 'name' ),
		'hero_tagline'           => get_bloginfo( 'description' ),
		'hero_bio'               => 'Welcome to my digital portfolio. I design, build, and ship modern digital experiences.',
		'hero_avatar'            => '',
		'hero_cv_url'            => '',
		'hero_cta_text'          => 'Get in Touch',
		'hero_cta_url'           => '#contact',
		'about_heading'          => 'About Me',
		'about_bio'              => '',
		'stat_years'             => '5+',
		'stat_projects'          => '40+',
		'stat_clients'           => '30+',
		'skills'                 => array(),
		'services'               => array(),
		'projects'               => array(),
		'resume'                 => array(),
		'contact_email'          => get_option( 'admin_email' ),
		'contact_phone'          => '',
		'contact_location'       => '',
		'contact_badge'          => 'Available for Freelance & Projects',
		'contact_form_shortcode' => '',
		'hide_contact_info'      => false,
		'social_github'          => '#',
		'social_linkedin'        => '#',
		'social_twitter'         => '#',
		'social_dribbble'        => '#',
		'social_instagram'       => '#',
		'primary_color'          => '#6366f1',
		'primary_hover'          => '#4f46e5',
		'site_copyright'         => '',
		'supporter_key'          => '',
		'hide_watermark'         => false,
		'customizer_credit'      => false,
		'customizer_credit_name' => '',
	);

	$saved = get_option( 'portfolio_options', array() );
	return wp_parse_args( $saved, $defaults );
}

/**
 * Get single option safely
 */
function portfolio_get_option( $key, $default = '' ) {
	$options = portfolio_get_theme_options();
	return isset( $options[ $key ] ) ? $options[ $key ] : $default;
}

/**
 * Output dynamic CSS variables in head
 */
function portfolio_custom_css_vars() {
	$primary = sanitize_hex_color( portfolio_get_option( 'primary_color', '#6366f1' ) );
	$hover   = sanitize_hex_color( portfolio_get_option( 'primary_hover', '#4f46e5' ) );
	if ( ! $primary ) {
		$primary = '#6366f1';
	}
	if ( ! $hover ) {
		$hover = '#4f46e5';
	}
	$rgb_parsed = sscanf( $primary, '#%02x%02x%02x' );
	$r = isset( $rgb_parsed[0] ) ? (int) $rgb_parsed[0] : 99;
	$g = isset( $rgb_parsed[1] ) ? (int) $rgb_parsed[1] : 102;
	$b = isset( $rgb_parsed[2] ) ? (int) $rgb_parsed[2] : 241;
	$primary_rgb = "{$r} {$g} {$b}";
	?>
	<style id="foliowind-dynamic-css">
		:root {
			--primary-color: <?php echo esc_attr( $primary ); ?>;
			--primary-hover: <?php echo esc_attr( $hover ); ?>;
			--primary-rgb: <?php echo esc_attr( $primary_rgb ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'portfolio_custom_css_vars', 99 );
