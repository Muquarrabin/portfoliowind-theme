<?php
/**
 * Tab: Contact & Socials
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="tab-contact" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Contact Info & Social Networks', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Provide direct methods for visitors, recruiters, and clients to contact and follow you.', 'portfoliowind' ); ?></p>

	<div class="form-group" style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:10px; padding:14px 16px; margin-bottom:20px; width:100%; box-sizing:border-box;">
		<label style="display:flex; align-items:center; gap:10px; cursor:pointer; font-weight:600; color:#0f172a;">
			<input type="checkbox" name="portfolio_options[hide_contact_info]" value="1" <?php checked( ! empty( $options['hide_contact_info'] ) ); ?>>
			<?php esc_html_e( 'Hide Contact Information Card (Upwork & Marketplace Compliance Mode)', 'portfoliowind' ); ?>
		</label>
		<p class="description" style="margin-top:6px; margin-left:26px; color:#64748b; font-size:12px; line-height:1.5;">
			<?php esc_html_e( 'Check this box to hide the direct email, phone, location, and contact information card from both the Home page and the Contact Us page. The contact message form will remain active and cleanly centered.', 'portfoliowind' ); ?>
		</p>
	</div>

	<div class="form-row-2">
		<div class="form-group">
			<label for="contact_email"><?php esc_html_e( 'Direct Email Address', 'portfoliowind' ); ?></label>
			<input type="email" id="contact_email" name="portfolio_options[contact_email]" value="<?php echo esc_attr( $options['contact_email'] ?? '' ); ?>">
		</div>
		<div class="form-group">
			<label for="contact_phone"><?php esc_html_e( 'Phone Number (Optional)', 'portfoliowind' ); ?></label>
			<input type="text" id="contact_phone" name="portfolio_options[contact_phone]" value="<?php echo esc_attr( $options['contact_phone'] ?? '' ); ?>">
		</div>
	</div>

	<div class="form-row-2">
		<div class="form-group">
			<label for="contact_location"><?php esc_html_e( 'Location / City, Country', 'portfoliowind' ); ?></label>
			<input type="text" id="contact_location" name="portfolio_options[contact_location]" value="<?php echo esc_attr( $options['contact_location'] ?? '' ); ?>" placeholder="e.g. San Francisco, CA (Remote)">
		</div>
		<div class="form-group">
			<label for="contact_badge"><?php esc_html_e( 'Availability Status Badge', 'portfoliowind' ); ?></label>
			<input type="text" id="contact_badge" name="portfolio_options[contact_badge]" value="<?php echo esc_attr( $options['contact_badge'] ?? 'Available for Freelance & Projects' ); ?>">
		</div>
	</div>

	<div class="form-group">
		<label for="contact_form_shortcode"><?php esc_html_e( 'Fluent Forms Shortcode', 'portfoliowind' ); ?></label>
		<input type="text" id="contact_form_shortcode" name="portfolio_options[contact_form_shortcode]" value="<?php echo esc_attr( $options['contact_form_shortcode'] ?? '' ); ?>" placeholder='e.g. [fluentform id="1"]'>
		<p class="description"><?php esc_html_e( 'Enter your Fluent Forms shortcode here to render it in the contact section. (WPForms or any standard form shortcode also works).', 'portfoliowind' ); ?></p>
	</div>

	<h3 style="margin-top:24px; margin-bottom:12px; font-size:15px; color:#334155;"><?php esc_html_e( 'Social Network Profiles', 'portfoliowind' ); ?></h3>

	<div class="form-group">
		<label><?php esc_html_e( 'GitHub Profile URL', 'portfoliowind' ); ?></label>
		<input type="text" name="portfolio_options[social_github]" value="<?php echo esc_attr( $options['social_github'] ?? '#' ); ?>" placeholder="#">
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'LinkedIn Profile URL', 'portfoliowind' ); ?></label>
		<input type="text" name="portfolio_options[social_linkedin]" value="<?php echo esc_attr( $options['social_linkedin'] ?? '#' ); ?>" placeholder="#">
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'X / Twitter Profile URL', 'portfoliowind' ); ?></label>
		<input type="text" name="portfolio_options[social_twitter]" value="<?php echo esc_attr( $options['social_twitter'] ?? '#' ); ?>" placeholder="#">
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'Dribbble Profile URL', 'portfoliowind' ); ?></label>
		<input type="text" name="portfolio_options[social_dribbble]" value="<?php echo esc_attr( $options['social_dribbble'] ?? '#' ); ?>" placeholder="#">
	</div>

	<div class="form-group">
		<label><?php esc_html_e( 'Instagram Profile URL', 'portfoliowind' ); ?></label>
		<input type="text" name="portfolio_options[social_instagram]" value="<?php echo esc_attr( $options['social_instagram'] ?? '#' ); ?>" placeholder="#">
	</div>
</div>
