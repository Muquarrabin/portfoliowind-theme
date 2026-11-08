<?php
/**
 * Tab: Buy Me a Coffee & License / Watermark
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_unlocked = portfolio_is_watermark_unlocked();
$is_pro      = portfolio_is_pro_license_unlocked();
$key_val     = $options['supporter_key'] ?? '';
?>
<div id="tab-license" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Theme Supporter & License Terms', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Support the free theme development, unlock footer watermark removal, or activate your professional developer license.', 'portfoliowind' ); ?></p>

	<!-- Tier Pricing Cards Grid -->
	<div class="license-tier-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
		
		<!-- Tier 1: Coffee Supporter ($3+) -->
		<div style="border: 2px solid #e2e8f0; border-radius: 14px; padding: 22px; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between;">
			<div>
				<div style="display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; background: #fef3c7; color: #b45309; text-transform: uppercase; margin-bottom: 12px;">
					☕ <?php esc_html_e( 'Optional Donation', 'portfoliowind' ); ?>
				</div>
				<h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">
					<?php esc_html_e( 'Coffee Supporter', 'portfoliowind' ); ?> <span style="color: #6366f1;">$3+</span>
				</h3>
				<p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
					<?php esc_html_e( 'Enjoying PortfolioWind? Buy me a coffee! Watermark removal is completely free for everyone, but your voluntary support helps fund ongoing open-source updates and new features.', 'portfoliowind' ); ?>
				</p>
			</div>
			<a href="https://nasifquarrab.gumroad.com/l/xummjn" target="_blank" rel="noopener noreferrer" class="coffee-btn" style="text-align: center; text-decoration: none; justify-content: center;">
				<span>☕ <?php esc_html_e( 'Donate $3+ Coffee', 'portfoliowind' ); ?></span>
			</a>
		</div>

		<!-- Tier 2: Pro Developer License ($10+ Minimum) -->
		<div style="border: 2px solid #6366f1; border-radius: 14px; padding: 22px; background: #fdfdfe; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
			<div style="position: absolute; top: -11px; right: 20px; background: #6366f1; color: #ffffff; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 9999px; text-transform: uppercase;">
				<?php esc_html_e( 'Add Your Own Watermark', 'portfoliowind' ); ?>
			</div>
			<div>
				<div style="display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; background: #e0e7ff; color: #4338ca; text-transform: uppercase; margin-bottom: 12px;">
					⚡ <?php esc_html_e( 'Agency Branding & Custom Watermark', 'portfoliowind' ); ?>
				</div>
				<h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">
					<?php esc_html_e( 'Pro Developer License', 'portfoliowind' ); ?> <span style="color: #6366f1;">$10+ <?php esc_html_e( 'Minimum', 'portfoliowind' ); ?></span>
				</h3>
				<p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
					<?php esc_html_e( 'For developers and agencies delivering client projects. Unlock the ability to display YOUR custom agency watermark ("Theme customized by [Your Name / Agency]") in the footer!', 'portfoliowind' ); ?>
				</p>
			</div>
			<a href="https://nasifquarrab.gumroad.com/l/xummjn" target="_blank" rel="noopener noreferrer" class="coffee-btn" style="text-align: center; text-decoration: none; justify-content: center; background: #6366f1;">
				<span>⚡ <?php esc_html_e( 'Get $10+ Pro Developer Key', 'portfoliowind' ); ?></span>
			</a>
		</div>

	</div>

	<!-- Edge Case & Upgrade Policy Info Box -->
	<div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 10px; padding: 18px 20px; margin-bottom: 24px; font-size: 13px; color: #334155; line-height: 1.6;">
		<strong style="color: #0f172a; display: block; font-size: 14px; margin-bottom: 8px;">📌 <?php esc_html_e( 'Attribution Rights by License Tier:', 'portfoliowind' ); ?></strong>
		<ul style="margin: 0; padding-left: 20px; list-style-type: disc;">
			<li style="margin-bottom: 6px;">
				<strong><?php esc_html_e( 'Free for Everyone ($0):', 'portfoliowind' ); ?></strong> 
				<?php esc_html_e( 'Anyone can freely remove the theme author watermark in the footer by checking the box below. No payment or license key required!', 'portfoliowind' ); ?>
			</li>
			<li style="margin-bottom: 6px;">
				<strong><?php esc_html_e( 'Coffee Supporter ($3+):', 'portfoliowind' ); ?></strong> 
				<?php esc_html_e( 'A voluntary donation to support open-source maintenance and future releases.', 'portfoliowind' ); ?>
			</li>
			<li style="margin-bottom: 6px;">
				<strong><?php esc_html_e( 'Pro Developer ($10+):', 'portfoliowind' ); ?></strong> 
				<?php esc_html_e( 'Unlocks adding YOUR name or agency watermark alone in the footer ("Theme customized by [Your Name / Agency]") with commercial client rights.', 'portfoliowind' ); ?>
			</li>
			<li>
				<strong><?php esc_html_e( 'Upgrading from $3 to $10?', 'portfoliowind' ); ?></strong> 
				<?php esc_html_e( 'If you donated $3 earlier and later paid $7 to upgrade, enter both license keys separated by a comma (e.g. ', 'portfoliowind' ); ?>
				<code style="background: #e2e8f0; color: #0f172a; padding: 2px 6px; border-radius: 4px; font-size: 12px;">KEY1, KEY2</code><?php esc_html_e( '). The system automatically sums both purchases ($3 + $7 = $10) and unlocks Pro Developer rights!', 'portfoliowind' ); ?>
			</li>
		</ul>
	</div>

	<?php
	// Perform verification for current entered key(s)
	$verification = ! empty( $key_val ) ? portfolio_verify_gumroad_license( $key_val ) : null;
	$is_valid_key = ! empty( $verification['valid'] );
	$is_pro_key   = ! empty( $verification['is_pro'] );
	?>

	<!-- Key Unlock Section -->
	<div class="form-group">
		<label for="supporter_key"><?php esc_html_e( 'Enter Your Gumroad License Key(s)', 'portfoliowind' ); ?></label>
		<input type="text" id="supporter_key" name="portfolio_options[supporter_key]" value="<?php echo esc_attr( $key_val ); ?>" placeholder="e.g. 6F0E4C97-B72A4E69-A11BF6C4-AF6517E7 (or: KEY1, KEY2 for upgrades)" style="font-family: monospace; font-size: 13px;">
		
		<div style="margin-top: 10px;">
			<?php if ( ! empty( $verification ) && $is_valid_key ) : ?>
				<?php if ( $is_pro_key ) : ?>
					<div style="background: #ecfdf5; border: 1px solid #10b981; border-radius: 8px; padding: 10px 14px; color: #065f46; font-size: 13px; line-height: 1.5;">
						<span style="font-weight: 700;">✓ <?php esc_html_e( 'Pro Developer License Verified!', 'portfoliowind' ); ?></span> 
						(<?php echo esc_html( sprintf( __( 'Total $%s USD paid across %d key(s)', 'portfoliowind' ), $verification['total_usd'], $verification['key_count'] ) ); ?>)<br>
						<span style="color: #047857; font-size: 12px;"><?php esc_html_e( 'Custom watermark unlocked! You can now display your name or agency alone in the footer.', 'portfoliowind' ); ?></span>
					</div>
				<?php else : ?>
					<div style="background: #fefce8; border: 1px solid #facc15; border-radius: 8px; padding: 10px 14px; color: #854d0e; font-size: 13px; line-height: 1.5;">
						<span style="font-weight: 700;">✓ <?php esc_html_e( 'Coffee Supporter Key Verified!', 'portfoliowind' ); ?></span> 
						(<?php echo esc_html( sprintf( __( 'Total $%s USD paid', 'portfoliowind' ), $verification['total_usd'] ) ); ?>)<br>
						<span style="color: #713f12; font-size: 12px;">
							<?php esc_html_e( 'Thank you for supporting PortfolioWind! (To unlock adding your own watermark/agency branding, upgrade to $10+ by topping up $7 on Gumroad and pasting both keys separated by a comma).', 'portfoliowind' ); ?>
						</span>
					</div>
				<?php endif; ?>
			<?php elseif ( ! empty( $key_val ) ) : ?>
				<div style="background: #fef2f2; border: 1px solid #f87171; border-radius: 8px; padding: 10px 14px; color: #991b1b; font-size: 13px;">
					<span style="font-weight: 700;">✕ <?php esc_html_e( 'Key Verification Failed', 'portfoliowind' ); ?></span> — 
					<?php esc_html_e( 'Please ensure you copied your key correctly from your Gumroad receipt email, or comma-separated multiple keys if upgrading.', 'portfoliowind' ); ?>
				</div>
			<?php else : ?>
				<p class="description" style="margin: 0; font-size: 12px; color: #64748b;">
					<?php esc_html_e( 'Purchased a $10+ Pro Developer License? Enter your key here to unlock custom watermark branding.', 'portfoliowind' ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>

	<!-- Watermark Removal Checkbox (100% Free for Everyone) -->
	<div class="form-group" style="margin-top:18px;">
		<label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
			<input type="checkbox" name="portfolio_options[hide_watermark]" value="1" <?php checked( ! empty( $options['hide_watermark'] ) ); ?>>
			<span style="font-weight: 600; color: #0f172a;"><?php esc_html_e( 'Hide Author Watermark in Footer', 'portfoliowind' ); ?></span>
		</label>
		<p class="description" style="margin: 4px 0 0 24px; font-size: 12px; color: #16a34a;">
			✓ <?php esc_html_e( 'Free for all users: Check this box to cleanly remove the author watermark from your website footer.', 'portfoliowind' ); ?>
		</p>
	</div>

	<hr style="border:none; border-top:1px solid #e2e8f0; margin:28px 0;">

	<!-- Custom Footer Copyright Line (Freely customizable by site owner) -->
	<div class="form-group" style="margin-top:20px;">
		<label for="site_copyright"><?php esc_html_e( 'Custom Footer Copyright Line', 'portfoliowind' ); ?></label>
		<input type="text" id="site_copyright" name="portfolio_options[site_copyright]" value="<?php echo esc_attr( $options['site_copyright'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Leave empty to use Site Title', 'portfoliowind' ); ?>">
		<p class="description"><?php esc_html_e( 'Customize the copyright text displayed at the bottom of every page (defaults to your Site Title).', 'portfoliowind' ); ?></p>
	</div>

	<hr style="border:none; border-top:1px solid #e2e8f0; margin:28px 0;">

	<!-- Customizer & Agency Attribution Credit ($10+ Pro Feature) -->
	<h3 style="font-size:16px; color:#1e293b; margin-bottom:8px; display:flex; align-items:center; gap:8px;">
		<span>⚡ <?php esc_html_e( 'Agency Branding & Custom Watermark', 'portfoliowind' ); ?></span>
		<?php if ( $is_pro_key ) : ?>
			<span style="background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; text-transform: uppercase;">
				<?php esc_html_e( 'Pro Unlocked', 'portfoliowind' ); ?>
			</span>
		<?php else : ?>
			<span style="background: #f1f5f9; color: #64748b; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; text-transform: uppercase;">
				<?php esc_html_e( 'Pro Feature', 'portfoliowind' ); ?>
			</span>
		<?php endif; ?>
	</h3>

	<?php if ( $is_pro_key ) : ?>
		<div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px; font-size: 13px; color: #065f46; line-height: 1.5;">
			⚡ <strong><?php esc_html_e( 'Pro Developer Rights Active:', 'portfoliowind' ); ?></strong>
			<?php esc_html_e( 'When enabled, your name or agency will be displayed as the custom watermark in the footer.', 'portfoliowind' ); ?><br>
			<span style="display: inline-block; margin-top: 4px; font-family: monospace; font-size: 12px; background: #ffffff; padding: 3px 8px; border-radius: 4px; border: 1px solid #6ee7b7;">
				<?php esc_html_e( 'Footer Output:', 'portfoliowind' ); ?> <strong>Theme customized by <?php echo esc_html( ! empty( $options['customizer_credit_name'] ) ? $options['customizer_credit_name'] : '[Your Name / Agency]' ); ?></strong>
			</span>
		</div>

		<div class="form-group">
			<label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
				<input type="checkbox" name="portfolio_options[customizer_credit]" value="1" <?php checked( ! empty( $options['customizer_credit'] ) ); ?>>
				<span style="font-weight: 600; color: #0f172a;"><?php esc_html_e( 'Display Your Custom Watermark in Footer', 'portfoliowind' ); ?></span>
			</label>
		</div>

		<div class="form-group" style="margin-top:14px;">
			<label for="customizer_credit_name"><?php esc_html_e( 'Your Name or Agency Name', 'portfoliowind' ); ?></label>
			<input type="text" id="customizer_credit_name" name="portfolio_options[customizer_credit_name]" value="<?php echo esc_attr( $options['customizer_credit_name'] ?? '' ); ?>" placeholder="e.g. John Doe / Apex Studios">
			<p class="description"><?php esc_html_e( 'Enter the person or agency name to display in the footer watermark.', 'portfoliowind' ); ?></p>
		</div>
	<?php else : ?>
		<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; margin-bottom: 14px; font-size: 13px; color: #475569; line-height: 1.6;">
			<div style="font-weight: 600; color: #1e293b; margin-bottom: 6px;">
				💼 <?php esc_html_e( 'Are you an agency or freelancer delivering client websites?', 'portfoliowind' ); ?>
			</div>
			<?php esc_html_e( 'The $10+ Pro Developer License allows you to add your custom white-label branding alone in the footer ("Theme customized by [Your Name / Agency]") with commercial rights.', 'portfoliowind' ); ?>
			<div style="margin-top: 10px;">
				<a href="https://nasifquarrab.gumroad.com/l/xummjn" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; color: #4f46e5; text-decoration: none;">
					<span><?php esc_html_e( 'Buy Pro Developer License on Gumroad', 'portfoliowind' ); ?> &rarr;</span>
				</a>
			</div>
		</div>
	<?php endif; ?>
</div>
