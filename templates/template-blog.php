<?php
/**
 * Template Name: Blog Overview (PortfolioWind)
 * Template Post Type: page
 *
 * Dedicated archive and overview page for blog posts.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$blog_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'paged'          => $paged,
	'posts_per_page' => 9,
) );
?>
<section class="py-16 md:py-24 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 min-h-screen">
	<div class="max-w-7xl mx-auto px-4">
		<!-- Page Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
				<?php esc_html_e( 'Articles, Thoughts & Tutorials', 'portfoliowind' ); ?>
			</span>
			<h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( 'Blog & Insights', 'portfoliowind' ); ?>
			</h1>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-6"></div>
			<p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'Exploring software engineering, design principles, modern workflows, and developer experiences.', 'portfoliowind' ); ?>
			</p>
		</div>

		<!-- Blog Category Filter Buttons -->
		<?php
		$blog_categories = get_categories( array( 'hide_empty' => true ) );
		if ( ! empty( $blog_categories ) ) :
			?>
			<div class="flex flex-wrap items-center justify-center gap-2 mb-14">
				<button type="button" class="blog-filter-btn px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-colors bg-primary text-white" data-filter="all">
					<?php esc_html_e( 'All Articles', 'portfoliowind' ); ?>
				</button>
				<?php foreach ( $blog_categories as $cat ) : ?>
					<button type="button" class="blog-filter-btn px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition-colors bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800" data-filter="<?php echo esc_attr( $cat->slug ); ?>">
						<?php echo esc_html( $cat->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<!-- Posts Grid -->
		<?php if ( $blog_query->have_posts() ) : ?>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20 items-stretch">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					$categories = get_the_category();
					$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'General', 'portfoliowind' );
					$cat_slug   = ! empty( $categories ) ? $categories[0]->slug : 'all';

					// Calculate reading time
					$word_count = str_word_count( strip_tags( get_the_content() ) );
					$read_time  = max( 1, ceil( $word_count / 200 ) );
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-blog-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between' ); ?> data-category="<?php echo esc_attr( $cat_slug ); ?>">
						<div>
							<!-- Featured Image with Strict 220px Height & Solid Badge -->
							<a href="<?php the_permalink(); ?>" class="blog-card-thumb block group">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
								<?php else : ?>
									<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 via-slate-100 to-indigo-500/10 dark:from-primary/20 dark:via-slate-900 dark:to-indigo-500/20 text-primary">
										<svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
									</div>
								<?php endif; ?>
								<!-- Clean High-Contrast Category Pill -->
								<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
									<?php echo esc_html( $cat_name ); ?>
								</span>
							</a>

							<!-- Content Area -->
							<div class="p-6">
								<div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
										<?php echo esc_html( get_the_date() ); ?>
									</time>
									<span>&bull;</span>
									<span><?php echo esc_html( sprintf( __( '%d min read', 'portfoliowind' ), $read_time ) ); ?></span>
								</div>

								<h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-2">
									<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
										<?php the_title(); ?>
									</a>
								</h2>

								<div class="text-sm text-slate-600 dark:text-slate-400 mb-2 leading-relaxed line-clamp-2">
									<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
								</div>
							</div>
						</div>

						<!-- Card Footer with Balanced Typography & Margins -->
						<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
							<a href="<?php the_permalink(); ?>" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
								<span><?php esc_html_e( 'Read Article', 'portfoliowind' ); ?></span>
								<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
								</svg>
							</a>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<!-- Pagination with Generous Margin -->
			<div class="text-center mt-12 mb-16">
				<?php
				echo paginate_links( array(
					'total'     => $blog_query->max_num_pages,
					'current'   => $paged,
					'prev_text' => '← ' . esc_html__( 'Previous', 'portfoliowind' ),
					'next_text' => esc_html__( 'Next', 'portfoliowind' ) . ' →',
				) );
				?>
			</div>

			<!-- Project Consultation Callout Box with Generous Top Margin (mt-20 sm:mt-24) -->
			<div class="mt-20 sm:mt-24 mb-16 p-8 sm:p-14 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 text-center max-w-4xl mx-auto shadow-md">
				<h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-4">
					<?php esc_html_e( 'Have a New Project on Your Mind?', 'portfoliowind' ); ?>
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
		<?php else : ?>
			<div class="text-center py-16 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 max-w-xl mx-auto">
				<p class="text-base text-slate-500 mb-4"><?php esc_html_e( 'No articles published yet. Check back soon!', 'portfoliowind' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="theme-btn-primary">
					<?php esc_html_e( 'Back to Home', 'portfoliowind' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
