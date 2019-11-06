window.Ladda = require('ladda');

(function () {
  const isDocumentReady = () => {
    if (document.readyState === "complete") {
      return true;
    }

    return document.readyState !== "loading" && !document.documentElement.doScroll;
  };

  const callback = function () {
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
