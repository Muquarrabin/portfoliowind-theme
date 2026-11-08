<?php
/**
 * Template Part: Blog Section (Front Page)
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$blog_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
) );

if ( ! $blog_query->have_posts() ) {
	return;
}
?>
<section id="blog" class="py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
	<div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
		<!-- Section Header -->
		<div class="text-center max-w-3xl mx-auto mb-12">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
				<?php esc_html_e( 'From the Blog', 'portfoliowind' ); ?>
			</span>
			<h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( 'Latest Articles & Insights', 'portfoliowind' ); ?>
			</h2>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-4"></div>
			<p class="text-base text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'Writing about software architecture, modern UI design, and developer experiences.', 'portfoliowind' ); ?>
			</p>
		</div>

		<!-- Blog Posts Grid (3 Columns) -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
			<?php
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post();
				$categories = get_the_category();
				$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Article', 'portfoliowind' );

				// Calculate approximate reading time
				$word_count = str_word_count( strip_tags( get_the_content() ) );
				$read_time  = max( 1, ceil( $word_count / 200 ) );
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio-blog-card bg-slate-50 dark:bg-slate-950 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between' ); ?>>
					<div>
						<!-- Thumbnail Image with Strict Uniform 220px Height & Solid Badge -->
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
							<!-- Meta: Date & Read Time -->
							<div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
								<span>&bull;</span>
								<span><?php echo esc_html( sprintf( __( '%d min read', 'portfoliowind' ), $read_time ) ); ?></span>
							</div>

							<!-- Title -->
							<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-2">
								<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
									<?php the_title(); ?>
								</a>
							</h3>

							<!-- Excerpt -->
							<p class="text-sm text-slate-600 dark:text-slate-400 mb-2 line-clamp-2 leading-relaxed">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
							</p>
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

		<!-- View All Articles CTA with Consistent Balanced Margin -->
		<div class="mt-10 sm:mt-12 text-center">
			<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="theme-btn-secondary inline-flex items-center gap-2 shadow-sm">
				<span><?php esc_html_e( 'View All Articles & Tutorials', 'portfoliowind' ); ?></span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
				</svg>
			</a>
		</div>
	</div>
</section>
