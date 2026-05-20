/* =============================================================
   SILIQ — interactions & animations
   Stack: Lenis + GSAP + ScrollTrigger + SplitType
============================================================= */

(function () {
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isTouch = window.matchMedia('(hover: none), (pointer: coarse)').matches;

  // If reduced motion: skip all anims, show everything immediately
  if (prefersReducedMotion) {
    document.body.classList.add('no-anim', 'is-loaded');
    const loader = document.getElementById('loader');
    if (loader) loader.style.display = 'none';
  }

  // Wait for DOM
  document.addEventListener('DOMContentLoaded', init);

  function init() {
    /* Footer year */
    const yearEl = document.getElementById('year');
    if (yearEl) yearEl.textContent = new Date().getFullYear();

    /* Drawers (mobile menu + cart) — works without GSAP */
    setupDrawers();

    if (prefersReducedMotion) {
      setupHeaderScrollState(null);
      return; // skip rest
    }

    /* Wait for vendor scripts to be available */
    if (typeof Lenis === 'undefined' || typeof gsap === 'undefined') {
      console.warn('[SILIQ] Vendor libraries not loaded — running degraded.');
      document.body.classList.add('no-anim', 'is-loaded');
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    /* 1. Smooth scroll (Lenis) */
    const lenis = setupLenis();

    /* 2. Custom cursor */
    if (!isTouch) setupCursor();

    /* Sticky header scroll-state */
    setupHeaderScrollState(lenis);

    /* Anchor links — use Lenis for smooth scroll to id */
    setupAnchorLinks(lenis);

    /* 3, 4, 7. Scroll-driven anims (text reveal, mask reveal, parallax, fades) */
    setupScrollAnimations();

    /* 11. Page transition (between pages) */
    setupPageTransitions();

    /* 12. Loader → hero intro */
    runIntroSequence();
  }

  /* =============================================================
     1) Lenis smooth scroll
  ============================================================= */
  function setupLenis() {
    const lenis = new Lenis({
      duration: 1.15,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
      wheelMultiplier: 1,
      touchMultiplier: 1.4,
    });

    // Keep ScrollTrigger in sync with Lenis
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => lenis.raf(time * 1000));
    gsap.ticker.lagSmoothing(0);

    // Expose for debugging / pause during transitions
    window._lenis = lenis;

    return lenis;
  }

  /* =============================================================
     2) Custom cursor (dot + lagging ring)
  ============================================================= */
  function setupCursor() {
    const dot = document.querySelector('.cursor-dot');
    const ring = document.querySelector('.cursor-ring');
    if (!dot || !ring) return;

    let mx = -100, my = -100;
    let rx = -100, ry = -100;
    let visible = true;

    window.addEventListener('mousemove', (e) => {
      mx = e.clientX;
      my = e.clientY;
      dot.style.transform = `translate3d(${mx}px, ${my}px, 0) translate(-50%, -50%)`;
    }, { passive: true });

    function tick() {
      rx += (mx - rx) * 0.18;
      ry += (my - ry) * 0.18;
      ring.style.transform = `translate3d(${rx}px, ${ry}px, 0) translate(-50%, -50%)`;
      requestAnimationFrame(tick);
    }
    tick();

    // Hover state on interactive elements
    const hoverSel = 'a, button, input, textarea, [data-cursor], [data-magnetic]';
    document.addEventListener('mouseover', (e) => {
      if (e.target.closest(hoverSel)) ring.classList.add('is-hover');
    });
    document.addEventListener('mouseout', (e) => {
      if (e.target.closest(hoverSel)) ring.classList.remove('is-hover');
    });

    // Hide when leaving window
    document.addEventListener('mouseleave', () => {
      dot.classList.add('is-hidden');
      ring.classList.add('is-hidden');
    });
    document.addEventListener('mouseenter', () => {
      dot.classList.remove('is-hidden');
      ring.classList.remove('is-hidden');
    });
  }

  /* =============================================================
     Header scroll state
  ============================================================= */
  function setupHeaderScrollState(lenis) {
    const header = document.getElementById('header');
    if (!header) return;
    const update = (y) => {
      if (y > 8) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    };
    if (lenis) lenis.on('scroll', ({ scroll }) => update(scroll));
    else document.addEventListener('scroll', () => update(window.scrollY), { passive: true });
    update(window.scrollY);
  }

  /* =============================================================
     Anchor links → smooth scroll via Lenis
  ============================================================= */
  function setupAnchorLinks(lenis) {
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (id.length <= 1) return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        lenis.scrollTo(target, { offset: -80, duration: 1.4 });
      });
    });
  }

  /* =============================================================
     3,4,7) Scroll-triggered animations
  ============================================================= */
  function setupScrollAnimations() {
    /* --- Word reveal: split each [data-anim="words"] heading --- */
    document.querySelectorAll('[data-anim="words"]').forEach((el) => {
      // Preserve italic <em> by using SplitType wholesale (it preserves child tags)
      const split = new SplitType(el, { types: 'words', tagName: 'span' });

      // Wrap each word in inner span so we can clip outer
      split.words.forEach((w) => {
        w.innerHTML = `<span class="word-inner">${w.innerHTML}</span>`;
      });

      // Make the heading visible now that it's prepared
      el.style.visibility = 'visible';

      const inners = el.querySelectorAll('.word-inner');
      const isHero = el.classList.contains('hero__title');

      gsap.set(inners, { yPercent: 110 });

      if (!isHero) {
        // Trigger when scrolled into view
        ScrollTrigger.create({
          trigger: el,
          start: 'top 88%',
          once: true,
          onEnter: () => {
            gsap.to(inners, {
              yPercent: 0,
              duration: 1.0,
              stagger: 0.06,
              ease: 'expo.out',
            });
          },
        });
      }
      // Hero words are animated by intro timeline
    });

    /* --- Generic fade-up reveals --- */
    document.querySelectorAll('[data-anim="fade-up"]').forEach((el) => {
      const isHero = el.closest('.hero');
      gsap.set(el, { y: 24, opacity: 0 });
      el.style.visibility = 'visible';

      if (!isHero) {
        ScrollTrigger.create({
          trigger: el,
          start: 'top 92%',
          once: true,
          onEnter: () => {
            gsap.to(el, {
              y: 0,
              opacity: 1,
              duration: 0.9,
              ease: 'expo.out',
            });
          },
        });
      }
    });

    /* --- Press row: stagger fade-in --- */
    document.querySelectorAll('[data-anim="press"]').forEach((el) => {
      const items = el.children;
      gsap.set(items, { y: 20, opacity: 0 });
      el.style.visibility = 'visible';
      ScrollTrigger.create({
        trigger: el,
        start: 'top 90%',
        once: true,
        onEnter: () => {
          gsap.to(items, { y: 0, opacity: 1, duration: 0.7, stagger: 0.08, ease: 'expo.out' });
        },
      });
    });

    /* --- Image mask reveal --- */
    document.querySelectorAll('.mask-reveal').forEach((el) => {
      ScrollTrigger.create({
        trigger: el,
        start: 'top 85%',
        once: true,
        onEnter: () => {
          gsap.to(el, {
            clipPath: 'inset(0% 0% 0% 0%)',
            duration: 1.4,
            ease: 'expo.out',
          });
        },
      });
    });

    /* --- Card stagger (collection + product) --- */
    document.querySelectorAll('.collections-grid, .products-grid').forEach((grid) => {
      const cards = grid.querySelectorAll('.reveal');
      gsap.set(cards, { y: 36, opacity: 0 });
      ScrollTrigger.create({
        trigger: grid,
        start: 'top 85%',
        once: true,
        onEnter: () => {
          gsap.to(cards, {
            y: 0,
            opacity: 1,
            duration: 0.9,
            stagger: 0.08,
            ease: 'expo.out',
          });
        },
      });
    });

    /* --- Parallax on images --- */
    document.querySelectorAll('[data-parallax]').forEach((img) => {
      const speed = parseFloat(img.dataset.parallax) || 0.15;
      const wrap = img.parentElement;
      // Pre-scale so image has room to move without exposing edges
      gsap.set(img, { scale: 1 + speed * 1.5, yPercent: 0 });
      wrap.style.overflow = 'hidden';

      gsap.to(img, {
        yPercent: -speed * 100,
        ease: 'none',
        scrollTrigger: {
          trigger: wrap,
          start: 'top bottom',
          end: 'bottom top',
          scrub: true,
        },
      });
    });
  }

  /* =============================================================
     11) Page transition (overlay slides up to cover, navigates)
  ============================================================= */
  function setupPageTransitions() {
    const overlay = document.getElementById('pageTransition');
    if (!overlay) return;

    // Reveal-in on load: overlay slides up from cover
    gsap.set(overlay, { yPercent: 0 }); // start covering
    gsap.to(overlay, {
      yPercent: -100,
      duration: 1.0,
      ease: 'expo.inOut',
      delay: 2.4, // matches loader exit
      onComplete: () => gsap.set(overlay, { yPercent: 100 }), // park below for next nav
    });

    // Intercept clicks on internal links that go to other pages (not anchors)
    document.querySelectorAll('a[href]').forEach((a) => {
      const href = a.getAttribute('href');
      if (!href) return;
      // skip anchors, externals, mailto/tel, and current-page links
      if (
        href.startsWith('#') ||
        href.startsWith('mailto:') ||
        href.startsWith('tel:') ||
        a.target === '_blank' ||
        href === '#' ||
        a.hasAttribute('download')
      ) return;

      const isExternal = /^https?:\/\//.test(href) && !href.includes(window.location.host);
      if (isExternal) return;

      a.addEventListener('click', (e) => {
        e.preventDefault();
        gsap.to(overlay, {
          yPercent: 0,
          duration: 0.7,
          ease: 'expo.inOut',
          onComplete: () => { window.location.href = href; },
        });
      });
    });
  }

  /* =============================================================
     12) Loader → Hero intro sequence
  ============================================================= */
  function runIntroSequence() {
    const body = document.body;
    const loader = document.getElementById('loader');
    const heroTitle = document.querySelector('.hero__title');
    const heroEyebrow = document.querySelector('.hero .eyebrow[data-anim="fade-up"]');
    const heroSubtitle = document.querySelector('.hero__subtitle');
    const heroCtaButtons = document.querySelectorAll('.hero__cta .btn');
    const heroImg = document.querySelector('.hero__media img');
    const heroScroll = document.querySelector('.hero__scroll');

    body.classList.add('is-locked');
    if (window._lenis) window._lenis.stop();

    // Pre-set hero state (already set by data-anim setups above; reaffirm)
    if (heroEyebrow) gsap.set(heroEyebrow, { y: 24, opacity: 0, visibility: 'visible' });
    if (heroSubtitle) gsap.set(heroSubtitle, { y: 24, opacity: 0, visibility: 'visible' });
    gsap.set(heroCtaButtons, { y: 24, opacity: 0, visibility: 'visible' });
    if (heroImg) gsap.set(heroImg, { scale: 1.18 });

    const tl = gsap.timeline({
      defaults: { ease: 'expo.out' },
      onComplete: () => {
        body.classList.remove('is-locked');
        body.classList.add('is-loaded');
        if (window._lenis) window._lenis.start();
        if (loader) loader.style.display = 'none';
        ScrollTrigger.refresh();
      },
    });

    // Loader: letters rise
    tl.to('.loader__letter', { yPercent: 0, duration: 0.9, stagger: 0.07 }, 0.2)
      .to('.loader__line', { width: 320, duration: 0.9, ease: 'power2.inOut' }, '-=0.6')
      .to('.loader__caption span', { yPercent: 0, duration: 0.7 }, '-=0.6')
      // Hold a beat
      .to({}, { duration: 0.35 })
      // Loader exit
      .to('.loader', { yPercent: -100, duration: 1.0, ease: 'expo.inOut' }, '+=0.05');

    // Hero reveal (overlapping with end of loader exit)
    if (heroImg) {
      tl.to(heroImg, { scale: 1, duration: 1.8, ease: 'expo.out' }, '-=0.9');
    }

    // Hero title — words rise
    const heroWordInners = heroTitle ? heroTitle.querySelectorAll('.word-inner') : [];
    if (heroWordInners.length) {
      heroTitle.style.visibility = 'visible';
      tl.to(heroWordInners, {
        yPercent: 0,
        duration: 1.0,
        stagger: 0.06,
        ease: 'expo.out',
      }, '-=0.7');
    }

    if (heroEyebrow) tl.to(heroEyebrow, { y: 0, opacity: 1, duration: 0.7 }, '-=0.7');
    if (heroSubtitle) tl.to(heroSubtitle, { y: 0, opacity: 1, duration: 0.7 }, '-=0.5');
    tl.to(heroCtaButtons, { y: 0, opacity: 1, duration: 0.6, stagger: 0.08 }, '-=0.4');
    if (heroScroll) tl.from(heroScroll, { opacity: 0, duration: 0.6 }, '-=0.2');
  }

  /* =============================================================
     Drawers (mobile menu + cart)
  ============================================================= */
  function setupDrawers() {
    const openDrawer = (id) => {
      const d = document.getElementById(id);
      if (!d) return;
      d.classList.add('is-open');
      d.setAttribute('aria-hidden', 'false');
      document.body.classList.add('is-locked');
      if (window._lenis) window._lenis.stop();
    };
    const closeDrawer = (d) => {
      if (!d) return;
      d.classList.remove('is-open');
      d.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('is-locked');
      if (window._lenis) window._lenis.start();
    };

    const cartTrigger = document.getElementById('cartTrigger');
    if (cartTrigger) cartTrigger.addEventListener('click', () => openDrawer('cartDrawer'));

    const menuTrigger = document.getElementById('menuTrigger');
    if (menuTrigger) menuTrigger.addEventListener('click', () => openDrawer('mobileMenu'));

    document.querySelectorAll('[data-close]').forEach((el) => {
      el.addEventListener('click', () => closeDrawer(el.closest('.drawer')));
    });

    document.addEventListener('keydown', (e) => {
      if (e.key !== 'Escape') return;
      document.querySelectorAll('.drawer.is-open').forEach(closeDrawer);
    });

    document.querySelectorAll('.drawer-nav a').forEach((a) => {
      a.addEventListener('click', () => closeDrawer(a.closest('.drawer')));
    });
  }
})();
