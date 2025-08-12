@extends('layouts.admin')

@section('title', 'Service Dashboard')

@section('content')
<style>
    #salesChart {
        height: 400px !important;
    }
</style>

<div class="container-fluid py-4">
    <!-- Chart Card -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Full-width Chart -->
                <div class="col-12">
                    <div class="chart">
                        <div style="position: relative; width: 100%;">
                            <!-- Combined Filter Form -->
                            <div class="d-flex justify-content-end">
                                <form method="GET" class="d-flex align-items-center flex-wrap gap-2 mb-4">
                                    <!-- Date Filters -->
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="date" name="start_day" class="form-control form-control-sm" style="max-width: 180px;" value="{{ request('start_day', date('Y-m-01')) }}">
                                        <span class="fw-semibold">to</span>
                                        <input type="date" name="end_day" class="form-control form-control-sm" style="max-width: 180px;" value="{{ request('end_day', date('Y-m-t')) }}">
                                    </div>

                                    <!-- Service Name Dropdown -->
                                    <select name="service_name" class="form-select form-select-sm" style="max-width: 200px;">
                                        <option value="">All Services</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->service_name }}" {{ request('service_name') == $service->service_name ? 'selected' : '' }}>
    {{ $service->service_name }}
</option>

                                        @endforeach
                                    </select>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                </form>
                            </div>

                            <!-- Chart Canvas (only one!) -->
                            <canvas id="salesChart" style="width: 100%; height: 250px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards Below Chart -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <!-- Total Sales Card -->
                        <div class="p-3 bg-light rounded shadow-sm text-center" style="min-width: 260px;">
                            <h6 class="mb-0">📊 Total Sales</h6>
                            <h5 class="text-success">₱{{ number_format($totalSales, 2) }}</h5>
                        </div>

                        <!-- Forecast Card -->
                        @if ($showPrediction)
                            <div class="p-3 bg-light rounded shadow-sm text-center"
                                 style="min-width: 260px;"
                                 data-bs-toggle="tooltip"
                                 data-bs-placement="top"
                                 title="Using Simple Moving Average Method to predict the next month sales: FORMULA: Month1 + Month2 + Month3 ÷ 3. Forecast is average of the last 3 full months.">
                                <h6 class="mb-0">🔮 Predicted Sales for Next Month</h6>
                                <h5 class="text-primary">₱{{ number_format($forecastedSales, 2) }}</h5>
                            </div>
                        @else
                            <div class="p-3 bg-light rounded shadow-sm text-center text-muted" style="min-width: 260px;">
                                <h6 class="mb-0">🔮 Predicted Sales</h6>
                                <small>Select 3 full months to show forecast</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div> <!-- end row -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Extract arrays from Blade
    const salesData = @json($salesData);
    const labels = salesData.map(item => item.label);
    const data = salesData.map(item => item.price);
    const tooltips = salesData.map(item => item.label);
    const services = salesData.map(item => item.service_names ?? []);
    const ctx = document.getElementById('salesChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Services from {{ request('start_day', date('Y-m-01')) }} - {{ request('end_day', date('Y-m-t')) }}',
                data: data,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Price (PHP)'
                    }
                }
            },
            plugins: {
    tooltip: {
        callbacks: {
            title: function(context) {
                return 'Date: ' + context[0].label;
            },
            label: function(context) {
                const index = context.dataIndex;
                const price = context.formattedValue;
                const serviceList = services[index];

                if (!serviceList || serviceList.length === 0) {
                    return  price;
                }

                const joined = serviceList.join(', ');
                return  joined + ' - ₱ ' + price;
            }
        }
    }
}
        }
    });

    // Bootstrap tooltip
    document.addEventListener('DOMContentLoaded', function () {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (el) {
            return new bootstrap.Popover(el);
        });
    });
</script>
@endsection
