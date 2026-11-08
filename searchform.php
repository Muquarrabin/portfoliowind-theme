<?php
/**
 * The template for displaying search forms
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$unique_id = wp_unique_id( 'search-form-' );
?>
<form role="search" method="get" class="search-form relative flex items-center w-full" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $unique_id ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'portfoliowind' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $unique_id ); ?>" class="search-input w-full pl-9 pr-10 py-2.5 text-sm rounded-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 border border-slate-200 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="<?php echo esc_attr_x( 'Search projects &amp; blogs&hellip;', 'placeholder', 'portfoliowind' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_attr_e( 'Press Enter to search', 'portfoliowind' ); ?>" autocomplete="off" />
	<svg class="w-4 h-4 text-slate-400 absolute left-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
		<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
	</svg>
	<div class="search-instruction-hint" aria-hidden="true">
		<span class="search-hint-text">
			<svg class="w-3.5 h-3.5 text-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
			</svg>
			<?php esc_html_e( 'Press Enter to search', 'portfoliowind' ); ?>
		</span>
		<kbd class="search-hint-kbd">↵ Enter</kbd>
	</div>
</form>
