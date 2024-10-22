<?php

// Remove Dashboad and redirect to home 
add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_node('users');
    $wp_admin_bar->remove_node('new-content');
    $wp_admin_bar->remove_node('comments');
    $wp_admin_bar->remove_node('customize');
    $wp_admin_bar->remove_node('themes');
    $wp_admin_bar->remove_node('widgets');
    $wp_admin_bar->remove_node('menus');
    $wp_admin_bar->remove_node('customize');
    $wp_admin_bar->remove_node('updates');
    $wp_admin_bar->remove_node('my-account');

    // remove user

});

// Remove Screen Options and help button
add_filter('screen_options_show_screen', '__return_false');
add_filter('contextual_help', '__return_false');



// Clean Backend Menu
add_action('admin_menu', function () {
    remove_menu_page('index.php');
    remove_menu_page('users.php');
    remove_menu_page('edit.php?post_type=page');
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
    remove_menu_page('themes.php');
    remove_menu_page('tools.php');
    remove_menu_page('options-general.php');
    remove_menu_page('edit.php?post_type=acf-field-group');


    remove_menu_page('users.php');
    remove_menu_page('plugins.php');
    remove_menu_page('mlang');
}, 999);

// Redirect to home wp-admin root to pages
add_action('admin_init', function () {
    if (preg_match('/wp-admin\/admin-ajax.php?$/', $_SERVER['REQUEST_URI'])) {
        return;
    }
    if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false) {
        wp_redirect(admin_url('admin.php?page=nestedpages-aide'));
        exit;
    }
    // if request ends with wp-admin\/? redirect to home
    if (preg_match('/wp-admin\/?$/', $_SERVER['REQUEST_URI'])) {
        wp_redirect(admin_url('admin.php?page=nestedpages-aide'));
        exit;
    }
});


add_action('admin_init', function () {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Disables all plugins
add_action('admin_init', function () {

    update_option('active_plugins', [
        "polylang/polylang.php",
        'wp-nested-pages/nestedpages.php', 
        'advanced-custom-fields-pro/acf.php',
        'duplicate-content-addon-for-polylang/duplicate-content-addon-for-polylang.php',
    ]);
    update_option('polylang', [
        "browser" => 0,
        "rewrite" => 1,
        "hide_default" => 1,
        "force_lang" => 1,
        "redirect_lang" => 0,
        "media_support" => 0,
        "uninstall" => 0,
        "sync" => [],
        "post_types" => [
            "guide",
            "aide",
            "nouvelles"
        ],
        "taxonomies" => [],
        "domains" => [],
        "version" => "3.6.3",
        "first_activation" => 1719349610,
        "default_lang" => "fr"
    ]);
});

// Remove all users where Id is not 1
add_action('admin_init', function () {
    $user_id_to_keep = 1;
    $all_users = get_users(array('fields' => 'ID'));
    foreach ($all_users as $user_id) {
        if ($user_id == $user_id_to_keep) {
            continue;
        }
        wp_delete_user($user_id);
    }
});
