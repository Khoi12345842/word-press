<?php
function sm_sinhvien_page() {
    global $wpdb;
    $table_sv = $wpdb->prefix . 'sinhvien';
    $table_lop = $wpdb->prefix . 'lop';

    // Xử lý xóa
    if (isset($_GET['delete'])) {
        $id = intval($_GET['delete']);
        $wpdb->delete($table_sv, ['id' => $id]);
        echo '<div class="notice notice-success"><p>Đã xoá sinh viên!</p></div>';
    }

    // Xử lý thêm mới
    if (isset($_POST['add_sv'])) {
        $wpdb->insert($table_sv, [
            'masv'     => sanitize_text_field($_POST['masv']),
            'hoten'    => sanitize_text_field($_POST['hoten']),
            'email'    => sanitize_email($_POST['email']),
            'ngaysinh' => sanitize_text_field($_POST['ngaysinh']),
            'malop'    => intval($_POST['malop']),
        ]);
        echo '<div class="notice notice-success"><p>Đã thêm sinh viên!</p></div>';
    }

    // Xử lý cập nhật
    if (isset($_POST['update_sv'])) {
        $wpdb->update($table_sv, [
            'masv'     => sanitize_text_field($_POST['masv']),
            'hoten'    => sanitize_text_field($_POST['hoten']),
            'email'    => sanitize_email($_POST['email']),
            'ngaysinh' => sanitize_text_field($_POST['ngaysinh']),
            'malop'    => intval($_POST['malop']),
        ], ['id' => intval($_POST['id'])]);
        echo '<div class="notice notice-success"><p>Đã cập nhật sinh viên!</p></div>';
    }

    // Lấy danh sách lớp
    $ds_lop = $wpdb->get_results("SELECT * FROM $table_lop");

    // Nếu đang sửa
    $editing = false;
    if (isset($_GET['edit'])) {
        $editing = true;
        $edit_id = intval($_GET['edit']);
        $sv = $wpdb->get_row("SELECT * FROM $table_sv WHERE id = $edit_id");
    }

    echo '<div class="wrap"><h2>' . ($editing ? 'Sửa sinh viên' : 'Thêm sinh viên mới') . '</h2>
    <form method="post">
        ' . ($editing ? '<input type="hidden" name="id" value="' . esc_attr($sv->id) . '">' : '') . '
        <table class="form-table">
            <tr><th><label>Mã SV</label></th><td><input required type="text" name="masv" value="' . ($editing ? esc_attr($sv->masv) : '') . '"></td></tr>
            <tr><th><label>Họ tên</label></th><td><input required type="text" name="hoten" value="' . ($editing ? esc_attr($sv->hoten) : '') . '"></td></tr>
            <tr><th><label>Email</label></th><td><input type="email" name="email" value="' . ($editing ? esc_attr($sv->email) : '') . '"></td></tr>
            <tr><th><label>Ngày sinh</label></th><td><input type="date" name="ngaysinh" value="' . ($editing ? esc_attr($sv->ngaysinh) : '') . '"></td></tr>
            <tr><th><label>Lớp</label></th><td>
                <select name="malop">';
                    foreach ($ds_lop as $lop) {
                        $selected = ($editing && $lop->id == $sv->malop) ? 'selected' : '';
                        echo "<option value='$lop->id' $selected>$lop->tenlop</option>";
                    }
        echo '</select></td></tr>
        </table>
        <p><input type="submit" name="' . ($editing ? 'update_sv' : 'add_sv') . '" class="button button-primary" value="' . ($editing ? 'Cập nhật' : 'Thêm mới') . '"></p>
    </form></div>';

    // Danh sách sinh viên
    $sinhvien = $wpdb->get_results("SELECT sv.*, l.tenlop FROM $table_sv sv LEFT JOIN $table_lop l ON sv.malop = l.id ORDER BY sv.id DESC");

    echo '<hr><h2>Danh sách sinh viên</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Mã SV</th><th>Họ tên</th><th>Email</th><th>Ngày sinh</th><th>Lớp</th><th>Hành động</th></tr></thead><tbody>';
    foreach ($sinhvien as $sv) {
        echo "<tr>
            <td>$sv->id</td>
            <td>$sv->masv</td>
            <td>$sv->hoten</td>
            <td>$sv->email</td>
            <td>$sv->ngaysinh</td>
            <td>$sv->tenlop</td>
            <td>
                <a href='?page=sm_sinhvien&edit=$sv->id'>Sửa</a> |
                <a href='?page=sm_sinhvien&delete=$sv->id' onclick='return confirm(\"Bạn có chắc chắn muốn xoá?\")'>Xoá</a>
            </td>
        </tr>";
    }
    echo '</tbody></table>';
}
