import Chart from 'chart.js';

import './dashkit/dashkit.chart-extensions';
import './dashkit/dashkit.chart';
import './dashkit/dashkit.flatpickr';
import './dashkit/dashkit.sortList';

function logout(event) {
  event.preventDefault();
  document.getElementById('logout-form').submit();
}

function initCallsChar(chart) {
  new Chart(chart, {
    type: 'bar',
    options: {
      scales: {
        yAxes: [{
          ticks: {
            callback: function (value) {
              if (!(value % 10)) {
                return value + ' calls'
              }
            }
          }
        }]
      },
      tooltips: {
        callbacks: {
          label: function (item, data) {
            const label = data.datasets[item.datasetIndex].label || '';
            const yLabel = item.yLabel;
            let content = '';

            if (data.datasets.length > 1) {
              content += '<span class="popover-body-label mr-auto">' + label + '</span>';
            }

            content += '<span class="popover-body-value">' + yLabel + ' calls</span>';
            return content;
          }
        }
      }
    },
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
      datasets: [{
        label: 'Calls',
        data: [23, 35, 30, 33, 45, 28, 23, 29, 48]
      }]
    }
  });
}

function initExtensionsChar(chart) {
  new Chart(chart, {
    type: 'doughnut',
    options: {
      tooltips: {
        callbacks: {
          title: function (item, data) {
            return data.labels[item[0].index];
          },
          label: function (item, data) {
            const value = data.datasets[0].data[item.index];
            let content = '';

            content += '<span class="popover-body-value">' + value + '%</span>';
            return content;
          }
        }
      }
    },
    data: {
      labels: ['Sales', 'Support', 'Accounting'],
      datasets: [{
        data: [60, 25, 15],
        backgroundColor: [
          '#704895',
          '#a381c2',
          '#D2DDEC'
        ]
      }]
    }
  });
}

// User Dashboard
const callChart = document.getElementById('callsChart');

if (typeof callChart !== 'undefined' && callChart) {
  initCallsChar(callChart);
}

const extensionChart = document.getElementById('extensionsChart');

if (typeof extensionChart !== 'undefined' && extensionChart) {
  initExtensionsChar(extensionChart);
}

window.onload = function () {
  let logoutItems = document.querySelectorAll('.logout-action');

  logoutItems.forEach((el) => {
    el.addEventListener('click', logout);
  });

  // Data Toggle - Bootstrap
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  // Automatically trigger the loading animation on click
  if (typeof Ladda !== 'undefined') {
    Ladda.bind('button[type=submit].js-ladda-submit');
  }

  // Delte and Retore element
  $('#delete-element, #restore-element').on('show.bs.modal', function (event) {
    const element = $(event.relatedTarget);
    const elementName = element.data('name');
    const elementDetail = element.data('detail');
    const elementAction = element.data('action');

    const modal = $(this);
    modal.find('.element-name').text(elementName);
    modal.find('.element-detail').text(elementDetail);
    modal.find('form').attr('action', elementAction);
  });
};
