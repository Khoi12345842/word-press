<?php
// Hàm tạo bảng chung
function sm_create_all_tables() {
    sm_create_table_sinhvien();
    sm_create_table_user();
    sm_create_table_lop();
    sm_create_table_khoa();
}

// Hàm tạo bảng sinh viên
function sm_create_table_sinhvien() {
    global $wpdb;
    $table = $wpdb->prefix . 'sinhvien';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id INT NOT NULL AUTO_INCREMENT,
        masv VARCHAR(20) NOT NULL,
        hoten VARCHAR(100) NOT NULL,
        ngaysinh DATE,
        email VARCHAR(100),
        malop INT,
        PRIMARY KEY (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Hàm tạo bảng user
function sm_create_table_user() {
    global $wpdb;
    $table = $wpdb->prefix . 'nguoidung';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(20),
        PRIMARY KEY (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Hàm tạo bảng lớp
function sm_create_table_lop() {
    global $wpdb;
    $table = $wpdb->prefix . 'lop';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id INT NOT NULL AUTO_INCREMENT,
        tenlop VARCHAR(100) NOT NULL,
        makhoa INT,
        PRIMARY KEY (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Hàm tạo bảng khoa
function sm_create_table_khoa() {
    global $wpdb;
    $table = $wpdb->prefix . 'khoa';
    $charset = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table (
        id INT NOT NULL AUTO_INCREMENT,
        tenkhoa VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    ) $charset;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
