<?php
function sm_khoa_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'khoa';

    // Xoá
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
        echo '<div class="notice notice-success"><p>Đã xoá khoa!</p></div>';
    }

    // Thêm
    if (isset($_POST['add_khoa'])) {
        $wpdb->insert($table, [
            'tenkhoa' => sanitize_text_field($_POST['tenkhoa']),
        ]);
        echo '<div class="notice notice-success"><p>Đã thêm khoa!</p></div>';
    }

    echo '<div class="wrap"><h2>Thêm khoa mới</h2>
    <form method="post">
        <table class="form-table">
            <tr><th>Tên khoa</th><td><input type="text" name="tenkhoa" required></td></tr>
        </table>
        <p><input type="submit" name="add_khoa" class="button button-primary" value="Thêm khoa"></p>
    </form>';

    $khoas = $wpdb->get_results("SELECT * FROM $table");
    echo '<hr><h2>Danh sách khoa</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Tên khoa</th><th>Hành động</th></tr></thead><tbody>';
    foreach ($khoas as $k) {
        echo "<tr>
            <td>$k->id</td>
            <td>$k->tenkhoa</td>
            <td><a href='?page=sm_khoa&delete=$k->id' onclick='return confirm(\"Xoá khoa này?\")'>Xoá</a></td>
        </tr>";
    }
    echo '</tbody></table>';
}
