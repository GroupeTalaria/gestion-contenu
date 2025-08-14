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
        "post_type" => "aideKPI",
        'lang' => $value,
        "posts_per_page" => -1,
    ]);

    $posts[$key] = [
        'lang' => $value,
        'posts' => array_map(function ($post) {
            return [
                'title' => $post->post_title,
                'key' => get_field('aideKPI', $post->ID),
                'types' => get_field('types', $post->ID) ?: [],
                'url' => get_permalink($post->ID),
            ];
        }, $posts_perlang),
    ];
}



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
echo json_encode($posts);
die();
