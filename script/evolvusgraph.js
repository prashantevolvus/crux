
var backgroundColor = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(54, 162, 235, 0.2)',
  'rgba(255, 206, 86, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(153, 102, 255, 0.2)',
  'rgba(255, 159, 64, 0.2)',

  'rgba(255, 204, 153, 0.2)',
  'rgba(255, 229, 204, 0.2)',
  'rgba(204, 255, 250, 0.2)',
  'rgba(20, 153, 138, 0.2)',
  'rgba(224, 204, 255, 0.2)',
  'rgba(0, 255, 156, 0.2)'


];
var borderColor =  [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 204, 153, 1)',
          'rgba(255, 229, 204, 1)',
          'rgba(204, 255, 250, 1)',
          'rgba(20, 153, 138, 1)',
          'rgba(224, 204, 255, 1)',
          'rgba(0, 255, 156, 1)'

        ];
var chartMap = [];
function pieChart(canvasid, data, labels,header="") {

  if(chartMap[canvasid]){
    chartMap[canvasid].destroy();
  }


  var bkcolor = [];

  i = 0;
  data.forEach(function(element) {
    bkcolor.push(backgroundColor[i++]);
  });

  dd = {
    datasets: [{
      data: data,
      backgroundColor: bkcolor,
      borderColor:borderColor,
      borderWidth: 1
    }],
    labels: labels,

  };
  document.getElementById(canvasid).innerHTML='';
  var ctx = document.getElementById(canvasid).getContext('2d');



  var chart = new Chart(ctx, {
    type: 'doughnut',
    data: dd,
    options: {
      title: {
        display: true,
        text: header
      },
      legend: {
        display: true,
        position: 'top'
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let sum = 0;
            let dataArr = ctx.chart.data.datasets[0].data;
            dataArr.map(data => {
              sum += data;
            });
            let percentage = (value * 100 / sum).toFixed(0) + "%";
            return percentage;
          },
          color: '#000',
        }
      }
    }
  });

  chartMap[canvasid] =  chart ;


}

function lineChart(canvasid, data, labels,header="") {

  if(chartMap[canvasid]){
    chartMap[canvasid].destroy();
  }


  document.getElementById(canvasid).innerHTML='';
  var chart = new Chart(document.getElementById(canvasid), {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          data: data[0].data,
          label: data[0].label,
          yAxisID: 'A',
          backgroundColor: backgroundColor[0],
          borderColor: borderColor[0],
          fill: false,
          datalabels: {
            labels: {
                title: null
            }
          }
        },
        {
          data: data[1].data,
          label: data[1].label,
          yAxisID: 'B',
          backgroundColor: backgroundColor[1],
          borderColor: borderColor[1],
          fill: false,
          datalabels: {
            labels: {
                title: null
            }
          }
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: header
      },
      scales: {
        yAxes: [
        {
          id: 'A',
          type: 'linear',
          position: 'left',
        },
        {
          id: 'B',
          type: 'linear',
          position: 'right',
        }
        ],
        xAxes: [{
            type: 'time',
            time: {
                unit: 'month'
            }
        }]
      }
    }
  });
  chartMap[canvasid] =  chart ;

}

function barChart(canvasid, data, labels,header="") {

  if(chartMap[canvasid]){
    chartMap[canvasid].destroy();
  }

  document.getElementById(canvasid).innerHTML='';
  var chart = new Chart(document.getElementById(canvasid), {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: data[0].label,
          backgroundColor: backgroundColor,
          borderColor:borderColor,
          borderWidth: 1,
          data: data[0].data,
          datalabels: {
            labels: {
                title: null
            }
          }
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: header
      }
    }
  });
  chartMap[canvasid] =  chart ;

}
