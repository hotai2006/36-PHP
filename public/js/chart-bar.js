// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

    const months = [
        "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
    ];

    document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("myBarChart").getContext("2d");
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: typeof chartLabels !== 'undefined' ? chartLabels : months,
            datasets: [
                {
                    label: "Đã hoàn thành",
                    backgroundColor: "rgba(40,167,69,1)", // Xanh lá cây
                    borderColor: "rgba(40,167,69,1)",
                    data: typeof chartOrderCompleted !== 'undefined' ? chartOrderCompleted : [],
                },
                {
                    label: "Chưa hoàn thành",
                    backgroundColor: "rgba(2,117,216,1)", // Xanh nước biển
                    borderColor: "rgba(2,117,216,1)",
                    data: typeof chartOrderIncomplete !== 'undefined' ? chartOrderIncomplete : [],
                },
                {
                    label: "Đã bị hủy",
                    backgroundColor: "rgba(220,53,69,1)", // Đỏ
                    borderColor: "rgba(220,53,69,1)",
                    data: typeof chartOrderCancelled !== 'undefined' ? chartOrderCancelled : [],
                }
            ],
        },
        options: {
            scales: {
                xAxes: [{
                    time: {
                        unit: 'month'
                    },
                    gridLines: {
                        display: false
                    },
                    ticks: {
                        maxTicksLimit: 12,
                        minRotation: 0,
                        maxRotation: 0
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    },
                    gridLines: {
                        display: true
                    }
                }],
            },
            legend: {
                display: true
            }
        }
    });
});
