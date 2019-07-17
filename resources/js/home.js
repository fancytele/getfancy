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

    if (scroll >= 130) {
      $('#getfancy-navbar').addClass(navbarLightClasses).removeClass(navbarDarkClass);
    } else {
      $('#getfancy-navbar').addClass(navbarDarkClass).removeClass(navbarLightClasses);
    }
  }

  const changePlan = function (e) {
    const id = e.target.dataset.type;

    $('#plans .btn-group .active')
      .removeClass('active btn-primary')
      .addClass('btn-outline-light text-body');

    $(`#plans .btn-group button[data-type="${id}"`)
      .addClass('active btn-primary')
      .removeClass('btn-outline-light text-body');

    $('#plans .plan-wrapper .plan-item.active').removeClass('active');
    $(`#plans .plan-wrapper #${id}`).addClass('active');
  };

  const redirectToCheckout = function (e) {
    e.preventDefault();

    const planType = $('#plans .btn-group .active').data('type');
    window.location.href = `/checkout/${planType}`;
  }

  $(document).ready(() => {
    // Set ScrollSpy
    $('body').scrollspy({ target: "#getfancy-navbar", offset: 95 });
    $("#getfancy-menu .nav-link").on('click', animateScrollSpy);

    // Listen Scroll event
    $(window).on('scroll', changeNavbarBg);

    $('#plans .btn-group button').on('click', changePlan);
    $('#plans #plan-buy').click(redirectToCheckout);

    changeNavbarBg();

    AOS.init();
  });
})();
