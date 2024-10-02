<?php
get_header();
the_post();
global $post;
header('Content-Type: application/json');
echo json_encode([
    'title' => $post->post_title,
    'content' => apply_filters('the_content', $post->post_content),

]);
die();
