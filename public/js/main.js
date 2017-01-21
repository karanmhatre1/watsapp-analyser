function plotResponseTimeChart(responseTimeChartElement, responseTimeJSON) {

  // Parse JSON
  data = JSON.parse(responseTimeJSON.replace(/&quot;/g,'"'));

  // Initialize chart data
  chartData = {};
  chartData.labels = [];
  chartData.datasets = [];
  dataArray = [];

  // Add data in data array
  for (x in data) {

    // Convert from object to array
    dataArray = $.map(data[x], function(value, index) {
        return [value];
    });

    datesArray = $.map(data[x], function(value, index) {
        return [index];
    });

    // Build dataset
    chartData.datasets.push({label: x, data: dataArray});
  }

  // Add dates as labels
  for (x in datesArray) {
    chartData.labels.push(datesArray[x]);
  }

  // Plot chart
  var myLineChart = new Chart(responseTimeChartElement, {
      type: 'line',
      data: chartData,
      options: {
        responsive: true,
        legend: {
            display: false
         }
      }
  });
}

function plotChatCountChart(chatCountPieChartElement, chatCountJSON) {

  // Parse JSON
  data = JSON.parse(chatCountJSON.replace(/&quot;/g,'"'));

  // Initialize chart data
  chartData = {};
  chartData.labels = [];
  chartData.datasets = [];
  dataArray = [];

  // Build data array
  for (x in data) {
    chartData.labels.push(x);
    dataArray.push(data[x]);
  }

  // Build dataset
  chartData.datasets.push({
     data: dataArray,
     backgroundColor: [
        "#3FC1C9",
        "#FC5185"
      ]
  });

  // Plot chart
  var myPieChart = new Chart(chatCountPieChartElement,{
      type: 'doughnut',
      data: chartData,
      animation:{
        animateScale:true
      },
      options: {
        responsive: true,
        legend: {
            display: false
         }
      }
  });
}

function plotWordChart(wordChartElement, wordChartJSON) {

  // Parse JSON
  data = JSON.parse(wordChartJSON.replace(/&quot;/g,'"'));

  // Initialize chart data
  chartData = {};
  chartData.labels = [];
  chartData.datasets = [];
  dataArray = [];

  // Add data in data array

  i = 0;

  for (x in data) {

    // Convert from object to array
    dataArray = $.map(data[x], function(value, index) {
        return [value];
    });

    datesArray = $.map(data[x], function(value, index) {
        return [index];
    });

    if(i == 0)
      // Build dataset
      chartData.datasets.push(
        {
          label: x,
          data: dataArray,
          backgroundColor: "rgba(10,150,198,0.2)",
          borderColor: "rgba(10,150,198,1)",
          pointBackgroundColor: "rgba(179,181,198,1)",
          fill: false,
          radius: 0
        });
    else
      chartData.datasets.push(
        {
          label: x,
          data: dataArray,
          backgroundColor: "rgba(255,99,132,0.2)",
          borderColor: "rgba(255,99,132,1)",
          fill: false,
          radius: 0
        });

    i++;

  }

  // Add dates as labels
  for (x in datesArray) {
    chartData.labels.push(datesArray[x]);
  }

  // Plot chart
  var myLineChart = new Chart(wordChartElement, {
      type: 'line',
      data: chartData,
      options: {
        scales: {
            xAxes: [{
              type: "time",
              display: true,
              time: {
                format: 'YYYY-MM-DD',
                round: 'day'
              }
            }],
        },
        responsive: true

      }
  });
}

function plotRadar(radarElement, radarDataJSON) {

  // Parse JSON
  data = JSON.parse(radarDataJSON.replace(/&quot;/g,'"'));

  // Initialize chart data
  chartData = {};
  chartData.labels = [];
  chartData.datasets = [];
  dataArray = [];

  // Add data in data array

   var i = 0;

  for (x in data) {

    // Convert from object to array
    dataArray = $.map(data[x], function(value, index) {
        return [value];
    });

    datesArray = $.map(data[x], function(value, index) {
        return [index];
    });

    if(i == 0)
      // Build dataset
      chartData.datasets.push(
        {
          label: x,
          data: dataArray,
          backgroundColor: "rgba(10,150,198,0.2)",
          borderColor: "rgba(10,150,198,1)",
          pointBackgroundColor: "rgba(179,181,198,1)",
          pointBorderColor: "#fff",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(179,181,198,1)"
        });
    else
      chartData.datasets.push(
        {
          label: x,
          data: dataArray,
          backgroundColor: "rgba(255,99,132,0.2)",
          borderColor: "rgba(255,99,132,1)",
          pointBackgroundColor: "rgba(255,99,132,1)",
          pointBorderColor: "#fff",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: "rgba(255,99,132,1)"
        });

    i++;
  }

  // Add dates as labels
  for (x in datesArray) {
    chartData.labels.push(datesArray[x]);
  }

  var myRadarChart = new Chart(radarElement, {
      type: 'radar',
      data: chartData,
      options: {
        responsive: true,
      }
  });

}

function plotInitiateCountChart(initiateCountPieChartElement, initiateCountJSON) {

  // Parse JSON
  data = JSON.parse(initiateCountJSON.replace(/&quot;/g,'"'));

  // Initialize chart data
  chartData = {};
  chartData.labels = [];
  chartData.datasets = [];
  dataArray = [];

  // Build data array
  for (x in data) {
    chartData.labels.push(x);
    dataArray.push(data[x]);
  }

  // Build dataset
  chartData.datasets.push({
     data: dataArray,
     backgroundColor: [
        "#3FC1C9",
        "#FC5185"
      ]
  });

  // Plot chart
  var myPieChart = new Chart(initiateCountPieChartElement,{
      type: 'doughnut',
      data: chartData,
      animation:{
        animateScale:true
      },
      options: {
        responsive: true,
        legend: {
            display: false
         }
      }
  });
}