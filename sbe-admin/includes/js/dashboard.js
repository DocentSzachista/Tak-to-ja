/* globals Chart:false, feather:false */

(function displayChart() {
  'use strict'

  feather.replace()

  // Graphs
  var ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [
        'Liczba Uczniow',
        'Liczba Nauczycieli',
        'Liczba Grup',
        'Liczba Potencjalnych Klientow'
      ],
      datasets: [{
        data: [
          ctx.getAttribute("students"),
          ctx.getAttribute("teachers"),
          ctx.getAttribute("teams"),
          ctx.getAttribute("potCustomers")
        ],
        lineTension: 0,
        backgroundColor: ['#FF9F40',
        '#FFCD56',
        '#36A2EB',
        '#FF6384'

      ],
        borderColor: '#FFFFFF',
        borderWidth: 4,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      responsive: true,
      legend: {
        display: true
      }
    }
  })
}())
