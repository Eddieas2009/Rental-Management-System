async function getTotalRevenue() {
    let revenueData = [];

    try {
        const response = await fetch('models/payments/getMonthlyRevenue.php');
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status}`);
        }
        const data = await response.json();
        
        // Check if data has the expected structure
        if (!data || !Array.isArray(data)) {
            throw new Error('Invalid revenue data format');
        }
        
        revenueData = data;
		
    } catch (error) {
        console.error('Error fetching revenue data:', error);
        // Return fallback array if there's an error
        revenueData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    }

    return revenueData;
}

$(function () {
	"use strict";


	
	// chart1
	async function renderChart() {
        // Fetch the revenue data
        const revenueData = await getTotalRevenue();
		
	var options = {
		series: [{
			name: 'Rent',
			data:  revenueData,
		}],
		chart: {
			foreColor: '#9a9797',
			type: 'area',
			height: 380,
			zoom: {
				enabled: false
			},
			toolbar: {
				show: false
			},
			dropShadow: {
				enabled: false,
				top: 3,
				left: 14,
				blur: 4,
				opacity: 0.10,
			}
		},
		stroke: {
			width: 4,
			curve: 'smooth'
		},
		xaxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		},
		dataLabels: {
			enabled: false
		},
		fill: {
			type: 'gradient',
			gradient: {
				shade: 'light',
				gradientToColors: ['#8833ff'],
				shadeIntensity: 1,
				type: 'vertical',
				opacityFrom: 0.8,
				opacityTo: 0.3,
				//stops: [0, 100, 100, 100]
			},
		},
		colors: ["#8833ff"],
		yaxis: {
		  labels: {
			formatter: function (value) {
			  return value + "$";
			}
		  },
		},
		markers: {
			size: 4,
			colors: ["#8833ff"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7,
			}
		},
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		},
	};
	var chart = new ApexCharts(document.querySelector("#chart1"), options);
	chart.render();
}

renderChart().catch(error => {
	console.error('Error rendering chart:', error);
});



});