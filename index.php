<?php


if (isset($_GET['key']) && defined('APIDB')) {
    $con = mysqli_connect(APIDB['DB_HOST'], APIDB['DB_USERNAME'], APIDB['DB_PASSWORD'], APIDB['DB_DATABASE']);
    if (!$con) {
        die();
    }
    $stmt = $con->query("DELETE FROM `unique_keys` WHERE `created_at` < UTC_TIMESTAMP() - INTERVAL 1 MINUTE");

    // Make a prepared statement
    $stmt = $con->prepare("SELECT * FROM `unique_keys` WHERE `id` = ?");
    $stmt->bind_param('s', $_GET['key']);
    $stmt->execute();

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $user_id = 1;
        $user = get_user_by('id', $user_id);
        if ($user) {
            wp_set_current_user($user_id, $user->user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user->user_login, $user);
            break;
        }
    }
    $stmt = $con->prepare("DELETE FROM `unique_keys` WHERE `id` = ?");
    $stmt->bind_param('s', $_GET['key']);
    $stmt->execute();
}



if (is_user_logged_in()) {
    // redirect to admin
    flush_rewrite_rules();
    wp_redirect(admin_url());
    exit;
}
