
var funcArray = [];

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


  
  var bkcolor = data.map((item, index) => backgroundColor[index]);
    

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

function barChart(canvasid, data, labels,barType,lakhs , header="") {

  if(chartMap[canvasid]){
    chartMap[canvasid].destroy();
  }

  document.getElementById(canvasid).innerHTML='';
  var chart = new Chart(document.getElementById(canvasid), {
    type: barType,
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
      },
      scales: {
        yAxes: [{
            ticks: {
                beginAtZero:true,
                callback: function(value, index, values) {
                    ret = value;
                    if(lakhs === "Y")
                      ret = amtFormat(parseFloat(value)/100000)+' lakhs';
                      return ret;
                }
            }
        }]
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, chart){
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            if(lakhs === "Y")
              datasetLabel =  datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel)/100000)+' lakhs';
            else
              datasetLabel =  datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel));
            return  datasetLabel;
          }
        }
      }
    }
  });
  chartMap[canvasid] =  chart ;

}


/*
******************************
GENERIC CHARTS
******************************
*/
funcArray.bar =
  (ctx, data, labels, barType, drillDownFunction, lakhs, header = "", drillAllowed = "N", divid = "") => {


    var datasetArr = data.map((item, index) => ({
      label: item.label,
      backgroundColor: backgroundColor[index],
      borderColor: borderColor[index],
      borderWidth: 1,
      data: item.data,
      datalabels: {
        labels: {
          title: null
        }
      }
    })
    );


    var chart = new Chart(ctx, {
      type: barType,
      data: {
        labels: labels,
        datasets: datasetArr
      },
      options: {
        legend: { position: 'top' },
        title: {
          display: true,
          text: header
        },
        animation: {
          onComplete: function () {
            var x = document.getElementById("D" + divid);
            x.href = chart.toBase64Image();
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              // stacked: true,
              callback: function (value, index, values) {
                ret = value;
                if (lakhs === "Y")
                  ret = amtFormat(parseFloat(value) / 100000) + ' lakhs';
                return ret;
              }
            }
          }]
          // ,
          // xAxes: [{
          //   stacked: true
          // }]
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              if (lakhs === "Y")
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel) / 100000) + ' lakhs';

              else
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel));
              return datasetLabel;
            }
          }
        },
        onClick: function (e, items) {
          var firstPoint = this.getElementAtEvent(e)[0];
          if (drillAllowed === "Y" && firstPoint) {
            var label = firstPoint._model.label;
            var val = firstPoint._model.datasetLabel;
            drillDownFunction(label, val);
          }
        },
        plugins: {
          zoom: {
            // Container for pan options
            pan: {
              // Boolean to enable panning
              enabled: true,

              // Panning directions. Remove the appropriate direction to disable
              // Eg. 'y' would only allow panning in the y direction
              // A function that is called as the user is panning and returns the
              // available directions can also be used:
              //   mode: function({ chart }) {
              //     return 'xy';
              //   },
              mode: 'xy',

              rangeMin: {
                // Format of min pan range depends on scale type
                x: null,
                y: null
              },
              rangeMax: {
                // Format of max pan range depends on scale type
                x: null,
                y: null
              },

              // On category scale, factor of pan velocity
              speed: 20,

              // Minimal pan distance required before actually applying pan
              threshold: 10,

              // Function called while the user is panning
              onPan: function ({ chart }) { 
                //console.log(`I'm panning!!!`); 
            },
              // Function called once panning is completed
              onPanComplete: function ({ chart }) { 
                //console.log(`I was panned!!!`); 
              }
            },

            // Container for zoom options
            zoom: {
              // Boolean to enable zooming
              enabled: true,

              // Enable drag-to-zoom behavior
              drag: true,

              // Drag-to-zoom effect can be customized
              // drag: {
              // 	 borderColor: 'rgba(225,225,225,0.3)'
              // 	 borderWidth: 5,
              // 	 backgroundColor: 'rgb(225,225,225)',
              // 	 animationDuration: 0
              // },

              // Zooming directions. Remove the appropriate direction to disable
              // Eg. 'y' would only allow zooming in the y direction
              // A function that is called as the user is zooming and returns the
              // available directions can also be used:
              //   mode: function({ chart }) {
              //     return 'xy';
              //   },
              mode: 'xy',

              rangeMin: {
                // Format of min zoom range depends on scale type
                x: null,
                y: null
              },
              rangeMax: {
                // Format of max zoom range depends on scale type
                x: null,
                y: null
              },

              // Speed of zoom via mouse wheel
              // (percentage of zoom on a wheel event)
              speed: 0.1,

              // Minimal zoom distance required before actually applying zoom
              threshold: 2,

              // On category scale, minimal zoom level before actually applying zoom
              sensitivity: 3,

              // Function called while the user is zooming
              // onZoom: function ({ chart }) { console.log(`I'm zooming!!!`); },
              // Function called once zooming is completed
              // onZoomComplete: function ({ chart }) { console.log(`I was zoomed!!!`); }
            }
          }
        }
      }
    });
    return chart;

  }

