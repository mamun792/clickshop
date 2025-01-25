document.addEventListener('DOMContentLoaded', function () {
    // Wait for the DOM to be fully loaded before interacting with the chart
    const chartContainer = document.querySelector('#chart');
    const chartLoading = document.querySelector('#chart-loading');
    const orderChartDataElement = document.getElementById('orderChartData');

    if (!orderChartDataElement) {
        console.error('Order chart data not found.');
        return;
    }

    const orderData = JSON.parse(orderChartDataElement.textContent);  // Now fetching the data correctly
    console.log(orderData);  // Inspect the order data in the console

    let seriesData = [];
    let categories = [];

    // Loop through the orderData and populate series and categories
    orderData.forEach(order => {
        const orderDate = new Date(order.order_date).toISOString();

        // Add the date to categories if it's not already included
        if (!categories.includes(orderDate)) {
            categories.push(orderDate);
        }

        // Check if the order status already exists in seriesData
        let existingSeries = seriesData.find(series => series.name === order.order_status);
        
        if (existingSeries) {
            // Append the order's total if the status exists
            existingSeries.data.push(order.total);
        } else {
            // Create a new series if the status is not found
            seriesData.push({
                name: order.order_status,
                data: [order.total]
            });
        }
    });

    // ApexCharts configuration
    var options = {
        series: seriesData,
        chart: {
            height: 500,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'datetime',
            categories: categories
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            }
        }
    };

    // Hide the loading state and show the chart container
    chartLoading.style.display = 'none';
    chartContainer.style.display = 'block';

    // Create and render the chart
    const chart = new ApexCharts(chartContainer, options);
    chart.render();
});
