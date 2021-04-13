<?php
require get_theme_file_path('/inc/SocialWidget.php');

function sidebar_widgets_init() {
    register_sidebar( array(
        'name'          => 'Social widget',
        'id'            => 'social_widget',
        'before_widget' => '<ul class="footer__menu footer__menu--social">',
        'after_widget'  => '</ul>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'sidebar_widgets_init' );

// register widgets
function register_widgets() {
    register_widget( 'SocialWidget' );
}
add_action( 'widgets_init', 'register_widgets' );
