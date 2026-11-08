<?php
/**
 * Template Part: Services Section
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = portfolio_get_option( 'services', array() );

if ( empty( $services ) ) {
	return;
}
?>
<section id="services" class="py-14 sm:py-16 md:py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
	<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
		<div class="text-center max-w-3xl mx-auto mb-12">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-2">
				<?php esc_html_e( 'Specialized Solutions', 'portfoliowind' ); ?>
			</span>
			<h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( 'What I Do & Offer', 'portfoliowind' ); ?>
			</h2>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-4"></div>
			<p class="text-base text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'Specialized services and tailored solutions to bring your vision into reality.', 'portfoliowind' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php foreach ( $services as $svc ) : ?>
				<div class="p-8 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl group">
					<div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-white transition-all shadow-sm">
						<span class="dashicons <?php echo esc_attr( $svc['icon'] ?? 'dashicons-laptop' ); ?>" style="font-size: 26px; width: 26px; height: 26px;"></span>
					</div>
					<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
						<?php echo esc_html( $svc['title'] ); ?>
					</h3>
					<?php if ( ! empty( $svc['desc'] ) ) : ?>
						<p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
							<?php echo esc_html( $svc['desc'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
