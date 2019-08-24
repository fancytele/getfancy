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

  $(document).ready(() => {
    // Set ScrollSpy
    $('body').scrollspy({ target: "#fancy-navbar", offset: 95 });

    $("#fancy-menu .nav-link").on('click', animateScrollSpy);

    // Change Navbar color when scrolling
    changeNavbarBg();

    // Listen Scroll event
    $(window).on('scroll', changeNavbarBg);

    // Change localization listener
    $('.locale').on('change', function () {
      $(this).parents('form').first().submit();
    });
  });
})();