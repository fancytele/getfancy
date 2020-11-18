import '../bootstrap';

import axios from 'axios';
import IMask from 'imask';

import contactUs from '../contactUs';
import haveUsCallYou from '../haveUsCallYou';
import navbar from '../navbar';
import navbarCollapse from '../navbarCollapse';

(function () {
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

    $('#price').keyup(function (event){
      if(event.target.value){
        document.getElementById('plan_submit').disabled = false;
      }
    })
    // Get Started buton
    $('#home #get-started').click(e => {
      e.preventDefault();

      const target = e.target.attributes.href.value;
      $('html, body').animate({ scrollTop: $(e.target.attributes.href.value).offset().top - 120 }, 800);
    })

    // Have Us Call You
    const phoneInput = document.querySelector('#have-us-call-you #phone');
    const maskOptions = { mask: '(000) 000-0000' };
    IMask(phoneInput, maskOptions);

    const priceInput = document.querySelector('#price');
    const maskOption = { mask: '00' };
    if(priceInput){
      IMask(priceInput, maskOption);
    }
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
