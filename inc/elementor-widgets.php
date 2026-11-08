<?php
/**
 * Elementor Custom Widgets for PortfolioWind
 *
 * Provides fully customizable native Elementor widgets for each portfolio section.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Elementor Widget Category
 */
function foliowind_add_elementor_category( $elements_manager ) {
	$elements_manager->add_category(
		'portfoliowind-elements',
		array(
			'title' => esc_html__( 'PortfolioWind Elements', 'portfoliowind' ),
			'icon'  => 'fa fa-plug',
		)
	);
}
add_action( 'elementor/elements/categories_registered', 'foliowind_add_elementor_category' );

/**
 * Register Custom Widgets
 */
function foliowind_register_elementor_widgets( $widgets_manager ) {
	if ( ! class_exists( '\Elementor\Widget_Base' ) ) {
		return;
	}

	// =========================================================================
	// 1. HERO WIDGET
	// =========================================================================
	class PortfolioWind_Hero_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_hero'; }
		public function get_title() { return esc_html__( 'Portfolio Hero & Bio', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-person'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_content',
				array(
					'label' => esc_html__( 'Hero Content', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'badge_text',
				array(
					'label'       => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'default'     => portfolio_get_option( 'hero_tagline', 'Available for New Projects' ),
					'placeholder' => esc_html__( 'e.g. Available for New Projects', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'greeting',
				array(
					'label'   => esc_html__( 'Greeting / Prefix', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( "Hi, I'm", 'portfoliowind' ),
				)
			);

			$this->add_control(
				'hero_name',
				array(
					'label'   => esc_html__( 'Your Name', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_name', 'Nasif Muquarrabin' ),
				)
			);

			$this->add_control(
				'hero_title',
				array(
					'label'   => esc_html__( 'Professional Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_title', 'Full-Stack Developer & WordPress Specialist' ),
				)
			);

			$this->add_control(
				'hero_bio',
				array(
					'label'   => esc_html__( 'Bio Paragraph', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXTAREA,
					'default' => portfolio_get_option( 'hero_bio', 'Crafting high-performance web applications and scalable solutions with precision.' ),
				)
			);

			$this->add_control(
				'hero_image',
				array(
					'label'   => esc_html__( 'Profile Avatar / Photo', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::MEDIA,
					'default' => array(
						'url' => portfolio_get_option( 'hero_avatar', '' ),
					),
				)
			);

			$this->add_control(
				'btn_primary_text',
				array(
					'label'   => esc_html__( 'Primary Button Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_btn_text', 'View Projects' ),
				)
			);

			$this->add_control(
				'btn_primary_url',
				array(
					'label'   => esc_html__( 'Primary Button URL', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_btn_url', '#portfolio' ),
				)
			);

			$this->add_control(
				'btn_secondary_text',
				array(
					'label'   => esc_html__( 'Secondary Button Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_btn2_text', 'Get In Touch' ),
				)
			);

			$this->add_control(
				'btn_secondary_url',
				array(
					'label'   => esc_html__( 'Secondary Button URL', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'hero_btn2_url', '#contact' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();

			$badge      = ! empty( $settings['badge_text'] ) ? $settings['badge_text'] : portfolio_get_option( 'hero_tagline', 'Available for New Projects' );
			$greeting   = ! empty( $settings['greeting'] ) ? $settings['greeting'] : "Hi, I'm";
			$name       = ! empty( $settings['hero_name'] ) ? $settings['hero_name'] : portfolio_get_option( 'hero_name', 'Nasif Muquarrabin' );
			$title      = ! empty( $settings['hero_title'] ) ? $settings['hero_title'] : portfolio_get_option( 'hero_title', 'Full-Stack Developer' );
			$bio        = ! empty( $settings['hero_bio'] ) ? $settings['hero_bio'] : portfolio_get_option( 'hero_bio', '' );
			$avatar     = ! empty( $settings['hero_image']['url'] ) ? $settings['hero_image']['url'] : portfolio_get_option( 'hero_avatar', '' );
			$btn1_text  = ! empty( $settings['btn_primary_text'] ) ? $settings['btn_primary_text'] : portfolio_get_option( 'hero_btn_text', 'View Projects' );
			$btn1_url   = ! empty( $settings['btn_primary_url'] ) ? $settings['btn_primary_url'] : portfolio_get_option( 'hero_btn_url', '#portfolio' );
			$btn2_text  = ! empty( $settings['btn_secondary_text'] ) ? $settings['btn_secondary_text'] : portfolio_get_option( 'hero_btn2_text', 'Get In Touch' );
			$btn2_url   = ! empty( $settings['btn_secondary_url'] ) ? $settings['btn_secondary_url'] : portfolio_get_option( 'hero_btn2_url', '#contact' );
			?>
			<section class="py-12 sm:py-20 md:py-32 overflow-hidden relative border-b border-slate-100 dark:border-slate-800">
				<div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-10 md:gap-12">
					<div class="w-full md:w-3/5 text-center md:text-left flex flex-col items-center md:items-start">
						<?php if ( ! empty( $badge ) ) : ?>
							<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 mb-6 max-w-full text-left">
								<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
								<span><?php echo esc_html( $badge ); ?></span>
							</div>
						<?php endif; ?>
						<h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4 tracking-tight">
							<?php echo esc_html( $greeting ); ?> <span class="text-primary"><?php echo esc_html( $name ); ?></span>
						</h1>
						<?php if ( ! empty( $title ) ) : ?>
							<h2 class="text-lg sm:text-2xl font-semibold text-slate-700 dark:text-slate-300 mb-6">
								<?php echo esc_html( $title ); ?>
							</h2>
						<?php endif; ?>
						<?php if ( ! empty( $bio ) ) : ?>
							<div class="text-sm sm:text-lg text-slate-600 dark:text-slate-400 mb-8 max-w-2xl leading-relaxed">
								<?php echo wp_kses_post( $bio ); ?>
							</div>
						<?php endif; ?>
						<div class="flex flex-wrap items-center justify-center md:justify-start gap-3 sm:gap-4 w-full">
							<?php if ( ! empty( $btn1_text ) ) : ?>
								<a href="<?php echo esc_url( $btn1_url ); ?>" class="theme-btn-primary">
									<span><?php echo esc_html( $btn1_text ); ?></span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
								</a>
							<?php endif; ?>
							<?php if ( ! empty( $btn2_text ) ) : ?>
								<a href="<?php echo esc_url( $btn2_url ); ?>" class="theme-btn-secondary">
									<span><?php echo esc_html( $btn2_text ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<?php if ( ! empty( $avatar ) ) : ?>
						<div class="w-full md:w-2/5 flex justify-center mt-8 md:mt-0 flex-shrink-0">
							<div class="relative w-52 h-52 sm:w-64 sm:h-64 md:w-80 md:h-80 rounded-3xl overflow-hidden shadow-2xl border-4 border-white dark:border-slate-800 bg-slate-100 dark:bg-slate-800">
								<img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="w-full h-full object-cover">
							</div>
						</div>
					<?php endif; ?>
				</div>
			</section>
			<?php
		}
	}

	// =========================================================================
	// 2. ABOUT WIDGET
	// =========================================================================
	class PortfolioWind_About_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_about'; }
		public function get_title() { return esc_html__( 'About & Skills', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-info-box'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_about_content',
				array(
					'label' => esc_html__( 'About Information', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'about_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Biography', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'about_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'About Me', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'about_bio',
				array(
					'label'   => esc_html__( 'Bio Paragraph', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXTAREA,
					'default' => portfolio_get_option( 'about_bio', 'Full-stack software engineer specialized in building scalable, secure, and modern web applications.' ),
				)
			);

			$this->add_control(
				'stat_exp',
				array(
					'label'   => esc_html__( 'Years Experience', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'about_stat_exp', '6+' ),
				)
			);

			$this->add_control(
				'stat_proj',
				array(
					'label'   => esc_html__( 'Completed Projects', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'about_stat_proj', '50+' ),
				)
			);

			$this->add_control(
				'stat_clients',
				array(
					'label'   => esc_html__( 'Satisfied Clients', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'about_stat_clients', '35+' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'about' );
		}
	}

	// =========================================================================
	// 3. SERVICES WIDGET
	// =========================================================================
	class PortfolioWind_Services_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_services'; }
		public function get_title() { return esc_html__( 'Services & Offerings', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-cogs'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_services_content',
				array(
					'label' => esc_html__( 'Services Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'services_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Specialized Services', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'services_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'What I Do & Offer', 'portfoliowind' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'services' );
		}
	}

	// =========================================================================
	// 4. PROJECTS WIDGET
	// =========================================================================
	class PortfolioWind_Projects_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_projects'; }
		public function get_title() { return esc_html__( 'Projects Showcase', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-gallery-grid'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_projects_content',
				array(
					'label' => esc_html__( 'Projects Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'projects_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Case Studies & Works', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'projects_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Featured Projects', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'view_all_text',
				array(
					'label'   => esc_html__( '"View All" Button Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'View All Projects & Case Studies', 'portfoliowind' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'projects' );
		}
	}

	// =========================================================================
	// 5. RESUME WIDGET
	// =========================================================================
	class PortfolioWind_Resume_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_resume'; }
		public function get_title() { return esc_html__( 'Resume & Experience', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-bullet-list'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_resume_content',
				array(
					'label' => esc_html__( 'Resume Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'resume_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Career Milestone & Education', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'resume_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Experience & Education', 'portfoliowind' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'resume' );
		}
	}

	// =========================================================================
	// 6. BLOG WIDGET
	// =========================================================================
	class PortfolioWind_Blog_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_blog'; }
		public function get_title() { return esc_html__( 'Blog & Latest Articles', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-post-list'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_blog_content',
				array(
					'label' => esc_html__( 'Blog Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'blog_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'From the Blog', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'blog_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Latest Articles & Insights', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'btn_view_all_text',
				array(
					'label'   => esc_html__( '"View All" Button Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'View All Articles & Tutorials', 'portfoliowind' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'blog' );
		}
	}

	// =========================================================================
	// 7. CONTACT WIDGET
	// =========================================================================
	class PortfolioWind_Contact_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_contact'; }
		public function get_title() { return esc_html__( 'Contact & Social Channels', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-mail'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_contact_content',
				array(
					'label' => esc_html__( 'Contact Channels', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$this->add_control(
				'contact_badge',
				array(
					'label'   => esc_html__( 'Badge Text', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Get In Touch', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'contact_title',
				array(
					'label'   => esc_html__( 'Section Title', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( "Let's Work Together", 'portfoliowind' ),
				)
			);

			$this->add_control(
				'contact_email',
				array(
					'label'   => esc_html__( 'Email Address', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'contact_email', '' ),
				)
			);

			$this->add_control(
				'contact_phone',
				array(
					'label'   => esc_html__( 'Phone Number', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'contact_phone', '' ),
				)
			);

			$this->add_control(
				'contact_location',
				array(
					'label'   => esc_html__( 'Location', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => portfolio_get_option( 'contact_location', '' ),
				)
			);

			$this->add_control(
				'form_shortcode',
				array(
					'label'       => esc_html__( 'Contact Form Shortcode (Fluent Forms / WPForms)', 'portfoliowind' ),
					'type'        => \Elementor\Controls_Manager::TEXT,
					'placeholder' => '[fluentform id="1"]',
					'default'     => portfolio_get_option( 'contact_form_shortcode', '' ),
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			get_template_part( 'template-parts/section', 'contact' );
		}
	}

	// =========================================================================
	// 8. HEADER & NAVIGATION MENU WIDGET (Customizable via Elementor)
	// =========================================================================
	class PortfolioWind_Nav_Menu_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_nav_menu'; }
		public function get_title() { return esc_html__( 'Portfolio Header & Navigation', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-nav-menu'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_menu_settings',
				array(
					'label' => esc_html__( 'Navigation Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			// Collect available WordPress menus
			$menus_options = array(
				'default' => esc_html__( 'Default (Home, Projects, Blogs, Contact)', 'portfoliowind' ),
			);
			$wp_menus = wp_get_nav_menus();
			if ( ! empty( $wp_menus ) ) {
				foreach ( $wp_menus as $menu_obj ) {
					$menus_options[ $menu_obj->slug ] = $menu_obj->name;
				}
			}

			$this->add_control(
				'selected_menu',
				array(
					'label'       => esc_html__( 'Select Menu', 'portfoliowind' ),
					'type'        => \Elementor\Controls_Manager::SELECT,
					'options'     => $menus_options,
					'default'     => 'default',
					'description' => esc_html__( 'Choose a custom WordPress menu from Appearance > Menus or use the default theme links.', 'portfoliowind' ),
				)
			);

			$this->add_control(
				'show_search',
				array(
					'label'        => esc_html__( 'Show Search Bar', 'portfoliowind' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'portfoliowind' ),
					'label_off'    => esc_html__( 'No', 'portfoliowind' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->add_control(
				'show_theme_toggle',
				array(
					'label'        => esc_html__( 'Show Dark Mode Toggle', 'portfoliowind' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'portfoliowind' ),
					'label_off'    => esc_html__( 'No', 'portfoliowind' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->add_control(
				'show_logo',
				array(
					'label'        => esc_html__( 'Show Brand Logo', 'portfoliowind' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'portfoliowind' ),
					'label_off'    => esc_html__( 'No', 'portfoliowind' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$selected = $settings['selected_menu'] ?? 'default';
			$show_search = ( 'yes' === ( $settings['show_search'] ?? 'yes' ) );
			$show_toggle = ( 'yes' === ( $settings['show_theme_toggle'] ?? 'yes' ) );
			$show_logo   = ( 'yes' === ( $settings['show_logo'] ?? 'yes' ) );
			?>
			<nav class="w-full bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 px-4 py-4 rounded-2xl transition-colors">
				<div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
					<?php if ( $show_logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 text-lg font-bold text-slate-900 dark:text-white">
							<span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-extrabold text-sm shadow-md flex-shrink-0">
								<?php echo esc_html( strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ) ); ?>
							</span>
							<span><?php bloginfo( 'name' ); ?></span>
						</a>
					<?php endif; ?>

					<div class="site-navigation hidden md:flex items-center gap-7 text-sm font-medium text-slate-600 dark:text-slate-300">
						<?php
						$custom_menu = ( 'default' !== $selected && ! empty( $selected ) ) ? $selected : '';
						if ( has_nav_menu( 'primary' ) || ! empty( $custom_menu ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'menu'           => $custom_menu,
									'container'      => false,
									'menu_class'     => 'flex items-center gap-7',
									'fallback_cb'    => false,
								)
							);
						} else {
							?>
							<ul class="flex items-center gap-7 list-none m-0 p-0">
								<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Blogs', 'portfoliowind' ); ?></a></li>
								<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Contact', 'portfoliowind' ); ?></a></li>
							</ul>
							<?php
						}
						?>
					</div>

					<div class="flex items-center gap-3">
						<?php if ( $show_search ) : ?>
							<div class="hidden sm:flex items-center">
								<?php get_search_form(); ?>
							</div>
						<?php endif; ?>

						<?php if ( $show_toggle ) : ?>
							<button type="button" class="theme-mode-toggle p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors" title="<?php esc_attr_e( 'Toggle Theme Mode', 'portfoliowind' ); ?>">
								<svg class="icon-sun w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
								<svg class="icon-moon w-4 h-4 text-slate-600 dark:text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
							</button>
						<?php endif; ?>
					</div>
				</div>
			</nav>
			<?php
		}
	}

	// =========================================================================
	// 9. FOOTER & NAVIGATION MENU WIDGET (Customizable via Elementor)
	// =========================================================================
	class PortfolioWind_Footer_Nav_Widget extends \Elementor\Widget_Base {
		public function get_name() { return 'portfoliowind_footer_nav'; }
		public function get_title() { return esc_html__( 'Portfolio Footer & Navigation', 'portfoliowind' ); }
		public function get_icon() { return 'eicon-footer'; }
		public function get_categories() { return array( 'portfoliowind-elements' ); }

		protected function register_controls() {
			$this->start_controls_section(
				'section_footer_settings',
				array(
					'label' => esc_html__( 'Footer Settings', 'portfoliowind' ),
					'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				)
			);

			$menus_options = array(
				'default' => esc_html__( 'Default (Home, Projects, Blogs, Contact)', 'portfoliowind' ),
			);
			$wp_menus = wp_get_nav_menus();
			if ( ! empty( $wp_menus ) ) {
				foreach ( $wp_menus as $menu_obj ) {
					$menus_options[ $menu_obj->slug ] = $menu_obj->name;
				}
			}

			$this->add_control(
				'selected_menu',
				array(
					'label'   => esc_html__( 'Select Menu', 'portfoliowind' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => $menus_options,
					'default' => 'default',
				)
			);

			$this->add_control(
				'show_logo',
				array(
					'label'        => esc_html__( 'Show Brand Logo', 'portfoliowind' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'portfoliowind' ),
					'label_off'    => esc_html__( 'No', 'portfoliowind' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				)
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$selected = $settings['selected_menu'] ?? 'default';
			$show_logo = ( 'yes' === ( $settings['show_logo'] ?? 'yes' ) );
			?>
			<footer class="w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 rounded-2xl p-6 transition-colors">
				<div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-5">
					<?php if ( $show_logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2.5 text-lg font-bold text-slate-900 dark:text-white">
							<span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-extrabold text-sm shadow-md flex-shrink-0">
								<?php echo esc_html( strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ) ); ?>
							</span>
							<span><?php bloginfo( 'name' ); ?></span>
						</a>
					<?php endif; ?>

					<nav class="footer-navigation flex flex-wrap items-center justify-center gap-5 sm:gap-7 text-sm font-medium text-slate-600 dark:text-slate-300">
						<?php
						$custom_footer_menu = ( 'default' !== $selected && ! empty( $selected ) ) ? $selected : '';
						if ( has_nav_menu( 'footer' ) || ! empty( $custom_footer_menu ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'menu'           => $custom_footer_menu,
									'container'      => false,
									'menu_class'     => 'flex flex-wrap items-center justify-center gap-5 sm:gap-7',
									'fallback_cb'    => false,
								)
							);
						} else {
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Projects', 'portfoliowind' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Blogs', 'portfoliowind' ); ?></a>
							<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Contact', 'portfoliowind' ); ?></a>
							<?php
						}
						?>
					</nav>
				</div>
			</footer>
			<?php
		}
	}

	// Register all 9 custom Elementor widgets
	$widgets_manager->register( new PortfolioWind_Hero_Widget() );
	$widgets_manager->register( new PortfolioWind_About_Widget() );
	$widgets_manager->register( new PortfolioWind_Services_Widget() );
	$widgets_manager->register( new PortfolioWind_Projects_Widget() );
	$widgets_manager->register( new PortfolioWind_Resume_Widget() );
	$widgets_manager->register( new PortfolioWind_Blog_Widget() );
	$widgets_manager->register( new PortfolioWind_Contact_Widget() );
	$widgets_manager->register( new PortfolioWind_Nav_Menu_Widget() );
	$widgets_manager->register( new PortfolioWind_Footer_Nav_Widget() );
}
add_action( 'elementor/widgets/register', 'foliowind_register_elementor_widgets' );
