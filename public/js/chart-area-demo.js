// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart for Monthly Revenue
var completedRevenue = typeof chartRevenueCompleted !== 'undefined' ? chartRevenueCompleted : [];
var incompleteRevenue = typeof chartRevenueIncomplete !== 'undefined' ? chartRevenueIncomplete : [];
var cancelledRevenue = typeof chartRevenueCancelled !== 'undefined' ? chartRevenueCancelled : [];

if (completedRevenue.length === 0 && typeof monthlyRevenue !== 'undefined') {
  for (var i = 0; i < 12; i++) {
    completedRevenue.push(Number(monthlyRevenue[i]));
  }
}

document.addEventListener("DOMContentLoaded", function () {
  var ctx = document.getElementById("myAreaChart");

  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: typeof chartLabels !== 'undefined' ? chartLabels : ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
      datasets: [
        {
          label: "Doanh thu thực tế (Đã hoàn thành)",
          lineTension: 0.3,
          backgroundColor: "rgba(40,167,69,0.2)",
          borderColor: "rgba(40,167,69,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(40,167,69,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(40,167,69,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: completedRevenue,
        },
        {
          label: "Doanh thu dự kiến (Chưa hoàn thành)",
          lineTension: 0.3,
          backgroundColor: "rgba(2,117,216,0.2)",
          borderColor: "rgba(2,117,216,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(2,117,216,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(2,117,216,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: incompleteRevenue,
        },
        {
          label: "Doanh thu bị mất (Đã hủy)",
          lineTension: 0.3,
          backgroundColor: "rgba(220,53,69,0.2)",
          borderColor: "rgba(220,53,69,1)",
          pointRadius: 5,
          pointBackgroundColor: "rgba(220,53,69,1)",
          pointBorderColor: "rgba(255,255,255,0.8)",
          pointHoverRadius: 5,
          pointHoverBackgroundColor: "rgba(220,53,69,1)",
          pointHitRadius: 50,
          pointBorderWidth: 2,
          data: cancelledRevenue,
        }
      ],
    },
    options: {
      scales: {
        xAxes: [{
          gridLines: { display: false },
          ticks: { 
            maxTicksLimit: 12,
            minRotation: 0,
            maxRotation: 0
          }
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) {
              return value.toLocaleString('vi-VN') + ' ₫'; 
            }
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: true
      }
    }
  });
});