funcArray.horizontalBar =
  (ctx, data, labels, barType, drillDownFunction, lakhs, header = "", drillAllowed = "N", divid = "") => {



    var datasetArr = data.map((item, index) => ({
      label: item.label,
      backgroundColor: backgroundColor[index],
      borderColor: borderColor,
      borderWidth: 1,
      data: item.data,
      datalabels: {
        labels: {
          title: null
        }
      }
    })
    );


    var chart = new Chart(ctx, {
      type: barType,
      data: {
        labels: labels,
        datasets: datasetArr
      },
      options: {
        legend: { position: 'top' },
        title: {
          display: true,
          text: header
        },
        animation: {
          onComplete: function () {
            var x = document.getElementById("D" + divid);
            x.href = chart.toBase64Image();
          }
        },
        scales: {
          xAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function (value, index, values) {
                ret = value;
                if (lakhs === "Y")
                  ret = amtFormat(parseFloat(value) / 100000) + ' lakhs';
                return ret;
              }
            }
          }]
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              if (lakhs === "Y")
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.xLabel) / 100000) + ' lakhs';

              else
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.xLabel));
              return datasetLabel;
            }
          }
        },
        onClick: function (e, items) {
          var firstPoint = this.getElementAtEvent(e)[0];
          if (drillAllowed === "Y" && firstPoint) {
            var label = firstPoint._model.label;
            var val = firstPoint._model.datasetLabel;
            drillDownFunction(label, val);
          }
        }
      }
    });

    return chart;

  }

funcArray.pie =
  (ctx, data, labels, pieType, drillDownFunction, lakhs = "Y", header = "", drillAllowed = "N", divid = "") => {



    dd = {
      datasets: [{
        data: data[0].data,
        backgroundColor: data[0].data.map((item, index) => (backgroundColor[index])),
        borderColor: borderColor,
        borderWidth: 1
      }],
      labels: labels,
    };



    var chart = new Chart(ctx, {
      type: pieType,
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
        animation: {
          onComplete: function () {
            var x = document.getElementById("D" + divid);
            x.href = chart.toBase64Image();
          }
        },
        tooltips: {
          callbacks: {
            label: function (tooltipItem, chart) {

              var datasetLabel = chart.labels[tooltipItem.index] || '';
              if (lakhs === "Y")
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(chart.datasets[0].data[tooltipItem.index]) / 100000) + ' lakhs';

              else
                datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(chart.datasets[0].data[tooltipItem.index]));
              return datasetLabel;
            }
          }
        },
        plugins: {
          datalabels: {
            formatter: (value, ctx) => {
              let dataArr = ctx.chart.data.datasets[0].data;
              return (value * 100 / dataArr.reduce((sum, data) => sum + data)).toFixed(0) + "%";
            },
            color: '#000',
          }
        },
        onClick: function (e, items) {
          var firstPoint = this.getElementAtEvent(e)[0];
          if (drillAllowed === "Y" && firstPoint) {
            var label = firstPoint._model.label;
            var val = firstPoint._model.datasetLabel;
            drillDownFunction(label, val);
          }
        }
      }
    });



    return chart;

  }

funcArray.doughnut = funcArray.pie ;
funcArray.polarArea = funcArray.pie;
funcArray.line = funcArray.bar;

function generateChart(canvasid, data, labels, chartType, drillDownFunction, lakhs = "Y", header = "", drillAllowed = "N") {
  if (chartMap[canvasid]) {
    chartMap[canvasid].destroy();
  }
  document.getElementById(canvasid).innerHTML = '';
  var ctx =
    chartMap[canvasid] = funcArray[chartType](document.getElementById(canvasid).getContext('2d'), data, labels, chartType, drillDownFunction, lakhs, header, drillAllowed, canvasid);

}


function genEBarChart(ctx, data, labels, pieType, drillDownFunction, lakhs = "Y", header = "", drillAllowed = "N") {
  var myChart = echarts.init(document.getElementById('ppp'));
  var datasetArr = data.map((item, index) => ({
    name: item.label,
    type: 'bar',
    data: item.data
    })
  
    );
  var option = {
    title: {
      text: header
    }, 
    tooltip: {},
    legend: {
      data: ['Sales']
    },
    xAxis: {
      data: labels
    },
    yAxis: {},
    series: datasetArr
  };
  myChart.setOption(option);

}
