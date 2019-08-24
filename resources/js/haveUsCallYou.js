import { serializeArrayToJSON } from './helpers';

let _element;
let _buttonCall;

let _error;
let _form;
let _inputs;

const _activeClass = 'active';
const _succesClass = 'success';

const _fireButtonCall = () => {
  _clearInputs();
  _enableInputs();
  _removeSuccess();
  _hideMessageError();

  _toggleElement();

  if (_element.classList.contains(_activeClass)) {
    if (typeof Ladda !== 'undefined') {
      Ladda.stopAll();
    }

    _focusFirstInput();
  }
}

const _disableButtonCall = () => {
  _buttonCall.setAttribute('disabled', 'disabled');
}

const _fireForm = (callback, e) => {
  e.preventDefault();

  let data = serializeArrayToJSON(_form);

  _disableInputs();
  _disableButtonCall();
  _hideMessageError();

  callback(data);
}

const _toggleElement = () => {
  _element.classList.toggle(_activeClass);
}

const _focusFirstInput = () => {
  _element.querySelector('input').focus();
}

const _clearInputs = () => {
  _inputs.forEach(el => el.value = '');
}

const _enableInputs = () => {
  _inputs.forEach(el => el.removeAttribute('disabled'));
}

const _disableInputs = () => {
  _inputs.forEach(el => el.setAttribute('disabled', 'disabled'));
}

const _removeSuccess = () => {
  _element.classList.remove(_succesClass);
}

const _hideMessageError = () => {
  _error.classList.add('d-none');
}

// Public
const enableButtonCall = () => {
  _buttonCall.removeAttribute('disabled');
}

const init = (element, buttonCall, error) => {
  _element = document.querySelector(element);
  _buttonCall = _element.querySelector(buttonCall);

  _error = _element.querySelector(error);
  _form = _element.querySelector('form');
  _inputs = _element.querySelectorAll('input');

  _buttonCall.addEventListener('click', _fireButtonCall);
};

const makeSuccess = () => {
  _element.classList.add(_succesClass);
}

const showMessageError = () => {
  if (typeof Ladda !== 'undefined') {
    Ladda.stopAll();
  }

  _error.classList.remove('d-none');
  _enableInputs();
}

const submit = (callback) => {
  _form.addEventListener('submit', _fireForm.bind(this, callback));
}

export default {
  enableButtonCall,
  init,
  makeSuccess,
  showMessageError,
  submit,
}
