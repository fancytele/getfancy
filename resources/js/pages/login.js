window.Ladda = require('ladda');

(function () {
  var isDocumentReady = () => {
    if (document.readyState === "complete") {
      return true;
    }

    return document.readyState !== "loading" && !document.documentElement.doScroll;
  }

  var callback = function () {
    if (typeof Ladda !== 'undefined') {
      Ladda.bind('button[type=submit]');
    }
  };

  if (isDocumentReady()) {
    callback();
  } else {
    document.addEventListener("DOMContentLoaded", callback);
  }
})();
