<?php
function sm_lop_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'lop';
    $table_khoa = $wpdb->prefix . 'khoa';

    // Xoá
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
        echo '<div class="notice notice-success"><p>Đã xoá lớp!</p></div>';
    }

    // Thêm
    if (isset($_POST['add_lop'])) {
        $wpdb->insert($table, [
            'tenlop' => sanitize_text_field($_POST['tenlop']),
            'makhoa' => intval($_POST['makhoa']),
        ]);
        echo '<div class="notice notice-success"><p>Đã thêm lớp!</p></div>';
    }

    // Lấy danh sách khoa
    $khoas = $wpdb->get_results("SELECT * FROM $table_khoa");

    echo '<div class="wrap"><h2>Thêm lớp mới</h2>
    <form method="post">
        <table class="form-table">
            <tr><th>Tên lớp</th><td><input type="text" name="tenlop" required></td></tr>
            <tr><th>Khoa</th><td><select name="makhoa">';
                foreach ($khoas as $k) {
                    echo "<option value='$k->id'>$k->tenkhoa</option>";
                }
    echo '</select></td></tr>
        </table>
        <p><input type="submit" name="add_lop" class="button button-primary" value="Thêm lớp"></p>
    </form>';

    $lops = $wpdb->get_results("SELECT l.*, k.tenkhoa FROM $table l LEFT JOIN $table_khoa k ON l.makhoa = k.id");
    echo '<hr><h2>Danh sách lớp</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Tên lớp</th><th>Khoa</th><th>Hành động</th></tr></thead><tbody>';
    foreach ($lops as $l) {
        echo "<tr>
            <td>$l->id</td>
            <td>$l->tenlop</td>
            <td>$l->tenkhoa</td>
            <td><a href='?page=sm_lop&delete=$l->id' onclick='return confirm(\"Xoá lớp này?\")'>Xoá</a></td>
        </tr>";
    }
    echo '</tbody></table>';
}
