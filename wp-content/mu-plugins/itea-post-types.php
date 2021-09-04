<?php

function itea_post_types() {

    register_post_type('slider', array(
        'supports' => array('title', 'thumbnail', 'excerpt'),//, 'editor'
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'Slider',
            'add_new_item' => 'Add New Slider',
            'edit_item' => 'Edit Slider',
            'all_items' => 'All Sliders',
            'singular_name' => 'Slider'
        ),
//        'has_archive' => true,
//        'has_archive' => 'topics/webinars',
//        'rewrite' => array('slug' => 'product', 'with_front' => true ),
//        'taxonomies'=> array( 'courses_category' ),
        'menu_icon' => 'dashicons-desktop'
    ));



}
add_action('init', 'itea_post_types');

function my_cptui_add_post_type_to_search($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_search()) {
        $query->set(
            'post_type',
            array('post', 'page', 'courses', 'courses_category', 'course')
        );
    }
}

//add_filter('pre_get_posts', 'my_cptui_add_post_type_to_search');
