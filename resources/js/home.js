import './bootstrap';
import './helpers';
import axios from 'axios';

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

    $('#have-us-call-you .call-you-button').click(function () {
      $('#have-us-call-you').toggleClass('active').find('input:first').focus();

      if (!$('#have-us-call-you').hasClass('active')) {
        Ladda.stopAll();
        $('#have-us-call-you input[type="text"]').val('').removeAttr("disabled");
        $('#have-us-call-you').removeClass('success');
      }
    });

    $('#have-us-call-you form').submit(function (e) {
      e.preventDefault();

      let data = $(this).serializeArrayToJSON();

      // Disable after getting data (or it will be empty)
      $('#have-us-call-you .call-you-button').attr("disabled", true);
      $('#have-us-call-you input[type="text"]').attr("disabled", true);
      $('#have-us-call-you .call-you-error').addClass('d-none');

      axios.post('/call-you', data)
        .then(function () {
          $('#have-us-call-you').addClass('success');
        })
        .catch(function () {
          if (typeof Ladda !== 'undefined') {
            Ladda.stopAll();
          }

          $('#have-us-call-you .call-you-error').removeClass('d-none');
          $('#have-us-call-you input[type="text"]').removeAttr("disabled");
        })
        .then(function () {
          $('#have-us-call-you .call-you-button').removeAttr("disabled");
        });
    })

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
