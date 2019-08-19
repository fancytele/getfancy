import { serializeArrayToJSON } from './helpers';

class HaveUsCallYou {
  constructor(element, buttonCall, error) {
    this._element = document.querySelector(element);
    this._buttonCall = this._element.querySelector(buttonCall);
    this._error = this._element.querySelector(error);

    this._form = this._element.querySelector('form');
    this._inputs = this._element.querySelectorAll('input[type="text"]');

    this._activeClass = 'active';
    this._succesClass = 'success';

    this._buttonCall.addEventListener('click', this.fireButtonCall.bind(this));
  }

  fireButtonCall() {
    this.toggleElement();
    this.clearInputs();
    this.enableInputs();
    this.removeSuccess();

    if (this._element.classList.contains(this._activeClass)) {
      if (typeof Ladda !== 'undefined') {
        Ladda.stopAll();
      }

      this.focusFirstInput();
    }
  }

  enableButtonCall() {
    this._buttonCall.removeAttribute('disabled');
  }

  disableButtonCall() {
    this._buttonCall.setAttribute('disabled', 'disabled');
  }

  submit(callback) {
    this._form.addEventListener('submit', this.fireForm.bind(this, callback));
  }

  fireForm(callback, e) {
    e.preventDefault();

    let data = serializeArrayToJSON(this._form);

    this.disableInputs();
    this.disableButtonCall();
    this._error.classList.add('d-none');

    callback(data);
  }

  toggleElement() {
    this._element.classList.toggle(this._activeClass);
  }

  focusFirstInput() {
    this._element.querySelector('input').focus();
  }

  clearInputs() {
    this._inputs.forEach(el => el.value = '');
  }

  enableInputs() {
    this._inputs.forEach(el => el.removeAttribute('disabled'));
  }

  disableInputs() {
    this._inputs.forEach(el => el.setAttribute('disabled', 'disabled'));
  }

  makeSuccess() {
    this._element.classList.add(this._succesClass);
  }

  removeSuccess() {
    this._element.classList.remove(this._succesClass);
  }

  showMessageError() {
    if (typeof Ladda !== 'undefined') {
      Ladda.stopAll();
    }

    this._error.classList.remove('d-none');
    this.enableInputs();
  }
}

export default HaveUsCallYou;
