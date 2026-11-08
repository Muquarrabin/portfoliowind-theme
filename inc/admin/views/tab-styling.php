<?php
/**
 * Tab: Theme Colors & Styling
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_primary = sanitize_hex_color( $options['primary_color'] ?? '#6366f1' ) ?: '#6366f1';
$current_hover   = sanitize_hex_color( $options['primary_hover'] ?? '#4f46e5' ) ?: '#4f46e5';

$color_presets = array(
	array(
		'name'    => __( 'Indigo Bloom', 'portfoliowind' ),
		'primary' => '#6366f1',
		'hover'   => '#4f46e5',
		'id'      => 'indigo',
		'is_def'  => true,
	),
	array(
		'name'    => __( 'Ocean Sapphire', 'portfoliowind' ),
		'primary' => '#0284c7',
		'hover'   => '#0369a1',
		'id'      => 'ocean',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Emerald Forest', 'portfoliowind' ),
		'primary' => '#10b981',
		'hover'   => '#059669',
		'id'      => 'emerald',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Electric Violet', 'portfoliowind' ),
		'primary' => '#8b5cf6',
		'hover'   => '#7c3aed',
		'id'      => 'violet',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Rose Crimson', 'portfoliowind' ),
		'primary' => '#f43f5e',
		'hover'   => '#e11d48',
		'id'      => 'rose',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Sunset Amber', 'portfoliowind' ),
		'primary' => '#f59e0b',
		'hover'   => '#d97706',
		'id'      => 'amber',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Nordic Teal', 'portfoliowind' ),
		'primary' => '#0d9488',
		'hover'   => '#0f766e',
		'id'      => 'teal',
		'is_def'  => false,
	),
	array(
		'name'    => __( 'Minimal Slate', 'portfoliowind' ),
		'primary' => '#334155',
		'hover'   => '#1e293b',
		'id'      => 'slate',
		'is_def'  => false,
	),
);
?>
<div id="tab-styling" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Theme Colors & Brand Palette', 'portfoliowind' ); ?></h2>
	<p class="tab-desc"><?php esc_html_e( 'Choose a curated 1-click theme color scheme or pick custom brand colors. The theme dynamically updates buttons, badges, category filters, active links, and focus rings.', 'portfoliowind' ); ?></p>

	<!-- 1. Curated 1-Click Color Presets -->
	<div class="color-presets-section">
		<h3 class="color-section-subtitle">
			<span class="dashicons dashicons-art" style="color:#6366f1;vertical-align:middle;margin-top:-2px;"></span>
			<?php esc_html_e( 'Curated 1-Click Color Schemes', 'portfoliowind' ); ?>
		</h3>
		<p class="color-section-hint"><?php esc_html_e( 'Click any color palette below to instantly apply harmonic primary and hover tones.', 'portfoliowind' ); ?></p>

		<div class="theme-color-presets-grid">
			<?php foreach ( $color_presets as $preset ) :
				$is_active = ( strtolower( $current_primary ) === strtolower( $preset['primary'] ) );
				?>
				<button type="button" 
					class="color-preset-card <?php echo $is_active ? 'is-active' : ''; ?>" 
					data-primary="<?php echo esc_attr( $preset['primary'] ); ?>" 
					data-hover="<?php echo esc_attr( $preset['hover'] ); ?>"
					title="<?php echo esc_attr( $preset['name'] ); ?>">
					<div class="preset-swatches">
						<span class="preset-dot primary-dot" style="background-color: <?php echo esc_attr( $preset['primary'] ); ?>;"></span>
						<span class="preset-dot hover-dot" style="background-color: <?php echo esc_attr( $preset['hover'] ); ?>;"></span>
					</div>
					<div class="preset-info">
						<span class="preset-name"><?php echo esc_html( $preset['name'] ); ?></span>
						<code class="preset-hex"><?php echo esc_html( $preset['primary'] ); ?></code>
					</div>
					<span class="preset-check-icon dashicons dashicons-yes"></span>
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<!-- 2. Interactive Color Pickers -->
	<div class="custom-pickers-section">
		<h3 class="color-section-subtitle">
			<span class="dashicons dashicons-color-picker" style="color:#6366f1;vertical-align:middle;margin-top:-2px;"></span>
			<?php esc_html_e( 'Custom Color Pickers', 'portfoliowind' ); ?>
		</h3>
		<p class="color-section-hint"><?php esc_html_e( 'Fine-tune exact brand colors with the WordPress visual color picker spectrum.', 'portfoliowind' ); ?></p>

		<div class="form-row-2">
			<div class="form-group color-picker-group">
				<label for="primary_color"><?php esc_html_e( 'Theme Accent / Primary Color', 'portfoliowind' ); ?></label>
				<div class="picker-input-wrap">
					<input type="text" 
						id="primary_color" 
						name="portfolio_options[primary_color]" 
						class="portfolio-color-picker" 
						value="<?php echo esc_attr( $current_primary ); ?>" 
						data-default-color="#6366f1">
				</div>
				<p class="description"><?php esc_html_e( 'Used for primary CTA buttons, badges, category filters, and brand highlights.', 'portfoliowind' ); ?></p>
			</div>

			<div class="form-group color-picker-group">
				<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 6px;">
					<label for="primary_hover" style="margin-bottom:0;"><?php esc_html_e( 'Primary Hover Shade', 'portfoliowind' ); ?></label>
					<div class="studio-tooltip-wrap">
						<button type="button" 
							id="btn-auto-hover" 
							class="button button-secondary button-small" 
							title="<?php esc_attr_e( 'Clicking this automatically calculates a harmonic 14% darker tone from your primary color.', 'portfoliowind' ); ?>"
							aria-label="<?php esc_attr_e( 'Automatically calculate harmonic 14% darker tone from primary color', 'portfoliowind' ); ?>"
							style="display:inline-flex; align-items:center; gap:4px; font-size:11.5px; height:26px; padding:0 8px;">
							<span class="dashicons dashicons-admin-generic" style="font-size:14px; width:14px; height:14px; vertical-align:middle; margin-top:-1px;"></span>
							<?php esc_html_e( 'Auto Hover', 'portfoliowind' ); ?>
							<span class="dashicons dashicons-editor-help" style="font-size:13px; width:13px; height:13px; opacity:0.65; vertical-align:middle; margin-left:1px;"></span>
						</button>
						<div class="studio-tooltip-bubble" role="tooltip">
							<?php esc_html_e( 'Clicking this automatically calculates a harmonic 14% darker tone from your primary color for button hover states.', 'portfoliowind' ); ?>
						</div>
					</div>
				</div>
				<div class="picker-input-wrap">
					<input type="text" 
						id="primary_hover" 
						name="portfolio_options[primary_hover]" 
						class="portfolio-color-picker" 
						value="<?php echo esc_attr( $current_hover ); ?>" 
						data-default-color="#4f46e5">
				</div>
				<p class="description"><?php esc_html_e( 'Darker tone for button hover and active interactive states.', 'portfoliowind' ); ?></p>
			</div>
		</div>
	</div>

	<!-- 3. Real-Time Live Component Preview -->
	<div class="theme-color-preview-section">
		<h3 class="color-section-subtitle">
			<span class="dashicons dashicons-visibility" style="color:#6366f1;vertical-align:middle;margin-top:-2px;"></span>
			<?php esc_html_e( 'Live Component Preview', 'portfoliowind' ); ?>
			<span id="preview-active-pill" class="preview-active-hex"><?php echo esc_html( strtoupper( $current_primary ) ); ?></span>
		</h3>
		<p class="color-section-hint"><?php esc_html_e( 'Live preview of how your chosen color renders across front-end portfolio components:', 'portfoliowind' ); ?></p>

		<div id="theme-color-preview-box" class="theme-color-preview-box" style="--preview-primary: <?php echo esc_attr( $current_primary ); ?>; --preview-hover: <?php echo esc_attr( $current_hover ); ?>;">
			<!-- Top Status Badge -->
			<div class="preview-row" style="margin-bottom: 16px;">
				<span class="preview-component-badge">
					<span class="preview-pulse-dot"></span>
					<?php esc_html_e( 'Available for Projects', 'portfoliowind' ); ?>
				</span>
			</div>

			<!-- Heading Sample -->
			<div class="preview-row" style="margin-bottom: 18px;">
				<h4 class="preview-heading">
					<?php esc_html_e( 'Crafting modern digital experiences with clean code & design', 'portfoliowind' ); ?>
				</h4>
			</div>

			<!-- Buttons & Links -->
			<div class="preview-actions-row">
				<button type="button" class="preview-btn-primary">
					<?php esc_html_e( 'Get in Touch', 'portfoliowind' ); ?> &nearr;
				</button>
				<button type="button" class="preview-btn-outline">
					<?php esc_html_e( 'View Resume', 'portfoliowind' ); ?>
				</button>
				<a href="javascript:void(0)" class="preview-text-link">
					<?php esc_html_e( 'Explore Case Studies', 'portfoliowind' ); ?> &rarr;
				</a>
			</div>

			<!-- Metrics / Cards Preview -->
			<div class="preview-cards-grid">
				<div class="preview-mini-card">
					<div class="preview-card-metric">40+</div>
					<div class="preview-card-label"><?php esc_html_e( 'Completed Projects', 'portfoliowind' ); ?></div>
					<div class="preview-progress-bar"><div class="preview-progress-fill" style="width: 85%;"></div></div>
				</div>
				<div class="preview-mini-card">
					<div class="preview-card-metric">99.8%</div>
					<div class="preview-card-label"><?php esc_html_e( 'Client Satisfaction', 'portfoliowind' ); ?></div>
					<div class="preview-progress-bar"><div class="preview-progress-fill" style="width: 95%;"></div></div>
				</div>
			</div>
		</div>
	</div>

	<!-- 4. Site Copyright -->
	<div class="form-group" style="margin-top: 28px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
		<label for="site_copyright"><?php esc_html_e( 'Your Site Copyright Name', 'portfoliowind' ); ?></label>
		<input type="text" id="site_copyright" name="portfolio_options[site_copyright]" value="<?php echo esc_attr( $options['site_copyright'] ?? '' ); ?>" placeholder="e.g. Alex Morgan / My Studio">
		<p class="description"><?php printf( esc_html__( 'Displays as: &copy; %s [Your Name]. All rights reserved.', 'portfoliowind' ), esc_html( date( 'Y' ) ) ); ?></p>
	</div>

	<!-- 5. Integration Notice -->
	<div class="legal-notice-box" style="margin-top: 20px;">
		<strong><?php esc_html_e( 'Live Customizer & Tailwind Integration Tip:', 'portfoliowind' ); ?></strong>
		<p style="margin:4px 0 0 0;"><?php esc_html_e( 'You can also preview and change theme colors with real-time live preview under Appearance > Customize > Colors. All settings remain 100% in sync with PortfolioWind Studio.', 'portfoliowind' ); ?></p>
	</div>
</div>
