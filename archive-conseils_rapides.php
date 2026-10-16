<?php
get_header();
$posts = [];
if (function_exists('pll_languages_list')) {
    $lang =     pll_languages_list();
} else {
    $lang = ['fr'];
}
foreach ($lang as $key => $value) {
    $posts_perlang = get_posts([
        "post_type" => "conseils_rapides",
        'lang' => $value,
        "posts_per_page" => -1,
        "orderby" => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    $posts[$key] = [
        'lang' => $value,
        'posts' => array_map(function ($post) {
            return [
                "id" => $post->ID,
                "ordre" => $post->menu_order,
                "titre" => $post->post_title,
                "texte" => get_field("texte", $post->ID) ?: "",
            ];
        }, $posts_perlang),
    ];
}



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($posts);
die();
