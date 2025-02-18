<style>
    .profile-header {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #ddd;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .profile-header img {
        border-radius: 50%;
        margin-right: 20px;
        width: 120px;
        height: 120px;
        border: 4px solid #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-header h1 {
        margin: 0;
        font-size: 2.5em;
        color: #007bff;
    }

    .profile-details {
        list-style-type: none;
        padding: 0;
    }

    .profile-details li {
        padding: 15px 0;
        border-bottom: 1px solid #ddd;
        font-size: 1.1em;
    }

    .profile-details li:last-child {
        border-bottom: none;
    }

    .profile-details li strong {
        color: #007bff;
        font-weight: bold;
        margin-right: 10px;
    }

    .profile-details li span {
        color: #555;
    }

    .profile-details li:hover {
        background-color: #f9f9f9;
        transition: background-color 0.3s ease;
    }

    @media (max-width: 600px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .profile-header img {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .profile-header h1 {
            font-size: 2em;
        }

        .profile-details li {
            font-size: 1em;
        }
    }
</style>

<div class="container">
    <div class="profile-header">
        <img src="https://cdn-icons-png.flaticon.com/512/9815/9815472.png" alt="avarta">
        <h1><?php echo htmlspecialchars($user['name']); ?></h1>
    </div>
    <ul class="profile-details">
        <li><strong>Email:</strong> <span><?php echo htmlspecialchars($user['email']); ?></span></li>
        <li><strong>Số điện thoại:</strong> <span><?php echo htmlspecialchars($user['phone']); ?></span></li>
        <li><strong>Quyền hạn:</strong> <span><?php echo htmlspecialchars($user['role']); ?></span></li>
        <li><strong>Loại tài khoản:</strong> <span><?php echo htmlspecialchars($user['auth_provider']); ?></span></li>
    </ul>
    <a href="/" class="btn btn-danger">Quay lại trang chủ</a>
</div>