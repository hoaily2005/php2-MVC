<?php
function checkLogin() {
    if (!isset($_SESSION['users'])) {
        header("Location: /login");
        exit;
    }
    return true;
}

function checkAdmin() {
    checkLogin();
    if (!isset($_SESSION['users']['role']) || $_SESSION['users']['role'] !== 'admin') {
        header("Location: /unauthorized");
        exit;
    }
    return true;
}

function checkUserOrAdmin() {
    checkLogin();
    $role = $_SESSION['users']['role'];
    if ($role !== 'user' && $role !== 'admin') {
        header("Location: /");
        exit;
    }
    return true;
}

function logRequest() {
    error_log("Request received at " . date('Y-m-d H:i:s'));
    return true;
}