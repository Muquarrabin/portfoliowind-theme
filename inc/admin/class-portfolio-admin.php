<?php
/**
 * PortfolioWind Admin Class
 * Registers the PortfolioWind Studio admin panel and handles data persistence.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PortfolioWind_Admin {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
		add_action( 'admin_head', array( $this, 'inject_cpt_import_button' ) );
		add_action( 'wp_ajax_foliowind_bulk_import_projects', array( $this, 'ajax_bulk_import_projects' ) );
		add_action( 'wp_ajax_foliowind_export_projects', array( $this, 'ajax_export_projects' ) );
		add_action( 'wp_ajax_foliowind_download_sample_csv', array( $this, 'ajax_download_sample_csv' ) );
	}

	public function register_admin_menu() {
		add_menu_page(
			__( 'PortfolioWind Studio', 'portfoliowind' ),
			__( 'PortfolioWind Studio', 'portfoliowind' ),
			'manage_options',
			'portfolio-studio',
			array( $this, 'render_admin_page' ),
			'dashicons-id-alt',
			3
		);

		$primary_cpt = function_exists( 'portfoliowind_get_primary_project_post_type' ) ? portfoliowind_get_primary_project_post_type() : 'portfoliowind_proj';
		add_submenu_page(
			'edit.php?post_type=' . $primary_cpt,
			__( 'Import Projects', 'portfoliowind' ),
			__( 'Import Projects', 'portfoliowind' ),
			'manage_options',
			'portfolio-project-import',
			array( $this, 'render_cpt_import_page' )
		);
	}

	public function inject_cpt_import_button() {
		$screen = get_current_screen();
		if ( $screen && in_array( $screen->post_type, array( 'portfoliowind_proj', 'portfolio_project' ), true ) && 'edit' === $screen->base ) {
			$sample_url = admin_url( 'admin-ajax.php?action=foliowind_download_sample_csv&nonce=' . wp_create_nonce( 'foliowind_admin_nonce' ) );
			?>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				if ($('.wrap .page-title-action').length && !$('#foliowind-cpt-import-btn').length) {
					var $btn = $('<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . esc_attr( $screen->post_type ) . '&page=portfolio-project-import' ) ); ?>" id="foliowind-cpt-import-btn" class="page-title-action" style="margin-left:6px;"><span class="dashicons dashicons-upload" style="vertical-align:middle;margin-top:-2px;color:#4f46e5 !important;"></span> <?php echo esc_js( __( 'Import Projects (CSV)', 'portfoliowind' ) ); ?></a>');
					var $sampleBtn = $('<a href="<?php echo esc_url( $sample_url ); ?>" id="foliowind-sample-csv-btn" class="page-title-action" download="sample-portfolio-projects.csv" style="margin-left:6px;"><span class="dashicons dashicons-download" style="vertical-align:middle;margin-top:-2px;color:#047857 !important;"></span> <?php echo esc_js( __( 'Download Sample CSV', 'portfoliowind' ) ); ?></a>');
					$('.wrap .page-title-action').first().after($sampleBtn).after($btn);
				}
			});
			</script>
			<?php
		}
	}

	public function ajax_download_sample_csv() {
		check_ajax_referer( 'foliowind_admin_nonce', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Unauthorized capability.', 'portfoliowind' ) );
		}

		$file_path = get_template_directory() . '/assets/sample-projects.csv';
		if ( ! file_exists( $file_path ) ) {
			wp_die( esc_html__( 'Sample CSV file not found.', 'portfoliowind' ) );
		}

		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="sample-portfolio-projects.csv"' );
		header( 'Pragma: no-cache' );
		header( 'Expires: 0' );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo file_get_contents( $file_path );
		exit;
	}

	public function render_cpt_import_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to access this page.', 'portfoliowind' ) );
		}
		include get_template_directory() . '/inc/admin/views/view-cpt-import.php';
	}

	public function enqueue_admin_assets( $hook ) {
		$valid_hooks = array(
			'toplevel_page_portfolio-studio',
			'portfolio_project_page_portfolio-project-import',
			'portfoliowind_proj_page_portfolio-project-import',
			'edit-portfolio_project',
			'edit-portfoliowind_proj',
		);
		if ( ! in_array( $hook, $valid_hooks, true ) ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style(
			'select2',
			get_template_directory_uri() . '/assets/css/select2.min.css',
			array(),
			'4.1.0-rc.0'
		);

		wp_enqueue_style(
			'portfolio-admin-studio',
			get_template_directory_uri() . '/assets/css/admin-studio.css',
			array( 'select2', 'wp-color-picker' ),
			'1.1.0'
		);

		wp_enqueue_script(
			'select2',
			get_template_directory_uri() . '/assets/js/select2.min.js',
			array( 'jquery' ),
			'4.1.0-rc.0',
			true
		);

		wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_script(
			'portfolio-admin-studio',
			get_template_directory_uri() . '/assets/js/admin-studio.js',
			array( 'jquery', 'select2', 'wp-color-picker' ),
			'1.1.0',
			true
		);

		$active_tax = taxonomy_exists( 'portfoliowind_project_category' ) ? 'portfoliowind_project_category' : 'project_category';
		$tax_terms  = get_terms( array(
			'taxonomy'   => $active_tax,
			'hide_empty' => false,
		) );
		$categories = array(
			array( 'slug' => 'web', 'label' => __( 'Web Development (web)', 'portfoliowind' ) ),
			array( 'slug' => 'mobile', 'label' => __( 'Mobile Apps (mobile)', 'portfoliowind' ) ),
			array( 'slug' => 'design', 'label' => __( 'UI/UX Design (design)', 'portfoliowind' ) ),
			array( 'slug' => 'fullstack', 'label' => __( 'Full Stack (fullstack)', 'portfoliowind' ) ),
			array( 'slug' => 'ecommerce', 'label' => __( 'E-Commerce (ecommerce)', 'portfoliowind' ) ),
			array( 'slug' => 'ai', 'label' => __( 'AI & Machine Learning (ai)', 'portfoliowind' ) ),
			array( 'slug' => 'cloud', 'label' => __( 'Cloud & DevOps (cloud)', 'portfoliowind' ) ),
			array( 'slug' => 'branding', 'label' => __( 'Branding & Graphics (branding)', 'portfoliowind' ) ),
		);
		if ( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			$existing_slugs = wp_list_pluck( $categories, 'slug' );
			foreach ( $tax_terms as $term ) {
				if ( ! in_array( $term->slug, $existing_slugs, true ) ) {
					$categories[] = array(
						'slug'  => $term->slug,
						'label' => $term->name . ' (' . $term->slug . ')',
					);
				}
			}
		}

		wp_localize_script( 'portfolio-admin-studio', 'foliowindAdmin', array(
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'nonce'      => wp_create_nonce( 'foliowind_admin_nonce' ),
			'categories' => $categories,
		) );
	}

	public function register_settings() {
		register_setting(
			'portfolio_options_group',
			'portfolio_options',
			array( $this, 'sanitize_options' )
		);
	}

	public function sanitize_options( $input ) {
		$clean = array();

		// Hero Tab
		$clean['hero_name']     = sanitize_text_field( $input['hero_name'] ?? '' );
		$clean['hero_tagline']  = sanitize_text_field( $input['hero_tagline'] ?? '' );
		$clean['hero_bio']      = sanitize_textarea_field( $input['hero_bio'] ?? '' );
		$clean['hero_avatar']   = esc_url_raw( $input['hero_avatar'] ?? '' );
		$clean['hero_cv_url']   = esc_url_raw( $input['hero_cv_url'] ?? '' );
		$clean['hero_cta_text'] = sanitize_text_field( $input['hero_cta_text'] ?? '' );
		$clean['hero_cta_url']  = sanitize_text_field( $input['hero_cta_url'] ?? '' );

		// About Tab
		$clean['about_heading'] = sanitize_text_field( $input['about_heading'] ?? '' );
		$clean['about_bio']     = wp_kses_post( $input['about_bio'] ?? '' );
		$clean['stat_years']    = sanitize_text_field( $input['stat_years'] ?? '' );
		$clean['stat_projects'] = sanitize_text_field( $input['stat_projects'] ?? '' );
		$clean['stat_clients']  = sanitize_text_field( $input['stat_clients'] ?? '' );

		// Skills Repeater
		$clean['skills'] = array();
		if ( ! empty( $input['skills'] ) && is_array( $input['skills'] ) ) {
			foreach ( $input['skills'] as $skill ) {
				if ( ! empty( $skill['name'] ) ) {
					$clean['skills'][] = array(
						'name'    => sanitize_text_field( $skill['name'] ),
						'percent' => absint( $skill['percent'] ?? 80 ),
					);
				}
			}
		}

		// Services Repeater
		$clean['services'] = array();
		if ( ! empty( $input['services'] ) && is_array( $input['services'] ) ) {
			foreach ( $input['services'] as $svc ) {
				if ( ! empty( $svc['title'] ) ) {
					$clean['services'][] = array(
						'title' => sanitize_text_field( $svc['title'] ),
						'icon'  => sanitize_text_field( $svc['icon'] ?? 'dashicons-laptop' ),
						'desc'  => sanitize_textarea_field( $svc['desc'] ?? '' ),
					);
				}
			}
		}

		// Featured Projects Selection (Custom Post Type Post IDs)
		$clean['featured_projects'] = array();
		if ( ! empty( $input['featured_projects'] ) && is_array( $input['featured_projects'] ) ) {
			foreach ( $input['featured_projects'] as $p_id ) {
				$clean_id = absint( $p_id );
				if ( $clean_id > 0 && ! in_array( $clean_id, $clean['featured_projects'], true ) ) {
					$clean['featured_projects'][] = $clean_id;
				}
			}
		}

		// Legacy Projects Repeater (kept for backward compatibility)
		$clean['projects'] = array();
		if ( ! empty( $input['projects'] ) && is_array( $input['projects'] ) ) {
			foreach ( $input['projects'] as $proj ) {
				if ( ! empty( $proj['title'] ) ) {
					$clean['projects'][] = array(
						'title'    => sanitize_text_field( $proj['title'] ),
						'category' => sanitize_key( $proj['category'] ?? 'all' ),
						'image'    => esc_url_raw( $proj['image'] ?? '' ),
						'url'      => esc_url_raw( $proj['url'] ?? '' ),
						'desc'     => sanitize_textarea_field( $proj['desc'] ?? '' ),
					);
				}
			}
		}

		// Resume Repeater
		$clean['resume'] = array();
		if ( ! empty( $input['resume'] ) && is_array( $input['resume'] ) ) {
			foreach ( $input['resume'] as $item ) {
				if ( ! empty( $item['role'] ) ) {
					$clean['resume'][] = array(
						'type'    => sanitize_key( $item['type'] ?? 'experience' ),
						'role'    => sanitize_text_field( $item['role'] ),
						'company' => sanitize_text_field( $item['company'] ?? '' ),
						'period'  => sanitize_text_field( $item['period'] ?? '' ),
						'desc'    => sanitize_textarea_field( $item['desc'] ?? '' ),
					);
				}
			}
		}

		// Contact & Socials
		$clean['contact_email']          = sanitize_email( $input['contact_email'] ?? '' );
		$clean['contact_phone']          = sanitize_text_field( $input['contact_phone'] ?? '' );
		$clean['contact_location']       = sanitize_text_field( $input['contact_location'] ?? '' );
		$clean['contact_badge']          = sanitize_text_field( $input['contact_badge'] ?? '' );
		$clean['contact_form_shortcode'] = sanitize_text_field( $input['contact_form_shortcode'] ?? '' );
		$clean['hide_contact_info']      = ! empty( $input['hide_contact_info'] );

		$clean['social_github']    = esc_url_raw( $input['social_github'] ?? '' );
		$clean['social_linkedin']  = esc_url_raw( $input['social_linkedin'] ?? '' );
		$clean['social_twitter']   = esc_url_raw( $input['social_twitter'] ?? '' );
		$clean['social_dribbble']  = esc_url_raw( $input['social_dribbble'] ?? '' );
		$clean['social_instagram'] = esc_url_raw( $input['social_instagram'] ?? '' );

		// Styling
		$clean['primary_color'] = sanitize_hex_color( $input['primary_color'] ?? '#6366f1' );
		$clean['primary_hover'] = sanitize_hex_color( $input['primary_hover'] ?? '#4f46e5' );

		$clean['supporter_key']  = sanitize_text_field( $input['supporter_key'] ?? '' );

		// Strictly verify Gumroad license key
		$verification = ! empty( $clean['supporter_key'] ) ? portfolio_verify_gumroad_license( $clean['supporter_key'] ) : array( 'valid' => false, 'is_pro' => false );

		// Watermark removal is 100% free for everyone (WordPress.org guideline compliant)
		$clean['hide_watermark'] = ! empty( $input['hide_watermark'] );

		// Footer Copyright Line (Site owner's site copyright, freely editable by all users)
		$clean['site_copyright'] = sanitize_text_field( $input['site_copyright'] ?? '' );

		// Customizer / Agency Watermark ($10+ Pro Developer License):
		// - Only users with a verified Pro Developer key ($10+ USD) can add their custom agency watermark
		if ( ! empty( $verification['is_pro'] ) ) {
			$clean['customizer_credit']      = ! empty( $input['customizer_credit'] );
			$clean['customizer_credit_name'] = sanitize_text_field( $input['customizer_credit_name'] ?? '' );
		} else {
			$clean['customizer_credit']      = false;
			$clean['customizer_credit_name'] = '';
		}

		return $clean;
	}

	public function render_admin_page() {
		$options = portfolio_get_theme_options();
		?>
		<div class="wrap portfolio-studio-wrap">
			<div class="portfolio-studio-header">
				<div>
					<h1><?php esc_html_e( 'PortfolioWind Studio', 'portfoliowind' ); ?></h1>
					<p><?php esc_html_e( 'Fill out your portfolio content below. Everything renders automatically with zero code.', 'portfoliowind' ); ?></p>
				</div>
				<div class="portfolio-studio-badge">
					<?php esc_html_e( 'Tailwind Powered', 'portfoliowind' ); ?>
				</div>
			</div>

			<form method="post" action="options.php">
				<?php settings_fields( 'portfolio_options_group' ); ?>

				<div class="portfolio-studio-container">
					<!-- Nav Sidebar Tabs -->
					<div class="portfolio-studio-nav">
						<a class="portfolio-tab-link active" data-tab="hero">
							<span class="dashicons dashicons-admin-users"></span>
							<?php esc_html_e( 'Hero & Bio', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="about">
							<span class="dashicons dashicons-id"></span>
							<?php esc_html_e( 'About & Skills', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="services">
							<span class="dashicons dashicons-grid-view"></span>
							<?php esc_html_e( 'Services', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="projects">
							<span class="dashicons dashicons-portfolio"></span>
							<?php esc_html_e( 'Projects', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="resume">
							<span class="dashicons dashicons-welcome-learn-more"></span>
							<?php esc_html_e( 'Resume', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="contact">
							<span class="dashicons dashicons-email"></span>
							<?php esc_html_e( 'Contact & Socials', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="styling">
							<span class="dashicons dashicons-art"></span>
							<?php esc_html_e( 'Theme Colors & Styling', 'portfoliowind' ); ?>
						</a>
						<a class="portfolio-tab-link" data-tab="license">
							<span class="dashicons dashicons-coffee"></span>
							<?php esc_html_e( 'License & Supporter Key', 'portfoliowind' ); ?>
						</a>
					</div>

					<!-- Tab Panes Content -->
					<div class="portfolio-studio-content">
						<?php
						include get_template_directory() . '/inc/admin/views/tab-hero.php';
						include get_template_directory() . '/inc/admin/views/tab-about.php';
						include get_template_directory() . '/inc/admin/views/tab-services.php';
						include get_template_directory() . '/inc/admin/views/tab-projects.php';
						include get_template_directory() . '/inc/admin/views/tab-resume.php';
						include get_template_directory() . '/inc/admin/views/tab-contact.php';
						include get_template_directory() . '/inc/admin/views/tab-styling.php';
						include get_template_directory() . '/inc/admin/views/tab-license.php';
						?>

						<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
							<?php submit_button( __( 'Save All Portfolio Changes', 'portfoliowind' ), 'primary', 'submit', false ); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * AJAX Handler: Bulk Import Projects
	 */
	public function ajax_bulk_import_projects() {
		check_ajax_referer( 'foliowind_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Unauthorized capability.', 'portfoliowind' ) ) );
		}

		$mode     = sanitize_text_field( $_POST['mode'] ?? 'append' );
		$raw_data = isset( $_POST['import_data'] ) ? wp_unslash( $_POST['import_data'] ) : '';

		if ( empty( trim( $raw_data ) ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No CSV content provided. Please upload or paste a CSV file.', 'portfoliowind' ) ) );
		}

		$raw_items = $this->parse_csv_projects( $raw_data );

		if ( empty( $raw_items ) || ! is_array( $raw_items ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No valid project records found in the uploaded CSV.', 'portfoliowind' ) ) );
		}

		$valid_projects = array();
		foreach ( $raw_items as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$title = sanitize_text_field( $item['title'] ?? '' );
			if ( empty( $title ) ) {
				continue;
			}
			$category = sanitize_title( $item['category'] ?? 'web' );
			if ( empty( $category ) ) {
				$category = 'web';
			}

			// URLs & Media
			$url        = esc_url_raw( $item['url'] ?? ( $item['live_url'] ?? ( $item['link'] ?? '' ) ) );
			$github_url = esc_url_raw( $item['github_url'] ?? ( $item['repo_url'] ?? ( $item['github'] ?? '' ) ) );
			$image      = esc_url_raw( $item['image'] ?? ( $item['thumbnail'] ?? ( $item['img'] ?? '' ) ) );

			// Text Content
			$excerpt = sanitize_textarea_field( $item['excerpt'] ?? ( $item['desc'] ?? ( $item['description'] ?? ( $item['summary'] ?? '' ) ) ) );
			$content = wp_kses_post( $item['content'] ?? ( $item['case_study'] ?? ( $item['body'] ?? ( $item['details'] ?? '' ) ) ) );
			if ( empty( $content ) ) {
				$content = ! empty( $excerpt ) ? '<p>' . esc_html( $excerpt ) . '</p>' : '';
			}

			// Meta Fields
			$client     = sanitize_text_field( $item['client'] ?? ( $item['company'] ?? '' ) );
			$timeline   = sanitize_text_field( $item['timeline'] ?? ( $item['year'] ?? ( $item['duration'] ?? '' ) ) );
			$role       = sanitize_text_field( $item['role'] ?? '' );
			$tech_stack = sanitize_text_field( $item['tech_stack'] ?? ( $item['tech'] ?? ( $item['skills'] ?? '' ) ) );

			// Metrics / KPIs
			$m1_val = sanitize_text_field( $item['metric1_val'] ?? ( $item['m1_val'] ?? ( $item['metrics'][0]['val'] ?? '' ) ) );
			$m1_lbl = sanitize_text_field( $item['metric1_lbl'] ?? ( $item['m1_lbl'] ?? ( $item['metrics'][0]['lbl'] ?? '' ) ) );
			$m2_val = sanitize_text_field( $item['metric2_val'] ?? ( $item['m2_val'] ?? ( $item['metrics'][1]['val'] ?? '' ) ) );
			$m2_lbl = sanitize_text_field( $item['metric2_lbl'] ?? ( $item['m2_lbl'] ?? ( $item['metrics'][1]['lbl'] ?? '' ) ) );
			$m3_val = sanitize_text_field( $item['metric3_val'] ?? ( $item['m3_val'] ?? ( $item['metrics'][2]['val'] ?? '' ) ) );
			$m3_lbl = sanitize_text_field( $item['metric3_lbl'] ?? ( $item['m3_lbl'] ?? ( $item['metrics'][2]['lbl'] ?? '' ) ) );

			$valid_projects[] = array(
				'title'       => $title,
				'category'    => $category,
				'url'         => $url,
				'github_url'  => $github_url,
				'image'       => $image,
				'excerpt'     => $excerpt,
				'content'     => $content,
				'desc'        => $excerpt,
				'client'      => $client,
				'timeline'    => $timeline,
				'role'        => $role,
				'tech_stack'  => $tech_stack,
				'metric1_val' => $m1_val,
				'metric1_lbl' => $m1_lbl,
				'metric2_val' => $m2_val,
				'metric2_lbl' => $m2_lbl,
				'metric3_val' => $m3_val,
				'metric3_lbl' => $m3_lbl,
			);
		}

		$imported_count = count( $valid_projects );
		if ( 0 === $imported_count ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Zero valid projects could be parsed. Each item must have at least a "title".', 'portfoliowind' ) ) );
		}

		// Process WordPress CPT Destination (Projects are saved as Custom Post Type)
		$created_ids   = array();
		$created_items = array();
		$target_cpt    = function_exists( 'portfoliowind_get_primary_project_post_type' ) ? portfoliowind_get_primary_project_post_type() : 'portfoliowind_proj';
		$target_tax    = taxonomy_exists( 'portfoliowind_project_category' ) ? 'portfoliowind_project_category' : 'project_category';

		if ( 'replace' === $mode ) {
			$existing_posts = get_posts( array(
				'post_type'      => function_exists( 'portfoliowind_get_project_post_types' ) ? portfoliowind_get_project_post_types() : array( 'portfoliowind_proj', 'portfolio_project' ),
				'posts_per_page' => -1,
				'post_status'    => 'any',
				'fields'         => 'ids',
			) );
			foreach ( $existing_posts as $p_id ) {
				wp_delete_post( $p_id, true );
			}
		}

		foreach ( $valid_projects as $vp ) {
			$new_id = wp_insert_post( array(
				'post_title'   => $vp['title'],
				'post_content' => $vp['content'],
				'post_excerpt' => $vp['excerpt'],
				'post_status'  => 'publish',
				'post_type'    => $target_cpt,
			) );

			if ( ! is_wp_error( $new_id ) && $new_id > 0 ) {
				$created_ids[]   = (int) $new_id;
				$created_items[] = array(
					'id'       => (int) $new_id,
					'title'    => $vp['title'],
					'category' => $vp['category'],
				);

				// Taxonomy Category
				if ( ! empty( $vp['category'] ) ) {
					$term = term_exists( $vp['category'], $target_tax );
					if ( ! $term ) {
						$term_label = ucfirst( str_replace( array( '-', '_' ), ' ', $vp['category'] ) );
						$term = wp_insert_term( $term_label, $target_tax, array( 'slug' => $vp['category'] ) );
					}
					if ( ! is_wp_error( $term ) && ! empty( $term['term_id'] ) ) {
						wp_set_object_terms( $new_id, (int) $term['term_id'], $target_tax, false );
					}
				}

				// Detailed Meta fields (save prefixed + legacy fallback)
				$meta_mappings = array(
					'client'      => $vp['client'] ?? '',
					'timeline'    => $vp['timeline'] ?? '',
					'role'        => $vp['role'] ?? '',
					'live_url'    => $vp['url'] ?? '',
					'github_url'  => $vp['github_url'] ?? '',
					'tech_stack'  => $vp['tech_stack'] ?? '',
					'metric1_val' => $vp['metric1_val'] ?? '',
					'metric1_lbl' => $vp['metric1_lbl'] ?? '',
					'metric2_val' => $vp['metric2_val'] ?? '',
					'metric2_lbl' => $vp['metric2_lbl'] ?? '',
					'metric3_val' => $vp['metric3_val'] ?? '',
					'metric3_lbl' => $vp['metric3_lbl'] ?? '',
					'image_url'   => $vp['image'] ?? '',
				);

				foreach ( $meta_mappings as $m_key => $m_val ) {
					if ( ! empty( $m_val ) ) {
						update_post_meta( $new_id, '_portfoliowind_' . $m_key, $m_val );
						update_post_meta( $new_id, '_project_' . $m_key, $m_val );
					}
				}

				// Attempt native WordPress media sideloading if available
				if ( ! empty( $vp['image'] ) ) {
					if ( ! function_exists( 'media_sideload_image' ) && file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
						require_once ABSPATH . 'wp-admin/includes/media.php';
						require_once ABSPATH . 'wp-admin/includes/file.php';
						require_once ABSPATH . 'wp-admin/includes/image.php';
					}
					if ( function_exists( 'media_sideload_image' ) ) {
						$attachment_id = media_sideload_image( $vp['image'], $new_id, $vp['title'], 'id' );
						if ( ! is_wp_error( $attachment_id ) && is_numeric( $attachment_id ) ) {
							set_post_thumbnail( $new_id, (int) $attachment_id );
						}
					}
				}
			}
		}

		// Auto-sync with Studio featured projects so they immediately show in the Studio dropdown
		$options = portfolio_get_theme_options();
		$current_featured = array_filter( array_map( 'absint', (array) ( $options['featured_projects'] ?? array() ) ) );
		if ( 'replace' === $mode || empty( $current_featured ) ) {
			$options['featured_projects'] = $created_ids;
		} else {
			$options['featured_projects'] = array_unique( array_merge( $current_featured, $created_ids ) );
		}
		update_option( 'portfolio_options', $options );

		wp_send_json_success( array(
			'count'             => $imported_count,
			'message'           => sprintf(
				/* translators: %d: number of imported projects */
				esc_html__( 'Successfully imported %d detailed projects from CSV!', 'portfoliowind' ),
				$imported_count
			),
			'projects'          => $valid_projects,
			'created_ids'       => $created_ids,
			'created_items'     => $created_items,
			'featured_projects' => $options['featured_projects'],
		) );
	}

	/**
	 * AJAX Handler: Export Projects as Detailed JSON
	 */
	public function ajax_export_projects() {
		check_ajax_referer( 'foliowind_admin_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Unauthorized capability.', 'portfoliowind' ) ) );
		}

		$options         = portfolio_get_theme_options();
		$studio_projects = $options['projects'] ?? array();

		$cpt_query = new WP_Query( array(
			'post_type'      => function_exists( 'portfoliowind_get_project_post_types' ) ? portfoliowind_get_project_post_types() : array( 'portfoliowind_proj', 'portfolio_project' ),
			'post_status'    => 'any',
			'posts_per_page' => -1,
		) );

		$exported_list = array();

		// Add Studio projects
		foreach ( $studio_projects as $p ) {
			$exported_list[] = array(
				'title'    => $p['title'] ?? '',
				'category' => $p['category'] ?? 'web',
				'url'      => $p['url'] ?? '',
				'image'    => $p['image'] ?? '',
				'excerpt'  => $p['desc'] ?? '',
				'content'  => ! empty( $p['desc'] ) ? '<p>' . esc_html( $p['desc'] ) . '</p>' : '',
				'source'   => 'studio_card',
			);
		}

		// Add CPT projects with complete detailed fields
		if ( $cpt_query->have_posts() ) {
			while ( $cpt_query->have_posts() ) {
				$cpt_query->the_post();
				$terms     = get_the_terms( get_the_ID(), 'portfoliowind_project_category' );
				if ( empty( $terms ) || is_wp_error( $terms ) ) {
					$terms = get_the_terms( get_the_ID(), 'project_category' );
				}
				$cat_slug  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->slug : 'web';
				$thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
				if ( empty( $thumb_url ) ) {
					$thumb_url = portfoliowind_get_project_meta( get_the_ID(), 'image_url' );
				}

				$exported_list[] = array(
					'title'       => get_the_title(),
					'category'    => $cat_slug,
					'url'         => portfoliowind_get_project_meta( get_the_ID(), 'live_url' ),
					'github_url'  => portfoliowind_get_project_meta( get_the_ID(), 'github_url' ),
					'image'       => $thumb_url,
					'excerpt'     => get_the_excerpt(),
					'content'     => get_the_content(),
					'client'      => portfoliowind_get_project_meta( get_the_ID(), 'client' ),
					'timeline'    => portfoliowind_get_project_meta( get_the_ID(), 'timeline' ),
					'role'        => portfoliowind_get_project_meta( get_the_ID(), 'role' ),
					'tech_stack'  => portfoliowind_get_project_meta( get_the_ID(), 'tech_stack' ),
					'metric1_val' => portfoliowind_get_project_meta( get_the_ID(), 'metric1_val' ),
					'metric1_lbl' => portfoliowind_get_project_meta( get_the_ID(), 'metric1_lbl' ),
					'metric2_val' => portfoliowind_get_project_meta( get_the_ID(), 'metric2_val' ),
					'metric2_lbl' => portfoliowind_get_project_meta( get_the_ID(), 'metric2_lbl' ),
					'metric3_val' => portfoliowind_get_project_meta( get_the_ID(), 'metric3_val' ),
					'metric3_lbl' => portfoliowind_get_project_meta( get_the_ID(), 'metric3_lbl' ),
					'source'      => 'cpt_post',
				);
			}
			wp_reset_postdata();
		}

		$payload = array(
			'theme'       => 'PortfolioWind',
			'version'     => '1.0.0',
			'exported_at' => current_time( 'mysql' ),
			'count'       => count( $exported_list ),
			'projects'    => $exported_list,
		);

		wp_send_json_success( array(
			'filename' => 'portfoliowind-projects-' . gmdate( 'Y-m-d' ) . '.json',
			'data'     => $payload,
		) );
	}

	/**
	 * Parse CSV string into array of project records with detailed fields
	 */
	private function parse_csv_projects( $csv_content ) {
		$lines = preg_split( '/\r\n|\r|\n/', trim( $csv_content ) );
		if ( empty( $lines ) ) {
			return array();
		}

		$projects = array();
		$headers  = array();
		$first    = true;

		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( empty( $line ) ) {
				continue;
			}

			$row = str_getcsv( $line );
			if ( empty( $row ) ) {
				continue;
			}

			if ( $first ) {
				$first = false;
				$row_lower = array_map( function( $col ) {
					return strtolower( trim( $col ) );
				}, $row );

				if ( in_array( 'title', $row_lower, true ) || in_array( 'name', $row_lower, true ) || in_array( 'project', $row_lower, true ) ) {
					$headers = $row_lower;
					continue;
				}
			}

			$item = array();
			if ( ! empty( $headers ) ) {
				foreach ( $headers as $col_idx => $header_name ) {
					$val = $row[ $col_idx ] ?? '';
					if ( 'title' === $header_name || 'name' === $header_name || 'project' === $header_name ) {
						$item['title'] = $val;
					} elseif ( 'category' === $header_name || 'cat' === $header_name ) {
						$item['category'] = $val;
					} elseif ( 'url' === $header_name || 'link' === $header_name || 'live' === $header_name || 'live_url' === $header_name || 'liveurl' === $header_name ) {
						$item['url'] = $val;
					} elseif ( 'github' === $header_name || 'github_url' === $header_name || 'githuburl' === $header_name || 'repo' === $header_name || 'source' === $header_name ) {
						$item['github_url'] = $val;
					} elseif ( 'image' === $header_name || 'img' === $header_name || 'photo' === $header_name || 'cover' === $header_name || 'thumbnail' === $header_name ) {
						$item['image'] = $val;
					} elseif ( 'excerpt' === $header_name || 'desc' === $header_name || 'description' === $header_name || 'summary' === $header_name ) {
						$item['excerpt'] = $val;
					} elseif ( 'content' === $header_name || 'case_study' === $header_name || 'casestudy' === $header_name || 'body' === $header_name || 'details' === $header_name ) {
						$item['content'] = $val;
					} elseif ( 'client' === $header_name || 'company' === $header_name ) {
						$item['client'] = $val;
					} elseif ( 'timeline' === $header_name || 'year' === $header_name || 'duration' === $header_name ) {
						$item['timeline'] = $val;
					} elseif ( 'role' === $header_name ) {
						$item['role'] = $val;
					} elseif ( 'tech' === $header_name || 'tech_stack' === $header_name || 'techstack' === $header_name || 'skills' === $header_name ) {
						$item['tech_stack'] = $val;
					} elseif ( 'metric1_val' === $header_name || 'm1_val' === $header_name || 'kpi1_val' === $header_name ) {
						$item['metric1_val'] = $val;
					} elseif ( 'metric1_lbl' === $header_name || 'm1_lbl' === $header_name || 'kpi1_lbl' === $header_name ) {
						$item['metric1_lbl'] = $val;
					} elseif ( 'metric2_val' === $header_name || 'm2_val' === $header_name || 'kpi2_val' === $header_name ) {
						$item['metric2_val'] = $val;
					} elseif ( 'metric2_lbl' === $header_name || 'm2_lbl' === $header_name || 'kpi2_lbl' === $header_name ) {
						$item['metric2_lbl'] = $val;
					} elseif ( 'metric3_val' === $header_name || 'm3_val' === $header_name || 'kpi3_val' === $header_name ) {
						$item['metric3_val'] = $val;
					} elseif ( 'metric3_lbl' === $header_name || 'm3_lbl' === $header_name || 'kpi3_lbl' === $header_name ) {
						$item['metric3_lbl'] = $val;
					}
				}
			} else {
				// Positional CSV fallback
				$item['title']       = $row[0] ?? '';
				$item['category']    = $row[1] ?? 'web';
				$item['excerpt']     = $row[2] ?? '';
				$item['content']     = $row[3] ?? '';
				$item['image']       = $row[4] ?? '';
				$item['client']      = $row[5] ?? '';
				$item['timeline']    = $row[6] ?? '';
				$item['role']        = $row[7] ?? '';
				$item['tech_stack']  = $row[8] ?? '';
				$item['url']         = $row[9] ?? '';
				$item['github_url']  = $row[10] ?? '';
				$item['metric1_val'] = $row[11] ?? '';
				$item['metric1_lbl'] = $row[12] ?? '';
				$item['metric2_val'] = $row[13] ?? '';
				$item['metric2_lbl'] = $row[14] ?? '';
				$item['metric3_val'] = $row[15] ?? '';
				$item['metric3_lbl'] = $row[16] ?? '';
			}

			if ( ! empty( $item['title'] ) ) {
				$projects[] = $item;
			}
		}

		return $projects;
	}
}

new PortfolioWind_Admin();
