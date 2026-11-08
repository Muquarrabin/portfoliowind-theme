<?php
/**
 * Template Part: Resume & Career / Education Timeline
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$resume = portfolio_get_option( 'resume', array() );

if ( empty( $resume ) ) {
	return;
}

// Split into Experience and Education columns
$experience_items = array();
$education_items  = array();

foreach ( $resume as $item ) {
	$item_type = strtolower( $item['type'] ?? 'experience' );
	$is_edu    = ( 'education' === $item_type || false !== stripos( $item['role'] ?? '', 'degree' ) || false !== stripos( $item['role'] ?? '', 'bachelor' ) || false !== stripos( $item['role'] ?? '', 'master' ) || false !== stripos( $item['company'] ?? '', 'university' ) || false !== stripos( $item['company'] ?? '', 'college' ) );

	if ( $is_edu ) {
		$education_items[] = $item;
	} else {
		$experience_items[] = $item;
	}
}

$has_experience = ! empty( $experience_items );
$has_education  = ! empty( $education_items );
$is_two_col     = ( $has_experience && $has_education );
?>
<section id="resume" class="py-20 mb-16 bg-white dark:bg-slate-900">
	<div class="<?php echo $is_two_col ? 'max-w-7xl' : 'max-w-3xl'; ?> mx-auto px-6 sm:px-8 lg:px-12">
		<!-- Section Header -->
		<div class="text-center max-w-2xl mx-auto mb-16">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-2">
				<?php esc_html_e( 'Career & Academic Path', 'portfoliowind' ); ?>
			</span>
			<h2 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( 'Experience & Education', 'portfoliowind' ); ?>
			</h2>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-4"></div>
			<p class="text-base text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'My educational foundation and professional career milestones.', 'portfoliowind' ); ?>
			</p>
		</div>

		<!-- Two-Column Timeline Grid -->
		<div class="<?php echo $is_two_col ? 'grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-start' : 'space-y-12'; ?>">

			<?php if ( $has_experience ) : ?>
				<!-- Experience Column -->
				<div class="space-y-6">
					<!-- Column Header -->
					<div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-800">
						<div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 shadow-sm">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
							</svg>
						</div>
						<div>
							<h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white leading-tight">
								<?php esc_html_e( 'Work Experience', 'portfoliowind' ); ?>
							</h3>
							<p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
								<?php esc_html_e( 'Professional career milestones', 'portfoliowind' ); ?>
							</p>
						</div>
					</div>

					<!-- Experience Timeline Items -->
					<div class="pt-2">
						<?php foreach ( $experience_items as $idx => $item ) : 
							$is_last = ( $idx === count( $experience_items ) - 1 );
						?>
							<div class="relative flex items-start gap-5 sm:gap-6 group">
								<!-- Left: Milestone Node Badge (Without dangling bottom line) -->
								<div class="flex-shrink-0 pt-0.5">
									<div class="timeline-node-circle" title="<?php esc_attr_e( 'Experience', 'portfoliowind' ); ?>">
										<svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
										</svg>
									</div>
								</div>

								<!-- Right: Elevated Card Content -->
								<div class="flex-1 min-w-0 <?php echo ! $is_last ? 'mb-8' : ''; ?> p-6 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-primary/40 transition-all duration-300">
									<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
										<div>
											<span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-primary/10 text-primary border border-primary/20 mb-1.5">
												<?php esc_html_e( 'Experience', 'portfoliowind' ); ?>
											</span>
											<h4 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white leading-snug">
												<?php echo esc_html( $item['role'] ); ?>
											</h4>
										</div>

										<?php if ( ! empty( $item['period'] ) ) : ?>
											<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 shadow-sm w-fit flex-shrink-0">
												<svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
												</svg>
												<?php echo esc_html( $item['period'] ); ?>
											</span>
										<?php endif; ?>
									</div>

									<?php if ( ! empty( $item['company'] ) ) : ?>
										<div class="text-sm font-semibold text-primary mb-3 flex items-center gap-2">
											<span><?php echo esc_html( $item['company'] ); ?></span>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $item['desc'] ) ) : ?>
										<p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
											<?php echo esc_html( $item['desc'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $has_education ) : ?>
				<!-- Education Column -->
				<div class="space-y-6">
					<!-- Column Header -->
					<div class="flex items-center gap-3.5 pb-4 border-b border-slate-100 dark:border-slate-800">
						<div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center flex-shrink-0 shadow-sm">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/>
							</svg>
						</div>
						<div>
							<h3 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white leading-tight">
								<?php esc_html_e( 'Education', 'portfoliowind' ); ?>
							</h3>
							<p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
								<?php esc_html_e( 'Academic background & degrees', 'portfoliowind' ); ?>
							</p>
						</div>
					</div>

					<!-- Education Timeline Items -->
					<div class="pt-2">
						<?php foreach ( $education_items as $idx => $item ) : 
							$is_last = ( $idx === count( $education_items ) - 1 );
						?>
							<div class="relative flex items-start gap-5 sm:gap-6 group">
								<!-- Left: Milestone Node Badge (Without dangling bottom line) -->
								<div class="flex-shrink-0 pt-0.5">
									<div class="timeline-node-circle edu-node" title="<?php esc_attr_e( 'Education', 'portfoliowind' ); ?>">
										<svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/>
										</svg>
									</div>
								</div>

								<!-- Right: Elevated Card Content -->
								<div class="flex-1 min-w-0 <?php echo ! $is_last ? 'mb-8' : ''; ?> p-6 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800/80 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:border-amber-500/40 transition-all duration-300">
									<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
										<div>
											<span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-amber-500/10 text-amber-500 border border-amber-500/20 mb-1.5">
												<?php esc_html_e( 'Education', 'portfoliowind' ); ?>
											</span>
											<h4 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white leading-snug">
												<?php echo esc_html( $item['role'] ); ?>
											</h4>
										</div>

										<?php if ( ! empty( $item['period'] ) ) : ?>
											<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 shadow-sm w-fit flex-shrink-0">
												<svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
												</svg>
												<?php echo esc_html( $item['period'] ); ?>
											</span>
										<?php endif; ?>
									</div>

									<?php if ( ! empty( $item['company'] ) ) : ?>
										<div class="text-sm font-semibold text-amber-600 dark:text-amber-400 mb-3 flex items-center gap-2">
											<span><?php echo esc_html( $item['company'] ); ?></span>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $item['desc'] ) ) : ?>
										<p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
											<?php echo esc_html( $item['desc'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
