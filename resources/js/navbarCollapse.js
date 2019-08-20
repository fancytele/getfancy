const navbarCollapse = (classElement, toggleClass) => {
  const body = document.querySelector('body');
  const element = document.querySelector(classElement);
  const toggleElement = document.querySelector(toggleClass);
  const closeButton = element.querySelector('.close');

  const registerEvents = () => {
    toggleElement.addEventListener('click', showCollapse.bind(this));
    closeButton.addEventListener('click', closeCollapse.bind(this));
    document.addEventListener('click', navigateTo.bind(this));
  }

  const showCollapse = () => {
    body.classList.add('overflow-collapse');
  }

  const closeCollapse = () => {
    element.classList.remove('show');
    body.classList.remove('overflow-collapse');
  }

  const navigateTo = () => {
    // Allow only nav-link
    if (!event.target.matches(`${classElement} .nav-link`)) return;

    event.preventDefault();
    closeCollapse();
  }

  const init = () => {
    registerEvents();
  }

  init();
}

export default navbarCollapse;
