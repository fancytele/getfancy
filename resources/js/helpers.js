// Define Jquery Helper to serialize Form Data into JSON
jQuery.fn.extend({
  serializeArrayToJSON: function () {
    let data = $(this).serializeArray();

    return data.reduce(function (obj, item) {
      obj[item.name] = item.value;
      return obj;
    }, {});
  }
});