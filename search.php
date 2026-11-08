<?php
/**
 * The template for displaying search results
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

global $wp_query;
$search_query = get_search_query();
$total_count  = $wp_query->found_posts;
?>

<section class="py-16 md:py-24 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 min-h-screen">
	<div class="max-w-7xl mx-auto px-4">

		<!-- Breadcrumbs Navigation -->
		<nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-8" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a>
			<span>/</span>
			<span class="text-slate-800 dark:text-slate-200 font-medium"><?php esc_html_e( 'Search Results', 'portfoliowind' ); ?></span>
		</nav>

		<!-- Header & Query Info -->
		<div class="text-center max-w-3xl mx-auto mb-14">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
				<?php esc_html_e( 'Search Explorer', 'portfoliowind' ); ?>
			</span>
			<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php
				/* translators: %s: search query string */
				printf( esc_html__( 'Results for: &ldquo;%s&rdquo;', 'portfoliowind' ), esc_html( $search_query ) );
				?>
			</h1>
			<p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 mb-8">
				<?php
				/* translators: %d: total results count */
				printf( esc_html( _n( 'Found %d match across projects and articles.', 'Found %d matches across projects and articles.', $total_count, 'portfoliowind' ) ), $total_count );
				?>
			</p>

			<!-- Quick Refine Search Form -->
			<div class="max-w-lg mx-auto">
				<?php get_search_form(); ?>
			</div>
		</div>

		<!-- Search Results Grid -->
		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20 items-stretch">
				<?php
				while ( have_posts() ) :
					the_post();
					$post_type = get_post_type();
					$is_project = in_array( $post_type, array( 'portfoliowind_proj', 'portfolio_project' ), true );

					// Badging
					if ( $is_project ) {
						$terms    = get_the_terms( get_the_ID(), 'portfoliowind_project_category' );
						if ( empty( $terms ) || is_wp_error( $terms ) ) {
							$terms = get_the_terms( get_the_ID(), 'project_category' );
						}
						$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Project', 'portfoliowind' );
						$type_lbl = __( 'Project', 'portfoliowind' );
					} else {
						$cats     = get_the_category();
						$cat_name = ! empty( $cats ) ? $cats[0]->name : __( 'Article', 'portfoliowind' );
						$type_lbl = __( 'Article', 'portfoliowind' );
					}
					?>
					<article id="post-<?php the_ID(); ?>" class="bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
						<div>
							<!-- Thumbnail Image with Strict Uniform 220px Height -->
							<a href="<?php the_permalink(); ?>" class="portfolio-card-thumb block group">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
								<?php else : ?>
									<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-indigo-500/10 text-primary">
										<?php if ( $is_project ) : ?>
											<svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
										<?php else : ?>
											<svg class="w-12 h-12 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<!-- Category Pill -->
								<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
									<?php echo esc_html( $cat_name ); ?>
								</span>
							</a>

							<!-- Content Area -->
							<div class="p-6">
								<div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">
									<span class="text-primary"><?php echo esc_html( $type_lbl ); ?></span>
									<span>&bull;</span>
									<span><?php echo esc_html( get_the_date() ); ?></span>
								</div>

								<h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-2">
									<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
										<?php the_title(); ?>
									</a>
								</h2>

								<div class="text-sm text-slate-600 dark:text-slate-400 mb-2 line-clamp-2 leading-relaxed">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
								</div>
							</div>
						</div>

						<!-- Card Footer with Balanced Typography & Margins -->
						<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
							<a href="<?php the_permalink(); ?>" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
								<span><?php echo $is_project ? esc_html__( 'Case Study', 'portfoliowind' ) : esc_html__( 'Read Article', 'portfoliowind' ); ?></span>
								<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
								</svg>
							</a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<!-- Pagination with Generous Margin -->
			<div class="text-center mt-12 mb-16">
				<?php
				echo paginate_links( array(
					'prev_text' => '&larr; ' . esc_html__( 'Previous', 'portfoliowind' ),
					'next_text' => esc_html__( 'Next', 'portfoliowind' ) . ' &rarr;',
				) );
				?>
			</div>
		<?php else : ?>
			<!-- Empty State -->
			<div class="text-center py-20 px-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 max-w-xl mx-auto shadow-sm">
				<div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-6">
					<svg class="w-8 h-8 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
					</svg>
				</div>
				<h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
					<?php esc_html_e( 'No Matches Found', 'portfoliowind' ); ?>
				</h3>
				<p class="text-sm text-slate-600 dark:text-slate-400 mb-8 leading-relaxed max-w-md mx-auto">
					<?php esc_html_e( 'We could not find any projects or articles matching your keyword. Please check your spelling or try exploring our dedicated sections below.', 'portfoliowind' ); ?>
				</p>
				<div class="flex flex-wrap items-center justify-center gap-4">
					<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="theme-btn-primary">
						<?php esc_html_e( 'Explore Projects', 'portfoliowind' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="theme-btn-secondary">
						<?php esc_html_e( 'Explore Blogs', 'portfoliowind' ); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php
get_footer();

