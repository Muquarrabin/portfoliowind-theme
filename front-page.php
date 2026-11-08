<?php
/**
 * The Front Page Template
 * Automatically renders Elementor visual builder if active,
 * or standard PortfolioWind Studio sections.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$is_elementor_page = false;
if ( class_exists( '\Elementor\Plugin' ) && get_the_ID() ) {
	$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
	if ( $document && $document->is_built_with_elementor() ) {
		$is_elementor_page = true;
	}
}

if ( $is_elementor_page ) {
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
} else {
	// Default: render PortfolioWind Studio sections
	get_template_part( 'template-parts/section', 'hero' );
	get_template_part( 'template-parts/section', 'about' );
	get_template_part( 'template-parts/section', 'services' );
	get_template_part( 'template-parts/section', 'projects' );
	get_template_part( 'template-parts/section', 'resume' );
	get_template_part( 'template-parts/section', 'blog' );
	get_template_part( 'template-parts/section', 'contact' );
}

get_footer();
