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
  const labels = JSON.parse(chart.dataset.labels);
  const values = JSON.parse(chart.dataset.values);

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
      labels,
      datasets: [{
        label: 'Calls',
        data: values
      }]
    }
  });
}

// User Dashboard
const callChart = document.getElementById('callsChart');

if (typeof callChart !== 'undefined' && callChart) {
  initCallsChar(callChart);
}

const changeCallTableHeight = function (e, callTable) {
  if (e.matches) {
    callTable.style.height = "308px";
  } else {
    callTable.style.height = "auto";
  }
};

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

  const callTable = document.getElementById('table-calls');

  if (callChart && callTable) {
    let breakpoint = window.matchMedia('(min-width: 1200px)');

    breakpoint.addListener((e) => changeCallTableHeight(e, callTable));
    changeCallTableHeight(breakpoint, callTable);
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
