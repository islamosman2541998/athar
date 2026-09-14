document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.menu-toggle');
  const menu = document.querySelector('.nav-links');

  const onScroll = () => header?.classList.toggle('is-scrolled', window.scrollY > 80);
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });

  toggle?.addEventListener('click', () => {
    const open = menu?.classList.toggle('is-open');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.textContent = open ? '×' : '☰';
  });

  document.querySelectorAll('.submenu-toggle').forEach(button => {
    button.addEventListener('click', event => {
      event.preventDefault();
      event.stopPropagation();
      const item = button.closest('.has-submenu');
      const open = item?.classList.toggle('is-open');
      button.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  menu?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    menu.classList.remove('is-open');
    toggle?.setAttribute('aria-expanded', 'false');
    if (toggle) toggle.textContent = '☰';
  }));

  const slider = document.querySelector('[data-hero-slider]');
  if (slider) {
    const slides = [...slider.querySelectorAll('.hero-slide')];
    const dots = [...slider.querySelectorAll('[data-slide-to]')];
    let current = 0;
    let timer;

    const showSlide = index => {
      if (!slides.length) return;
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => {
        const active = i === current;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
      });
      dots.forEach((dot, i) => dot.classList.toggle('is-active', i === current));
    };
    const restart = () => {
      window.clearInterval(timer);
      if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        timer = window.setInterval(() => showSlide(current + 1), 6500);
      }
    };

    slider.querySelector('[data-slide-prev]')?.addEventListener('click', () => { showSlide(current - 1); restart(); });
    slider.querySelector('[data-slide-next]')?.addEventListener('click', () => { showSlide(current + 1); restart(); });
    dots.forEach(dot => dot.addEventListener('click', () => { showSlide(Number(dot.dataset.slideTo)); restart(); }));
    slider.addEventListener('mouseenter', () => window.clearInterval(timer));
    slider.addEventListener('mouseleave', restart);
    restart();
  }

  document.querySelectorAll('[data-filter]').forEach(button => {
    button.addEventListener('click', () => {
      const value = button.dataset.filter;
      document.querySelectorAll('[data-filter]').forEach(item => item.classList.remove('active'));
      button.classList.add('active');
      document.querySelectorAll('[data-category]').forEach(card => {
        card.hidden = value !== 'all' && card.dataset.category !== value;
      });
    });
  });

  const mediaViewer = document.querySelector('[data-media-viewer]');
  const viewerVideo = mediaViewer?.querySelector('[data-media-video]');
  const viewerPdf = mediaViewer?.querySelector('[data-media-pdf]');
  const closeMediaViewer = () => {
    if (!mediaViewer) return;
    viewerVideo?.pause();
    if (viewerVideo) {
      viewerVideo.removeAttribute('src');
      viewerVideo.hidden = true;
      viewerVideo.load();
    }
    if (viewerPdf) {
      viewerPdf.removeAttribute('src');
      viewerPdf.hidden = true;
    }
    if (mediaViewer.open) mediaViewer.close();
  };

  document.querySelectorAll('[data-media-open]').forEach(button => {
    button.addEventListener('click', () => {
      if (!mediaViewer || !button.dataset.mediaSrc) return;
      const isVideo = button.dataset.mediaType === 'video';
      if (viewerVideo) {
        viewerVideo.hidden = !isVideo;
        if (isVideo) viewerVideo.src = button.dataset.mediaSrc;
      }
      if (viewerPdf) {
        viewerPdf.hidden = isVideo;
        if (!isVideo) viewerPdf.src = button.dataset.mediaSrc;
      }
      mediaViewer.showModal();
      if (isVideo) viewerVideo?.play().catch(() => {});
    });
  });
  mediaViewer?.querySelector('[data-media-close]')?.addEventListener('click', closeMediaViewer);
  mediaViewer?.addEventListener('click', event => {
    if (event.target === mediaViewer) closeMediaViewer();
  });
  mediaViewer?.addEventListener('cancel', event => {
    event.preventDefault();
    closeMediaViewer();
  });

  document.querySelectorAll('[data-project-carousel]').forEach(carousel => {
    const slides = [...carousel.querySelectorAll('[data-project-slide]')];
    const thumbs = [...carousel.querySelectorAll('[data-project-thumb]')];
    const thumbsTrack = carousel.querySelector('.project-media-thumbs');
    const stage = carousel.querySelector('.project-media-stage');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let current = 0;
    let timer;
    let touchStartX = 0;

    const hydrateVideo = slide => {
      const video = slide?.querySelector('[data-project-video]');
      if (video && !video.src && video.dataset.src) {
        video.src = video.dataset.src;
        video.load();
      }
    };
    const show = index => {
      if (!slides.length) return;
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, slideIndex) => {
        const active = slideIndex === current;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        if (!active) slide.querySelector('video')?.pause();
      });
      hydrateVideo(slides[current]);
      thumbs.forEach((thumb, thumbIndex) => {
        const active = thumbIndex === current;
        thumb.classList.toggle('is-active', active);
        thumb.setAttribute('aria-selected', active ? 'true' : 'false');
      });
      const activeThumb = thumbs[current];
      if (activeThumb && thumbsTrack) {
        thumbsTrack.scrollTo({
          left: activeThumb.offsetLeft - (thumbsTrack.clientWidth - activeThumb.clientWidth) / 2,
          behavior: reducedMotion ? 'auto' : 'smooth'
        });
      }
    };
    const stop = () => window.clearInterval(timer);
    const start = () => {
      stop();
      if (slides.length > 1 && !reducedMotion) timer = window.setInterval(() => show(current + 1), 6000);
    };
    const go = index => { show(index); start(); };

    carousel.querySelector('[data-project-prev]')?.addEventListener('click', () => go(current - 1));
    carousel.querySelector('[data-project-next]')?.addEventListener('click', () => go(current + 1));
    thumbs.forEach(thumb => thumb.addEventListener('click', () => go(Number(thumb.dataset.projectThumb))));
    carousel.querySelectorAll('video').forEach(video => {
      video.addEventListener('play', stop);
      video.addEventListener('pause', start);
      video.addEventListener('ended', () => go(current + 1));
    });
    stage?.addEventListener('touchstart', event => { touchStartX = event.changedTouches[0].clientX; }, { passive: true });
    stage?.addEventListener('touchend', event => {
      const delta = event.changedTouches[0].clientX - touchStartX;
      if (Math.abs(delta) > 55) go(current + (delta < 0 ? 1 : -1));
    }, { passive: true });
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);
    show(0);
    start();
  });

  const createSlider = (wrapper, { delay, breakpoints, ...options }) => {
    const container = wrapper.querySelector('.swiper');
    if (!container || typeof window.Swiper === 'undefined') return;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const maxPerView = Math.max(options.slidesPerView || 1, ...Object.values(breakpoints || {}).map(bp => bp.slidesPerView || 1));
    // Loop mode needs more slides than the widest breakpoint shows; otherwise rewind instead.
    const canLoop = container.querySelectorAll('.swiper-slide').length > maxPerView;
    const pagination = wrapper.querySelector('[data-swiper-pagination]');

    new window.Swiper(container, {
      speed: 700,
      loop: canLoop,
      rewind: !canLoop,
      grabCursor: true,
      watchOverflow: true,
      autoplay: reducedMotion ? false : { delay, disableOnInteraction: false, pauseOnMouseEnter: true },
      navigation: {
        prevEl: wrapper.querySelector('[data-swiper-prev]'),
        nextEl: wrapper.querySelector('[data-swiper-next]'),
        disabledClass: 'is-disabled',
        lockClass: 'is-locked'
      },
      pagination: pagination ? { el: pagination, clickable: true, lockClass: 'is-locked' } : false,
      a11y: {
        prevSlideMessage: wrapper.dataset.prevLabel || 'Previous',
        nextSlideMessage: wrapper.dataset.nextLabel || 'Next'
      },
      breakpoints,
      ...options
    });
  };

  document.querySelectorAll('[data-blogs-swiper]').forEach(wrapper => createSlider(wrapper, {
    delay: 5000,
    slidesPerView: 1,
    spaceBetween: 16,
    breakpoints: {
      640: { slidesPerView: 2, spaceBetween: 20 },
      1024: { slidesPerView: 3, spaceBetween: 24 }
    }
  }));

  document.querySelectorAll('[data-partners-swiper]').forEach(wrapper => createSlider(wrapper, {
    delay: 2800,
    slidesPerView: 2,
    spaceBetween: 12,
    breakpoints: {
      576: { slidesPerView: 3, spaceBetween: 16 },
      768: { slidesPerView: 4, spaceBetween: 20 },
      1100: { slidesPerView: 5, spaceBetween: 24 }
    }
  }));

  const observer = 'IntersectionObserver' in window
    ? new IntersectionObserver(entries => entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      }), { threshold: .12 })
    : null;
  document.querySelectorAll('[data-reveal]').forEach(el => observer ? observer.observe(el) : el.classList.add('is-visible'));
});
