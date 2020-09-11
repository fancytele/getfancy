/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/haveUsCallYou.js":
/*!***************************************!*\
  !*** ./resources/js/haveUsCallYou.js ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
var _this = undefined;



var _element;

var _buttonCall;

var _error;

var _form;

var _inputs;

var _activeClass = 'active';
var _succesClass = 'success';

var _fireButtonCall = function _fireButtonCall() {
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
};

var _disableButtonCall = function _disableButtonCall() {
  _buttonCall.setAttribute('disabled', 'disabled');
};

var _fireForm = function _fireForm(callback, e) {
  e.preventDefault();
  var data = Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["serializeArrayToJSON"])(_form);

  _disableInputs();

  _disableButtonCall();

  _hideMessageError();

  callback(data);
};

var _toggleElement = function _toggleElement() {
  _element.classList.toggle(_activeClass);
};

var _focusFirstInput = function _focusFirstInput() {
  _element.querySelector('input').focus();
};

var _clearInputs = function _clearInputs() {
  _inputs.forEach(function (el) {
    return el.value = '';
  });
};

var _enableInputs = function _enableInputs() {
  _inputs.forEach(function (el) {
    return el.removeAttribute('disabled');
  });
};

var _disableInputs = function _disableInputs() {
  _inputs.forEach(function (el) {
    return el.setAttribute('disabled', 'disabled');
  });
};

var _removeSuccess = function _removeSuccess() {
  _element.classList.remove(_succesClass);
};

var _hideMessageError = function _hideMessageError() {
  _error.classList.add('d-none');
}; // Public


var enableButtonCall = function enableButtonCall() {
  _buttonCall.removeAttribute('disabled');
};

var init = function init(element, buttonCall, error) {
  _element = document.querySelector(element);
  _buttonCall = _element.querySelector(buttonCall);
  _error = _element.querySelector(error);
  _form = _element.querySelector('form');
  _inputs = _element.querySelectorAll('input');

  _buttonCall.addEventListener('click', _fireButtonCall);
};

var makeSuccess = function makeSuccess() {
  _element.classList.add(_succesClass);
};

var showMessageError = function showMessageError() {
  if (typeof Ladda !== 'undefined') {
    Ladda.stopAll();
  }

  _error.classList.remove('d-none');

  _enableInputs();
};

var submit = function submit(callback) {
  _form.addEventListener('submit', _fireForm.bind(_this, callback));
};

/* harmony default export */ __webpack_exports__["default"] = ({
  enableButtonCall: enableButtonCall,
  init: init,
  makeSuccess: makeSuccess,
  showMessageError: showMessageError,
  submit: submit
});

/***/ }),

/***/ "./resources/js/helpers.js":
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
/*! exports provided: serializeArray, serializeArrayToJSON, trans */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "serializeArray", function() { return serializeArray; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "serializeArrayToJSON", function() { return serializeArrayToJSON; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "trans", function() { return trans; });
/*!
 * Serialize all form data into an array
 * (c) 2018 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Node}   form The form to serialize
 * @return {String}      The serialized form data
 */
var serializeArray = function serializeArray(form) {
  // Setup our serialized data
  var serialized = []; // Loop through each field in the form

  for (var i = 0; i < form.elements.length; i++) {
    var field = form.elements[i]; // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields

    if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue; // If a multi-select, get all selections

    if (field.type === 'select-multiple') {
      for (var n = 0; n < field.options.length; n++) {
        if (!field.options[n].selected) continue;
        serialized.push({
          name: field.name,
          value: field.options[n].value
        });
      }
    } // Convert field data to a query string
    else if (field.type !== 'checkbox' && field.type !== 'radio' || field.checked) {
        serialized.push({
          name: field.name,
          value: field.value
        });
      }
  }

  return serialized;
};

function serializeArrayToJSON(form) {
  var data = serializeArray(form);
  return data.reduce(function (obj, item) {
    obj[item.name] = item.value;
    return obj;
  }, {});
}

var trans = function trans(string) {
  return _.get(window.i18n, string) || string;
};



/***/ }),

/***/ "./resources/js/navbar.js":
/*!********************************!*\
  !*** ./resources/js/navbar.js ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var offsetSection = 118;

var animateScrollSpy = function animateScrollSpy(event) {
  if (this.hash !== "" && this.hash !== window.location.hash) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: $(this.hash).offset().top - offsetSection
    }, 800);
  }
};

var changeNavbarBg = function changeNavbarBg() {
  var scroll = $(window).scrollTop();
  var navbarDarkClass = 'border-0 bg-transparent navbar-dark';
  var navbarLightClasses = 'bg-white navbar-light shadow';

  if (scroll >= 100) {
    $('#fancy-navbar').addClass(navbarLightClasses).removeClass(navbarDarkClass);
  } else {
    $('#fancy-navbar').addClass(navbarDarkClass).removeClass(navbarLightClasses);
  }
};

var init = function init() {
  $('body').scrollspy({
    target: "#fancy-navbar",
    offset: offsetSection + 2
  });
  $("#fancy-menu .nav-link").on('click', animateScrollSpy);
  $(window).on('scroll', changeNavbarBg);
  changeNavbarBg();
};

/* harmony default export */ __webpack_exports__["default"] = ({
  init: init
});

/***/ }),

/***/ "./resources/js/web/checkout.js":
/*!**************************************!*\
  !*** ./resources/js/web/checkout.js ***!
  \**************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _navbar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../navbar */ "./resources/js/navbar.js");
/* harmony import */ var _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../haveUsCallYou */ "./resources/js/haveUsCallYou.js");


$(document).ready(function () {
  _navbar__WEBPACK_IMPORTED_MODULE_0__["default"].init(); // Have Us Call You

  var phoneInput = document.querySelector('#have-us-call-you #phone');
  var maskOptions = {
    mask: '(000) 000-0000'
  };
  IMask(phoneInput, maskOptions);
  _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__["default"].init('#have-us-call-you', '.call-you-button', '.call-you-error');
  _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__["default"].submit(function (data) {
    axios.post('/callyou', data).then(function () {
      return _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__["default"].makeSuccess();
    })["catch"](function () {
      return _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__["default"].showMessageError();
    }).then(function () {
      return _haveUsCallYou__WEBPACK_IMPORTED_MODULE_1__["default"].enableButtonCall();
    });
  });
});

/***/ }),

/***/ 2:
/*!********************************************!*\
  !*** multi ./resources/js/web/checkout.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/work/getfancy/resources/js/web/checkout.js */"./resources/js/web/checkout.js");


/***/ })

/******/ });
//# sourceMappingURL=checkout.js.map