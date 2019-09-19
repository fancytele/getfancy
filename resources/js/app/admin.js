
window.onload = function () {
  let logoutItems = document.querySelectorAll('.logout-action');
  logoutItems.forEach((el) => {
    el.addEventListener('click', logout);
  });
};

function logout(event) {
  event.preventDefault();
  document.getElementById('logout-form').submit();
}