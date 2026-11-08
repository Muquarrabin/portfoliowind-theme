<?php
/**
 * The template for displaying all single posts
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$categories = get_the_category();
	$cat_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Article', 'portfoliowind' );
	$cat_id     = ! empty( $categories ) ? $categories[0]->term_id : 0;

	// Calculate read time
	$word_count = str_word_count( strip_tags( get_the_content() ) );
	$read_time  = max( 1, ceil( $word_count / 200 ) );

	// Author presentation
	$author_id   = get_the_author_meta( 'ID' );
	$author_name = get_the_author_meta( 'display_name' );
	if ( empty( $author_name ) || 'admin' === strtolower( $author_name ) ) {
		$author_name = 'Nasif Muquarrabin';
	}
	$author_bio    = get_the_author_meta( 'description' );
	if ( empty( $author_bio ) ) {
		$author_bio = __( 'Full-stack software engineer and architect specializing in high-performance WordPress themes, modern UI engineering, and web performance optimization.', 'portfoliowind' );
	}
	$author_avatar = portfolio_get_option( 'hero_avatar', '' );
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'max-w-4xl mx-auto px-4 py-12 md:py-20' ); ?>>
		
		<!-- Article Header -->
		<header class="mb-12 text-center max-w-3xl mx-auto">
			<div class="flex items-center justify-center gap-3 mb-4">
				<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary">
					<?php echo esc_html( $cat_name ); ?>
				</span>
				<span class="text-xs text-slate-400">&bull;</span>
				<span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
					<?php echo esc_html( get_the_date() ); ?>
				</span>
				<span class="text-xs text-slate-400">&bull;</span>
				<span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">
					<?php echo esc_html( sprintf( __( '%d min read', 'portfoliowind' ), $read_time ) ); ?>
				</span>
			</div>

			<h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
				<?php the_title(); ?>
			</h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto">
					<?php echo esc_html( get_the_excerpt() ); ?>
				</p>
			<?php endif; ?>
		</header>

		<!-- Featured Cover Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="w-full rounded-3xl overflow-hidden mb-16 shadow-xl border border-slate-200/80 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 max-h-[520px]">
				<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full max-h-[520px] object-cover' ) ); ?>
			</div>
		<?php endif; ?>

		<!-- Article Body -->
		<div class="prose prose-slate dark:prose-invert max-w-none text-base sm:text-lg leading-relaxed text-slate-700 dark:text-slate-300 space-y-6">
			<?php the_content(); ?>
			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links mt-8 pt-4 border-t border-slate-200 dark:border-slate-800 font-semibold"><span class="mr-2 text-slate-500">' . esc_html__( 'Pages:', 'portfoliowind' ) . '</span>',
					'after'  => '</div>',
				)
			);
			?>
		</div>

		<?php if ( has_tag() ) : ?>
			<div class="mt-8 pt-6 border-t border-slate-200/80 dark:border-slate-800 flex flex-wrap items-center gap-2">
				<span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2"><?php esc_html_e( 'Tags:', 'portfoliowind' ); ?></span>
				<?php the_tags( '<span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">', '</span><span class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">', '</span>' ); ?>
			</div>
		<?php endif; ?>

		<!-- Polished Author Bio Card (Strictly Left-Aligned) -->
		<div class="my-20 p-8 sm:p-10 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-md flex flex-col sm:flex-row items-start gap-6 text-left">
			<!-- Author Avatar Ring -->
			<div class="w-20 h-20 rounded-full p-[2px] bg-gradient-to-tr from-primary to-indigo-500/70 flex-shrink-0 shadow-sm">
				<div class="w-full h-full rounded-full overflow-hidden bg-slate-100 dark:bg-slate-800">
					<?php if ( ! empty( $author_avatar ) ) : ?>
						<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="w-full h-full object-cover">
					<?php else : ?>
						<?php echo get_avatar( $author_id, 80, '', $author_name, array( 'class' => 'w-full h-full object-cover' ) ); ?>
					<?php endif; ?>
				</div>
			</div>
			<!-- Author Details -->
			<div class="flex-1 text-left">
				<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-2">
					<?php esc_html_e( 'Article Author', 'portfoliowind' ); ?>
				</span>
				<h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">
					<?php echo esc_html( $author_name ); ?>
				</h3>
				<p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
					<?php echo esc_html( $author_bio ); ?>
				</p>
				<div class="flex flex-wrap items-center justify-start gap-4 text-xs font-semibold text-primary">
					<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:underline flex items-center gap-1">
						<span><?php esc_html_e( 'View All Posts', 'portfoliowind' ); ?></span>
						<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
					</a>
					<span>&bull;</span>
					<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:underline flex items-center gap-1">
						<span><?php esc_html_e( 'Get In Touch', 'portfoliowind' ); ?></span>
					</a>
				</div>
			</div>
		</div>

		<!-- Post Navigation (Previous / Next Article) -->
		<?php
		the_post_navigation(
			array(
				'prev_text' => '<span class="text-xs uppercase tracking-wider text-slate-400 block mb-1">&larr; ' . esc_html__( 'Previous Article', 'portfoliowind' ) . '</span><span class="text-sm font-semibold hover:text-primary transition-colors line-clamp-1">%title</span>',
				'next_text' => '<span class="text-xs uppercase tracking-wider text-slate-400 block mb-1 text-right">' . esc_html__( 'Next Article', 'portfoliowind' ) . ' &rarr;</span><span class="text-sm font-semibold hover:text-primary transition-colors line-clamp-1">%title</span>',
			)
		);
		?>

		<!-- Category-Aware "More Articles in [Category]" Section with Generous Margins -->
		<?php
		$related_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => array( get_the_ID() ),
		);

		if ( $cat_id ) {
			$related_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $cat_id,
				),
			);
		}

		$related_query = new WP_Query( $related_args );

		// Only render if other articles exist in this category!
		if ( $related_query->have_posts() ) :
			?>
			<div class="mt-20 pt-16 border-t border-slate-200 dark:border-slate-800 mb-20 text-left">
				<div class="mb-10 text-left">
					<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
						<?php echo esc_html( $cat_name ); ?>
					</span>
					<h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
						<?php echo esc_html( sprintf( __( 'More Articles in %s', 'portfoliowind' ), $cat_name ) ); ?>
					</h3>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
					<?php
					while ( $related_query->have_posts() ) :
						$related_query->the_post();
						$rel_categories = get_the_category();
						$rel_cat_name   = ! empty( $rel_categories ) ? $rel_categories[0]->name : $cat_name;
						$rel_words      = str_word_count( strip_tags( get_the_content() ) );
						$rel_read_time  = max( 1, ceil( $rel_words / 200 ) );
						?>
						<article id="post-<?php the_ID(); ?>" class="portfolio-blog-card bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
							<div>
								<!-- Thumbnail with Strict Uniform 220px Height & Elegant Badge -->
								<a href="<?php the_permalink(); ?>" class="blog-card-thumb block group">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
									<?php else : ?>
										<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-indigo-500/10 text-primary">
											<svg class="w-10 h-10 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
										</div>
									<?php endif; ?>
									<!-- Clean High-Contrast Pill -->
									<span class="absolute top-3.5 right-3.5 px-3 py-1 text-xs font-semibold rounded-full bg-white dark:bg-slate-900 text-primary border border-slate-200/80 dark:border-slate-700 shadow-sm">
										<?php echo esc_html( $rel_cat_name ); ?>
									</span>
								</a>

								<!-- Content Area -->
								<div class="p-6">
									<div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
										<span><?php echo esc_html( get_the_date() ); ?></span>
										<span>&bull;</span>
										<span><?php echo esc_html( sprintf( __( '%d min read', 'portfoliowind' ), $rel_read_time ) ); ?></span>
									</div>
									<h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2 leading-snug line-clamp-2">
										<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
											<?php the_title(); ?>
										</a>
									</h4>
									<p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 leading-relaxed">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?>
									</p>
								</div>
							</div>

							<!-- Action Footer with Balanced Typography & Margins -->
							<div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-sm bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
								<a href="<?php the_permalink(); ?>" class="font-medium text-primary hover:text-primary-hover inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white transition-all duration-200 text-xs sm:text-sm">
									<span><?php esc_html_e( 'Read Article', 'portfoliowind' ); ?></span>
									<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
								</a>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
		endif;
		?>

		<!-- WordPress Comments Section -->
		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>

	</article>

	<?php
endwhile;

get_footer();
