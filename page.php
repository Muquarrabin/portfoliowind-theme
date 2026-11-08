<?php
/**
 * The template for displaying all regular pages
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="max-w-4xl mx-auto px-4 py-16">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<header class="mb-10 text-center">
			<h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php the_title(); ?>
			</h1>
			<div class="w-12 h-1 bg-primary mx-auto rounded-full"></div>
		</header>

		<div class="text-slate-700 dark:text-slate-300 leading-relaxed space-y-6">
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

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
		<?php
	endwhile;
	?>
</div>

<?php
get_footer();
