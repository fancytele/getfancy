import navbar from '../navbar';
import haveUsCallYou from '../haveUsCallYou';

$(document).ready(function () {
  navbar.init();

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
});
