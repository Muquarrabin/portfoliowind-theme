<?php
/**
 * Template Part: Hero Section
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_name     = portfolio_get_option( 'hero_name', get_bloginfo( 'name' ) );
$hero_tagline  = portfolio_get_option( 'hero_tagline', get_bloginfo( 'description' ) );
$hero_bio      = portfolio_get_option( 'hero_bio', '' );
$hero_avatar   = portfolio_get_option( 'hero_avatar', '' );
$hero_cv_url   = portfolio_get_option( 'hero_cv_url', '' );
$hero_cta_text = portfolio_get_option( 'hero_cta_text', __( 'Get in Touch', 'portfoliowind' ) );
$hero_cta_url  = portfolio_get_option( 'hero_cta_url', '#contact' );
$status_badge  = portfolio_get_option( 'contact_badge', 'Available for Freelance & Projects' );
?>
<section id="hero" class="relative py-14 sm:py-16 md:py-20 overflow-hidden bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
	<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12">
		<!-- Left: Text Content -->
		<div class="w-full md:w-3/5 text-center md:text-left flex flex-col items-center md:items-start">
			<?php if ( ! empty( $status_badge ) ) : ?>
				<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 mb-6 max-w-full text-left">
					<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
					<span><?php echo esc_html( $status_badge ); ?></span>
				</div>
			<?php endif; ?>

			<h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( "Hi, I'm", 'portfoliowind' ); ?> 
				<span class="text-primary"><?php echo esc_html( $hero_name ); ?></span>
			</h1>

			<?php if ( ! empty( $hero_tagline ) ) : ?>
				<h2 class="text-lg sm:text-2xl font-medium text-slate-700 dark:text-slate-300 mb-6">
					<?php echo esc_html( $hero_tagline ); ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $hero_bio ) ) : ?>
				<p class="text-sm sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed mb-8">
					<?php echo esc_html( $hero_bio ); ?>
				</p>
			<?php endif; ?>

			<!-- CTA Buttons -->
			<div class="flex flex-wrap items-center justify-center md:justify-start gap-3 sm:gap-4 w-full">
				<?php if ( ! empty( $hero_cta_url ) && ! empty( $hero_cta_text ) ) : ?>
					<a href="<?php echo esc_attr( $hero_cta_url ); ?>" class="theme-btn-primary">
						<span><?php echo esc_html( $hero_cta_text ); ?></span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
						</svg>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $hero_cv_url ) ) : ?>
					<a href="<?php echo esc_url( $hero_cv_url ); ?>" target="_blank" rel="noopener noreferrer" class="theme-btn-secondary">
						<svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
						</svg>
						<span><?php esc_html_e( 'Download CV', 'portfoliowind' ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<!-- Right: Avatar / Photo -->
		<?php if ( ! empty( $hero_avatar ) ) : ?>
			<div class="w-full md:w-2/5 flex justify-center mt-8 md:mt-0 flex-shrink-0 relative">
				<div class="w-52 h-52 sm:w-64 sm:h-64 md:w-80 md:h-80 rounded-3xl overflow-hidden shadow-2xl border-4 border-white dark:border-slate-800 relative z-10">
					<img src="<?php echo esc_url( $hero_avatar ); ?>" alt="<?php echo esc_attr( $hero_name ); ?>" class="w-full h-full object-cover">
				</div>
				<!-- Decorative Glow -->
				<div class="absolute -inset-4 bg-primary/20 rounded-3xl blur-2xl -z-10 transform rotate-6"></div>
			</div>
		<?php endif; ?>
	</div>
</section>
