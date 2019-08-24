import { serializeArrayToJSON, trans } from "./helpers";

let _element;
let _inputs;
let _textarea;
let _message_element;

const _fireForm = (callback, e) => {
  e.preventDefault();

  let data = serializeArrayToJSON(_element);

  _disableForm();
  _hideMessage();

  callback(data);
}

const _disableForm = () => {
  _inputs.forEach(el => el.setAttribute('disabled', 'disabled'));
  _textarea.setAttribute('disabled', 'disabled');
}

const _hideMessage = () => {
  _message_element.classList = 'd-none';
}

const _renderMessage = (text) => {
  _message_element.innerHTML = trans(text);
}

// Public
const enableSubmit = () => {
  if (typeof Ladda !== 'undefined') {
    Ladda.stopAll();
  }

  _inputs.forEach(el => {
    el.removeAttribute('disabled');
    el.value = ''
  });

  _textarea.removeAttribute('disabled');
  _textarea.value = '';
}

const init = (formClass) => {
  _element = document.querySelector(formClass);
  _inputs = _element.querySelectorAll('input');
  _textarea = _element.querySelector('textarea');
  _message_element = _element.querySelector('.text-message');
}

const showErrorMessage = (text = 'contactUsErrorMessage') => {
  _renderMessage(text);
  _message_element.classList = 'text-danger';
}

const showSuccessMessage = (text = 'contactUsSuccessMessage') => {
  _renderMessage(text);
  _message_element.classList = '';
}

const submit = (callback) => {
  _element.addEventListener('submit', _fireForm.bind(this, callback));
}

export default {
  enableSubmit,
  init,
  showErrorMessage,
  showSuccessMessage,
  submit,
};
