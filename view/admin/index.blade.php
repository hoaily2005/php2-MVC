@extends('layouts.admin')
@section('content')
<style>
    /* Cải thiện độ rộng và layout cho phần nội dung chính */
    .main-content {
        margin-left: 270px;  /* Tăng khoảng cách để tránh bị che bởi sidebar */
        margin-top: 60px;
        padding: 20px;
        background-color: #f8f9fa;  /* Màu nền nhẹ cho phần nội dung */
        min-height: 100vh;  /* Đảm bảo chiều cao đủ */
    }

    .card {
        border-radius: 10px;  /* Làm tròn góc các thẻ card */
        border: none;  /* Bỏ viền mặc định */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  /* Thêm bóng nhẹ cho các thẻ card */
        margin-bottom: 30px;
    }

    .card-header {
        background-color: #343a40;
        color: white;
        padding: 15px;
        font-size: 1.25rem;
        border-radius: 10px 10px 0 0;
    }

    .card-body {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 0 0 10px 10px;
    }

    .card-title {
        margin-bottom: 0;
    }

    /* Cải tiến biểu đồ */
    canvas {
        max-width: 100%;
        height: 350px;  /* Đảm bảo chiều cao vừa phải cho các biểu đồ */
    }

    /* Điều chỉnh độ rộng của các card theo màn hình */
    .card {
        flex: 1 1 30%; /* Cho phép các card có thể co giãn */
        margin: 10px;
    }

    /* Điều chỉnh bố cục cho các card */
    .d-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    @media (max-width: 1200px) {
        .main-content {
            margin-left: 220px;
        }

        .card {
            flex: 1 1 45%;  /* Các thẻ card sẽ chiếm 45% độ rộng màn hình */
        }
    }

    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
        }

        .card {
            flex: 1 1 100%;  /* Các thẻ card chiếm toàn bộ độ rộng */
        }
    }
</style>

<main class="main-contentz">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
    </div>

    <!-- Biểu đồ Tổng doanh thu, Số đơn thành công, Đơn hủy, Đơn chưa xử lý -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Tổng Doanh Thu và Thống Kê Đơn Hàng</h5>
        </div>
        <div class="card-body">
            <canvas id="orderStatsChart"></canvas>
        </div>
    </div>

    <!-- Biểu đồ Sản phẩm bán chạy và Sản phẩm ít người mua -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Sản Phẩm Bán Chạy vs Sản Phẩm Ít Người Mua</h5>
        </div>
        <div class="card-body">
            <canvas id="productStatsChart"></canvas>
        </div>
    </div>

    <!-- Biểu đồ Số Người Dùng -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Số Người Dùng</h5>
        </div>
        <div class="card-body">
            <canvas id="userStatsChart"></canvas>
        </div>
    </div>

</main>

<script>
    // Biểu đồ Tổng Doanh Thu và Thống Kê Đơn Hàng
    var ctx1 = document.getElementById('orderStatsChart').getContext('2d');
    var orderStatsChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Doanh Thu', 'Đơn Thành Công', 'Đơn Hủy', 'Đơn Chưa Xử Lý'],
            datasets: [{
                label: 'Thống Kê Đơn Hàng',
                data: [500000, 120, 30, 50], // Dữ liệu mẫu, bạn cần thay đổi theo dữ liệu thực tế
                backgroundColor: ['#28a745', '#007bff', '#dc3545', '#ffc107'],
                borderColor: ['#218838', '#0069d9', '#c82333', '#e0a800'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw.toLocaleString(); // Hiển thị dữ liệu dưới dạng số
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ Sản Phẩm Bán Chạy và Sản Phẩm Ít Người Mua
    var ctx2 = document.getElementById('productStatsChart').getContext('2d');
    var productStatsChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Sản Phẩm Bán Chạy', 'Sản Phẩm Ít Người Mua'],
            datasets: [{
                label: 'Sản Phẩm',
                data: [75, 25], // Dữ liệu mẫu, bạn cần thay đổi theo dữ liệu thực tế
                backgroundColor: ['#007bff', '#dc3545'],
                borderColor: ['#0069d9', '#c82333'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + '%'; // Hiển thị tỷ lệ phần trăm
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ Số Người Dùng
    var ctx3 = document.getElementById('userStatsChart').getContext('2d');
    var userStatsChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Các tháng trong năm
            datasets: [{
                label: 'Số Người Dùng',
                data: [50, 75, 100, 125, 150, 200], // Dữ liệu mẫu, bạn cần thay đổi theo dữ liệu thực tế
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw.toLocaleString(); // Hiển thị dữ liệu dưới dạng số
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
