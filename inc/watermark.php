<?php
/**
 * PortfolioWind Watermark & Legal Attribution Engine
 * Handles author credit preservation, GPLv2 compliance, and Buy Me a Coffee unlocks.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get Author Name
 */
function portfolio_get_author_name() {
	return apply_filters( 'foliowind_author_name', 'Nasif Muquarrabin' );
}

/**
 * Get Author Official Link
 */
function portfolio_get_author_link() {
	return apply_filters( 'foliowind_author_link', 'https://nasifmuquarrabin.me' );
}

/**
 * Get Buy Me a Coffee Support Link
 */
function portfolio_get_coffee_link() {
	return apply_filters( 'foliowind_coffee_link', 'https://nasifquarrab.gumroad.com/l/xummjn' );
}

/**
 * Verify license key(s) with Gumroad API.
 * Supports comma-separated keys for upgrades (e.g. $3 key + $7 key = $10 total).
 *
 * @param string $keys_input Single key or comma-separated keys.
 * @return array Verification results.
 */
function portfolio_verify_gumroad_license( $keys_input ) {
	$raw_input = trim( (string) $keys_input );
	if ( empty( $raw_input ) ) {
		return array(
			'valid'        => false,
			'total_cents'  => 0,
			'total_usd'    => '0.00',
			'is_pro'       => false,
			'is_supporter' => false,
			'key_count'    => 0,
			'message'      => '',
		);
	}

	$cache_key = 'foliowind_lic_' . md5( $raw_input );
	$cached    = get_transient( $cache_key );
	if ( false !== $cached && is_array( $cached ) ) {
		return $cached;
	}

	$keys        = array_filter( array_map( 'trim', explode( ',', $raw_input ) ) );
	$total_cents = 0;
	$valid_keys  = 0;
	$product_id  = 'atPxMc8lpjpu0O-VGsWo2w==';

	foreach ( $keys as $key ) {
		if ( strlen( $key ) < 10 ) {
			continue;
		}

		$response = wp_remote_post( 'https://api.gumroad.com/v2/licenses/verify', array(
			'body'    => array(
				'product_id'           => $product_id,
				'license_key'          => $key,
				'increment_uses_count' => 'false',
			),
			'timeout' => 8,
		) );

		if ( ! is_wp_error( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( 200 === $code && ! empty( $body['success'] ) ) {
				$valid_keys++;
				$paid_cents   = isset( $body['purchase']['price'] ) ? (int) $body['purchase']['price'] : 300;
				$total_cents += $paid_cents;
				continue;
			}
		}

		// Offline / fallback verification: if length >= 10, grant standard $3 credit
		$valid_keys++;
		$total_cents += 300;
	}

	$is_pro       = ( $total_cents >= 1000 ); // $10.00+ USD
	$is_supporter = ( $total_cents >= 300 );  // $3.00+ USD
	$is_valid     = ( $valid_keys > 0 && $is_supporter );
	$total_usd    = number_format( $total_cents / 100, 2 );

	if ( $is_pro ) {
		if ( count( $keys ) > 1 ) {
			$message = sprintf(
				/* translators: 1: total USD, 2: number of keys */
				__( 'Verified Pro Upgrade: Total $%1$s paid across %2$d keys — Pro Developer License Active!', 'portfoliowind' ),
				$total_usd,
				count( $keys )
			);
		} else {
			$message = sprintf(
				/* translators: %s: total USD */
				__( 'Verified Pro Developer: $%s paid — Full Code Customization + Watermark Removal Active!', 'portfoliowind' ),
				$total_usd
			);
		}
	} elseif ( $is_supporter ) {
		$remaining_cents = max( 0, 1000 - $total_cents );
		$remaining_usd   = number_format( $remaining_cents / 100, 2 );
		$message         = sprintf(
			/* translators: 1: total USD paid, 2: remaining USD to reach Pro */
			__( 'Verified Coffee Supporter: $%1$s paid — Thank you for supporting PortfolioWind! (To unlock adding your own watermark, top up $%2$s on Gumroad and add the second key separated by a comma).', 'portfoliowind' ),
			$total_usd,
			$remaining_usd
		);
	} else {
		$message = __( 'Invalid license key. Please check your key or purchase on Gumroad.', 'portfoliowind' );
	}

	$result = array(
		'valid'        => $is_valid,
		'total_cents'  => $total_cents,
		'total_usd'    => $total_usd,
		'is_pro'       => $is_pro,
		'is_supporter' => $is_supporter,
		'key_count'    => $valid_keys,
		'message'      => $message,
	);

	// Cache for 12 hours
	set_transient( $cache_key, $result, 12 * HOUR_IN_SECONDS );

	return $result;
}

/**
 * Check if the user has chosen to hide the author watermark in the footer.
 * In compliance with WordPress.org guidelines, footer watermark removal is 100% free for everyone.
 *
 * @return bool True if hide_watermark option is set.
 */
function portfolio_is_watermark_unlocked() {
	$options        = get_option( 'portfolio_options', array() );
	$hide_watermark = ! empty( $options['hide_watermark'] );

	return (bool) apply_filters( 'foliowind_is_unlocked', $hide_watermark );
}

/**
 * Check if developer has an active Pro License for commercial code customization
 *
 * @return bool True if valid license key is supplied.
 */
function portfolio_is_pro_license_unlocked() {
	$options       = get_option( 'portfolio_options', array() );
	$supporter_key = isset( $options['supporter_key'] ) ? trim( $options['supporter_key'] ) : '';

	if ( empty( $supporter_key ) ) {
		return false;
	}

	$verification = portfolio_verify_gumroad_license( $supporter_key );
	return ! empty( $verification['is_pro'] );
}

/**
 * Check if developer customizer credit mode is active
 */
function portfolio_is_customizer_mode() {
	$options = get_option( 'portfolio_options', array() );
	return ! empty( $options['customizer_credit'] ) && ! empty( $options['customizer_credit_name'] );
}

/**
 * Get Customizer Name
 */
function portfolio_get_customizer_name() {
	$options = get_option( 'portfolio_options', array() );
	return isset( $options['customizer_credit_name'] ) ? sanitize_text_field( $options['customizer_credit_name'] ) : '';
}

/**
 * Render the footer copyright and attribution mark
 */
function portfolio_render_footer_watermark() {
	$options          = get_option( 'portfolio_options', array() );
	$custom_copyright = ! empty( $options['site_copyright'] ) ? trim( $options['site_copyright'] ) : '';
	$display_title    = ! empty( $custom_copyright ) ? $custom_copyright : 'PortfolioWind';
	$current_year     = date( 'Y' );
	?>
	<div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
		<!-- Site Owner Copyright -->
		<div class="text-center md:text-left">
			&copy; <?php echo esc_html( $current_year ); ?> 
			<strong>
				<?php echo esc_html( $display_title ); ?>
			</strong>. 
			<?php esc_html_e( 'All rights reserved.', 'portfoliowind' ); ?>
		</div>

		<!-- Attribution / Watermark Section -->
		<div>
			<?php
			$customizer_name = portfolio_get_customizer_name();
			$has_customizer  = portfolio_is_customizer_mode();
			$is_pro          = portfolio_is_pro_license_unlocked();
			$is_unlocked     = portfolio_is_watermark_unlocked();
			?>

			<?php if ( $has_customizer && $is_pro ) : ?>
				<!-- Pro Developer ($10+): Custom watermark / agency branding alone -->
				<span class="inline-flex items-center gap-1.5">
					<?php esc_html_e( 'Theme customized by', 'portfoliowind' ); ?> 
					<span class="font-medium text-slate-800 dark:text-slate-200"><?php echo esc_html( $customizer_name ); ?></span>
				</span>
			<?php elseif ( $is_unlocked ) : ?>
				<!-- Watermark cleanly removed (Free for everyone) -->
			<?php else : ?>
				<!-- Default Author Attribution Badge -->
				<a href="<?php echo esc_url( portfolio_get_author_link() ); ?>" target="_blank" rel="noopener" class="watermark-badge hover:opacity-80 transition-all">
					<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
						<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
					</svg>
					<span>Crafted with PortfolioWind by <?php echo esc_html( portfolio_get_author_name() ); ?></span>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
}
