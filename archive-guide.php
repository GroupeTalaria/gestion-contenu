<?php
get_header();


echo json_encode([
    'home_fr' => get_permalink( get_field('accueil_fr', 'options'), false ),
    'home_en' => get_permalink( get_field('accueil_en', 'options'), false ),

]);
die();
