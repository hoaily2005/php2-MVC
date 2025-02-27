@extends('layouts.admin')
@section('content')
    <div class="p-3 mb-4 rounded-3" style="background-color: #fff;">
        <h2>Bảng điều khiển</h2>
    </div>
    <div class="p-3 mb-4 rounded-3" style="background-color: #fff;">

        <div class="row mb-4 mt-3">
            <!-- Số người ghé thăm -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">12</h4>
                            <p class="mb-0">Người Dùng</p>
                        </div>
                        <i class="fa-solid fa-people-group fa-2x"></i>
                    </div>
                </div>
            </div>

            <!-- Tỷ lệ thoát trang -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">{{ $successfulOrders['total_successful_orders'] }}</h4>
                            <p class="mb-0">Đơn hàng thành công</p>
                        </div>
                        <i class="fa-solid fa-share fa-2x"></i>
                    </div>
                </div>
            </div>

            <!-- Số lượt xem trang -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">{{ $failedOrders['total_failed_orders'] }}</h4>
                            <p class="mb-0">Đơn hàng thất bại</p>
                        </div>
                        <i class="fa-solid fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>

            <!-- Tỷ lệ tăng trưởng -->
            <div class="col-12 col-md-3 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="fw-bold mb-0">{{ number_format($successfulOrders['total_revenue'], 0, ',', '.') }} VND</h4>
                            <p class="mb-0">Doanh Thu Ngày Hôm Nay</p>
                        </div>
                        <i class="fa-solid fa-chart-bar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Best Selling Products -->
        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm bán chạy nhất</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bestSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ $product['total_sold'] }}</td>
                                        <td>{{ number_format($product['revenue'], 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Least Selling Products -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm ít người mua nhất</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng bán</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leastSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ $product['total_sold'] }}</td>
                                        <td>{{ number_format($product['revenue'], 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Doanh thu tuần</h5>
                        <canvas id="earningsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Doanh thu theo tháng</h5>
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var ctx1 = document.getElementById('earningsChart').getContext('2d');
        var earningsChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: @json($months), 
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: @json($earnings), 
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        var ctx2 = document.getElementById('monthlyRevenueChart').getContext('2d');
        var monthlyRevenueChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($months), 
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: @json($earnings), 
                    backgroundColor: 'blue'
                }]
            }
        });
    </script>
@endsection
