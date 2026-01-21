@extends('layouts.admin')

@section('content')
    <div class="dashboard">
        <div class="dash-head">
            <h6>Dashboard</h6>
            <div class="size-menu">
                @foreach($sizes as $size)
                    <a href="{{ route('admin.dashboard', ['size' => $size]) }}" style="text-decoration: none;">
                        <button class="sizes {{ $selectedSize === $size ? 'active' : '' }}">{{ $size }}</button>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="monitor">
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m1.png') }}" class="m-icons">
                <h4>Orders</h4>
                <p>{{ str_pad($totalOrders, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m2.png') }}" class="m-icons">
                <h4>Profit</h4>
                <p>${{ number_format($totalProfit, 2) }}</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m3.png') }}" class="m-icons">
                <h4>Stocks</h4>
                <p>{{ str_pad($totalStocks, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="mm">
                <img src="{{ Vite::asset('resources/images/m4.png') }}" class="m-icons">
                <h4>Sold</h4>
                <p>{{ str_pad($totalSold, 2, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div class="big-monitor">
            <div class="sales-graph-container">
                <h3>Sales Overview - {{ $selectedSize === 'All' ? 'All Sizes' : $selectedSize }} (Last 7 Days)</h3>
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Sales ($)',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#C92829',
                    backgroundColor: 'rgba(201, 40, 41, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#C92829',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            color: '#333'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'Sales: $' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toFixed(0);
                            },
                            font: {
                                size: 12
                            },
                            color: '#666'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#666'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection