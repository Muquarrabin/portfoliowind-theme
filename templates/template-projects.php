<?php
/**
 * Template Name: Projects Overview (PortfolioWind)
 * Template Post Type: page
 *
 * Dedicated showcase and filterable overview page for all projects.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// 1. Query CPT projects
$cpt_query = new WP_Query( array(
	'post_type'      => function_exists( 'portfoliowind_get_project_post_types' ) ? portfoliowind_get_project_post_types() : array( 'portfoliowind_proj', 'portfolio_project' ),
	'post_status'    => 'publish',
	'posts_per_page' => -1,
) );

$has_cpt = $cpt_query->have_posts();

// 2. Fallback to Studio options
$studio_projects = portfolio_get_option( 'projects', array() );

// Extract unique categories for filter tabs
$categories = array();
if ( $has_cpt ) {
	$active_tax = taxonomy_exists( 'portfoliowind_project_category' ) ? 'portfoliowind_project_category' : 'project_category';
	$terms = get_terms( array(
		'taxonomy'   => $active_tax,
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$categories[ $term->slug ] = $term->name;
		}
	}
} else {
	foreach ( $studio_projects as $proj ) {
		if ( ! empty( $proj['category'] ) ) {
			$categories[ sanitize_key( $proj['category'] ) ] = ucfirst( $proj['category'] );
		}
	}
}
?>
<section class="py-16 md:py-24 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 min-h-screen">
	<div class="max-w-7xl mx-auto px-4">
		<!-- Page Header -->
		<div class="text-center max-w-3xl mx-auto mb-14">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
				<?php esc_html_e( 'Case Studies, Products & Open-Source', 'portfoliowind' ); ?>
			</span>
			<h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( 'Projects Portfolio', 'portfoliowind' ); ?>
			</h1>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-6"></div>
			<p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'A comprehensive collection of software, web applications, open-source utilities, and UI/UX projects I have designed and engineered.', 'portfoliowind' ); ?>
			</p>
		</div>

		<!-- Category Filter Buttons -->
		<?php if ( count( $categories ) > 1 ) : ?>
			<div class="flex flex-wrap items-center justify-center gap-2 mb-14">
				<button type="button" class="portfolio-filter-btn px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-colors bg-primary text-white" data-filter="all">
					<?php esc_html_e( 'All Projects', 'portfoliowind' ); ?>
				</button>
				<?php foreach ( $categories as $slug => $label ) : ?>
					<button type="button" class="portfolio-filter-btn px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-colors bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800" data-filter="<?php echo esc_attr( $slug ); ?>">
						<?php echo esc_html( $label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Projects Grid -->
		<?php if ( $has_cpt || ! empty( $studio_projects ) ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
				<?php
				if ( $has_cpt ) :
					while ( $cpt_query->have_posts() ) :
						$cpt_query->the_post();
						$project_terms = get_the_terms( get_the_ID(), 'portfoliowind_project_category' );
						if ( empty( $project_terms ) || is_wp_error( $project_terms ) ) {
							$project_terms = get_the_terms( get_the_ID(), 'project_category' );
						}
						$cat_slug      = ( ! empty( $project_terms ) && ! is_wp_error( $project_terms ) ) ? $project_terms[0]->slug : 'all';
						$cat_title     = ( ! empty( $project_terms ) && ! is_wp_error( $project_terms ) ) ? $project_terms[0]->name : __( 'Case Study', 'portfoliowind' );
						$live_url      = portfoliowind_get_project_meta( get_the_ID(), 'live_url' );
						$custom_img    = portfoliowind_get_project_meta( get_the_ID(), 'image_url' );
						?>
						<div class="portfolio-project-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between" data-category="<?php echo esc_attr( $cat_slug ); ?>">
							<div>
								<!-- Image Thumbnail (Strict 220px Height & Solid Badge) -->
								<a href="<?php the_permalink(); ?>" class="portfolio-card-thumb block group">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
									<?php elseif ( ! empty( $custom_img ) ) : ?>
										<img src="<?php echo esc_url( $custom_img ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover">
									<?php else : ?>
										<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-indigo-500/10 text-primary">
											<svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
										</div>
									<?php endif; ?>
									<!-- Clean High-Contrast Category Pill -->
									<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
										<?php echo esc_html( $cat_title ); ?>
									</span>
								</a>

								<!-- Content Area -->
								<div class="p-6">
									<h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-1">
										<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
											<?php the_title(); ?>
										</a>
									</h2>
									<?php if ( has_excerpt() ) : ?>
										<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 line-clamp-2 leading-relaxed">
											<?php echo esc_html( get_the_excerpt() ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>

							<!-- Card Actions with Balanced Typography & Margins -->
							<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
								<a href="<?php the_permalink(); ?>" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
									<span><?php esc_html_e( 'Case Study', 'portfoliowind' ); ?></span>
									<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
								</a>
								<?php if ( ! empty( $live_url ) ) : ?>
									<a href="<?php echo esc_url( $live_url ); ?>" target="_blank" rel="noopener noreferrer" class="font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-xs sm:text-sm">
										<span><?php esc_html_e( 'Live Demo', 'portfoliowind' ); ?></span>
										<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					// Fallback to Studio options
					foreach ( $studio_projects as $proj ) :
						$cat_slug = sanitize_key( $proj['category'] ?? 'all' );
						?>
						<div class="portfolio-project-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between" data-category="<?php echo esc_attr( $cat_slug ); ?>">
							<div>
								<!-- Image Thumbnail (Strict 220px Height & Clean Badge) -->
								<?php if ( ! empty( $proj['image'] ) ) : ?>
									<div class="portfolio-card-thumb block group">
										<img src="<?php echo esc_url( $proj['image'] ); ?>" alt="<?php echo esc_attr( $proj['title'] ); ?>" class="w-full h-full object-cover">
										<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
											<?php echo esc_html( ucfirst( $proj['category'] ?? 'General' ) ); ?>
										</span>
									</div>
								<?php endif; ?>

								<!-- Content Area -->
								<div class="p-6">
									<h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-1">
										<?php echo esc_html( $proj['title'] ); ?>
									</h2>
									<?php if ( ! empty( $proj['desc'] ) ) : ?>
										<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 line-clamp-2 leading-relaxed">
											<?php echo esc_html( $proj['desc'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>

							<?php if ( ! empty( $proj['url'] ) ) : ?>
								<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
									<a href="<?php echo esc_url( $proj['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
										<span><?php esc_html_e( 'View Live Project', 'portfoliowind' ); ?></span>
										<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
										</svg>
									</a>
								</div>
							<?php endif; ?>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>

			<!-- Project Consultation Callout Box with Generous Top Margin (mt-24 sm:mt-28) -->
			<div class="mt-24 sm:mt-28 mb-16 p-8 sm:p-14 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 text-center max-w-4xl mx-auto shadow-md">
				<h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-4">
					<?php esc_html_e( 'Have a New Project in Mind?', 'portfoliowind' ); ?>
				</h3>
				<p class="text-base text-slate-600 dark:text-slate-400 mb-8 max-w-xl mx-auto leading-relaxed">
					<?php esc_html_e( 'I am available for freelance contracts, full-time remote opportunities, and architecture consulting.', 'portfoliowind' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="theme-btn-primary shadow-lg inline-flex items-center gap-2">
					<span><?php esc_html_e( 'Start a Conversation', 'portfoliowind' ); ?></span>
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
					</svg>
				</a>
			</div>
		<?php else : ?>
			<div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 max-w-xl mx-auto">
				<p class="text-base text-slate-500 mb-4"><?php esc_html_e( 'No projects added yet. Populate projects in WordPress Admin.', 'portfoliowind' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="theme-btn-primary">
					<?php esc_html_e( 'Back to Home', 'portfoliowind' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
