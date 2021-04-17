var luar_provinsi = {
    chart: { height: 350, type: "area", toolbar: { show: !1 } },
    colors: ["#2a76f4", "rgba(42, 118, 244, .2)"],
    dataLabels: { enabled: !1 },
    markers: {
        discrete: [
            { seriesIndex: 0, dataPointIndex: 7, fillColor: "#000", strokeColor: "#000", size: 5 },
            { seriesIndex: 2, dataPointIndex: 11, fillColor: "#000", strokeColor: "#000", size: 4 },
        ],
    },
    stroke: { show: !0, curve: "smooth", width: 3, lineCap: "square" },
    series: [
        { name: "Diterima", data: [0, 10, 40, 10, 75, 30, 155, 24, 43, 24, 64, 43] },
        { name: "Dibatalkan", data: [0, 34, 55, 43, 55, 54, 34, 54, 32, 24, 53, 43] },
    ],
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    yaxis: { labels: { offsetX: -12, offsetY: 0 } },
    grid: { borderColor: "#e0e6ed", strokeDashArray: 5, xaxis: { lines: { show: !0 } }, yaxis: { lines: { show: !1 } } },
    legend: { show: !1 },
    tooltip: { marker: { show: !0 }, x: { show: !1 } },
    fill: { type: "gradient", gradient: { type: "vertical", shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.28, opacityTo: 0.05, stops: [45, 100] } },
    responsive: [{ breakpoint: 575 }],
};
(chart = new ApexCharts(document.querySelector("#luar_provinsi"), luar_provinsi)).render();
var dalam_provinsi = {
    chart: { height: 350, type: "area", toolbar: { show: !1 } },
    colors: ["#2a76f4", "rgba(42, 118, 244, .2)"],
    dataLabels: { enabled: !1 },
    markers: {
        discrete: [
            { seriesIndex: 0, dataPointIndex: 7, fillColor: "#000", strokeColor: "#000", size: 5 },
            { seriesIndex: 2, dataPointIndex: 11, fillColor: "#000", strokeColor: "#000", size: 4 },
        ],
    },
    stroke: { show: !0, curve: "smooth", width: 3, lineCap: "square" },
    series: [
        { name: "Diterima", data: [0, 160, 100, 210, 145, 400, 155, 210, 120, 275, 110, 200] },
        { name: "Dibatalkan", data: [0, 100, 90, 220, 100, 180, 140, 315, 130, 105, 165, 120] },
    ],
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    yaxis: { labels: { offsetX: -12, offsetY: 0 } },
    grid: { borderColor: "#e0e6ed", strokeDashArray: 5, xaxis: { lines: { show: !0 } }, yaxis: { lines: { show: !1 } } },
    legend: { show: !1 },
    tooltip: { marker: { show: !0 }, x: { show: !1 } },
    fill: { type: "gradient", gradient: { type: "vertical", shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.28, opacityTo: 0.05, stops: [45, 100] } },
    responsive: [{ breakpoint: 575 }],
};
(chart = new ApexCharts(document.querySelector("#dalam_provinsi"), dalam_provinsi)).render();
var keuangan = {
    chart: { height: 350, type: "area", toolbar: { show: !1 } },
    colors: ["#2a76f4", "rgba(42, 118, 244, .2)"],
    dataLabels: { enabled: !1 },
    markers: {
        discrete: [
            { seriesIndex: 0, dataPointIndex: 7, fillColor: "#000", strokeColor: "#000", size: 5 },
            { seriesIndex: 2, dataPointIndex: 11, fillColor: "#000", strokeColor: "#000", size: 4 },
        ],
    },
    stroke: { show: !0, curve: "smooth", width: 3, lineCap: "square" },
    series: [
        { name: "Estimasi", data: [48000000, 30000000, 54000000, 34000000, 37600000, 45300000, 23400000, 76500000, 30000000, 35400000, 37400000, 64300000] },
        { name: "Realisasi", data: [12000000, 32000000, 12000000, 43000000, 12600000, 4300000, 2420000, 73200000, 30000000, 35400000, 37400000, 64300000] },
        { name: "Sisa Anggaran", data: [3400000, 23000000, 3440000, 21, 37600000, 45300000, 23400000, 76500000, 30000000, 35400000, 37400000, 64300000] },
    ],
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    yaxis: { labels: { offsetX: -12, offsetY: 0 } },
    grid: { borderColor: "#e0e6ed", strokeDashArray: 5, xaxis: { lines: { show: !0 } }, yaxis: { lines: { show: !1 } } },
    legend: { show: !1 },
    tooltip: { marker: { show: !0 }, x: { show: !1 } },
    fill: { type: "gradient", gradient: { type: "vertical", shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.28, opacityTo: 0.05, stops: [45, 100] } },
    responsive: [{ breakpoint: 575 }],
};
(chart = new ApexCharts(document.querySelector("#keuangan"), keuangan)).render();