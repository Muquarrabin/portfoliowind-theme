/**
 * Portfolio Studio Admin Script
 * Tab switching, WP Media Uploader, and Dynamic Repeaters
 */

jQuery(document).ready(function ($) {
  // 1. Tab Switching: Smart Persistence (Studio-internal navigation stays where left; external entry starts at first tab)
  const lastTabKey = 'portfoliowind_last_tab';
  const sidebarClickKey = 'portfoliowind_sidebar_clicked';

  // Check if navigation came from clicking the WP admin sidebar menu item
  let wasSidebarClicked = false;
  try {
    if (sessionStorage.getItem(sidebarClickKey) === '1') {
      wasSidebarClicked = true;
      sessionStorage.removeItem(sidebarClickKey);
    }
  } catch (e) {}

  // Determine if this page load is coming from Studio itself:
  // e.g. reload (F5 / Ctrl+R), options.php form save redirect, explicit hash, or same-page referrer
  function isComingFromStudio() {
    if (wasSidebarClicked) {
      return false;
    }

    // 1. Explicit hash in URL (e.g. #tab-styling or #styling)
    if (window.location.hash && window.location.hash.match(/#tab-[a-z0-9_-]+|#[a-z0-9_-]+/i)) {
      return true;
    }

    // 2. Page reload (F5 / browser refresh / location.reload)
    try {
      const navEntries = (window.performance && performance.getEntriesByType) ? performance.getEntriesByType('navigation') : [];
      if (navEntries.length && navEntries[0].type === 'reload') {
        return true;
      }
      if (window.performance && window.performance.navigation && window.performance.navigation.type === 1) {
        return true;
      }
    } catch (e) {}

    // 3. Settings saved (WordPress options.php redirected back)
    try {
      const urlParams = new URLSearchParams(window.location.search);
      if (urlParams.get('settings-updated') === 'true') {
        return true;
      }
    } catch (e) {}

    // 4. Referrer check: was the previous request Studio itself or options.php?
    const referrer = document.referrer || '';
    if (referrer) {
      if (referrer.includes('page=portfolio-studio') || referrer.includes('options.php')) {
        return true;
      }
    }

    return false;
  }

  const fromStudio = isComingFromStudio();
  let initialTab = '';

  if (fromStudio) {
    // 1. Check explicit URL hash first
    if (window.location.hash) {
      const rawHash = window.location.hash.replace('#tab-', '').replace('#', '');
      if ($(`.portfolio-tab-link[data-tab="${rawHash}"]`).length) {
        initialTab = rawHash;
      }
    }

    // 2. Check remembered tab where user left off
    if (!initialTab) {
      try {
        const storedTab = sessionStorage.getItem(lastTabKey);
        if (storedTab && $(`.portfolio-tab-link[data-tab="${storedTab}"]`).length) {
          initialTab = storedTab;
        }
      } catch (e) {}
    }
  } else {
    // Coming from other WP admin pages or fresh outside entry: clear memory to guarantee clean first tab
    try {
      sessionStorage.removeItem(lastTabKey);
    } catch (e) {}
  }

  // Fallback: Default to the first menu tab ('hero' / Hero & Bio)
  if (!initialTab) {
    initialTab = $('.portfolio-tab-link').first().data('tab') || 'hero';
  }

  function activateTab(tabId, updateHistory) {
    if (!tabId || !$(`.portfolio-tab-link[data-tab="${tabId}"]`).length) {
      tabId = $('.portfolio-tab-link').first().data('tab') || 'hero';
    }

    $('.portfolio-tab-link').removeClass('active');
    $('.portfolio-tab-pane').removeClass('active');

    $(`.portfolio-tab-link[data-tab="${tabId}"]`).addClass('active');
    $(`#tab-${tabId}`).addClass('active');

    // Remember where the user left off in sessionStorage
    try {
      sessionStorage.setItem(lastTabKey, tabId);
    } catch (e) {}

    // Update URL hash smoothly without jumpy scroll
    if (updateHistory !== false && window.history && window.history.replaceState) {
      window.history.replaceState(null, null, '#tab-' + tabId);
    }

    // Smoothly scroll active tab into view when in horizontal scrollable mode
    const navEl = document.querySelector('.portfolio-studio-nav');
    const activeTabEl = document.querySelector(`.portfolio-tab-link[data-tab="${tabId}"]`);
    if (navEl && activeTabEl && navEl.scrollWidth > navEl.clientWidth) {
      activeTabEl.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    if (tabId === 'projects') {
      initFeaturedProjectsSelect();
    }
  }

  // Initial tab activation
  activateTab(initialTab, false);
  initFeaturedProjectsSelect();

  $('.portfolio-tab-link').on('click', function (e) {
    e.preventDefault();
    const tabId = $(this).data('tab');
    activateTab(tabId);
  });

  // Clicking WP admin sidebar menu item resets to first tab
  $(document).on('click', '#adminmenu a[href*="page=portfolio-studio"]', function () {
    try {
      sessionStorage.removeItem(lastTabKey);
      sessionStorage.setItem(sidebarClickKey, '1');
    } catch (e) {}
  });

  // When submitting settings form, preserve active tab in sessionStorage and referer
  $('form[action="options.php"]').on('submit', function () {
    const currentTab = $('.portfolio-tab-link.active').data('tab') || 'hero';
    try {
      sessionStorage.setItem(lastTabKey, currentTab);
    } catch (e) {}

    const refererInput = $(this).find('input[name="_wp_http_referer"]');
    if (refererInput.length) {
      let refVal = refererInput.val();
      refVal = refVal.split('#')[0] + '#tab-' + currentTab;
      refererInput.val(refVal);
    }
  });

  // 1b. Enable intuitive Mouse-Wheel Horizontal Scrolling on Tab Bar
  const studioNav = document.querySelector('.portfolio-studio-nav');
  if (studioNav) {
    studioNav.addEventListener('wheel', function (e) {
      if (e.deltaY !== 0 && studioNav.scrollWidth > studioNav.clientWidth) {
        e.preventDefault();
        studioNav.scrollLeft += e.deltaY;
      }
    }, { passive: false });
  }

  // 2. WP Media Uploader integration
  $(document).on('click', '.upload-media-btn', function (e) {
    e.preventDefault();
    const button = $(this);
    const targetInput = $(button.data('target-input'));
    const previewContainer = $(button.data('preview'));

    const customUploader = wp.media({
      title: button.data('title') || 'Select Media',
      button: {
        text: 'Use this media'
      },
      multiple: false
    }).on('select', function () {
      const attachment = customUploader.state().get('selection').first().toJSON();
      targetInput.val(attachment.url);

      if (previewContainer.length) {
        if (attachment.type === 'image') {
          previewContainer.html(`<img src="${attachment.url}" alt="Preview" style="max-width:100px; height:auto; border-radius:8px; margin-top:8px;">`);
        } else {
          previewContainer.html(`<p style="font-size:12px; color:#4f46e5; margin-top:6px;">Selected: ${attachment.filename}</p>`);
        }
      }
    }).open();
  });

  // 3. Repeater row removal
  $(document).on('click', '.remove-repeater-btn', function (e) {
    e.preventDefault();
    $(this).closest('.repeater-item').fadeOut(200, function () {
      $(this).remove();
    });
  });

  // 3b. Initialize Select2 for Project Category with Search & Tagging
  function initProjectSelect2($context) {
    if (typeof $.fn.select2 === 'undefined') {
      return;
    }
    const $targets = $context ? $context.find('.project-cat-select') : $('.project-cat-select');
    $targets.each(function () {
      const $select = $(this);
      if (!$select.hasClass('select2-hidden-accessible')) {
        $select.select2({
          placeholder: 'Search or select category...',
          allowClear: false,
          width: '100%',
          tags: true,
          createTag: function (params) {
            const term = $.trim(params.term);
            if (term === '') {
              return null;
            }
            const slug = term.toLowerCase().replace(/[^a-z0-9_-]/g, '-');
            return {
              id: slug,
              text: term + ' (' + slug + ')',
              newTag: true
            };
          }
        });
      }
    });
  }

  // 4. Adding new Skill repeater
  $('#add-skill-btn').on('click', function (e) {
    e.preventDefault();
    const index = $('#skills-container .repeater-item').length;
    const html = `
      <div class="repeater-item">
        <div class="repeater-item-header">
          <h4>Skill #${index + 1}</h4>
          <button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> Remove</button>
        </div>
        <div class="repeater-row" style="margin-bottom:0;">
          <div class="repeater-col flex-2">
            <label>Skill Name</label>
            <input type="text" name="portfolio_options[skills][${index}][name]" placeholder="e.g. WordPress, React, Figma">
          </div>
          <div class="repeater-col flex-1">
            <label>Proficiency (0-100%)</label>
            <input type="number" min="1" max="100" name="portfolio_options[skills][${index}][percent]" placeholder="90">
          </div>
        </div>
      </div>`;
    $('#skills-container').append(html);
  });

  // 5. Adding new Service repeater
  $('#add-service-btn').on('click', function (e) {
    e.preventDefault();
    const index = $('#services-container .repeater-item').length;
    const html = `
      <div class="repeater-item">
        <div class="repeater-item-header">
          <h4>Service #${index + 1}</h4>
          <button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> Remove</button>
        </div>
        <div class="form-group">
          <label>Service Title</label>
          <input type="text" name="portfolio_options[services][${index}][title]" placeholder="e.g. Web Development">
        </div>
        <div class="form-group">
          <label>Icon Name (Dashicon code)</label>
          <input type="text" name="portfolio_options[services][${index}][icon]" placeholder="dashicons-laptop or dashicons-layout">
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Service Description</label>
          <textarea name="portfolio_options[services][${index}][desc]" rows="2" placeholder="Brief summary of service..."></textarea>
        </div>
      </div>`;
    $('#services-container').append(html);
  });

  // 6. Featured Projects Selector (Select2 Multi-Select)
  function initFeaturedProjectsSelect() {
    const $select = $('#featured-projects-select');
    if ($select.length && typeof $.fn.select2 !== 'undefined') {
      $select.select2({
        placeholder: 'Click to search and select projects...',
        allowClear: true,
        width: '100%'
      });
    }
  }

  // Live removal of a featured project from preview card
  $(document).on('click', '.remove-featured-project-btn', function (e) {
    e.preventDefault();
    const postId = $(this).data('post-id');
    const $select = $('#featured-projects-select');
    if ($select.length) {
      const currentVals = $select.val() || [];
      const updatedVals = currentVals.filter(function (id) {
        return String(id) !== String(postId);
      });
      $select.val(updatedVals).trigger('change');
      $(this).closest('.featured-card-preview').fadeOut(200, function () {
        $(this).remove();
        const remaining = $('.featured-card-preview').length;
        $('#projects-count-badge').text(remaining + ' Active');
      });
    }
  });


  // 7. Adding new Resume/Timeline repeater
  $('#add-resume-btn').on('click', function (e) {
    e.preventDefault();
    const index = $('#resume-container .repeater-item').length;
    const html = `
      <div class="repeater-item">
        <div class="repeater-item-header">
          <h4>Milestone #${index + 1}</h4>
          <button type="button" class="remove-repeater-btn"><span class="dashicons dashicons-trash"></span> Remove</button>
        </div>
        <div class="repeater-row">
          <div class="repeater-col flex-1">
            <label>Type</label>
            <select name="portfolio_options[resume][${index}][type]">
              <option value="experience">Experience / Work</option>
              <option value="education">Education</option>
            </select>
          </div>
          <div class="repeater-col flex-2">
            <label>Role / Degree</label>
            <input type="text" name="portfolio_options[resume][${index}][role]" placeholder="e.g. Senior Frontend Engineer">
          </div>
        </div>
        <div class="repeater-row">
          <div class="repeater-col flex-2">
            <label>Company / University</label>
            <input type="text" name="portfolio_options[resume][${index}][company]" placeholder="e.g. Automattic Inc.">
          </div>
          <div class="repeater-col flex-1">
            <label>Years / Period</label>
            <input type="text" name="portfolio_options[resume][${index}][period]" placeholder="2022 - Present">
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0;">
          <label>Description / Key Achievements</label>
          <textarea name="portfolio_options[resume][${index}][desc]" rows="2" placeholder="Summarize achievements..."></textarea>
        </div>
      </div>`;
    $('#resume-container').append(html);
  });

  // ==========================================================================
  // 8. Bulk Import & Export Projects Functionality
  // ==========================================================================
  const $modal = $('#bulk-import-modal');
  let selectedFileContent = '';

  function openBulkImportModal() {
    $modal.addClass('active');
  }

  function closeBulkImportModal() {
    $modal.removeClass('active');
  }

  // Open Modal
  $(document).on('click', '.open-bulk-import-trigger, #open-bulk-import-btn', function (e) {
    e.preventDefault();
    openBulkImportModal();
  });

  // Close Modal
  $(document).on('click', '#close-bulk-import-modal, #cancel-import-modal-btn', function (e) {
    e.preventDefault();
    closeBulkImportModal();
  });

  $(document).on('click', '#bulk-import-modal', function (e) {
    if ($(e.target).is('#bulk-import-modal')) {
      closeBulkImportModal();
    }
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $modal.hasClass('active')) {
      closeBulkImportModal();
    }
  });

  // Tab switching in Modal (Upload vs Paste)
  $('.import-tab-btn').on('click', function () {
    const source = $(this).data('source');
    $('.import-tab-btn').removeClass('active');
    $(this).addClass('active');

    $('.import-source-panel').hide();
    $(`#panel-source-${source}`).fadeIn(150);
  });

  // Sample CSV template inserter
  $('#insert-sample-csv-btn').on('click', function () {
    const sampleCsv = `Title,Category,Excerpt,Content,Image,Client,Timeline,Role,TechStack,LiveURL,GitHubURL,Metric1_Val,Metric1_Lbl,Metric2_Val,Metric2_Lbl,Metric3_Val,Metric3_Lbl
"SaaS Analytics & Cloud Telemetry Platform",fullstack,"High-throughput real-time telemetry dashboard featuring event streaming, customizable KPI widgets, and hardware-accelerated charting.","<p class=""lead"">Enterprise telemetry platform.</p><h3>Architecture</h3><p>Kafka, ClickHouse, and Next.js.</p><h3>Outcomes</h3><p>Sub-second query latencies and 99.99% uptime.</p>",https://images.example.com/project-telemetry.jpg,"DataPulse Global Inc.","2025 (4 Months)","Lead Architect","Next.js, TypeScript, Tailwind CSS, ClickHouse",https://example.com/saas,https://github.com/example/saas,99.99%,Uptime SLA,4.2x,Query Speed,< 200ms,Latency
"Cross-Platform FinTech Mobile App",mobile,"High-security mobile banking and wealth management application.","<p class=""lead"">Mobile banking application.</p><h3>Security</h3><p>Biometric authentication and zero-knowledge encryption.</p>",https://images.example.com/project-fintech.jpg,"Aura Financial Tech","2025 (6 Months)","Mobile Lead","React Native, Expo, TypeScript, Tailwind",https://example.com/app,https://github.com/example/app,4.9 ★,App Store Rating,1.2M+,Active Users,0,Vulnerabilities
"Generative AI Semantic Search",ai,"Enterprise retrieval-augmented generation search assistant.","<p class=""lead"">Semantic search system indexing millions of technical documents.</p>",https://images.example.com/project-ai-search.jpg,"Synthetix AI Lab","2024 (3 Months)","AI Engineer","Python, FastAPI, OpenAI, Qdrant, React",https://example.com/ai,https://github.com/example/ai,94.8%,Retrieval Precision,780ms,Generation Time,15M+,Docs Indexed`;
    $('#import-paste-textarea').val(sampleCsv);
  });

  // File Upload & Drag-and-drop (.csv only)
  $('#browse-file-btn').on('click', function () {
    $('#import-file-input').trigger('click');
  });

  $('#import-file-input').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      handleImportCsvFile(file);
    }
  });

  const $dropzone = $('#import-dropzone');
  $dropzone.on('dragover', function (e) {
    e.preventDefault();
    $(this).addClass('drag-over');
  }).on('dragleave drop', function (e) {
    e.preventDefault();
    $(this).removeClass('drag-over');
    if (e.type === 'drop') {
      const file = e.originalEvent.dataTransfer.files[0];
      if (file) {
        handleImportCsvFile(file);
      }
    }
  });

  function handleImportCsvFile(file) {
    if (!file.name.toLowerCase().endsWith('.csv')) {
      alert('Please select a valid .csv file.');
      return;
    }
    const reader = new FileReader();
    reader.onload = function (event) {
      selectedFileContent = event.target.result;
      $('#selected-file-info').text(`✓ Loaded: ${file.name} (${Math.round(file.size / 1024)} KB)`).show();
    };
    reader.readAsText(file);
  }

  // Run Bulk Import Button (Strictly CSV)
  $('#execute-bulk-import-btn').on('click', function (e) {
    e.preventDefault();
    const $btn = $(this);
    const activeSource = $('.import-tab-btn.active').data('source') || 'upload';
    const mode = $('#import-mode').val() || 'append';
    const $statusMsg = $('#import-status-message');

    let importData = '';

    if (activeSource === 'paste') {
      importData = $.trim($('#import-paste-textarea').val());
      if (!importData) {
        alert('Please paste CSV rows into the text box first.');
        return;
      }
    } else {
      importData = selectedFileContent;
      if (!importData) {
        alert('Please choose or drop a CSV file first.');
        return;
      }
    }

    $btn.prop('disabled', true).css('opacity', '0.7');
    $('#import-btn-label').text('Importing Projects...');
    $statusMsg.hide().removeClass('notice-error notice-success');

    $.ajax({
      url: window.foliowindAdmin ? window.foliowindAdmin.ajaxUrl : ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'foliowind_bulk_import_projects',
        nonce: window.foliowindAdmin ? window.foliowindAdmin.nonce : '',
        mode: mode,
        import_data: importData
      },
      success: function (res) {
        $btn.prop('disabled', false).css('opacity', '1');
        $('#import-btn-label').text('Run CSV Import to Projects');

        if (res.success) {
          $statusMsg
            .css({ background: '#dcfce7', color: '#166534', border: '1px solid #bbf7d0' })
            .html(`<strong>✓ ${res.data.message}</strong> Refreshing projects list...`)
            .fadeIn(200);

          setTimeout(function () {
            window.location.reload();
          }, 900);
        } else {
          $statusMsg
            .css({ background: '#fee2e2', color: '#991b1b', border: '1px solid #fecaca' })
            .html(`<strong>Error:</strong> ${res.data && res.data.message ? res.data.message : 'Import failed'}`)
            .fadeIn(200);
        }
      },
      error: function () {
        $btn.prop('disabled', false).css('opacity', '1');
        $('#import-btn-label').text('Run CSV Import to Projects');
        $statusMsg
          .css({ background: '#fee2e2', color: '#991b1b', border: '1px solid #fecaca' })
          .html('<strong>Error:</strong> Server connection failed during import.')
          .fadeIn(200);
      }
    });
  });

  // Export Projects as JSON
  $('#export-projects-btn').on('click', function (e) {
    e.preventDefault();
    const $btn = $(this);
    $btn.prop('disabled', true).text('Exporting...');

    $.ajax({
      url: window.foliowindAdmin ? window.foliowindAdmin.ajaxUrl : ajaxurl,
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'foliowind_export_projects',
        nonce: window.foliowindAdmin ? window.foliowindAdmin.nonce : ''
      },
      success: function (res) {
        $btn.prop('disabled', false).html('<span class="dashicons dashicons-download" style="color: #475569 !important; vertical-align: middle;"></span> Export JSON');
        if (res.success && res.data) {
          const dataStr = 'data:text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(res.data.data, null, 2));
          const downloadAnchor = document.createElement('a');
          downloadAnchor.setAttribute('href', dataStr);
          downloadAnchor.setAttribute('download', res.data.filename || 'portfoliowind-projects.json');
          document.body.appendChild(downloadAnchor);
          downloadAnchor.click();
          downloadAnchor.remove();
        } else {
          alert('Export failed: ' + (res.data ? res.data.message : 'Unknown error'));
        }
      },
      error: function () {
        $btn.prop('disabled', false).html('<span class="dashicons dashicons-download"></span> Export JSON');
        alert('Server connection error while exporting projects.');
      }
    });
  });

  // ==========================================================================
  // 9. Theme Colors & Styling Palette Studio
  // ==========================================================================
  function hexToRgb(hex) {
    if (!hex) return { r: 99, g: 102, b: 241 };
    let c = hex.replace('#', '').trim();
    if (c.length === 3) {
      c = c.split('').map(function (char) { return char + char; }).join('');
    }
    const num = parseInt(c, 16);
    if (isNaN(num)) return { r: 99, g: 102, b: 241 };
    return {
      r: (num >> 16) & 255,
      g: (num >> 8) & 255,
      b: num & 255
    };
  }

  function darkenColor(hex, percent) {
    let rgb = hexToRgb(hex);
    let factor = 1 - (percent / 100);
    let r = Math.max(0, Math.min(255, Math.round(rgb.r * factor)));
    let g = Math.max(0, Math.min(255, Math.round(rgb.g * factor)));
    let b = Math.max(0, Math.min(255, Math.round(rgb.b * factor)));
    return '#' + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
  }

  function updateColorPreview(primary, hover) {
    const $preview = $('#theme-color-preview-box');
    if (!$preview.length) return;

    primary = primary || '#6366f1';
    hover = hover || '#4f46e5';

    const rgb = hexToRgb(primary);
    const rgbStr = `${rgb.r}, ${rgb.g}, ${rgb.b}`;

    $preview.css({
      '--preview-primary': primary,
      '--preview-hover': hover,
      '--preview-rgb': `${rgb.r} ${rgb.g} ${rgb.b}`
    });

    $preview.find('.preview-component-badge').css({
      'background-color': `rgba(${rgbStr}, 0.1)`,
      'color': primary,
      'border-color': `rgba(${rgbStr}, 0.25)`
    });

    $preview.find('.preview-pulse-dot').css('background-color', primary);
    $preview.find('.preview-btn-primary').css('background-color', primary);
    $preview.find('.preview-btn-outline').css({
      'color': primary,
      'border-color': primary
    });
    $preview.find('.preview-text-link').css('color', primary);
    $preview.find('.preview-progress-fill').css('background-color', primary);

    $('#preview-active-pill').text(primary.toUpperCase());

    // Highlight matching preset card if one matches
    $('.color-preset-card').each(function () {
      const presetPrimary = $(this).data('primary');
      if (presetPrimary && presetPrimary.toLowerCase() === primary.toLowerCase()) {
        $(this).addClass('is-active');
      } else {
        $(this).removeClass('is-active');
      }
    });
  }

  // Initialize WP Color Pickers
  if ($.fn.wpColorPicker) {
    $('#primary_color').wpColorPicker({
      change: function (event, ui) {
        const color = ui.color.toString();
        const hover = $('#primary_hover').val() || darkenColor(color, 12);
        updateColorPreview(color, hover);
      },
      clear: function () {
        const def = $('#primary_color').data('default-color') || '#6366f1';
        updateColorPreview(def, $('#primary_hover').val());
      }
    });

    $('#primary_hover').wpColorPicker({
      change: function (event, ui) {
        const hoverColor = ui.color.toString();
        const primary = $('#primary_color').val() || '#6366f1';
        updateColorPreview(primary, hoverColor);
      },
      clear: function () {
        const def = $('#primary_hover').data('default-color') || '#4f46e5';
        updateColorPreview($('#primary_color').val(), def);
      }
    });
  }

  // Handle Preset Clicks
  $(document).on('click', '.color-preset-card', function (e) {
    e.preventDefault();
    const primary = $(this).data('primary');
    const hover = $(this).data('hover');

    if (!primary) return;

    if ($.fn.wpColorPicker) {
      $('#primary_color').wpColorPicker('color', primary);
      $('#primary_hover').wpColorPicker('color', hover);
    } else {
      $('#primary_color').val(primary);
      $('#primary_hover').val(hover);
    }

    $('.color-preset-card').removeClass('is-active');
    $(this).addClass('is-active');

    updateColorPreview(primary, hover);
  });

  // Auto-Match Hover Button
  $('#btn-auto-hover').on('click', function (e) {
    e.preventDefault();
    const primary = $('#primary_color').val() || '#6366f1';
    const computedHover = darkenColor(primary, 14);

    if ($.fn.wpColorPicker) {
      $('#primary_hover').wpColorPicker('color', computedHover);
    } else {
      $('#primary_hover').val(computedHover);
    }

    updateColorPreview(primary, computedHover);
  });

  // Initial Preview Refresh on Styling Tab Activate
  $(document).on('click', '.portfolio-tab-link[data-tab="styling"]', function () {
    setTimeout(function () {
      const p = $('#primary_color').val() || '#6366f1';
      const h = $('#primary_hover').val() || '#4f46e5';
      updateColorPreview(p, h);
    }, 50);
  });
});
