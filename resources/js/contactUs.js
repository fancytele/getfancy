import { serializeArrayToJSON, trans } from "./helpers";

const contactUs = (formClass) => {
  const element = document.querySelector(formClass);
  const inputs = element.querySelectorAll('input');
  const textarea = element.querySelector('textarea');
  const messageElement = element.querySelector('.text-message');

  const fireForm = (callback, e) => {
    e.preventDefault();

    let data = serializeArrayToJSON(element);

    disableForm();
    hideMessage();

    callback(data);
  }

  const disableForm = () => {
    inputs.forEach(el => el.setAttribute('disabled', 'disabled'));
    textarea.setAttribute('disabled', 'disabled');
  }

  const hideMessage = () => {
    messageElement.classList = 'd-none';
  }

  const renderMessage = (text) => {
    messageElement.innerHTML = trans(text);
  }

  // Public
  const submit = (callback) => {
    element.addEventListener('submit', fireForm.bind(this, callback));
  }

  const showSuccessMessage = (text = 'contactUsSuccessMessage') => {
    renderMessage(text);
    messageElement.classList = '';
  }

  const showErrorMessage = (text = 'contactUsErrorMessage') => {
    renderMessage(text);
    messageElement.classList = 'text-danger';
  }

  const enableSubmit = () => {
    if (typeof Ladda !== 'undefined') {
      Ladda.stopAll();
    }

    inputs.forEach(el => {
      el.removeAttribute('disabled');
      el.value = ''
    });

    textarea.removeAttribute('disabled');
    textarea.value = '';
  }

  return {
    submit,
    showSuccessMessage,
    showErrorMessage,
    enableSubmit
  };
};

export default contactUs;
