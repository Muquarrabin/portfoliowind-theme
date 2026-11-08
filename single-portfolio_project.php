<?php
/**
 * Single Project Case Study Template
 *
 * Dedicated showcase for portfolio projects with 2-column split layout,
 * sticky project overview sidebar, and category-aware related projects.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	// Check if this project page is built with Elementor
	if ( function_exists( 'portfolio_is_built_with_elementor' ) && portfolio_is_built_with_elementor() ) {
		?>
		<div class="elementor-canvas-wrapper w-full">
			<?php the_content(); ?>
		</div>
		<?php
		continue;
	}

	$client     = portfoliowind_get_project_meta( get_the_ID(), 'client' );
	$timeline   = portfoliowind_get_project_meta( get_the_ID(), 'timeline' );
	$role       = portfoliowind_get_project_meta( get_the_ID(), 'role' );
	$live_url   = portfoliowind_get_project_meta( get_the_ID(), 'live_url' );
	$github_url = portfoliowind_get_project_meta( get_the_ID(), 'github_url' );
	$tech_stack = portfoliowind_get_project_meta( get_the_ID(), 'tech_stack' );
	$image_url  = portfoliowind_get_project_meta( get_the_ID(), 'image_url' );

	$m1_val = portfoliowind_get_project_meta( get_the_ID(), 'metric1_val' );
	$m1_lbl = portfoliowind_get_project_meta( get_the_ID(), 'metric1_lbl' );
	$m2_val = portfoliowind_get_project_meta( get_the_ID(), 'metric2_val' );
	$m2_lbl = portfoliowind_get_project_meta( get_the_ID(), 'metric2_lbl' );
	$m3_val = portfoliowind_get_project_meta( get_the_ID(), 'metric3_val' );
	$m3_lbl = portfoliowind_get_project_meta( get_the_ID(), 'metric3_lbl' );

	$metrics = array();
	if ( ! empty( $m1_val ) || ! empty( $m1_lbl ) ) {
		$metrics[] = array(
			'val'   => $m1_val,
			'lbl'   => $m1_lbl,
			'color' => 'text-primary',
		);
	}
	if ( ! empty( $m2_val ) || ! empty( $m2_lbl ) ) {
		$metrics[] = array(
			'val'   => $m2_val,
			'lbl'   => $m2_lbl,
			'color' => 'text-emerald-500',
		);
	}
	if ( ! empty( $m3_val ) || ! empty( $m3_lbl ) ) {
		$metrics[] = array(
			'val'   => $m3_val,
			'lbl'   => $m3_lbl,
			'color' => 'text-indigo-500',
		);
	}

	$categories = get_the_terms( get_the_ID(), 'portfoliowind_project_category' );
	if ( empty( $categories ) || is_wp_error( $categories ) ) {
		$categories = get_the_terms( get_the_ID(), 'project_category' );
	}
	$cat_name   = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0]->name : __( 'Case Study', 'portfoliowind' );
	$cat_id     = ( ! empty( $categories ) && ! is_wp_error( $categories ) ) ? $categories[0]->term_id : 0;

	$tech_items = array();
	if ( ! empty( $tech_stack ) ) {
		$tech_items = array_map( 'trim', explode( ',', $tech_stack ) );
	}
	?>

	<article id="project-<?php the_ID(); ?>" <?php post_class( 'py-12 md:py-20 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800' ); ?>>
		<div class="max-w-7xl mx-auto px-4">

			<!-- Breadcrumb Navigation -->
			<nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-8" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a>
				<span>/</span>
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a>
				<span>/</span>
				<span class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-xs"><?php the_title(); ?></span>
			</nav>

			<!-- Project Header -->
			<div class="max-w-4xl mb-12">
				<div class="flex items-center gap-3 mb-4">
					<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
						<?php echo esc_html( $cat_name ); ?>
					</span>
				</div>
				<h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4">
					<?php the_title(); ?>
				</h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="text-lg sm:text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
						<?php echo esc_html( get_the_excerpt() ); ?>
					</p>
				<?php endif; ?>
			</div>

			<!-- Project Featured Mockup / Cover Image -->
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="w-full rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xl mb-16 bg-slate-100 dark:bg-slate-900 max-h-[520px]">
					<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full max-h-[520px] object-cover' ) ); ?>
				</div>
			<?php elseif ( ! empty( $image_url ) ) : ?>
				<div class="w-full rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xl mb-16 bg-slate-100 dark:bg-slate-900 max-h-[520px]">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full max-h-[520px] object-cover" />
				</div>
			<?php endif; ?>

			<!-- 2-Column Split Layout: 65% Case Study / 35% Sticky Sidebar -->
			<div class="project-detail-layout mb-24">
				
				<!-- Left 65%: Case Study Breakdown -->
				<div class="project-main-content">
					<div class="prose prose-slate dark:prose-invert max-w-none text-base sm:text-lg leading-relaxed text-slate-700 dark:text-slate-300">
						<?php the_content(); ?>
					</div>

					<!-- Key Highlights & Deliverables Box -->
					<?php if ( ! empty( $metrics ) ) : 
						$grid_cols = 'grid-cols-1';
						if ( count( $metrics ) === 2 ) {
							$grid_cols = 'grid-cols-1 sm:grid-cols-2';
						} elseif ( count( $metrics ) >= 3 ) {
							$grid_cols = 'grid-cols-1 sm:grid-cols-3';
						}
					?>
						<div class="mt-16 p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm">
							<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6">
								<?php esc_html_e( 'Key Deliverables & Outcomes', 'portfoliowind' ); ?>
							</h3>
							<div class="grid <?php echo esc_attr( $grid_cols ); ?> gap-5 text-center">
								<?php foreach ( $metrics as $metric ) : ?>
									<div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
										<?php if ( ! empty( $metric['val'] ) ) : ?>
											<div class="text-2xl sm:text-3xl font-extrabold <?php echo esc_attr( $metric['color'] ); ?> mb-1">
												<?php echo esc_html( $metric['val'] ); ?>
											</div>
										<?php endif; ?>
										<?php if ( ! empty( $metric['lbl'] ) ) : ?>
											<div class="text-xs font-medium text-slate-500 dark:text-slate-400">
												<?php echo esc_html( $metric['lbl'] ); ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Right 35%: Sticky Project Overview Card -->
				<div class="project-meta-sidebar">
					<div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
						<h3 class="text-lg font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3">
							<?php esc_html_e( 'Project Overview', 'portfoliowind' ); ?>
						</h3>

						<?php if ( ! empty( $client ) ) : ?>
							<div>
								<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php esc_html_e( 'Client / Company', 'portfoliowind' ); ?></div>
								<div class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200"><?php echo esc_html( $client ); ?></div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $role ) ) : ?>
							<div>
								<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php esc_html_e( 'Role', 'portfoliowind' ); ?></div>
								<div class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200"><?php echo esc_html( $role ); ?></div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $timeline ) ) : ?>
							<div>
								<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php esc_html_e( 'Timeline / Year', 'portfoliowind' ); ?></div>
								<div class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200"><?php echo esc_html( $timeline ); ?></div>
							</div>
						<?php endif; ?>

						<div>
							<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php esc_html_e( 'Category', 'portfoliowind' ); ?></div>
							<div class="text-sm sm:text-base font-medium text-slate-800 dark:text-slate-200"><?php echo esc_html( $cat_name ); ?></div>
						</div>

						<?php if ( ! empty( $tech_items ) ) : ?>
							<div>
								<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2"><?php esc_html_e( 'Tech Stack', 'portfoliowind' ); ?></div>
								<div class="flex flex-wrap gap-1.5">
									<?php foreach ( $tech_items as $tech ) : ?>
										<span class="px-2.5 py-1 text-xs font-medium rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
											<?php echo esc_html( $tech ); ?>
										</span>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- Action Buttons with Generous Margins & Gap -->
						<div class="mt-8 pt-6 border-t border-slate-200/80 dark:border-slate-800 flex flex-col gap-3.5">
							<?php if ( ! empty( $live_url ) ) : ?>
								<a href="<?php echo esc_url( $live_url ); ?>" target="_blank" rel="noopener noreferrer" class="theme-btn-primary w-full text-center justify-center">
									<span><?php esc_html_e( 'Visit Live Project', 'portfoliowind' ); ?></span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
									</svg>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $github_url ) ) : ?>
								<a href="<?php echo esc_url( $github_url ); ?>" target="_blank" rel="noopener noreferrer" class="theme-btn-secondary w-full text-center justify-center">
									<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
									<span><?php esc_html_e( 'View Source Code', 'portfoliowind' ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>

			</div>

			<!-- Category-Aware "More Projects in [Category]" Section with Generous Margins -->
			<?php
			$active_tax = taxonomy_exists( 'portfoliowind_project_category' ) ? 'portfoliowind_project_category' : 'project_category';
			$related_args = array(
				'post_type'      => portfoliowind_get_project_post_types(),
				'post_status'    => 'publish',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
			);

			if ( $cat_id ) {
				$related_args['tax_query'] = array(
					array(
						'taxonomy' => $active_tax,
						'field'    => 'term_id',
						'terms'    => $cat_id,
					),
				);
			}

			$related_query = new WP_Query( $related_args );

			// Only render if there are other projects in this category!
			if ( $related_query->have_posts() ) :
				?>
				<div class="mt-20 pt-16 border-t border-slate-200 dark:border-slate-800 mb-20 text-left">
					<div class="mb-10 text-left">
						<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
							<?php echo esc_html( $cat_name ); ?>
						</span>
						<h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
							<?php echo esc_html( sprintf( __( 'More Projects in %s', 'portfoliowind' ), $cat_name ) ); ?>
						</h2>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							$rel_terms = get_the_terms( get_the_ID(), 'portfoliowind_project_category' );
							if ( empty( $rel_terms ) || is_wp_error( $rel_terms ) ) {
								$rel_terms = get_the_terms( get_the_ID(), 'project_category' );
							}
							$rel_cat   = ( ! empty( $rel_terms ) && ! is_wp_error( $rel_terms ) ) ? $rel_terms[0]->name : $cat_name;
							$rel_live  = portfoliowind_get_project_meta( get_the_ID(), 'live_url' );
							?>
							<div class="portfolio-project-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
								<div>
									<!-- Thumbnail Image with Strict Uniform 220px Height & Clean Badge -->
									<a href="<?php the_permalink(); ?>" class="portfolio-card-thumb block group">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
										<?php else : ?>
											<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-indigo-500/10 text-primary">
												<svg class="w-10 h-10 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
											</div>
										<?php endif; ?>
										<!-- Clean High-Contrast Category Pill -->
										<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
											<?php echo esc_html( $rel_cat ); ?>
										</span>
									</a>

									<!-- Content Area -->
									<div class="p-6">
										<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 line-clamp-1">
											<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
												<?php the_title(); ?>
											</a>
										</h3>
										<?php if ( has_excerpt() ) : ?>
											<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 line-clamp-2 leading-relaxed">
												<?php echo esc_html( get_the_excerpt() ); ?>
											</p>
										<?php endif; ?>
									</div>
								</div>

								<!-- Action Links with Balanced Typography & Margins -->
								<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
									<a href="<?php the_permalink(); ?>" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
										<span><?php esc_html_e( 'Case Study', 'portfoliowind' ); ?></span>
										<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
									</a>
									<?php if ( ! empty( $rel_live ) ) : ?>
										<a href="<?php echo esc_url( $rel_live ); ?>" target="_blank" rel="noopener noreferrer" class="font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-xs sm:text-sm">
											<span><?php esc_html_e( 'Live Demo', 'portfoliowind' ); ?></span>
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
										</a>
									<?php endif; ?>
								</div>
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
				<?php
			endif;
			?>

			<!-- Consultation Callout Banner with Generous Margins -->
			<div class="mt-24 sm:mt-28 mb-16 p-8 sm:p-14 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 text-center max-w-4xl mx-auto shadow-md">
				<h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-4">
					<?php esc_html_e( 'Need a Similar Solution Built?', 'portfoliowind' ); ?>
				</h3>
				<p class="text-base text-slate-600 dark:text-slate-400 mb-8 max-w-xl mx-auto leading-relaxed">
					<?php esc_html_e( 'Let us discuss how we can turn your architectural concepts into robust, scalable software.', 'portfoliowind' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="theme-btn-primary shadow-lg inline-flex items-center gap-2">
					<span><?php esc_html_e( 'Start a Project Discussion', 'portfoliowind' ); ?></span>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
					</svg>
				</a>
			</div>

		</div>
	</article>

	<?php
endwhile;

get_footer();
