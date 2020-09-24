
var backgroundColor = [
  'rgba(255, 99, 132, 0.2)',
  'rgba(54, 162, 235, 0.2)',
  'rgba(255, 206, 86, 0.2)',
  'rgba(75, 192, 192, 0.2)',
  'rgba(153, 102, 255, 0.2)',
  'rgba(255, 159, 64, 0.2)'
];

var chartMap = [];
function pieChart(canvasid, data, labels) {

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
      backgroundColor: bkcolor
    }],
    labels: labels,

  };
  document.getElementById(canvasid).innerHTML='';
  var ctx = document.getElementById(canvasid).getContext('2d');



  var chart = new Chart(ctx, {
    type: 'pie',
    data: dd,
    options: {
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
          borderColor: backgroundColor[0],
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
          borderColor: backgroundColor[1],
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
