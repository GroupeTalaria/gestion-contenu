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
        "post_type" => "nouvelles",
        'lang' => $value,

    ]);

    $posts[$key] = [
        'lang' => $value,
        'posts' => array_map(function ($post) {
            return [
                "id" => $post->ID,
                "date_publication" => $post->post_date,
                "date_retrait" => get_field("fin", $post->ID) ?: null,
                "titre" => $post->post_title,
                "message" => cleanHtml($post->post_content),
                "icone" => ""
            ];
        }, $posts_perlang),
    ];
}



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($posts);
die();
