import './bootstrap';

import axios from 'axios';
import IMask from 'imask';

import contactUs from './contactUs';
import haveUsCallYou from './haveUsCallYou';
import navbar from './navbar';
import navbarCollapse from './navbarCollapse';

(function () {
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

      items.css('min-height', 0);

      const itemsHeight = items.map(function () {
        return $(this).outerHeight()
      }).get();

      var maxHeight = Math.max.apply(null, itemsHeight);

      items.css('height', maxHeight + 'px');
    })
  }

  $(document).ready(() => {
    navbar.init();

    $('#plans .btn-group button').on('click', changePlan);
    $('#plans #plan-buy').click(redirectToCheckout);

    // Have Us Call You
    const phoneInput = document.querySelector('#have-us-call-you #phone');
    const maskOptions = { mask: '(000) 000-0000' };
    IMask(phoneInput, maskOptions);

    haveUsCallYou.init('#have-us-call-you', '.call-you-button', '.call-you-error');

    haveUsCallYou.submit((data) => {
      axios.post('/callyou', data)
        .then(() => haveUsCallYou.makeSuccess())
        .catch(() => haveUsCallYou.showMessageError())
        .then(() => haveUsCallYou.enableButtonCall());
    });

    // NavbarCollapse
    navbarCollapse('.navbar .navbar-collapse', '.navbar .navbar-toggler');

    // ContactUs Form
    contactUs.init('footer form');

    contactUs.submit((data) => {
      axios.post('contactus', data)
        .then(() => contactUs.showSuccessMessage())
        .catch(() => contactUs.showErrorMessage())
        .then(() => contactUs.enableSubmit());
    });

    // Init AOS Animation
    if (typeof AOS !== 'undefined') {
      AOS.init();
    }

    // Normalize Testimonial Slides
    normalizeSlideHeights('#testimonial .carousel');

    // Automatically trigger the loading animation on click
    if (typeof Ladda !== 'undefined') {
      Ladda.bind('button[type=submit]');
    }

    $(window).on('load', function () {
      // Fix browser soft reload page
      if (typeof AOS !== 'undefined') {
        AOS.refresh();
      }
    });

    // Normalize Testimonial Slides on resize
    $(window).on('resize orientationchange', normalizeSlideHeights.bind('#testimonial .carousel'));
  });
})();
