


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
function genBarChart(ctx, data, labels, barType, lakhs, header = "",drillAllowed="N") {

  
  var datasetArr = data.map((item,index)=>({
        label: item.label,
        backgroundColor: backgroundColor[index],
        borderColor: borderColor[index],
        borderWidth: 1,
        data: item.data
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
      scales: {
        yAxes: [{
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
              datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel) / 100000) + ' lakhs';
            else
              datasetLabel = datasetLabel + ': ' + amtFormat(parseFloat(tooltipItem.yLabel));
            return datasetLabel;
          }
        }
      },
      onClick: function (e, items) {
        var firstPoint = this.getElementAtEvent(e)[0];
        if (drillAllowed === "Y" && firstPoint ){
          var label = firstPoint._model.label;
          var val = firstPoint._model.datasetLabel;
          alert(label + " - " + val);
        }
      }
    }
  });
  return chart;

}


function genHBarChart(ctx, data, labels, barType, lakhs, header = "") {

  

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
        if (firstPoint) {
          var label = firstPoint._model.label;
          var val = firstPoint._model.datasetLabel;
          console.log(label + " - " + val);
        }

      }
    }
  });
  
  return chart;

}


function genPieChart(ctx, data, labels, pieType,lakhs = "Y" , header = "") {

 
  
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
    data: dd
    ,
    options: {
      title: {
        display: true,
        text: header
      },
      legend: {
        display: true,
        position: 'top'
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
        if (firstPoint) {
          var label = firstPoint._model.label;
          var val = firstPoint._model.datasetLabel;
          console.log(label + " - " + val);
        }

      }
    }
  });

  return chart;

}

function generateChart(canvasid, data, labels, chartType, lakhs = "Y", header = "",drillAllowed="N") {
  if (chartMap[canvasid]) {
    chartMap[canvasid].destroy();
  }
  document.getElementById(canvasid).innerHTML = '';
  var ctx = document.getElementById(canvasid).getContext('2d');

  if (chartType === "pie" || chartType === "doughnut" || chartType === "polarArea") {
    chart = genPieChart(ctx, data, labels, chartType, lakhs , header );
  }
  else if (chartType === "line" || chartType === "bar") {
    chart = genBarChart(ctx, data, labels, chartType, lakhs, header, drillAllowed);
  }
  else if (chartType === "horizontalBar" ) {
    chart = genHBarChart(ctx, data, labels, chartType, lakhs, header);
  }

  chartMap[canvasid] = chart;

}