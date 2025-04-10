<?php
function sm_user_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'nguoidung';

    // Xoá
    if (isset($_GET['delete'])) {
        $wpdb->delete($table, ['id' => intval($_GET['delete'])]);
        echo '<div class="notice notice-success"><p>Đã xoá người dùng!</p></div>';
    }

    // Thêm
    if (isset($_POST['add_user'])) {
        $wpdb->insert($table, [
            'username' => sanitize_text_field($_POST['username']),
            'password' => wp_hash_password($_POST['password']),
            'role'     => sanitize_text_field($_POST['role']),
        ]);
        echo '<div class="notice notice-success"><p>Đã thêm người dùng!</p></div>';
    }

    echo '<div class="wrap"><h2>Thêm người dùng mới</h2>
    <form method="post">
        <table class="form-table">
            <tr><th>Tên đăng nhập</th><td><input type="text" name="username" required></td></tr>
            <tr><th>Mật khẩu</th><td><input type="password" name="password" required></td></tr>
            <tr><th>Vai trò</th><td>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </td></tr>
        </table>
        <p><input type="submit" name="add_user" class="button button-primary" value="Thêm người dùng"></p>
    </form>';

    $users = $wpdb->get_results("SELECT * FROM $table");
    echo '<hr><h2>Danh sách người dùng</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Tên đăng nhập</th><th>Vai trò</th><th>Hành động</th></tr></thead><tbody>';
    foreach ($users as $u) {
        echo "<tr>
            <td>$u->id</td>
            <td>$u->username</td>
            <td>$u->role</td>
            <td><a href='?page=sm_user&delete=$u->id' onclick='return confirm(\"Bạn có chắc xoá người dùng này?\")'>Xoá</a></td>
        </tr>";
    }
    echo '</tbody></table>';
}
