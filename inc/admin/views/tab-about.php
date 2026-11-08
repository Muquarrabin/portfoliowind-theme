<?php
/**
 * Tab: About & Skills
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-about" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'About Me & Tech Stack / Skills', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Introduce yourself in detail, share key professional stats, and showcase your skill proficiency.', 'portfoliowind' ); ?></p>

	<div class="form-group">
		<label for="about_heading"><?php esc_html_e( 'Section Heading', 'portfoliowind' ); ?></label>
		<input type="text" id="about_heading" name="portfolio_options[about_heading]" value="<?php echo esc_attr( $options['about_heading'] ?? 'About Me' ); ?>">
	</div>

	<div class="form-group">
		<label for="about_bio"><?php esc_html_e( 'Extended Professional Biography', 'portfoliowind' ); ?></label>
		<textarea id="about_bio" name="portfolio_options[about_bio]" rows="5" placeholder="<?php esc_attr_e( 'Share your journey, design philosophy, and what problems you solve...', 'portfoliowind' ); ?>"><?php echo esc_textarea( $options['about_bio'] ?? '' ); ?></textarea>
	</div>

	<h3 style="margin-top:24px; margin-bottom:12px; font-size:15px; color:#334155;"><?php esc_html_e( 'Key Performance Stats', 'portfoliowind' ); ?></h3>
	<div class="form-row-3">
		<div class="form-group">
			<label><?php esc_html_e( 'Years Experience', 'portfoliowind' ); ?></label>
			<input type="text" name="portfolio_options[stat_years]" value="<?php echo esc_attr( $options['stat_years'] ?? '5+' ); ?>" placeholder="5+">
		</div>
		<div class="form-group">
			<label><?php esc_html_e( 'Projects Completed', 'portfoliowind' ); ?></label>
			<input type="text" name="portfolio_options[stat_projects]" value="<?php echo esc_attr( $options['stat_projects'] ?? '40+' ); ?>" placeholder="40+">
		</div>
		<div class="form-group">
			<label><?php esc_html_e( 'Happy Clients', 'portfoliowind' ); ?></label>
			<input type="text" name="portfolio_options[stat_clients]" value="<?php echo esc_attr( $options['stat_clients'] ?? '30+' ); ?>" placeholder="30+">
		</div>
	</div>

	<h3 style="margin-top:24px; margin-bottom:12px; font-size:15px; color:#334155;"><?php esc_html_e( 'Skills & Proficiency Bars', 'portfoliowind' ); ?></h3>
	<div id="skills-container" class="repeater-container">
		<?php
		$skills = $options['skills'] ?? array();
		if ( ! empty( $skills ) ) :
			foreach ( $skills as $idx => $skill ) :
				?>
				<div class="repeater-item">
					<div class="repeater-item-header">
						<h4><?php echo esc_html( sprintf( __( 'Skill #%d', 'portfoliowind' ), $idx + 1 ) ); ?></h4>
						<button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> <?php esc_html_e( 'Remove', 'portfoliowind' ); ?></button>
					</div>
					<div class="repeater-row" style="margin-bottom:0;">
						<div class="repeater-col flex-2">
							<label><?php esc_html_e( 'Skill Name', 'portfoliowind' ); ?></label>
							<input type="text" name="portfolio_options[skills][<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $skill['name'] ); ?>" placeholder="e.g. WordPress, React, Figma">
						</div>
						<div class="repeater-col flex-1">
							<label><?php esc_html_e( 'Proficiency (0-100%)', 'portfoliowind' ); ?></label>
							<input type="number" min="1" max="100" name="portfolio_options[skills][<?php echo esc_attr( $idx ); ?>][percent]" value="<?php echo esc_attr( $skill['percent'] ); ?>" placeholder="90">
						</div>
					</div>
				</div>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<button type="button" id="add-skill-btn" class="add-repeater-btn">
		<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Another Skill', 'portfoliowind' ); ?>
	</button>
</div>
