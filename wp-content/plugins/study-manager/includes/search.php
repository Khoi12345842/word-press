<?php
function sm_search_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'sinhvien';
    $results = [];

    if (isset($_POST['search'])) {
        $key = '%' . esc_sql($_POST['keyword']) . '%';
        $results = $wpdb->get_results(
            $wpdb->prepare("SELECT * FROM $table WHERE masv LIKE %s OR hoten LIKE %s", $key, $key)
        );
    }

    echo '<div class="wrap"><h2>Tìm kiếm sinh viên</h2>
    <form method="post">
        <input type="text" name="keyword" placeholder="Nhập mã SV hoặc họ tên" style="width: 300px;" />
        <input type="submit" name="search" class="button" value="Tìm kiếm" />
    </form>';

    if ($results) {
        echo '<hr><table class="wp-list-table widefat fixed striped">
            <thead><tr><th>ID</th><th>Mã SV</th><th>Họ tên</th><th>Email</th><th>Ngày sinh</th></tr></thead><tbody>';
        foreach ($results as $r) {
            echo "<tr>
                <td>$r->id</td>
                <td>$r->masv</td>
                <td>$r->hoten</td>
                <td>$r->email</td>
                <td>$r->ngaysinh</td>
            </tr>";
        }
        echo '</tbody></table>';
    } elseif (isset($_POST['search'])) {
        echo '<p>Không tìm thấy kết quả.</p>';
    }

    echo '</div>';
}
