<?php
/**
 * PortfolioWind Required Plugins Dependency Manager
 * Requires Elementor and Fluent Forms for theme operation.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if Elementor is installed and active
 *
 * @return bool
 */
function foliowind_is_elementor_active() {
	return did_action( 'elementor/loaded' ) || defined( 'ELEMENTOR_VERSION' ) || class_exists( '\Elementor\Plugin' );
}

/**
 * Check if PortfolioWind Core companion plugin is installed and active
 *
 * @return bool
 */
function foliowind_is_core_active() {
	return defined( 'PORTFOLIOWIND_CORE_VERSION' ) || function_exists( 'portfoliowind_core_register_cpt' );
}

/**
 * Check if Fluent Forms is installed and active
 *
 * @return bool
 */
function foliowind_is_fluentform_active() {
	return function_exists( 'wpFluentForm' ) || defined( 'FLUENTFORM' ) || class_exists( '\FluentForm\App' );
}

/**
 * Display Required Plugin Admin Notices
 */
function foliowind_required_plugins_notice() {
	$missing_plugins = array();

	if ( ! foliowind_is_core_active() ) {
		$core_activate_url = wp_nonce_url(
			'plugins.php?action=activate&plugin=portfoliowind-core/portfoliowind-core.php',
			'activate-plugin_portfoliowind-core/portfoliowind-core.php'
		);
		$is_installed = file_exists( WP_PLUGIN_DIR . '/portfoliowind-core/portfoliowind-core.php' );
		$action_url   = $is_installed ? $core_activate_url : admin_url( 'plugins.php' );
		$action_text  = $is_installed ? __( 'Activate PortfolioWind Core', 'portfoliowind' ) : __( 'Install PortfolioWind Core Plugin', 'portfoliowind' );

		$missing_plugins[] = array(
			'name'   => 'PortfolioWind Core',
			'url'    => $action_url,
			'action' => $action_text,
		);
	}

	if ( ! foliowind_is_elementor_active() ) {
		$elementor_install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ),
			'install-plugin_elementor'
		);
		$elementor_activate_url = wp_nonce_url(
			'plugins.php?action=activate&plugin=elementor/elementor.php',
			'activate-plugin_elementor/elementor.php'
		);

		$is_installed = file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' );
		$action_url   = $is_installed ? $elementor_activate_url : $elementor_install_url;
		$action_text  = $is_installed ? __( 'Activate Elementor', 'portfoliowind' ) : __( 'Install Elementor', 'portfoliowind' );

		$missing_plugins[] = array(
			'name'   => 'Elementor Website Builder',
			'url'    => $action_url,
			'action' => $action_text,
		);
	}

	if ( ! foliowind_is_fluentform_active() ) {
		$fluentform_install_url = wp_nonce_url(
			self_admin_url( 'update.php?action=install-plugin&plugin=fluentform' ),
			'install-plugin_fluentform'
		);
		$fluentform_activate_url = wp_nonce_url(
			'plugins.php?action=activate&plugin=fluentform/fluentform.php',
			'activate-plugin_fluentform/fluentform.php'
		);

		$is_installed = file_exists( WP_PLUGIN_DIR . '/fluentform/fluentform.php' );
		$action_url   = $is_installed ? $fluentform_activate_url : $fluentform_install_url;
		$action_text  = $is_installed ? __( 'Activate Fluent Forms', 'portfoliowind' ) : __( 'Install Fluent Forms', 'portfoliowind' );

		$missing_plugins[] = array(
			'name'   => 'Fluent Forms',
			'url'    => $action_url,
			'action' => $action_text,
		);
	}

	if ( empty( $missing_plugins ) ) {
		return;
	}
	?>
	<div class="notice notice-warning is-dismissible" style="border-left-color: #6366f1; padding: 12px 16px;">
		<p style="font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #1e293b;">
			⚡ <?php esc_html_e( 'PortfolioWind Theme Notice: Core Plugins Recommended', 'portfoliowind' ); ?>
		</p>
		<p style="margin: 0 0 10px 0; color: #475569; font-size: 13px;">
			<?php esc_html_e( 'PortfolioWind works best with Elementor for page layouts and Fluent Forms for the contact section.', 'portfoliowind' ); ?>
		</p>
		<div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
			<?php foreach ( $missing_plugins as $plugin ) : ?>
				<a href="<?php echo esc_url( $plugin['url'] ); ?>" class="button button-primary" style="background: #6366f1; border-color: #4f46e5;">
					<?php echo esc_html( $plugin['action'] ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}
add_action( 'admin_notices', 'foliowind_required_plugins_notice' );

