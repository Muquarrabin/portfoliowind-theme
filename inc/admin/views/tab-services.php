<?php
/**
 * Tab: Services
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-services" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Services & Offerings', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Display your service cards highlighting what you provide for clients or employers.', 'portfoliowind' ); ?></p>

	<div id="services-container" class="repeater-container">
		<?php
		$services = $options['services'] ?? array();
		if ( ! empty( $services ) ) :
			foreach ( $services as $idx => $svc ) :
				?>
				<div class="repeater-item">
					<div class="repeater-item-header">
						<h4><?php echo esc_html( sprintf( __( 'Service #%d', 'portfoliowind' ), $idx + 1 ) ); ?></h4>
						<button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> <?php esc_html_e( 'Remove', 'portfoliowind' ); ?></button>
					</div>
					<div class="form-group">
						<label><?php esc_html_e( 'Service Title', 'portfoliowind' ); ?></label>
						<input type="text" name="portfolio_options[services][<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $svc['title'] ); ?>" placeholder="e.g. Web Development" style="width:100%;">
					</div>
					<div class="form-group">
						<label><?php esc_html_e( 'Dashicon Class (e.g. dashicons-laptop, dashicons-layout, dashicons-smartphone)', 'portfoliowind' ); ?></label>
						<input type="text" name="portfolio_options[services][<?php echo esc_attr( $idx ); ?>][icon]" value="<?php echo esc_attr( $svc['icon'] ?? 'dashicons-laptop' ); ?>" style="width:100%;">
					</div>
					<div class="form-group">
						<label><?php esc_html_e( 'Service Description', 'portfoliowind' ); ?></label>
						<textarea name="portfolio_options[services][<?php echo esc_attr( $idx ); ?>][desc]" rows="2" style="width:100%;"><?php echo esc_textarea( $svc['desc'] ?? '' ); ?></textarea>
					</div>
				</div>
				<?php
			endforeach;
		endif;
		?>
	</div>
	<button type="button" id="add-service-btn" class="add-repeater-btn">
		<span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Add Service Card', 'portfoliowind' ); ?>
	</button>
</div>
