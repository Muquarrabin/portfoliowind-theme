<?php
/**
 * Tab: Resume & Timeline
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-resume" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Resume & Career Timeline', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Chronicle your work history, education, and notable career achievements.', 'portfoliowind' ); ?></p>

	<div id="resume-container" class="repeater-container">
		<?php
		$resume = $options['resume'] ?? array();
		if ( ! empty( $resume ) ) :
			foreach ( $resume as $idx => $item ) :
				?>
				<div class="repeater-item">
					<div class="repeater-item-header">
						<h4><?php echo esc_html( sprintf( __( 'Milestone #%d: %s', 'portfoliowind' ), $idx + 1, $item['role'] ) ); ?></h4>
						<button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> <?php esc_html_e( 'Remove', 'portfoliowind' ); ?></button>
					</div>
					<div class="repeater-row">
						<div class="repeater-col flex-1">
							<label><?php esc_html_e( 'Type', 'portfoliowind' ); ?></label>
							<select name="portfolio_options[resume][<?php echo esc_attr( $idx ); ?>][type]">
								<option value="experience" <?php selected( $item['type'] ?? '', 'experience' ); ?>><?php esc_html_e( 'Experience / Work', 'portfoliowind' ); ?></option>
								<option value="education" <?php selected( $item['type'] ?? '', 'education' ); ?>><?php esc_html_e( 'Education', 'portfoliowind' ); ?></option>
							</select>
						</div>
						<div class="repeater-col flex-2">
							<label><?php esc_html_e( 'Role / Degree', 'portfoliowind' ); ?></label>
							<input type="text" name="portfolio_options[resume][<?php echo esc_attr( $idx ); ?>][role]" value="<?php echo esc_attr( $item['role'] ); ?>" placeholder="e.g. Senior Frontend Engineer">
						</div>
					</div>
					<div class="repeater-row">
						<div class="repeater-col flex-2">
							<label><?php esc_html_e( 'Company / University', 'portfoliowind' ); ?></label>
							<input type="text" name="portfolio_options[resume][<?php echo esc_attr( $idx ); ?>][company]" value="<?php echo esc_attr( $item['company'] ?? '' ); ?>" placeholder="e.g. Automattic Inc.">
						</div>
						<div class="repeater-col flex-1">
							<label><?php esc_html_e( 'Years / Period', 'portfoliowind' ); ?></label>
							<input type="text" name="portfolio_options[resume][<?php echo esc_attr( $idx ); ?>][period]" value="<?php echo esc_attr( $item['period'] ?? '' ); ?>" placeholder="2022 - Present">
						</div>
					</div>
					<div class="form-group" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Description / Achievements', 'portfoliowind' ); ?></label>
						<textarea name="portfolio_options[resume][<?php echo esc_attr( $idx ); ?>][desc]" rows="2"><?php echo esc_textarea( $item['desc'] ?? '' ); ?></textarea>
					</div>
				</div>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<button type="button" id="add-resume-btn" class="add-repeater-btn">
		<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Career Milestone', 'portfoliowind' ); ?>
	</button>
</div>
