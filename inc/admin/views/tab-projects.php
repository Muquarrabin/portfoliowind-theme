<?php
/**
 * Tab: Projects / Portfolio
 * Streamlined Single-Source Architecture:
 * All projects are managed in the WordPress Projects Custom Post Type.
 * Users can just click and select which projects to feature on the homepage from the dropdown!
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$target_post_type = function_exists( 'portfoliowind_get_primary_project_post_type' ) ? portfoliowind_get_primary_project_post_type() : 'portfoliowind_proj';
$all_cpt_projects = get_posts( array(
	'post_type'      => function_exists( 'portfoliowind_get_project_post_types' ) ? portfoliowind_get_project_post_types() : array( 'portfoliowind_proj', 'portfolio_project' ),
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

$published_count = count( $all_cpt_projects );
$featured_ids    = array_filter( array_map( 'absint', (array) ( $options['featured_projects'] ?? array() ) ) );
$sample_csv_url  = admin_url( 'admin-ajax.php?action=foliowind_download_sample_csv&nonce=' . wp_create_nonce( 'foliowind_admin_nonce' ) );

// Determine projects to display in preview (selected ones, or top 6 by default)
$preview_projects = array();
if ( ! empty( $featured_ids ) ) {
	foreach ( $featured_ids as $fid ) {
		$post_obj = get_post( $fid );
		if ( $post_obj && 'publish' === $post_obj->post_status && in_array( $post_obj->post_type, array( 'portfoliowind_proj', 'portfolio_project' ), true ) ) {
			$preview_projects[] = $post_obj;
		}
	}
}
$is_using_default_latest = empty( $preview_projects ) && ! empty( $all_cpt_projects );
if ( $is_using_default_latest ) {
	$preview_projects = array_slice( $all_cpt_projects, 0, 6 );
}
?>

<div id="tab-projects" class="portfolio-tab-pane">
	<h2><?php esc_html_e( 'Portfolio Projects Showcase', 'portfoliowind' ); ?></h2>
	<p class="tab-desc">
		<?php esc_html_e( 'All projects and case studies are managed directly in the WordPress Projects menu. Any project you publish or import there automatically appears in the dropdown below—just click and select which ones to showcase on your homepage!', 'portfoliowind' ); ?>
	</p>

	<!-- Projects Action Toolbar & Bulk Importer Launcher -->
	<div class="projects-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
		<div style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
			<?php esc_html_e( 'Homepage Featured Selection', 'portfoliowind' ); ?>
			<span id="projects-count-badge" style="display: inline-block; padding: 2px 8px; border-radius: 9999px; background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 700;">
				<?php echo esc_html( count( $preview_projects ) ); ?> <?php esc_html_e( 'Active', 'portfoliowind' ); ?>
			</span>
		</div>
		<div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
			<button type="button" id="open-bulk-import-btn" class="button button-secondary open-bulk-import-trigger" style="display: inline-flex; align-items: center; gap: 5px; font-weight: 600; color: #4f46e5; border-color: #c7d2fe;">
				<span class="dashicons dashicons-upload" style="color: #4f46e5 !important; vertical-align: middle;"></span> <?php esc_html_e( 'Import Projects (CSV)', 'portfoliowind' ); ?>
			</button>
			<a href="<?php echo esc_url( $sample_csv_url ); ?>" download="sample-portfolio-projects.csv" class="button" style="display: inline-flex; align-items: center; gap: 5px; font-weight: 500; color: #047857; border-color: #a7f3d0; background: #ecfdf5;">
				<span class="dashicons dashicons-download" style="color: #047857 !important; vertical-align: middle;"></span> <?php esc_html_e( 'Sample CSV', 'portfoliowind' ); ?>
			</a>
			<button type="button" id="export-projects-btn" class="button" style="display: inline-flex; align-items: center; gap: 5px; font-weight: 500; color: #475569;">
				<span class="dashicons dashicons-download" style="color: #475569 !important; vertical-align: middle;"></span> <?php esc_html_e( 'Export JSON', 'portfoliowind' ); ?>
			</button>
			<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . $target_post_type ) ); ?>" class="button" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 600;">
				<span class="dashicons dashicons-plus-alt2" style="color: #475569 !important; vertical-align: middle;"></span> <?php esc_html_e( 'Add New', 'portfoliowind' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $target_post_type ) ); ?>" class="button" style="font-weight: 500;">
				<?php esc_html_e( 'All Projects', 'portfoliowind' ); ?> (<?php echo esc_html( $published_count ); ?>)
			</a>
		</div>
	</div>

	<?php if ( ! empty( $all_cpt_projects ) ) : ?>
		<!-- Featured Projects Dropdown Selector -->
		<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<div class="form-group" style="margin-bottom: 0;">
				<label for="featured-projects-select" style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
					<?php esc_html_e( 'Select Featured Projects from Dropdown:', 'portfoliowind' ); ?>
				</label>
				<p class="description" style="margin-top: 0; margin-bottom: 12px; color: #64748b; font-size: 12.5px;">
					<?php esc_html_e( 'Click the box below to select projects from your custom post type. You can search by name, pick multiple projects, and remove with one click. (If empty, your latest 6 published projects are shown automatically).', 'portfoliowind' ); ?>
				</p>
				<select id="featured-projects-select" name="portfolio_options[featured_projects][]" multiple="multiple" style="width: 100%; min-height: 48px;" data-placeholder="<?php esc_attr_e( 'Click to search and select projects...', 'portfoliowind' ); ?>">
					<?php foreach ( $all_cpt_projects as $p ) : 
						$terms = get_the_terms( $p->ID, 'portfoliowind_project_category' );
						if ( empty( $terms ) || is_wp_error( $terms ) ) {
							$terms = get_the_terms( $p->ID, 'project_category' );
						}
						$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Case Study', 'portfoliowind' );
						$is_selected = in_array( $p->ID, $featured_ids, true );
					?>
						<option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $is_selected ); ?>>
							<?php echo esc_html( $p->post_title ); ?> (<?php echo esc_html( $cat_name ); ?>)
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<!-- Live Visual Preview of Featured Showcase on Front Page -->
		<div style="margin-bottom: 24px;">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
				<h4 style="margin: 0; font-size: 13.5px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.05em;">
					<?php esc_html_e( 'Live Preview: Projects Shown on Homepage', 'portfoliowind' ); ?>
					<?php if ( $is_using_default_latest ) : ?>
						<span style="font-size: 11px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 9999px; text-transform: none; margin-left: 6px;">
							<?php esc_html_e( 'Showing Latest by Default', 'portfoliowind' ); ?>
						</span>
					<?php endif; ?>
				</h4>
			</div>

			<div id="featured-projects-preview-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
				<?php foreach ( $preview_projects as $post_item ) : 
					$terms = get_the_terms( $post_item->ID, 'portfoliowind_project_category' );
					if ( empty( $terms ) || is_wp_error( $terms ) ) {
						$terms = get_the_terms( $post_item->ID, 'project_category' );
					}
					$cat_name = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'Case Study', 'portfoliowind' );
					$thumb_url = has_post_thumbnail( $post_item->ID ) ? get_the_post_thumbnail_url( $post_item->ID, 'medium' ) : portfoliowind_get_project_meta( $post_item->ID, 'image_url' );
				?>
					<div class="featured-card-preview" data-post-id="<?php echo esc_attr( $post_item->ID ); ?>" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
						<div>
							<!-- Thumbnail Preview -->
							<div style="height: 140px; background: #f1f5f9; position: relative; overflow: hidden;">
								<?php if ( ! empty( $thumb_url ) ) : ?>
									<img src="<?php echo esc_url( $thumb_url ); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
								<?php else : ?>
									<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
										<span class="dashicons dashicons-format-image" style="font-size: 36px; width: 36px; height: 36px;"></span>
									</div>
								<?php endif; ?>
								<span style="position: absolute; top: 8px; right: 8px; background: rgba(15, 23, 42, 0.8); color: #ffffff; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 9999px;">
									<?php echo esc_html( $cat_name ); ?>
								</span>
							</div>

							<!-- Card Content -->
							<div style="padding: 14px;">
								<h5 style="margin: 0 0 6px 0; font-size: 14px; font-weight: 700; color: #0f172a; line-height: 1.4;">
									<?php echo esc_html( $post_item->post_title ); ?>
								</h5>
								<p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.4;">
									<?php echo esc_html( wp_trim_words( $post_item->post_excerpt ?: $post_item->post_content, 12 ) ); ?>
								</p>
							</div>
						</div>

						<!-- Card Actions -->
						<div style="padding: 10px 14px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
							<a href="<?php echo esc_url( get_edit_post_link( $post_item->ID ) ); ?>" target="_blank" style="color: #4f46e5; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
								<span class="dashicons dashicons-edit" style="font-size: 14px; width: 14px; height: 14px;"></span>
								<?php esc_html_e( 'Edit Case Study ↗', 'portfoliowind' ); ?>
							</a>
							<button type="button" class="remove-featured-project-btn" data-post-id="<?php echo esc_attr( $post_item->ID ); ?>" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 12px; font-weight: 600; padding: 0;">
								<?php esc_html_e( 'Remove', 'portfoliowind' ); ?>
							</button>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	<?php else : ?>
		<!-- Empty State: No Projects In Database Yet -->
		<div style="background: #ffffff; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 48px 24px; text-align: center; margin-bottom: 24px;">
			<span class="dashicons dashicons-portfolio" style="font-size: 48px; width: 48px; height: 48px; color: #94a3b8; margin-bottom: 12px;"></span>
			<h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 700; color: #1e293b;">
				<?php esc_html_e( 'No Projects in Custom Post Type Yet', 'portfoliowind' ); ?>
			</h3>
			<p style="margin: 0 auto 24px auto; max-width: 520px; font-size: 13.5px; color: #64748b; line-height: 1.5;">
				<?php esc_html_e( 'Your portfolio is ready! Import your projects and case studies using our CSV template, or add them manually. Once imported, they will automatically populate the dropdown above for instant homepage selection.', 'portfoliowind' ); ?>
			</p>
			<div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
				<button type="button" class="button button-primary button-hero open-bulk-import-trigger" style="display: inline-flex; align-items: center; gap: 6px;">
					<span class="dashicons dashicons-upload" style="color: #ffffff !important; vertical-align: middle;"></span>
					<?php esc_html_e( 'Import Projects from CSV', 'portfoliowind' ); ?>
				</button>
				<a href="<?php echo esc_url( $sample_csv_url ); ?>" download="sample-portfolio-projects.csv" class="button button-hero" style="display: inline-flex; align-items: center; gap: 6px; color: #047857; border-color: #a7f3d0; background: #ecfdf5;">
					<span class="dashicons dashicons-download" style="color: #047857 !important; vertical-align: middle;"></span>
					<?php esc_html_e( 'Download Sample CSV', 'portfoliowind' ); ?>
				</a>
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . $target_post_type ) ); ?>" class="button button-hero" style="display: inline-flex; align-items: center; gap: 6px;">
					<span class="dashicons dashicons-plus-alt2" style="color: #475569 !important; vertical-align: middle;"></span>
					<?php esc_html_e( 'Add Project Manually', 'portfoliowind' ); ?>
				</a>
			</div>
		</div>
	<?php endif; ?>

	<!-- Modal: Bulk CSV Importer -->
	<div id="bulk-import-modal" class="studio-modal-overlay" style="display: none;">
		<div class="studio-modal-dialog" style="max-width: 680px;">
			<div class="studio-modal-header">
				<div style="display: flex; align-items: center; gap: 8px;">
					<span class="dashicons dashicons-upload" style="color: #6366f1; font-size: 20px;"></span>
					<h3 style="margin: 0; font-size: 16px; font-weight: 700; color: #1e293b;">
						<?php esc_html_e( 'Import Projects via CSV', 'portfoliowind' ); ?>
					</h3>
				</div>
				<button type="button" class="studio-modal-close" id="close-bulk-import-modal">&times;</button>
			</div>

			<div class="studio-modal-body">
				<!-- Sample Template Banner with Direct Download -->
				<div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
					<div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #166534; flex: 1; min-width: 240px;">
						<span class="dashicons dashicons-media-spreadsheet" style="font-size: 20px; width: 20px; height: 20px; color: #16a34a; flex-shrink: 0;"></span>
						<span><?php esc_html_e( 'Need the template? Download our pre-formatted sample CSV with columns for case studies, KPIs & tech stacks:', 'portfoliowind' ); ?></span>
					</div>
					<a href="<?php echo esc_url( $sample_csv_url ); ?>" download="sample-portfolio-projects.csv" class="button" style="font-weight: 600; color: #15803d; border-color: #86efac; background: #ffffff;">
						<span class="dashicons dashicons-download" style="color: #15803d !important; vertical-align: middle;"></span> <?php esc_html_e( 'Download Sample CSV', 'portfoliowind' ); ?>
					</a>
				</div>

				<!-- Source Sub-Tabs: Upload File vs Paste Rows -->
				<div class="import-source-tabs">
					<button type="button" class="import-tab-btn active" data-source="upload">
						<span class="dashicons dashicons-upload"></span>
						<?php esc_html_e( 'Upload CSV File', 'portfoliowind' ); ?>
					</button>
					<button type="button" class="import-tab-btn" data-source="paste">
						<span class="dashicons dashicons-clipboard"></span>
						<?php esc_html_e( 'Paste CSV Rows', 'portfoliowind' ); ?>
					</button>
				</div>

				<!-- Mode Selection Grid -->
				<div class="import-settings-grid" style="margin-bottom: 16px;">
					<div class="import-setting-col" style="flex: 1;">
						<label style="font-weight: 600; font-size: 12.5px; color: #334155; margin-bottom: 6px; display: block;">
							<?php esc_html_e( 'Import Mode:', 'portfoliowind' ); ?>
						</label>
						<select id="import-mode" class="import-select" style="width: 100%;">
							<option value="append"><?php esc_html_e( 'Append to Existing Projects (Keep Current)', 'portfoliowind' ); ?></option>
							<option value="replace"><?php esc_html_e( 'Replace Existing Projects (Fresh Start)', 'portfoliowind' ); ?></option>
						</select>
					</div>
				</div>

				<!-- Panel: Upload File -->
				<div id="panel-source-upload" class="import-source-panel active">
					<div class="import-dropzone" id="import-dropzone">
						<span class="dashicons dashicons-media-spreadsheet" style="font-size: 40px; width: 40px; height: 40px; color: #6366f1; margin-bottom: 8px;"></span>
						<strong style="color: #1e293b; font-size: 14.5px; display: block; margin-bottom: 4px;">
							<?php esc_html_e( 'Choose or Drag & Drop a .csv file', 'portfoliowind' ); ?>
						</strong>
						<span style="font-size: 12px; color: #64748b; margin-bottom: 12px; display: block;">
							<?php esc_html_e( 'Supports standard comma-separated project records (.csv)', 'portfoliowind' ); ?>
						</span>
						<input type="file" id="import-file-input" accept=".csv" style="display: none;">
						<button type="button" class="button" id="browse-file-btn">
							<?php esc_html_e( 'Browse CSV File...', 'portfoliowind' ); ?>
						</button>
						<div id="selected-file-info" style="display: none; margin-top: 10px; font-weight: 600; color: #4338ca; font-size: 12.5px;"></div>
					</div>
				</div>

				<!-- Panel: Paste CSV Rows -->
				<div id="panel-source-paste" class="import-source-panel" style="display: none;">
					<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
						<label style="font-weight: 600; font-size: 12.5px; color: #334155;">
							<?php esc_html_e( 'Paste CSV Content (with headers):', 'portfoliowind' ); ?>
						</label>
						<button type="button" class="button button-small" id="insert-sample-csv-btn">
							<?php esc_html_e( 'Insert Sample CSV Rows', 'portfoliowind' ); ?>
						</button>
					</div>
					<textarea id="import-paste-textarea" rows="8" placeholder="Title,Category,Excerpt,Content,Image,Client,Timeline,Role,TechStack,LiveURL,GitHubURL,Metric1_Val,Metric1_Lbl,Metric2_Val,Metric2_Lbl,Metric3_Val,Metric3_Lbl&#10;&quot;SaaS Telemetry Platform&quot;,fullstack,&quot;Real-time dashboard&quot;,&quot;&lt;p&gt;Details...&lt;/p&gt;&quot;,https://...,&quot;Client&quot;,&quot;2025&quot;,&quot;Architect&quot;,&quot;Next.js, TypeScript&quot;,https://...,https://...,99.9%,Uptime,4.2x,Speed,&lt;200ms,Latency" style="width: 100%; font-family: monospace; font-size: 12px; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;"></textarea>
				</div>

				<!-- Live Progress / Message Toast -->
				<div id="import-status-message" style="display: none; margin-top: 14px; padding: 10px 14px; border-radius: 6px; font-size: 13px;"></div>
			</div>

			<div class="studio-modal-footer">
				<button type="button" id="cancel-import-modal-btn" class="button">
					<?php esc_html_e( 'Cancel', 'portfoliowind' ); ?>
				</button>
				<button type="button" id="execute-bulk-import-btn" class="button button-primary" style="display: inline-flex; align-items: center; gap: 6px;">
					<span class="dashicons dashicons-upload" style="color: #ffffff !important; vertical-align: middle;"></span>
					<span id="import-btn-label"><?php esc_html_e( 'Run CSV Import to Projects', 'portfoliowind' ); ?></span>
				</button>
			</div>
		</div>
	</div>
</div>
