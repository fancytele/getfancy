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

  // Delte and Retore element
  $('#delete-element, #restore-element').on('show.bs.modal', function (event) {
    var element = $(event.relatedTarget);
    var elementName = element.data('name')
    var agentEmail = element.data('email');
    var agentAction = element.data('action');

    var modal = $(this);
    modal.find('.element-email').text(agentEmail);
    modal.find('form').attr('action', agentAction);
  });
};
