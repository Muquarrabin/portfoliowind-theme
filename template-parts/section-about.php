<?php
/**
 * Template Part: About & Skills Section
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_heading = portfolio_get_option( 'about_heading', __( 'About Me', 'portfoliowind' ) );
$about_bio     = portfolio_get_option( 'about_bio', '' );
$stat_years    = portfolio_get_option( 'stat_years', '5+' );
$stat_projects = portfolio_get_option( 'stat_projects', '40+' );
$stat_clients  = portfolio_get_option( 'stat_clients', '30+' );
$skills        = portfolio_get_option( 'skills', array() );
?>
<section id="about" class="py-14 sm:py-16 md:py-20 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800">
	<div class="max-w-7xl mx-auto px-4">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-12">
			<h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">
				<?php echo esc_html( $about_heading ); ?>
			</h2>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-6"></div>
			<?php if ( ! empty( $about_bio ) ) : ?>
				<div class="text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
					<?php echo wp_kses_post( wpautop( $about_bio ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Performance Metric Cards -->
		<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto mb-12">
			<div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
				<div class="text-3xl sm:text-4xl font-extrabold text-primary mb-1">
					<?php echo esc_html( $stat_years ); ?>
				</div>
				<div class="text-sm font-medium text-slate-500 dark:text-slate-400">
					<?php esc_html_e( 'Years Experience', 'portfoliowind' ); ?>
				</div>
			</div>

			<div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
				<div class="text-3xl sm:text-4xl font-extrabold text-primary mb-1">
					<?php echo esc_html( $stat_projects ); ?>
				</div>
				<div class="text-sm font-medium text-slate-500 dark:text-slate-400">
					<?php esc_html_e( 'Completed Projects', 'portfoliowind' ); ?>
				</div>
			</div>

			<div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
				<div class="text-3xl sm:text-4xl font-extrabold text-primary mb-1">
					<?php echo esc_html( $stat_clients ); ?>
				</div>
				<div class="text-sm font-medium text-slate-500 dark:text-slate-400">
					<?php esc_html_e( 'Satisfied Clients', 'portfoliowind' ); ?>
				</div>
			</div>
		</div>

		<!-- Redesigned High-Impact Skill Cards -->
		<?php if ( ! empty( $skills ) ) : ?>
			<div class="max-w-4xl mx-auto">
				<div class="text-center mb-8">
					<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-2">
						<?php esc_html_e( 'Expertise & Tools', 'portfoliowind' ); ?>
					</span>
					<h3 class="text-2xl font-bold text-slate-900 dark:text-white">
						<?php esc_html_e( 'Core Skills & Technologies', 'portfoliowind' ); ?>
					</h3>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
					<?php foreach ( $skills as $skill ) : 
						$percent = absint( $skill['percent'] ?? 80 );
						$initial = strtoupper( substr( trim( $skill['name'] ), 0, 2 ) );
						
						// Proficiency level badge label
						$level_label = __( 'Intermediate', 'portfoliowind' );
						if ( $percent >= 90 ) {
							$level_label = __( 'Expert', 'portfoliowind' );
						} elseif ( $percent >= 75 ) {
							$level_label = __( 'Advanced', 'portfoliowind' );
						} elseif ( $percent < 50 ) {
							$level_label = __( 'Beginner', 'portfoliowind' );
						}
					?>
						<div class="group p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-primary/50 dark:hover:border-primary/50 transition-all duration-300">
							<div class="flex items-center justify-between mb-3">
								<div class="flex items-center gap-3">
									<div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-bold text-xs flex items-center justify-center flex-shrink-0 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
										<?php echo esc_html( $initial ); ?>
									</div>
									<div>
										<h4 class="text-base font-bold text-slate-900 dark:text-white leading-tight">
											<?php echo esc_html( $skill['name'] ); ?>
										</h4>
										<span class="text-xs text-slate-400 font-medium">
											<?php echo esc_html( $level_label ); ?>
										</span>
									</div>
								</div>
								<div class="text-right">
									<span class="inline-block px-2.5 py-1 rounded-full text-xs font-extrabold bg-primary/10 text-primary border border-primary/20">
										<?php echo esc_html( $percent ); ?>%
									</span>
								</div>
							</div>

							<!-- Sleek Progress Bar Track -->
							<div class="w-full bg-slate-100 dark:bg-slate-800/80 rounded-full h-2.5 overflow-hidden p-0.5">
								<div class="bg-primary h-full rounded-full transition-all duration-500 shadow-sm" style="width: <?php echo esc_attr( $percent ); ?>%;"></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
