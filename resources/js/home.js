window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

require('bootstrap');

const animateScrollSpy = function (event) {
  if (this.hash !== "" && this.hash !== window.location.hash) {
    event.preventDefault();
    $('html, body').animate({ scrollTop: $(this.hash).offset().top - 91 }, 800);
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

$(document).ready(() => {
  // Set ScrollSpy
  $('body').scrollspy({ target: "#getfancy-navbar", offset: 95 });
  $("#getfancy-menu .nav-link").on('click', animateScrollSpy);

  // Listen Scroll event
  $(window).on('scroll', changeNavbarBg)
});
