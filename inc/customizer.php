<?php
/**
 * PortfolioWind Theme Customizer Integration
 * Exposes Theme Colors to WordPress Core Customizer (Appearance > Customize > Colors).
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register color settings and controls for WordPress Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Core Customizer instance.
 */
function foliowind_customize_register( $wp_customize ) {
	// 1. Primary Accent Color
	$wp_customize->add_setting(
		'portfolio_options[primary_color]',
		array(
			'type'              => 'option',
			'default'           => '#6366f1',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'portfolio_options_primary_color',
			array(
				'label'       => esc_html__( 'Theme Accent Color', 'portfoliowind' ),
				'description' => esc_html__( 'Controls buttons, category pills, active links, and brand highlights across the theme.', 'portfoliowind' ),
				'section'     => 'colors',
				'settings'    => 'portfolio_options[primary_color]',
			)
		)
	);

	// 2. Primary Hover Color
	$wp_customize->add_setting(
		'portfolio_options[primary_hover]',
		array(
			'type'              => 'option',
			'default'           => '#4f46e5',
			'sanitize_callback' => 'sanitize_hex_color',
			'capability'        => 'edit_theme_options',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'portfolio_options_primary_hover',
			array(
				'label'       => esc_html__( 'Primary Hover Shade', 'portfoliowind' ),
				'description' => esc_html__( 'Hover state for primary action buttons and interactive controls.', 'portfoliowind' ),
				'section'     => 'colors',
				'settings'    => 'portfolio_options[primary_hover]',
			)
		)
	);
}
add_action( 'customize_register', 'foliowind_customize_register' );

