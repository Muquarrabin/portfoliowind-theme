<?php
/**
 * View: WordPress Custom Post Type Import Screen
 * Screen: wp-admin > Projects > Import Projects
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$primary_cpt     = function_exists( 'portfoliowind_get_primary_project_post_type' ) ? portfoliowind_get_primary_project_post_type() : 'portfoliowind_proj';
$cpt_count       = wp_count_posts( $primary_cpt );
$legacy_count    = ( 'portfolio_project' !== $primary_cpt ) ? wp_count_posts( 'portfolio_project' ) : null;
$published_count = ( $cpt_count->publish ?? 0 ) + ( $legacy_count->publish ?? 0 );
$sample_csv_url  = admin_url( 'admin-ajax.php?action=foliowind_download_sample_csv&nonce=' . wp_create_nonce( 'foliowind_admin_nonce' ) );
?>

<div class="wrap foliowind-admin-wrap" style="max-width: 1000px; margin-top: 20px;">
	<!-- Page Header & Action Navigation -->
	<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
		<div>
			<h1 style="display: flex; align-items: center; gap: 10px; margin: 0 0 6px 0; font-size: 24px; font-weight: 700; color: #0f172a;">
				<span class="dashicons dashicons-portfolio" style="font-size: 28px; width: 28px; height: 28px; color: #4f46e5;"></span>
				<?php esc_html_e( 'Import Case Studies & Projects (CSV)', 'portfoliowind' ); ?>
			</h1>
			<p style="margin: 0; color: #64748b; font-size: 13.5px;">
				<?php esc_html_e( 'Import full-length case studies with architecture breakdowns, KPIs, and cover mockups directly into WordPress Projects using CSV.', 'portfoliowind' ); ?>
			</p>
		</div>

		<div style="display: flex; gap: 8px; flex-wrap: wrap;">
			<a href="<?php echo esc_url( $sample_csv_url ); ?>" download="sample-portfolio-projects.csv" class="button" style="display: inline-flex; align-items: center; gap: 5px; font-weight: 600; color: #047857; border-color: #a7f3d0; background: #ecfdf5;">
				<span class="dashicons dashicons-download" style="font-size: 16px; width: 16px; height: 16px; color: #047857 !important; vertical-align: middle;"></span>
				<?php esc_html_e( 'Download Sample CSV', 'portfoliowind' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . $primary_cpt ) ); ?>" class="button" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 500;">
				<span class="dashicons dashicons-arrow-left-alt" style="font-size: 16px; width: 16px; height: 16px; color: #475569 !important; vertical-align: middle;"></span>
				<?php esc_html_e( 'All Projects', 'portfoliowind' ); ?>
				<span style="background: #e2e8f0; color: #475569; padding: 1px 7px; border-radius: 9999px; font-size: 11px; margin-left: 4px; font-weight: 600;">
					<?php echo esc_html( $published_count ); ?>
				</span>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=portfolio-studio#tab-projects' ) ); ?>" class="button button-secondary" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 600; color: #4f46e5; border-color: #c7d2fe;">
				<span class="dashicons dashicons-id-alt" style="font-size: 16px; width: 16px; height: 16px; color: #4f46e5 !important; vertical-align: middle;"></span>
				<?php esc_html_e( 'Configure in Studio →', 'portfoliowind' ); ?>
			</a>
		</div>
	</div>

	<!-- Info Notice Card -->
	<div style="background: #eef2ff; border: 1px solid #c7d2fe; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
		<div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 260px;">
			<span class="dashicons dashicons-info" style="font-size: 22px; width: 22px; height: 22px; color: #4f46e5; flex-shrink: 0;"></span>
			<div style="font-size: 13px; color: #312e81; line-height: 1.5;">
				<strong><?php esc_html_e( 'Single-Source Projects Architecture:', 'portfoliowind' ); ?></strong>
				<?php esc_html_e( 'All records imported from CSV are stored as native WordPress Custom Post Types and become instantly selectable on the homepage from PortfolioWind Studio.', 'portfoliowind' ); ?>
			</div>
		</div>
		<a href="<?php echo esc_url( $sample_csv_url ); ?>" download="sample-portfolio-projects.csv" class="button" style="font-weight: 600; color: #15803d; border-color: #86efac; background: #ffffff;">
			<span class="dashicons dashicons-download" style="color: #15803d !important; vertical-align: middle;"></span> <?php esc_html_e( 'Download Sample CSV', 'portfoliowind' ); ?>
		</a>
	</div>

	<!-- Main Import Container -->
	<div class="cpt-import-box" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 24px;">
		
		<!-- Settings Row: Mode Selection -->
		<div style="margin-bottom: 20px; padding-bottom: 18px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
			<div>
				<label style="font-weight: 700; font-size: 13px; color: #1e293b; display: block; margin-bottom: 3px;">
					<?php esc_html_e( 'Import Mode', 'portfoliowind' ); ?>
				</label>
				<span style="font-size: 12px; color: #64748b;">
					<?php esc_html_e( 'Choose whether to append new items or replace all existing projects.', 'portfoliowind' ); ?>
				</span>
			</div>
			<div>
				<select id="import-mode" class="import-select" style="min-width: 220px; height: 38px;">
					<option value="append"><?php esc_html_e( 'Append (Keep Existing Projects)', 'portfoliowind' ); ?></option>
					<option value="replace"><?php esc_html_e( 'Replace (Delete Existing Projects)', 'portfoliowind' ); ?></option>
				</select>
			</div>
		</div>

		<!-- Import Source Tabs Navigation -->
		<div class="import-source-tabs" style="display: flex; gap: 8px; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
			<button type="button" class="import-tab-btn active" data-source="upload">
				<span class="dashicons dashicons-upload"></span>
				<?php esc_html_e( 'Upload CSV File', 'portfoliowind' ); ?>
			</button>
			<button type="button" class="import-tab-btn" data-source="paste">
				<span class="dashicons dashicons-clipboard"></span>
				<?php esc_html_e( 'Paste CSV Content', 'portfoliowind' ); ?>
			</button>
		</div>

		<!-- Panel 1: Upload File -->
		<div id="panel-source-upload" class="import-source-panel active">
			<div class="import-dropzone" id="import-dropzone" style="border: 2px dashed #c7d2fe; background: #f8fafc; border-radius: 10px; padding: 36px 20px; text-align: center; cursor: pointer;">
				<span class="dashicons dashicons-media-spreadsheet" style="font-size: 48px; width: 48px; height: 48px; color: #6366f1; margin-bottom: 10px;"></span>
				<strong style="color: #1e293b; font-size: 15px; display: block; margin-bottom: 4px;">
					<?php esc_html_e( 'Choose or Drag & Drop a .csv file', 'portfoliowind' ); ?>
				</strong>
				<span style="font-size: 12.5px; color: #64748b; margin-bottom: 14px; display: block;">
					<?php esc_html_e( 'Supports standard comma-separated project records (.csv) with headers', 'portfoliowind' ); ?>
				</span>
				<input type="file" id="import-file-input" accept=".csv" style="display: none;">
				<button type="button" class="button" id="browse-file-btn">
					<?php esc_html_e( 'Browse Local CSV File...', 'portfoliowind' ); ?>
				</button>
				<div id="selected-file-info" style="display: none; margin-top: 12px; font-weight: 600; color: #4338ca; font-size: 13px;"></div>
			</div>
		</div>

		<!-- Panel 2: Paste CSV Content -->
		<div id="panel-source-paste" class="import-source-panel" style="display: none;">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
				<label style="font-weight: 600; font-size: 13px; color: #334155;">
					<?php esc_html_e( 'Paste CSV Rows (with column headers):', 'portfoliowind' ); ?>
				</label>
				<button type="button" class="button button-small" id="insert-sample-csv-btn">
					<?php esc_html_e( 'Insert Sample CSV Rows', 'portfoliowind' ); ?>
				</button>
			</div>
			<textarea id="import-paste-textarea" rows="10" placeholder="Title,Category,Excerpt,Content,Image,Client,Timeline,Role,TechStack,LiveURL,GitHubURL,Metric1_Val,Metric1_Lbl,Metric2_Val,Metric2_Lbl,Metric3_Val,Metric3_Lbl&#10;&quot;SaaS Telemetry Platform&quot;,fullstack,&quot;Real-time dashboard&quot;,&quot;&lt;p&gt;Details...&lt;/p&gt;&quot;,https://...,&quot;Client&quot;,&quot;2025&quot;,&quot;Architect&quot;,&quot;Next.js, TypeScript&quot;,https://...,https://...,99.9%,Uptime,4.2x,Speed,&lt;200ms,Latency" style="width: 100%; font-family: monospace; font-size: 12px; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;"></textarea>
		</div>

		<!-- Action Footer & Progress Toast -->
		<div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
			<button type="button" id="execute-bulk-import-btn" class="button button-primary button-hero" style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; padding: 0 20px; height: 44px; line-height: 42px;">
				<span class="dashicons dashicons-upload" style="color: #ffffff !important; vertical-align: middle;"></span>
				<span id="import-btn-label"><?php esc_html_e( 'Run CSV Import to Projects', 'portfoliowind' ); ?></span>
			</button>

			<a href="<?php echo esc_url( admin_url( 'admin.php?page=portfolio-studio#tab-projects' ) ); ?>" class="button button-secondary" style="font-size: 13px; height: 38px; line-height: 36px;">
				<?php esc_html_e( 'Go to Portfolio Studio →', 'portfoliowind' ); ?>
			</a>
		</div>

		<!-- Dynamic Status / Alert Box -->
		<div id="import-status-message" style="display: none; margin-top: 16px; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; font-weight: 500;"></div>
	</div>
</div>


