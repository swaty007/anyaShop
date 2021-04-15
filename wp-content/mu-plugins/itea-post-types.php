<?php

function itea_post_types() {

    register_post_type('courses', array(
        'supports' => array('title', 'thumbnail', 'excerpt'),//, 'editor'
        'public' => true,
        'publicly_queryable' => true,
        'labels' => array(
            'name' => 'Курсы',
            'add_new_item' => 'Add New Course',
            'edit_item' => 'Edit Course',
            'all_items' => 'All Courses',
            'singular_name' => 'Course'
        ),
        'rewrite' => [
            'slug'                  => 'course', ///%courses_category%
            'with_front'            => false,
//            'pages'                 => true,
//            'feeds'                 => true,
        ],
//        'has_archive' => true,
        'has_archive' => 'topics/courses',
//        'rewrite' => array('slug' => 'product', 'with_front' => true ),
        'taxonomies'=> array( 'courses_category' ),
        'menu_icon' => 'dashicons-cart'
    ));
    register_post_type('professions', array(
        'supports' => array('title', 'thumbnail', 'excerpt'),//, 'editor'
        'public' => true,
        'publicly_queryable' => true,
        'labels' => array(
            'name' => 'Профессии',
            'add_new_item' => 'Add Профессию',
            'edit_item' => 'Edit Профессию',
            'all_items' => 'All Профессии',
            'singular_name' => 'Профессия'
        ),
//        'rewrite' => [
//            'slug'                  => 'courses/%courses_category%',
//            'with_front'            => false,
//            'pages'                 => true,
//            'feeds'                 => true,
//        ],
//        'has_archive' => true,
        'has_archive' => 'topics/professions',
        'taxonomies'=> array( 'courses_category' ),
        'menu_icon' => 'dashicons-businessman'
    ));

    register_post_type('webinars', array(
        'supports' => array('title', 'thumbnail', 'excerpt'),//, 'editor'
        'public' => true,
        'publicly_queryable' => true,
        'labels' => array(
            'name' => 'Webinars',
            'add_new_item' => 'Add New Webinars',
            'edit_item' => 'Edit Webinar',
            'all_items' => 'All Webinars',
            'singular_name' => 'Webinar'
        ),
//        'has_archive' => true,
        'has_archive' => 'topics/webinars',
//        'rewrite' => array('slug' => 'product', 'with_front' => true ),
        'taxonomies'=> array( 'courses_category' ),
        'menu_icon' => 'dashicons-desktop'
    ));

    register_post_type('partners', array(
        'supports' => array('title', 'thumbnail', 'excerpt'),
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'Partners',
            'add_new_item' => 'Add New Partner',
            'edit_item' => 'Edit Partner',
            'all_items' => 'All Partners',
            'singular_name' => 'Partner'
        ),
        'menu_icon' => 'dashicons-format-image'
    ));

    register_post_type('reviews', array(
        'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'Отзывы Пользователей',
            'add_new_item' => 'Add Review',
            'edit_item' => 'Edit Review',
            'all_items' => 'All Reviews',
            'singular_name' => 'Review'
        ),
        'menu_icon' => 'dashicons-admin-comments'
    ));

    register_post_type('faq', array(
        'supports' => array('title', 'excerpt'),
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'FAQ',
            'add_new_item' => 'Add FAQ',
            'edit_item' => 'Edit FAQ',
            'all_items' => 'All FAQs',
            'singular_name' => 'FAQ'
        ),
        'menu_icon' => 'dashicons-list-view'
    ));

    register_post_type('teachers', array(
        'supports' => array('title', 'thumbnail', 'excerpt', 'editor'),
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'Преподаватели',
            'add_new_item' => 'Add Teacher',
            'edit_item' => 'Edit Teacher',
            'all_items' => 'All Teachers',
            'singular_name' => 'Teacher'
        ),
        'menu_icon' => 'dashicons-admin-users'
    ));

    register_post_type('portfolio', array(
        'supports' => array('title', 'thumbnail', 'excerpt'), //, 'editor'
        'public' => true,
        'publicly_queryable' => false,
        'labels' => array(
            'name' => 'Портфолио',
            'add_new_item' => 'Add Portfolio',
            'edit_item' => 'Edit Portfolio',
            'all_items' => 'All Portfolios',
            'singular_name' => 'Портфолио'
        ),
        'menu_icon' => 'dashicons-buddicons-groups'
    ));



//    add_rewrite_tag( "%book%", '([^/]+)', "post_type=$post_type&name=" );

    $permastruct = "kniga/%book%"; // наша структура ЧПУ

    $args = array(
        'with_front'  => true,
        'paged'       => true,
        'ep_mask'     => EP_NONE,
        'feed'        => false,
        'forcomments' => false,
        'walk_dirs'   => false,
        'endpoints'   => false,
    );

//    add_permastruct( $post_type, $permastruct, $args );
}
//add_action('init', 'itea_post_types');

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
