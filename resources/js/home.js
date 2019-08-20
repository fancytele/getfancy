import './bootstrap';
import axios from 'axios';
import HaveUsCallYou from './haveUsCallYou';

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
    $('#plans .btn-group button').on('click', changePlan);
    $('#plans #plan-buy').click(redirectToCheckout);

    // Have Us Call You
    let haveUsCallYou = new HaveUsCallYou('#have-us-call-you', '.call-you-button', '.call-you-error');

    haveUsCallYou.submit(function (data) {
      axios.post('/callyou', data)
        .then(() => haveUsCallYou.makeSuccess())
        .catch(() => haveUsCallYou.showMessageError())
        .then(() => haveUsCallYou.enableButtonCall());
    });

    // Init AOS Animation
    if (typeof AOS !== 'undefined') {
      AOS.init();
    }

    $(window).on('load', function () {
      // Normalize Testimonial Slides
      normalizeSlideHeights('#testimonial .carousel');

      // Fix browser soft reload page
      if (typeof AOS !== 'undefined') {
        AOS.refresh();
      }

      // Automatically trigger the loading animation on click
      if (typeof Ladda !== 'undefined') {
        Ladda.bind('button[type=submit]');
      }
    });

    // Normalize Testimonial Slides on resize
    $(window).on('resize orientationchange', normalizeSlideHeights.bind('#testimonial .carousel'));
  });
})();
