async function getTotalMonthlyRent() {
    let revenueData = [];

    try {
        const response = await fetch('models/reporting/getMonthlyRent.php');
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
/* End of getTotalMonthlyRent */

async function getTotalMonthlyExpenses() {
    let revenueData = [];

    try {
        const response = await fetch('models/reporting/getMonthlyExpenses.php');
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
/* End of getTotalMonthlyExpenses */

async function getRentVsExpensesInPieChart() {
    let revenueData = [];

    try {
        const response = await fetch('models/reporting/getRentVsExpensesInPieChart.php');
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

async function renderChart() {
	const revenueData = await getTotalMonthlyRent();
	const expensesData = await getTotalMonthlyExpenses();
	// chart3
	Highcharts.chart('barChart1', {
		chart: {
			height: 330,
			type: 'column',
			styledMode: true
		},
		credits: {
			enabled: false
		},
		title: {
			text: 'Rent vs Expenses per month',
			style: {
				display: 'none',
			}
		},
		subtitle: {
			text: 'Rent vs Expenses per month',
			style: {
				display: 'none',
			}
		},
		xAxis: {
			categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			crosshair: true
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Amount (UGX)',
				style: {
					display: 'none',
				}
			}
		},
		exporting: {
			buttons: {
				contextButton: {
					enabled: false,
				}
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		//colors: ['#50b5ff', '#ff9ad5'],
		series: [{
			name: 'Rent',
			data: revenueData
		}, {
			name: 'Expenses',
			data: expensesData
		}]
	});
}
renderChart().catch(error => {
	console.error('Error rendering chart:', error);
});

	// chart 4
	// Make monochrome colors
	async function renderPieChart() {
	const rentVsExpensesData = await getRentVsExpensesInPieChart();
	var pieColors = (function () {
		var colors = ['#0370e6', 'rgb(3 112 230 / 76%)', 'rgb(3 112 230 / 60%)', 'rgb(3 112 230 / 46%)', 'rgb(3 112 230 / 26%)'],
			base = Highcharts.getOptions().colors[0],
			i;
		for (i = 0; i < 10; i += 1) {
			// Start out with a darkened base color (negative brighten), and end
			// up with a much brighter color
			colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
		}
		return colors;
	}());
	// Build the chart
	Highcharts.chart('chart4', {
		chart: {
			//height:380,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			//styledMode: true
		},
		credits: {
			enabled: false
		},
		exporting: {
			buttons: {
				contextButton: {
					enabled: false,
				}
			}
		},
		title: {
			text: 'Rent vs Expenses in a year'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				innerSize: 0,
				colors: pieColors,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
					distance: -50,
					filter: {
						property: 'percentage',
						operator: '>',
						value: 4
					}
				}
			}
		},
		series: [{
			name: 'Rent vs Expenses',
			data: rentVsExpensesData
		}]
	});
}
renderPieChart().catch(error => {
	console.error('Error rendering chart:', error);
});

});