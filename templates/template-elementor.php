<?php
/**
 * Template Name: Elementor Full Width
 * Template Post Type: post, page, portfoliowind_proj, portfolio_project
 *
 * Blank full-width template designed specifically for Elementor page builders.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div class="elementor-canvas-wrapper w-full">
	<?php
	while ( have_posts() ) :
		the_post();
		the_content();
	endwhile;
	?>
</div>

<?php
get_footer();
