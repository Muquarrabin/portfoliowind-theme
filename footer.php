<?php
/**
 * The Footer for PortfolioWind
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main><!-- #primary -->

<footer class="site-footer bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 transition-colors">
	<div class="max-w-7xl mx-auto px-4 pt-10 pb-6 flex flex-col sm:flex-row items-center justify-between gap-6 border-b border-slate-100 dark:border-slate-800">
		<!-- Brand Logo / Site Title -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 text-lg font-bold text-slate-900 dark:text-white">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-extrabold text-sm shadow-md flex-shrink-0">
					<?php echo esc_html( strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ) ); ?>
				</span>
				<span><?php bloginfo( 'name' ); ?></span>
				<?php
			}
			?>
		</a>

		<!-- Footer Navigation Menu -->
		<nav class="footer-navigation flex flex-wrap items-center justify-center gap-5 sm:gap-7 text-sm font-medium text-slate-600 dark:text-slate-300">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'fallback_cb'    => false,
					'items_wrap'     => '%3$s',
				) );
				?>
			<?php else : ?>
				<?php $contact_url = home_url( '/contact/' ); ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Blogs', 'portfoliowind' ); ?></a>
				<a href="<?php echo esc_url( $contact_url ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Contact', 'portfoliowind' ); ?></a>
			<?php endif; ?>
		</nav>
	</div>

	<?php
	// Render copyright & watermark credit engine
	portfolio_render_footer_watermark();
	?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
