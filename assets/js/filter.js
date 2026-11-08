/**
 * PortfolioWind Portfolio Filter
 * Client-side category filtering for portfolio cards
 */

document.addEventListener('DOMContentLoaded', function () {
  // Portfolio Projects Filtering
  const filterBtns = document.querySelectorAll('.portfolio-filter-btn');
  const projectCards = document.querySelectorAll('.portfolio-project-card');

  if (filterBtns.length && projectCards.length) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', function () {
        const selectedFilter = this.getAttribute('data-filter');

        // Update button active state
        filterBtns.forEach(b => {
          b.classList.remove('bg-primary', 'text-white');
          b.classList.add('bg-white', 'dark:bg-slate-900', 'text-slate-700', 'dark:text-slate-300');
        });
        this.classList.remove('bg-white', 'dark:bg-slate-900', 'text-slate-700', 'dark:text-slate-300');
        this.classList.add('bg-primary', 'text-white');

        // Filter project cards without breaking flexbox column layout
        projectCards.forEach(card => {
          const cardCategory = card.getAttribute('data-category');
          if (selectedFilter === 'all' || cardCategory === selectedFilter) {
            card.style.display = '';
            card.style.opacity = '1';
          } else {
            card.style.display = 'none';
            card.style.opacity = '0';
          }
        });
      });
    });
  }

  // Blog Articles Filtering
  const blogFilterBtns = document.querySelectorAll('.blog-filter-btn');
  const blogCards = document.querySelectorAll('.portfolio-blog-card');

  if (blogFilterBtns.length && blogCards.length) {
    blogFilterBtns.forEach(btn => {
      btn.addEventListener('click', function () {
        const selectedFilter = this.getAttribute('data-filter');

        // Update button active state
        blogFilterBtns.forEach(b => {
          b.classList.remove('bg-primary', 'text-white');
          b.classList.add('bg-white', 'dark:bg-slate-900', 'text-slate-700', 'dark:text-slate-300');
        });
        this.classList.remove('bg-white', 'dark:bg-slate-900', 'text-slate-700', 'dark:text-slate-300');
        this.classList.add('bg-primary', 'text-white');

        // Filter blog cards
        blogCards.forEach(card => {
          const cardCategory = card.getAttribute('data-category');
          if (selectedFilter === 'all' || cardCategory === selectedFilter) {
            card.style.display = '';
            card.style.opacity = '1';
          } else {
            card.style.display = 'none';
            card.style.opacity = '0';
          }
        });
      });
    });
  }
});
