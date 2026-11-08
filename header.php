<?php
/**
 * The Header for PortfolioWind
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'antialiased bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary">
	<?php esc_html_e( 'Skip to content', 'portfoliowind' ); ?>
</a>

<!-- Sticky Navigation Bar -->
<header class="sticky top-0 z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 transition-colors">
	<div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between gap-4">
		<!-- Brand Logo / Site Title -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 text-xl font-bold text-slate-900 dark:text-white flex-shrink-0">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-extrabold text-sm shadow-md">
					<?php echo esc_html( strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ) ); ?>
				</span>
				<span><?php bloginfo( 'name' ); ?></span>
				<?php
			}
			?>
		</a>

		<!-- Desktop Navigation Menu -->
		<nav class="site-navigation hidden lg:flex items-center gap-7 text-sm font-medium text-slate-600 dark:text-slate-300" aria-label="<?php esc_attr_e( 'Primary Navigation', 'portfoliowind' ); ?>">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'nav-menu flex items-center gap-7 list-none m-0 p-0',
					'fallback_cb'    => false,
				) );
				?>
			<?php else : ?>
				<ul class="nav-menu flex items-center gap-7 list-none m-0 p-0">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Blogs', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Contact', 'portfoliowind' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>

		<!-- Right Side Controls: Search Bar, Dark Mode Toggle & Mobile Menu Trigger -->
		<div class="flex items-center gap-3 flex-shrink-0">
			<!-- Search Bar for Projects & Blogs (Desktop only) -->
			<div class="header-search-wrap">
				<?php get_search_form(); ?>
			</div>

			<!-- Dark Mode Toggle Button -->
			<button type="button" class="theme-mode-toggle p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="<?php esc_attr_e( 'Toggle Dark/Light Mode', 'portfoliowind' ); ?>" aria-label="<?php esc_attr_e( 'Toggle Theme Mode', 'portfoliowind' ); ?>">
				<!-- Sun Icon (shows in dark mode) -->
				<svg class="icon-sun w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
				</svg>
				<!-- Moon Icon (shows in light mode) -->
				<svg class="icon-moon w-5 h-5 text-slate-600 dark:text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
				</svg>
			</button>

			<!-- Mobile Menu Button with Animated Hamburger / Close Icon -->
			<button type="button" id="mobile-menu-toggle" class="lg:hidden p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" aria-label="<?php esc_attr_e( 'Toggle Navigation Menu', 'portfoliowind' ); ?>" aria-expanded="false">
				<svg id="icon-hamburger" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
				</svg>
				<svg id="icon-close" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>
	</div>

	<!-- Mobile Menu Drawer (Floating Overlay with Solid Opaque Background) -->
	<div id="mobile-menu-drawer" class="mobile-drawer hidden lg:hidden px-5 py-6">
		<!-- Mobile Search Bar -->
		<div class="mobile-search-wrap mb-5 w-full">
			<?php get_search_form(); ?>
		</div>

		<nav class="mobile-navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'portfoliowind' ); ?>">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'mobile-nav-menu flex flex-col gap-1 list-none m-0 p-0',
					'fallback_cb'    => false,
				) );
				?>
			<?php else : ?>
				<ul class="mobile-nav-menu flex flex-col gap-1 list-none m-0 p-0">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-link"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="mobile-nav-link"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="mobile-nav-link"><?php esc_html_e( 'Blogs', 'portfoliowind' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="mobile-nav-link"><?php esc_html_e( 'Contact', 'portfoliowind' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>
	</div>
</header>
<main id="primary" class="site-main">
