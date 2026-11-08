/**
 * PortfolioWind Main Front-End Script
 * Handles Dark/Light Mode Switcher, Mobile Menu Drawer, and Smooth Scrolling
 */

(function () {
  'use strict';

  var htmlElement = document.documentElement;

  function getSavedTheme() {
    try {
      var saved = localStorage.getItem('portfoliowind_theme') || localStorage.getItem('portfoliocraft_theme');
      if (saved === 'dark' || saved === 'light') {
        return saved;
      }
    } catch (e) {}

    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    return prefersDark ? 'dark' : 'light';
  }

  function applyTheme(theme) {
    var isDark = (theme === 'dark');
    if (isDark) {
      htmlElement.classList.add('dark');
      if (document.body) {
        document.body.classList.add('dark');
      }
    } else {
      htmlElement.classList.remove('dark');
      if (document.body) {
        document.body.classList.remove('dark');
      }
    }

    try {
      localStorage.setItem('portfoliowind_theme', theme);
      localStorage.setItem('portfoliocraft_theme', theme);
    } catch (e) {}
  }

  // Initial sync before DOM ready
  applyTheme(getSavedTheme());

  document.addEventListener('DOMContentLoaded', function () {
    var bodyElement = document.body;

    // Ensure body matches html dark state
    if (htmlElement.classList.contains('dark')) {
      bodyElement.classList.add('dark');
    }

    // 1. Bulletproof Dark Mode Toggle with Event Delegation
    document.addEventListener('click', function (e) {
      var toggleBtn = e.target.closest('.theme-mode-toggle');
      if (!toggleBtn) return;

      e.preventDefault();
      var currentlyDark = htmlElement.classList.contains('dark');
      var newTheme = currentlyDark ? 'light' : 'dark';
      applyTheme(newTheme);
    });

    // 2. Mobile Menu Navigation Drawer
    var mobileMenuBtn = document.getElementById('mobile-menu-toggle');
    var mobileMenuDrawer = document.getElementById('mobile-menu-drawer');

    if (mobileMenuBtn && mobileMenuDrawer) {
      function toggleMobileMenu(open) {
        var isCurrentlyOpen = !mobileMenuDrawer.classList.contains('hidden');
        var shouldOpen = (typeof open === 'boolean') ? open : !isCurrentlyOpen;

        if (shouldOpen) {
          mobileMenuDrawer.classList.remove('hidden');
          mobileMenuBtn.classList.add('is-active');
          mobileMenuBtn.setAttribute('aria-expanded', 'true');
        } else {
          mobileMenuDrawer.classList.add('hidden');
          mobileMenuBtn.classList.remove('is-active');
          mobileMenuBtn.setAttribute('aria-expanded', 'false');
        }
      }

      mobileMenuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMobileMenu();
      });

      // Close on any link clicked inside drawer
      mobileMenuDrawer.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
          toggleMobileMenu(false);
        });
      });

      // Close mobile menu if clicked outside
      document.addEventListener('click', function (e) {
        if (!mobileMenuDrawer.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
          toggleMobileMenu(false);
        }
      });

      // Close on Escape key
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !mobileMenuDrawer.classList.contains('hidden')) {
          toggleMobileMenu(false);
        }
      });
    }

    // 3. Smooth Scrolling for Internal Hash Anchors
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        var targetId = this.getAttribute('href');
        if (targetId && targetId.length > 1 && !targetId.includes('/')) {
          try {
            var targetElement = document.querySelector(targetId);
            if (targetElement) {
              e.preventDefault();
              if (mobileMenuDrawer) {
                mobileMenuDrawer.classList.add('hidden');
              }
              targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
              });
              if (history.pushState) {
                history.pushState(null, null, targetId);
              }
            }
          } catch (err) {}
        }
      });
    });
  });
})();
