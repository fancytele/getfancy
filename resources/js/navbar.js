const animateScrollSpy = function (event) {
  if (this.hash !== "" && this.hash !== window.location.hash) {
    event.preventDefault();
    $('html, body').animate({ scrollTop: $(this.hash).offset().top - 120 }, 800);
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

const init = () => {
  $('body').scrollspy({ target: "#fancy-navbar", offset: 95 });

  $("#fancy-menu .nav-link").on('click', animateScrollSpy);

  $(window).on('scroll', changeNavbarBg);

  changeNavbarBg();
};

export default {
  init,
}