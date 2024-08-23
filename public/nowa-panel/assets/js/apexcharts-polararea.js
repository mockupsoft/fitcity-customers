(function () {
    "use strict";

    /* basic polar area chart */
    var options = {
        series: [14, 23, 21, 17, 15, 10, 12, 17, 21],
        chart: {
            type: 'polarArea',
            height: 300
        },
        stroke: {
            colors: ['#fff']
        },
        fill: {
            opacity: 0.8
        },
        legend: {
            position: 'bottom'
        },
        colors: ["#38cab3", "#38cab3", "#ffbd5a", "#4ec2f0", "#f34343", "#24d5b8", "#a65e76", "#4ec2f0", "#5b67c7"],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#polararea-basic"), options);
    chart.render();

    /* polar area monochrome chart */
    var options = {
        series: [42, 47, 52, 58, 65],
        chart: {
            height: 300,
            type: 'polarArea'
        },
        labels: ['Rose A', 'Rose B', 'Rose C', 'Rose D', 'Rose E'],
        fill: {
            opacity: 1
        },
        stroke: {
            width: 1,
            colors: undefined
        },
        yaxis: {
            show: false
        },
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            polarArea: {
                rings: {
                    strokeWidth: 0
                },
                spokes: {
                    strokeWidth: 0
                },
            }
        },
        theme: {
            monochrome: {
                enabled: true,
                shadeTo: 'light',
                shadeIntensity: 0.6,
                color: "#38cab3",
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#polararea-monochrome"), options);
    chart.render();

})();