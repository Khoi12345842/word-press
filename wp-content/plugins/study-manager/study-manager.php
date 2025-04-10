<?php
/*
Plugin Name: Study Manager
Description: Plugin quan ly sinh vien day du chuc nang: sinh vien, lop, khoa, nguoi dung va tim kiem.
Version: 1.0
Author: Ban
*/

defined('ABSPATH') or die('Khong duoc truy cap truc tiep');

// Load cac file chuc nang
include_once plugin_dir_path(__FILE__) . 'includes/functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/sinhvien.php';
include_once plugin_dir_path(__FILE__) . 'includes/user.php';
include_once plugin_dir_path(__FILE__) . 'includes/lop.php';
include_once plugin_dir_path(__FILE__) . 'includes/khoa.php';
include_once plugin_dir_path(__FILE__) . 'includes/search.php';

// Tao menu admin
add_action('admin_menu', 'study_manager_admin_menu');
function study_manager_admin_menu() {
    add_menu_page('QLSV', 'QLSV', 'manage_options', 'study-manager', 'sm_sinhvien_page', 'dashicons-welcome-learn-more');
    add_submenu_page('study-manager', 'Sinh vien', 'Sinh vien', 'manage_options', 'study-manager', 'sm_sinhvien_page');
    add_submenu_page('study-manager', 'Lop', 'Lop', 'manage_options', 'study-manager-lop', 'sm_lop_page');
    add_submenu_page('study-manager', 'Khoa', 'Khoa', 'manage_options', 'study-manager-khoa', 'sm_khoa_page');
    add_submenu_page('study-manager', 'Nguoi dung', 'Nguoi dung', 'manage_options', 'study-manager-user', 'sm_user_page');
    add_submenu_page('study-manager', 'Tim kiem', 'Tim kiem', 'manage_options', 'study-manager-search', 'sm_search_page');
}

// Tao csdl khi kich hoat plugin
register_activation_hook(__FILE__, 'study_manager_create_tables');
function study_manager_create_tables() {
    require_once plugin_dir_path(__FILE__) . 'includes/functions.php';
    sm_create_all_tables();
}
