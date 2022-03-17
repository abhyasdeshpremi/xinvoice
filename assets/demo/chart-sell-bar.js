// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Metropolis"),
'-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

var sell_30graph = JSON.parse(sessionStorage.getItem('sell_30graph'));
console.log("before sorted");
console.log(sell_30graph);
for (i = 0; i < sell_30graph.length; i++) {
    var temp_sell = sell_30graph[i];
    var tempdate = temp_sell["date"];
    var tempdate = tempdate.split(" ");
    var tempdate = tempdate[0].split("-");
    var yyyy = tempdate[0].split("");
    temp_sell["date"] = tempdate[2]+"/"+tempdate[1]+"/"+yyyy[2]+""+yyyy[3];
}
var tmp_sell_30graph = [];
sell_30graph.reduce(function (res, value) {
    if (!res[value["date"]]) {
        res[value["date"]] = {
            "amount": 0,
            "date": value["date"]
        };
        tmp_sell_30graph.push(res[value["date"]])
    }
    res[value["date"]]["amount"] += parseInt(value["amount"])
    return res;
}, {});
compare_dates = function(date1,date2){
    d1= new Date(date1["date"]);
    d2= new Date(date2["date"]);
    if (d1>d2) return 1;
     else if (d1<d2)  return -1;
     else return 0;
  }
tmp_sell_30graph.sort(compare_dates);
console.log("after sorted");
console.log(tmp_sell_30graph);
var labels = [];
var amounts = [];
for (i = 0; i < tmp_sell_30graph.length; i++) {
    labels.push(tmp_sell_30graph[i]["date"]);
    amounts.push(tmp_sell_30graph[i]["amount"]);
}

let maximum = amounts.sort((a, b) => b - a)[0];
console.log("labels");
console.log(labels);
console.log("amount");
console.log(amounts);
// Bar Chart Example
var ctx = document.getElementById("myBarSellChart");
var myBarChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: labels,
        datasets: [{
            label: "Revenue",
            backgroundColor: "rgba(0, 97, 242, 1)",
            hoverBackgroundColor: "rgba(0, 97, 242, 0.9)",
            borderColor: "#4e73df",
            data: amounts,
            maxBarThickness: 25
        }]
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: "month"
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 6
                }
            }],
            yAxes: [{
                ticks: {
                    min: 0,
                    max: maximum,
                    maxTicksLimit: 5,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return "₹" + number_format(value);
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }]
        },
        legend: {
            display: false
        },
        tooltips: {
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel =
                        chart.datasets[tooltipItem.datasetIndex].label || "";
                    return datasetLabel + ": ₹" + number_format(tooltipItem.yLabel);
                }
            }
        }
    }
});
