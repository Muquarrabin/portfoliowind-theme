<?php
/**
 * Template Name: Contact Page (PortfolioWind)
 * Template Post Type: page
 *
 * Dedicated standalone page for Contact Us.
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$contact_email     = portfolio_get_option( 'contact_email', '' );
$contact_phone     = portfolio_get_option( 'contact_phone', '' );
$contact_loc       = portfolio_get_option( 'contact_location', '' );
$form_sc           = portfolio_get_option( 'contact_form_shortcode', '' );
$hide_contact_info = (bool) portfolio_get_option( 'hide_contact_info', false );

$github    = portfolio_get_option( 'social_github', '' );
$linkedin  = portfolio_get_option( 'social_linkedin', '' );
$twitter   = portfolio_get_option( 'social_twitter', '' );
$dribbble  = portfolio_get_option( 'social_dribbble', '' );
$instagram = portfolio_get_option( 'social_instagram', '' );
$has_socials = ( ! empty( $github ) || ! empty( $linkedin ) || ! empty( $twitter ) || ! empty( $dribbble ) || ! empty( $instagram ) );
?>

<section class="py-16 md:py-24 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 min-h-screen">
	<div class="max-w-7xl mx-auto px-4">

		<!-- Breadcrumb Navigation -->
		<nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-8" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors"><?php esc_html_e( 'Home', 'portfoliowind' ); ?></a>
			<span>/</span>
			<span class="text-slate-800 dark:text-slate-200 font-medium"><?php esc_html_e( 'Contact Us', 'portfoliowind' ); ?></span>
		</nav>

		<!-- Page Header -->
		<div class="text-center max-w-3xl mx-auto mb-16">
			<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
				<?php esc_html_e( 'Get In Touch', 'portfoliowind' ); ?>
			</span>
			<h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white mb-4">
				<?php esc_html_e( "Let's Connect & Work Together", 'portfoliowind' ); ?>
			</h1>
			<div class="w-16 h-1 bg-primary mx-auto rounded-full mb-6"></div>
			<p class="text-base sm:text-lg text-slate-600 dark:text-slate-400">
				<?php esc_html_e( 'Have a question, a project opportunity, or want to discuss a new collaboration? Drop a line below.', 'portfoliowind' ); ?>
			</p>
		</div>

		<!-- Main Contact Layout (2-Column Grid or Centered Single-Column if Contact Info Hidden) -->
		<div class="<?php echo $hide_contact_info ? 'max-w-2xl mx-auto mb-16' : 'grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-5xl mx-auto items-stretch mb-16'; ?>">

			<?php if ( ! $hide_contact_info ) : ?>
				<!-- Contact Information & Social Profiles Card -->
				<div class="p-8 sm:p-10 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
					<div>
						<div class="flex items-center gap-3 mb-6">
							<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400">
								<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
								<?php esc_html_e( 'Available for Opportunities', 'portfoliowind' ); ?>
							</span>
						</div>

						<h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
							<?php esc_html_e( 'Contact Information', 'portfoliowind' ); ?>
						</h2>
						<p class="text-sm text-slate-600 dark:text-slate-400 mb-8">
							<?php esc_html_e( 'Feel free to reach out directly through any of these communication channels. Typical reply time is within 24 hours.', 'portfoliowind' ); ?>
						</p>

						<div class="space-y-6">
							<?php if ( ! empty( $contact_email ) ) : ?>
								<div class="flex items-start gap-4">
									<div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
										</svg>
									</div>
									<div>
										<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider"><?php esc_html_e( 'Email', 'portfoliowind' ); ?></div>
										<a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="text-base font-medium text-slate-800 dark:text-slate-200 hover:text-primary transition-colors">
											<?php echo esc_html( $contact_email ); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $contact_phone ) ) : ?>
								<div class="flex items-start gap-4">
									<div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
										</svg>
									</div>
									<div>
										<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider"><?php esc_html_e( 'Phone', 'portfoliowind' ); ?></div>
										<a href="tel:<?php echo esc_attr( $contact_phone ); ?>" class="text-base font-medium text-slate-800 dark:text-slate-200 hover:text-primary transition-colors">
											<?php echo esc_html( $contact_phone ); ?>
										</a>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $contact_loc ) ) : ?>
								<div class="flex items-start gap-4">
									<div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
										</svg>
									</div>
									<div>
										<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider"><?php esc_html_e( 'Location', 'portfoliowind' ); ?></div>
										<div class="text-base font-medium text-slate-800 dark:text-slate-200">
											<?php echo esc_html( $contact_loc ); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Social Networks Bar with Generous Spacing -->
					<?php if ( $has_socials ) : ?>
						<div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800">
							<div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
								<?php esc_html_e( 'Connect Online', 'portfoliowind' ); ?>
							</div>
							<div class="social-icons-wrapper">
								<?php if ( ! empty( $github ) ) : ?>
									<a href="<?php echo esc_url( $github ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="GitHub" aria-label="GitHub">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $linkedin ) ) : ?>
									<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="LinkedIn" aria-label="LinkedIn">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $twitter ) ) : ?>
									<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="Twitter / X" aria-label="Twitter">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $dribbble ) ) : ?>
									<a href="<?php echo esc_url( $dribbble ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="Dribbble" aria-label="Dribbble">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm10.155 10.741c-.206-.025-2.025-.236-4.148.601-.173-.393-.357-.791-.555-1.192 3.125-1.42 4.382-3.155 4.549-3.398.884 1.134 1.455 2.497 1.624 3.989zm-2.671-5.185c-.218.286-1.488 1.89-4.469 3.18-1.452-2.613-3.072-4.993-3.33-5.374 1.341-.54 2.812-.844 4.354-.844 1.282 0 2.498.214 3.445.626v.412zm-9.484-2.802c.264.385 1.879 2.756 3.328 5.344-2.827 1.109-5.748 1.325-6.843 1.364.714-2.732 2.012-5.087 3.515-6.708zm-7.986 8.246c.995-.038 4.296-.282 7.37-1.489.206.417.397.832.576 1.242-4.17 1.492-7.464 4.606-7.839 4.974-.356-1.189-.554-2.457-.554-3.771 0-.323.016-.642.047-.956zm2.399 9.615c.44-.43 3.491-3.308 7.57-4.662 1.054 2.748 1.486 5.367 1.583 6.002-1.298.549-2.723.858-4.22.858-1.802 0-3.486-.454-4.933-1.246v-.048zm10.743.088c-.11-.69-.548-3.189-1.564-5.845 1.839-.773 3.385-.63 3.655-.601-.252 2.593-1.602 4.839-3.565 6.446h1.474z"/></svg>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $instagram ) ) : ?>
									<a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" title="Instagram" aria-label="Instagram">
										<svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Contact Form Card -->
			<div class="p-8 sm:p-10 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-center">
				<h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
					<?php esc_html_e( 'Send a Direct Message', 'portfoliowind' ); ?>
				</h2>
				<p class="text-sm text-slate-600 dark:text-slate-400 mb-8">
					<?php esc_html_e( 'Fill out the form below and we will get back to you promptly.', 'portfoliowind' ); ?>
				</p>

				<?php if ( ! empty( $form_sc ) ) : ?>
					<div class="portfolio-shortcode-form">
						<?php echo do_shortcode( $form_sc ); ?>
					</div>
				<?php else : ?>
					<form action="<?php echo ! empty( $contact_email ) ? esc_attr( 'mailto:' . $contact_email ) : '#'; ?>" method="post" enctype="text/plain" class="space-y-5">
						<div>
							<label for="contact-name" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">
								<?php esc_html_e( 'Your Name', 'portfoliowind' ); ?> <span class="text-rose-500">*</span>
							</label>
							<input type="text" id="contact-name" name="name" required class="portfolio-form-input" placeholder="<?php esc_attr_e( 'e.g. John Doe', 'portfoliowind' ); ?>" />
						</div>

						<div>
							<label for="contact-email" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">
								<?php esc_html_e( 'Email Address', 'portfoliowind' ); ?> <span class="text-rose-500">*</span>
							</label>
							<input type="email" id="contact-email" name="email" required class="portfolio-form-input" placeholder="<?php esc_attr_e( 'john@example.com', 'portfoliowind' ); ?>" />
						</div>

						<div>
							<label for="contact-subject" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">
								<?php esc_html_e( 'Subject', 'portfoliowind' ); ?>
							</label>
							<input type="text" id="contact-subject" name="subject" class="portfolio-form-input" placeholder="<?php esc_attr_e( 'Project Inquiry / Collaboration', 'portfoliowind' ); ?>" />
						</div>

						<div>
							<label for="contact-message" class="block text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-2">
								<?php esc_html_e( 'Message', 'portfoliowind' ); ?> <span class="text-rose-500">*</span>
							</label>
							<textarea id="contact-message" name="message" rows="5" required class="portfolio-form-input" placeholder="<?php esc_attr_e( 'Tell me about your project, goals, and timeline...', 'portfoliowind' ); ?>"></textarea>
						</div>

						<button type="submit" class="theme-btn-primary w-full">
							<span><?php esc_html_e( 'Send Message', 'portfoliowind' ); ?></span>
							<svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
							</svg>
						</button>
					</form>
				<?php endif; ?>
			</div>

		</div>

		<!-- Optional Page Editor Content -->
		<?php
		while ( have_posts() ) :
			the_post();
			if ( get_the_content() ) :
				?>
				<div class="prose dark:prose-invert max-w-4xl mx-auto mt-12 p-8 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800">
					<?php the_content(); ?>
				</div>
				<?php
			endif;
		endwhile;
		?>

	</div>
</section>

<?php
get_footer();

