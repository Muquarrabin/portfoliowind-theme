<?php
/**
 * Tab: Hero & Bio
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-hero" class="portfolio-tab-pane active">
	<h2><?php esc_html_e( 'Hero & Introduction Section', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Configure the primary hero headline, profile avatar, and primary action buttons.', 'portfoliowind' ); ?></p>

	<div class="form-group">
		<label for="hero_name"><?php esc_html_e( 'Full Name / Brand Title', 'portfoliowind' ); ?></label>
		<input type="text" id="hero_name" name="portfolio_options[hero_name]" value="<?php echo esc_attr( $options['hero_name'] ?? '' ); ?>" placeholder="e.g. Alex Morgan">
	</div>

	<div class="form-group">
		<label for="hero_tagline"><?php esc_html_e( 'Professional Title / Tagline', 'portfoliowind' ); ?></label>
		<input type="text" id="hero_tagline" name="portfolio_options[hero_tagline]" value="<?php echo esc_attr( $options['hero_tagline'] ?? '' ); ?>" placeholder="e.g. Full-Stack Engineer & Product Designer">
	</div>

	<div class="form-group">
		<label for="hero_bio"><?php esc_html_e( 'Hero Short Bio', 'portfoliowind' ); ?></label>
		<textarea id="hero_bio" name="portfolio_options[hero_bio]" rows="3" placeholder="<?php esc_attr_e( 'Brief punchy introduction paragraph...', 'portfoliowind' ); ?>"><?php echo esc_textarea( $options['hero_bio'] ?? '' ); ?></textarea>
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'Profile Photo / Avatar', 'portfoliowind' ); ?></label>
		<div class="studio-upload-group" style="display:flex; gap:10px; width:100%;">
			<input type="text" id="hero_avatar" name="portfolio_options[hero_avatar]" value="<?php echo esc_url( $options['hero_avatar'] ?? '' ); ?>" placeholder="https://..." style="flex:1;">
			<button type="button" class="button upload-media-btn" data-target-input="#hero_avatar" data-preview="#hero-avatar-preview">
				<?php esc_html_e( 'Upload Avatar', 'portfoliowind' ); ?>
			</button>
		</div>
		<div id="hero-avatar-preview" class="media-preview-box">
			<?php if ( ! empty( $options['hero_avatar'] ) ) : ?>
				<img src="<?php echo esc_url( $options['hero_avatar'] ); ?>" alt="Avatar Preview">
			<?php endif; ?>
		</div>
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'Resume / CV File (PDF URL)', 'portfoliowind' ); ?></label>
		<div class="studio-upload-group" style="display:flex; gap:10px; width:100%;">
			<input type="text" id="hero_cv_url" name="portfolio_options[hero_cv_url]" value="<?php echo esc_url( $options['hero_cv_url'] ?? '' ); ?>" placeholder="https://..." style="flex:1;">
			<button type="button" class="button upload-media-btn" data-target-input="#hero_cv_url" data-title="<?php esc_attr_e( 'Select Resume PDF', 'portfoliowind' ); ?>">
				<?php esc_html_e( 'Upload PDF', 'portfoliowind' ); ?>
			</button>
		</div>
		<p class="description"><?php esc_html_e( 'Adds a "Download CV" button next to your primary CTA.', 'portfoliowind' ); ?></p>
	</div>

	<div class="form-row-2">
		<div class="form-group">
			<label for="hero_cta_text"><?php esc_html_e( 'Primary Button Text', 'portfoliowind' ); ?></label>
			<input type="text" id="hero_cta_text" name="portfolio_options[hero_cta_text]" value="<?php echo esc_attr( $options['hero_cta_text'] ?? 'Get in Touch' ); ?>">
		</div>
		<div class="form-group">
			<label for="hero_cta_url"><?php esc_html_e( 'Primary Button URL / Hash', 'portfoliowind' ); ?></label>
			<input type="text" id="hero_cta_url" name="portfolio_options[hero_cta_url]" value="<?php echo esc_attr( $options['hero_cta_url'] ?? '#contact' ); ?>">
		</div>
	</div>
</div>
