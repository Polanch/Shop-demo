@extends('layouts.admin')

@section('content')
    <div class="sales-container">
        <div class="sales-head">
            <h6>Sales Report & Analytics</h6>
        </div>

        <!-- Summary Cards -->
        <div class="sales-summary">
            <div class="summary-card">
                <div class="summary-icon" style="background-color: #d4edda;">
                    <span style="font-size: 24px;">💰</span>
                </div>
                <div class="summary-info">
                    <h4>Total Revenue</h4>
                    <p>${{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background-color: #d1ecf1;">
                    <span style="font-size: 24px;">📦</span>
                </div>
                <div class="summary-info">
                    <h4>Total Orders</h4>
                    <p>{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background-color: #fff3cd;">
                    <span style="font-size: 24px;">⏳</span>
                </div>
                <div class="summary-info">
                    <h4>Pending Orders</h4>
                    <p>{{ $pendingOrders }}</p>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon" style="background-color: #d4edda;">
                    <span style="font-size: 24px;">✅</span>
                </div>
                <div class="summary-info">
                    <h4>Completed Orders</h4>
                    <p>{{ $completedOrders }}</p>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="charts-grid">
            <!-- Monthly Sales Bar Chart -->
            <div class="chart-box chart-large">
                <h3>Monthly Sales Trend</h3>
                <canvas id="monthlySalesChart"></canvas>
            </div>

            <!-- Order Status Doughnut Chart -->
            <div class="chart-box chart-small">
                <h3>Order Status Distribution</h3>
                <canvas id="orderStatusChart"></canvas>
            </div>

            <!-- Top Products Bar Chart -->
            <div class="chart-box chart-large">
                <h3>Top 5 Best Selling Products</h3>
                <canvas id="topProductsChart"></canvas>
            </div>

            <!-- Sales by Size Pie Chart -->
            <div class="chart-box chart-small">
                <h3>Sales by Size</h3>
                <canvas id="salesBySizeChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Sales Bar Chart
        const monthlyCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Monthly Revenue ($)',
                    data: {!! json_encode($monthData) !!},
                    backgroundColor: 'rgba(201, 40, 41, 0.7)',
                    borderColor: '#C92829',
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toFixed(0);
                            }
                        }
                    }
                }
            }
        });

        // Order Status Doughnut Chart
        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        '#ffc107',
                        '#28a745',
                        '#dc3545'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Top Products Bar Chart (Horizontal)
        const productsCtx = document.getElementById('topProductsChart').getContext('2d');
        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($productLabels) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($productQuantities) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: '#36a2eb',
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales by Size Pie Chart
        const sizeCtx = document.getElementById('salesBySizeChart').getContext('2d');
        new Chart(sizeCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($sizeLabels) !!},
                datasets: [{
                    data: {!! json_encode($sizeData) !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(199, 199, 199, 0.7)',
                        'rgba(83, 102, 255, 0.7)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': $' + context.parsed.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection