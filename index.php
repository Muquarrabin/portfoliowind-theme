<?php
/**
 * The main template file (Blog / Archives fallback)
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="max-w-7xl mx-auto px-4 py-16">
	<header class="mb-12 text-center">
		<h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-2">
			<?php single_post_title(); ?>
		</h1>
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
							<div class="rounded-xl overflow-hidden mb-4 h-48 bg-slate-100">
								<?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( is_sticky() && ! is_paged() ) : ?>
							<span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2.5 py-0.5 rounded-full mb-2">
								<svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
								<?php esc_html_e( 'Featured', 'portfoliowind' ); ?>
							</span>
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
			<p><?php esc_html_e( 'No posts found.', 'portfoliowind' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
