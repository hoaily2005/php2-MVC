@extends('layouts.master')
@section('content')
    <div class="success-page">
        <div class="container text-center">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="mt-4">Thanh toán thành công!</h1>
            <p class="mt-3">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng sớm nhất.</p>
            <p>Mã đơn hàng của bạn sẽ được gửi qua email hoặc số điện thoại đã đăng ký.</p>
            <div class="mt-3">
                <a href="/" class="btn btn-primary"><i class="fa-solid fa-house"></i> Quay lại Trang Chủ</a>
                <a href="/orders" class="btn btn-danger"><i class="fa-solid fa-truck-fast"></i> Xem Đơn Hàng</a>
            </div>
        </div>
    </div>

    <style>
        .success-page {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            background-color: #f8f9fa;
        }

        .success-icon {
            font-size: 100px;
            color: #28a745;
        }

        .buttons .btn {
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
@endsection
