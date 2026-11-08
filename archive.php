<?php
/**
 * The template for displaying archive pages (Category, Tag, Author, Date)
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="max-w-7xl mx-auto px-4 py-16">
	<header class="mb-12 text-center max-w-3xl mx-auto">
		<?php
		the_archive_title( '<h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3">', '</h1>' );
		the_archive_description( '<div class="text-sm sm:text-base text-slate-600 dark:text-slate-400 leading-relaxed mb-4">', '</div>' );
		?>
		<div class="w-12 h-1 bg-primary mx-auto rounded-full"></div>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow' ); ?>>
					<div>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="rounded-xl overflow-hidden mb-4 h-48 bg-slate-100 dark:bg-slate-800">
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
							</div>
						<?php endif; ?>

						<div class="text-xs text-slate-400 mb-2">
							<?php echo get_the_date(); ?>
						</div>

						<h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3 leading-snug">
							<a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
								<?php
								if ( get_the_title() ) {
									the_title();
								} else {
									esc_html_e( '(Untitled)', 'portfoliowind' );
								}
								?>
							</a>
						</h2>

						<div class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed line-clamp-3">
							<?php the_excerpt(); ?>
						</div>
					</div>

					<a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
						<span><?php esc_html_e( 'Read More', 'portfoliowind' ); ?></span>
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
						</svg>
					</a>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<div class="mt-12 text-center">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<div class="text-center py-12 text-slate-500">
			<p><?php esc_html_e( 'No posts found in this archive.', 'portfoliowind' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
