<?php
/**
 * PortfolioWind Functions and Definitions
 *
 * @package PortfolioWind
 * @author Nasif Muquarrabin
 * @license GPL-2.0-or-later
 *
 * ============================================================================
 * LEGAL NOTICE & ATTRIBUTION CLAUSE (GPLv2 Section 2)
 * Copyright (C) 2026 Nasif Muquarrabin. All rights reserved.
 * GitHub: https://github.com/muquarrabin
 * LinkedIn: https://www.linkedin.com/in/nasif-m-59054292/
 * Under GNU General Public License v2 Section 2, all modified and derivative
 * works must preserve the original author copyright declarations and attribution
 * notices present in this codebase.
 * ============================================================================
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PORTFOLIOWIND_VERSION', '1.0.1' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function foliowind_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'portfoliowind', get_template_directory() . '/languages' );

	// Let WordPress manage document title.
	add_theme_support( 'title-tag' );

	// Enable featured images.
	add_theme_support( 'post-thumbnails' );

	// Custom Logo support.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Switch default core markup for search form, comment form, etc. to valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Gutenberg Block Editor enhancements.
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_editor_style();

	// Remove default WordPress core admin bar margin-top bump from html element.
	add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

	// Set content width in pixels.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}

	// Register Navigation Menus.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'portfoliowind' ),
			'footer'  => esc_html__( 'Footer Menu', 'portfoliowind' ),
		)
	);
}
add_action( 'after_setup_theme', 'foliowind_setup' );

/**
 * Flush rewrite rules upon theme activation.
 */
function foliowind_rewrite_flush() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'foliowind_rewrite_flush' );

/**
 * Enqueue scripts and styles.
 */
function foliowind_scripts() {
	// Dashicons for front-end service icons.
	wp_enqueue_style( 'dashicons' );

	$css_ver = file_exists( get_template_directory() . '/assets/css/tailwind.css' ) 
		? filemtime( get_template_directory() . '/assets/css/tailwind.css' ) 
		: PORTFOLIOWIND_VERSION;

	// Tailwind CSS production build with dynamic filemtime cache-busting.
	wp_enqueue_style(
		'foliowind-tailwind',
		get_template_directory_uri() . '/assets/css/tailwind.css',
		array(),
		$css_ver
	);

	// Main stylesheet.
	wp_enqueue_style(
		'foliowind-style',
		get_stylesheet_uri(),
		array( 'foliowind-tailwind' ),
		PORTFOLIOWIND_VERSION
	);

	// Front-end Main script (Dark mode toggle & mobile drawer).
	wp_enqueue_script(
		'foliowind-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		PORTFOLIOWIND_VERSION,
		true
	);

	// Client-side category filtering script.
	wp_enqueue_script(
		'foliowind-filter',
		get_template_directory_uri() . '/assets/js/filter.js',
		array(),
		PORTFOLIOWIND_VERSION,
		true
	);

	// Threaded comments reply script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'foliowind_scripts' );

/**
 * Immediate Theme Mode Resolver (Prevents Flash of Light Mode).
 * Injected at highest priority into wp_head so .dark applies before CSS rendering.
 */
function foliowind_anti_flicker_script() {
	?>
	<script id="portfoliowind-theme-resolver">
		(function() {
			var saved = localStorage.getItem('portfoliowind_theme') || localStorage.getItem('portfoliocraft_theme');
			var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
			if (saved === 'dark' || (!saved && prefersDark)) {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark');
			}
		})();
	</script>
	<?php
}
add_action( 'wp_head', 'foliowind_anti_flicker_script', 1 );

/**
 * Load Core Modules
 */
require get_template_directory() . '/inc/watermark.php';
require get_template_directory() . '/inc/front-renderer.php';
require get_template_directory() . '/inc/cpt-project.php';
require get_template_directory() . '/inc/elementor-support.php';
require get_template_directory() . '/inc/plugin-dependency.php';
require get_template_directory() . '/inc/customizer.php';

// Load Admin Panel only in Dashboard.
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-portfolio-admin.php';
}

/**
 * Include Portfolio Projects and Blog Posts in Search Results
 */
function foliowind_search_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		$query->set( 'post_type', array( 'post', 'portfoliowind_proj', 'portfolio_project' ) );
	}
}
add_action( 'pre_get_posts', 'foliowind_search_filter' );


