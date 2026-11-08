<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package FolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="max-w-2xl mx-auto px-4 py-28 text-center">
	<div class="text-8xl font-black text-primary mb-4">404</div>
	<h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">
		<?php esc_html_e( 'Page Not Found', 'portfoliowind' ); ?>
	</h1>
	<p class="text-base text-slate-600 dark:text-slate-400 mb-8">
		<?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'portfoliowind' ); ?>
	</p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="theme-btn-primary">
		<?php esc_html_e( 'Return to Home', 'portfoliowind' ); ?>
	</a>
</div>

<?php
get_footer();
