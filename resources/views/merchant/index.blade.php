@extends('merchant.layouts.main')
@section('title', 'Merchant Dashboard')
@section('main-content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <img width="30" height="30" src="https://img.icons8.com/ios-filled/30/crowd.png" alt="crowd"/>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                           Canceled Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <img width="30" height="30" src="https://img.icons8.com/ios-filled/50/box--v1.png" alt="box--v1"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            No. of Products</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <img width="30" height="30" src="https://img.icons8.com/ios-filled/30/fast-moving-consumer-goods.png" alt="fast-moving-consumer-goods"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Orders
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    {{ $pendingOrders }}</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 10%"
                                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <img width="30" height="30" class="" src="https://img.icons8.com/material-outlined/96/data-pending.png" alt="data-pending"/>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Sample data for the Bar Chart
            var barChartData = {
                labels: ["Canceled Orders", "Products", "Pending Orders", "Total Orders", "Complete Orders"],
                datasets: [{
                    label: 'Sample Bar Chart',
                    backgroundColor: 'rgb(3, 177, 252)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    data: [
                        {{ $totalOrders }},
                        {{ $totalProducts }},
                        {{ $pendingOrders }},
                        {{ $totalUsers }},
                        40 // Assuming this is placeholder for "Complete Orders", adjust as needed
                    ]
                }]
            };


            // Get the canvas element and initialize the Bar Chart
            var ctx = document.getElementById('myBarChart').getContext('2d');
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Entity'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Total Numbers'
                            }
                        }
                    },
                    // Set the bar thickness (adjust this value as needed)
                    barThickness: 50
                }
            });
        </script>


    @endsection
