/* SILIQ — interactions */

document.addEventListener('DOMContentLoaded', () => {

  /* Year in footer */
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  /* Header shadow on scroll */
  const header = document.getElementById('header');
  const onScroll = () => {
    if (!header) return;
    if (window.scrollY > 8) header.classList.add('is-scrolled');
    else header.classList.remove('is-scrolled');
  };
  document.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* Drawers (mobile menu + cart) */
  const openDrawer = (id) => {
    const d = document.getElementById(id);
    if (!d) return;
    d.classList.add('is-open');
    d.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  };
  const closeDrawer = (d) => {
    if (!d) return;
    d.classList.remove('is-open');
    d.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  };

  const cartTrigger = document.getElementById('cartTrigger');
  if (cartTrigger) cartTrigger.addEventListener('click', () => openDrawer('cartDrawer'));

  const menuTrigger = document.getElementById('menuTrigger');
  if (menuTrigger) menuTrigger.addEventListener('click', () => openDrawer('mobileMenu'));

  document.querySelectorAll('[data-close]').forEach(el => {
    el.addEventListener('click', () => closeDrawer(el.closest('.drawer')));
  });

  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    document.querySelectorAll('.drawer.is-open').forEach(closeDrawer);
  });

  /* Drawer-nav anchor links should close drawer first */
  document.querySelectorAll('.drawer-nav a').forEach(a => {
    a.addEventListener('click', () => closeDrawer(a.closest('.drawer')));
  });

  /* Reveal-on-scroll using IntersectionObserver */
  const reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && reveals.length) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add('is-visible');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach((el) => el.classList.add('is-visible'));
  }

  /* Subtle parallax on hero image */
  const heroImg = document.querySelector('.hero__media img');
  if (heroImg && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.addEventListener('scroll', () => {
      const y = Math.min(window.scrollY, 600);
      heroImg.style.transform = `translateY(${y * 0.18}px) scale(1.02)`;
    }, { passive: true });
  }
});
