window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

require('bootstrap');

(function () {
  const animateScrollSpy = function (event) {
    if (this.hash !== "" && this.hash !== window.location.hash) {
      event.preventDefault();
      $('html, body').animate({ scrollTop: $(this.hash).offset().top - 83 }, 800);
    }
  }

  const changeNavbarBg = function () {
    const scroll = $(window).scrollTop();
    const navbarDarkClass = 'border-0 bg-transparent navbar-dark';
    const navbarLightClasses = 'bg-white navbar-light shadow';

    if (scroll >= 100) {
      $('#fancy-navbar').addClass(navbarLightClasses).removeClass(navbarDarkClass);
    } else {
      $('#fancy-navbar').addClass(navbarDarkClass).removeClass(navbarLightClasses);
    }
  }

  const changePlan = function (e) {
    const activeClass = 'active';

    if ($(this).hasClass(activeClass)) {
      e.stopPropagation();
      return;
    }

    const id = e.target.dataset.type;

    // Remove active Button and Plan Item the 'active' class
    $('#plans .active').removeClass(activeClass);

    // Add selected Button and Plan Item class 'active'
    $(`#plans .btn-group button[data-type="${id}"], #plans .plan-wrapper #${id}`)
      .addClass(activeClass);
  };

  const redirectToCheckout = function (e) {
    e.preventDefault();

    const planType = $('#plans .btn-group .active').data('type');
    window.location.href = `/checkout/${planType}`;
  }

  const normalizeSlideHeights = function (element) {
    if (!element) {
      return false;
    }

    $(element).each(function () {
      var items = $('.carousel-item', this);
      console.table(items);

      // reset the height
      items.css('min-height', 0);

      const itemsHeight = items.map(function () {
        return $(this).outerHeight()
      }).get();

      var maxHeight = Math.max.apply(null, itemsHeight);

      // set the height
      items.css('height', maxHeight + 'px');
    })
  }

  $(document).ready(() => {
    // Set ScrollSpy
    $('body').scrollspy({ target: "#fancy-navbar", offset: 95 });
    $("#fancy-menu .nav-link").on('click', animateScrollSpy);

    // Listen Scroll event
    $(window).on('scroll', changeNavbarBg);

    // Change localization listener
    $('.locale').on('change', function () {
      $(this).parents('form').first().submit();
    });

    $('#plans .btn-group button').on('click', changePlan);
    $('#plans #plan-buy').click(redirectToCheckout);

    // Change Navbar color when scrolling
    changeNavbarBg();

    // Init AOS Animation
    AOS.init();

    $(window).on('load resize orientationchange', function () {
      // Normalize Testimonial Slides
      normalizeSlideHeights('#testimonial .carousel');

      // Fix browser soft reload page
      AOS.refresh();
    });
  });
})();
