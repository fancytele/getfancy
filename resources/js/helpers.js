/*!
 * Serialize all form data into an array
 * (c) 2018 Chris Ferdinandi, MIT License, https://gomakethings.com
 * @param  {Node}   form The form to serialize
 * @return {String}      The serialized form data
 */
const serializeArray = (form) => {

  // Setup our serialized data
  let serialized = [];

  // Loop through each field in the form
  for (let i = 0; i < form.elements.length; i++) {

    let field = form.elements[i];

    // Don't serialize fields without a name, submits, buttons, file and reset inputs, and disabled fields
    if (!field.name || field.disabled || field.type === 'file' || field.type === 'reset' || field.type === 'submit' || field.type === 'button') continue;

    // If a multi-select, get all selections
    if (field.type === 'select-multiple') {
      for (let n = 0; n < field.options.length; n++) {
        if (!field.options[n].selected) continue;
        serialized.push({
          name: field.name,
          value: field.options[n].value
        });
      }
    }

    // Convert field data to a query string
    else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
      serialized.push({
        name: field.name,
        value: field.value
      });
    }
  }

  return serialized;
};

function serializeArrayToJSON(form) {
  let data = serializeArray(form);

  return data.reduce((obj, item) => {
    obj[item.name] = item.value;
    return obj;
  }, {});
}

const trans = string => _.get(window.i18n, string) || string;

export {
  serializeArray,
  serializeArrayToJSON,
  trans
}
