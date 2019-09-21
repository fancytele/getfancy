import './sortList';

function logout(event) {
  event.preventDefault();
  document.getElementById('logout-form').submit();
}

window.onload = function () {
  let logoutItems = document.querySelectorAll('.logout-action');

  logoutItems.forEach((el) => {
    el.addEventListener('click', logout);
  });

  // Automatically trigger the loading animation on click
  if (typeof Ladda !== 'undefined') {
    Ladda.bind('button[type=submit]');
  }

  // Agent Delete
  $('#delete-agent, #restore-agent').on('show.bs.modal', function (event) {
    var element = $(event.relatedTarget);
    var agentEmail = element.data('agent-email');
    var agentAction = element.data('agent-action');

    var modal = $(this);
    modal.find('.agent-email').text(agentEmail);
    modal.find('form').attr('action', agentAction);
  });
};
