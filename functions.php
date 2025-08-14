<?php

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');
    header("Access-Control-Allow-Headers:  Authorization");
    exit(0);
}

// composer autoload
require_once get_stylesheet_directory() . '/vendor/autoload.php';
include('parts/clean.php');
// make sure ACF Pro is loaded force activate if
// the plugin is not already activated


if (!class_exists('acf')) {
    // do not do that on POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return;
    }

    if (! function_exists('activate_plugin')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    activate_plugin('advanced-custom-fields-pro/acf.php');
    header('Location: ' . $_SERVER['REQUEST_URI']);
    die();
}



// add custom post type
add_action('init', function () {
    register_post_type('guide', [
        'public' => true,
        'label' => 'Guide',
        'supports' => ['title', 'editor', 'revisions', 'page-attributes'],
        'hierarchical' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    register_post_type('aide', [
        'public' => true,
        'label' => "Bulle d'aide",
        'supports' => ['title', 'editor', 'revisions'],
        'show_in_menu' => true,
        'menu_position' => 6,
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    register_post_type('aideKPI', [
        'public' => true,
        'label' => "Bulle d'aide dashboard KPI",
        'supports' => ['title', 'editor', 'revisions'],
        'show_in_menu' => true,
        'menu_position' => 6,
        'show_in_rest' => true,
        'has_archive' => true,
    ]);

    register_post_type('nouvelles', [
        'public' => true,
        'label' => "Nouvelles",
        'supports' => ['title', 'editor', 'revisions'],
        'show_in_menu' => true,
        'menu_position' => 4,
        'show_in_rest' => true,
        'has_archive' => true,
    ]);
});


add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    acf_add_options_page([
        'page_title' => 'Options',
        'menu_title' => 'Options',
        'menu_slug' => 'options',
        'capability' => 'edit_posts',
        'parent_slug' => 'nestedpages-guide',
        'redirect' => false,
    ]);

    acf_add_local_field_group(array(
        'key' => 'group_66fd6b8b23a13',
        'title' => 'Guide',
        'fields' => array(
            array(
                'key' => 'field_66fd6b8be660d',
                'label' => 'Accueil (fr)',
                'name' => 'accueil_fr',
                'aria-label' => '',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'guide',
                ),
                'post_status' => '',
                'taxonomy' => '',
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 0,
                'allow_in_bindings' => 0,
                'bidirectional' => 0,
                'ui' => 1,
                'bidirectional_target' => array(),
            ),
            array(
                'key' => 'field_66fd6bc5e660e',
                'label' => 'Accueil (en)',
                'name' => 'accueil_en',
                'aria-label' => '',
                'type' => 'post_object',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'guide',
                ),
                'post_status' => '',
                'taxonomy' => '',
                'return_format' => 'id',
                'multiple' => 0,
                'allow_null' => 0,
                'allow_in_bindings' => 0,
                'bidirectional' => 0,
                'ui' => 1,
                'bidirectional_target' => array(),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));



    acf_add_local_field_group(array(
        'key' => 'group_667b309dbba28',
        'title' => 'Bulle d\'aide',
        'fields' => array(
            array(
                'key' => 'field_667b309d9c9f4',
                'label' => 'Bulle d\'aide',
                'name' => 'aide',
                'type' => 'select',
                'choices' => json_decode(file_get_contents(get_stylesheet_directory() . '/elements.json'), true),
                'allow_null' => true,
            ),
            array(
                'key' => 'field_667b309d9c9sdf',
                'label' => 'Type d\'orthèses',
                'name' => 'type',
                'type' => 'checkbox',
                'choices' => [
                    "coquille3d" => "Coquille 3D",
                    "coquilleMoulee" => "Orthèse moulée (Thermo)",
                    "ortheseFraisee" => "Orthèse fraisée (EVA)",
                    "coquilleBaseTexturee" => "Coquille à base texturée",
                    "coquilleAccommodatrice" => "Coquille accommodatrice",

                ],
                'allow_null' => true,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'aide',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_667b309dbba28',
        'title' => 'Bulle d\'aide dashboard KPI',
        'fields' => array(
            array(
                'key' => 'field_667b309d9c9f4',
                'label' => 'Bulle d\'aide dashboard KPI',
                'name' => 'aideKPI',
                'type' => 'select',
                'choices' => json_decode(file_get_contents(get_stylesheet_directory() . '/elements.json'), true),
                'allow_null' => true,
            ),
            array(
                'key' => 'field_667b309d9c9sdf',
                'label' => 'Type d\'orthèses',
                'name' => 'type',
                'type' => 'checkbox',
                'choices' => [
                    "KPI Lead-time moyen" => "Temps moyen de traitement",
                    "KPI Ratio fill Rate On Time" => "Taux de complétion dans les délais",
                    "KPI Rejection Rate" => "Taux de rejet",
                    "KPI Design Ratio" => "Ratio de conception",
                    "KPI Printing Capacity Ratio" => "Ratio de capacité d'impression",
                    "KPI 3D Printer Uptime Ratio" => "Ratio de disponibilité des imprimantes 3D",
                    "KPI Finishing Ratio" => "Ratio de finitions",
                    "KPI Quality Ratio" => "Ratio de qualité",
                    "KPI SST" => "SST",
                    "KPI Average Revenue" => "Revenu moyen",
                    "KPI Operating Cycle" => "Cycle d'exploitation",
                ],
                'allow_null' => true,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'aideKPI',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_667c56ad41c3d',
        'title' => 'Nouvelles',
        'fields' => array(
            array(
                'key' => 'field_667c56ad54e89',
                'label' => 'Fin de la publication',
                'name' => 'fin',
                'type' => 'date_time_picker',
                'display_format' => 'Y-m-d H:i:s',
                'return_format' => 'Y-m-d H:i:s',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'nouvelles',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
});





add_filter(
    'rest_authentication_errors',
    function ($access) {
        if (!is_user_logged_in()) {
            return new WP_Error('rest_not_logged_in', __('You are not currently logged in.'), array('status' => 401));
        }
        //  return new WP_Error('rest_disabled', __('The WordPress REST API has been disabled.'), array('status' => rest_authorization_required_code()));
    }
);


function cleanHtml($raw)
{
    $dom = new DOMDocument();
    $raw = mb_convert_encoding($raw, 'UTF-8');
    $raw = mb_convert_encoding($raw, 'HTML-ENTITIES', 'UTF-8');
    $dom->loadHTML($raw, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $script = $dom->getElementsByTagName('script');
    $remove = [];
    foreach ($script as $item) {
        $remove[] = $item;
    }
    foreach ($remove as $item) {
        $item->parentNode->removeChild($item);
    }
    return $dom->saveHTML();
}
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('template_redirect', 'rest_output_link_header', 11);

add_action('init', function ($value) {

    header('Access-Control-Allow-Origin: *');


    return $value;
});
