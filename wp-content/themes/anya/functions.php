<?php

//strings for wp-config.php
//define('MAIN_SITE_URL', 'https://jungo-master.demo.gns-it.com');
//define('API_URL', 'https://api.jungo-dev.demo.gns-it.com/api/v1');

require_once get_theme_file_path('/inc/widgets.php');
require_once get_theme_file_path('/inc/polylang-slug.php');
require_once get_theme_file_path('/inc/importXml.php');
require_once get_theme_file_path('/inc/parse-routes.php');


if (!function_exists('itea_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function itea_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on target, use a find and replace
         * to change 'target' to the name of your theme in all the template files.
         */
        //load_theme_textdomain( 'target', get_template_directory() . '/languages' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_post_type_support('page', 'excerpt');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-header' => esc_html__('Header', 'itea'),
        ));
        register_nav_menus(array(
            'menu-footer-navigation' => esc_html__('Footer Navigation', 'itea'),
        ));
        register_nav_menus(array(
            'menu-footer-catalog' => esc_html__('Footer Catalog', 'itea'),
        ));
//        register_nav_menus(array(
//            'menu-support' => esc_html__('Client Support', 'itea'),
//        ));


    }
endif;
add_action('after_setup_theme', 'itea_setup');


function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

function your_theme_customizer_setting($wp_customize)
{
// add a setting
    $wp_customize->add_setting('your_theme_light_logo');
// Add a control to upload the hover logo
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'your_theme_light_logo', array(
        'label' => 'Upload Light Logo',
        'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
        'settings' => 'your_theme_light_logo',
        'priority' => 8 // show it just below the custom-logo
    )));
}

//add_action('customize_register', 'your_theme_customizer_setting');


function itea_files()
{
    // $catvar = get_the_category( );
    // if (!in_category('tilda')){
    wp_enqueue_script('main-itea-bundled-js', get_template_directory_uri() . '/js/scripts-bundled.js', '', '', true);
//        wp_enqueue_script('fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', '', '', true);
//        wp_enqueue_script('scroll', get_template_directory_uri() . '/js/scroll.js', '', '', true);
//        wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js', '', '', true);
//        wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', '', '', true);
//        wp_enqueue_script('modal-js', get_template_directory_uri() . '/js/modalDiscount.js', '', '', true);
    wp_enqueue_style('material_icons', '//fonts.googleapis.com/icon?family=Material+Icons');
    wp_enqueue_style('tiny_slider', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.3/tiny-slider.css');
    wp_enqueue_style('itea_main_styles', get_stylesheet_uri());
    wp_enqueue_style('fancybox_css', '//cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css');
//    wp_enqueue_script('fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', ['main-itea-bundled-js', 'jquery'], '', true);
    wp_enqueue_script('fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js', ['main-itea-bundled-js', 'jquery'], '', true);
    // }


    $gravatar_image = get_avatar_url(get_current_user_id(), $args = null);
    $profile_picture_url = get_user_meta(get_current_user_id(), 'user_registration_profile_pic_url', true);
    $image = (!empty($profile_picture_url)) ? $profile_picture_url : $gravatar_image;
    wp_localize_script('main-itea-bundled-js', 'iteaData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('protection'),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'language' => pll_current_language(),
        'translates' => [
//            'favorite' => pll__('Favorite equipment'),
        ],
        'thank_page_urls' => [
            'order' => get_permalink(457),
            'trial' => get_permalink(1120),
            'consultation' => get_permalink(1118),
        ]
    ));
}

add_action('wp_enqueue_scripts', 'itea_files', 0);

//contact form 7 br fix
add_filter('wpcf7_autop_or_not', '__return_false');


//Opti start
add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue()
{
    if (is_admin()) {
        return;
    }
    wp_deregister_script('jquery');
    wp_register_script('jquery', false);
//    wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
//    wp_enqueue_script('jquery');
}

add_action('wp_head', 'fix_header_jquery', 1);
function fix_header_jquery () {
    if(is_admin()) {return;}
    echo '<script>(function(w,d,u){w.readyQ=[];w.bindReadyQ=[];function p(x,y){if(x=="ready"){w.bindReadyQ.push(y);}else{w.readyQ.push(x);}};var a={ready:p,bind:p};w.$=w.jQuery=function(f){if(f===d||f===u){return a}else{p(f)}}})(window,document)</script>';
}
add_action('wp_footer', 'fix_footer_jquery', 8);
function fix_footer_jquery () {
    if(is_admin()) {return;}
    echo '<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).bind("ready",f)})})(jQuery,document)</script>';
}

//add_filter('script_loader_tag', 'add_async_attribute', 49, 3);
function add_async_attribute($tag, $handle, $src)
{
    if (is_admin()) {
        return $tag;
    }
    // ???????????????? ?????????????????????? (????????????????) ???????????????? ?? ???????????? ????????
    $scripts_to_async = array('jquery-core');
    foreach ($scripts_to_async as $async_script) {
        if ($async_script === $handle) {
            return str_replace(' src', ' src', $tag);
        } else {
            return str_replace(' src', ' defer src', $tag);
        }
    }
    return $tag;
}

//add_filter('style_loader_tag', 'async_load_css', 10, 4);
function async_load_css($html, $handle, $href, $media)
{
    if (is_admin()) {
        return $html;
    } //???????? ?? ??????????????

    //$href = str_replace('https://example.com/','/',$href);

    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false ||
        strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false ||
        strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false) {
        return $html;
        //        return '<script async id="'.$handle.'-css-js">var async_css = document.createElement( "link" );async_css.id = "'.$handle.'-css";async_css.rel = "stylesheet";async_css.href = "'.$href.'";document.body.insertBefore( async_css, document.body.childNodes[ document.body.childNodes.length - 1 ].nextSibling );</script>';
//        return '<script async>var async_css = document.createElement( "link" );async_css.rel = "stylesheet";async_css.href = "'.$href.'";document.body.insertBefore( async_css, document.body.childNodes[ document.body.childNodes.length - 1 ].nextSibling );</script>';
    } else {
        return str_replace(" rel='stylesheet'", " rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet';\" ", $html);
    }
}


//Disable REST API link tag
remove_action('wp_head', 'rest_output_link_wp_head', 10);
//Disable oEmbed Discovery Links
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
//Disable REST API link in HTTP headers
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'feed_links_extra', 3); // ?????????????? ???????????? ???? rss ??????????????????
remove_action('wp_head', 'feed_links', 2); // ?????????? ???????????? ???? ???????????????? rss ?? ??????????????????????
remove_action('wp_head', 'rsd_link');  // ???????????? Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // ???????????? ???????????? wordpress

add_filter('after_setup_theme', 'remove_redundant_shortlink');
function remove_redundant_shortlink()
{
    // remove HTML meta tag
    // <link rel='shortlink' href='http://example.com/?p=25' />
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);

    // remove HTTP header
    // Link: <https://example.com/?p=25>; rel=shortlink
    remove_action('template_redirect', 'wp_shortlink_header', 11);
}


//add_action( 'wp_print_styles', 'my_font_awesome_cdn', 1);
//function my_font_awesome_cdn() {
//    wp_deregister_style( 'fontawesome' );
//    wp_register_style( 'fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', false, '4.7.0', 'all');
//    wp_enqueue_style( 'fontawesome' );
//}

add_action('after_setup_theme', 'footer_enqueue_scripts');
function footer_enqueue_scripts()
{
    if (is_admin()) {
        return;
    }
    remove_action('wp_enqueue_scripts', 'ls_load_google_fonts'); //remove google fonts
    remove_action('admin_enqueue_scripts', 'ls_load_google_fonts'); //remove google fonts


    remove_action('wp_head', 'download_rss_link'); //RRS meta

    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_enqueue_scripts', 2);
//    remove_action('wp_head', 'wp_print_styles', 8);
    remove_action('wp_head', 'wp_print_head_scripts', 9);
//    wp_enqueue_style
//    style_loader_tag
    add_action('wp_footer', 'wp_print_scripts', 4);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
//    add_action('wp_footer', 'wp_print_styles', 6);
    add_action('wp_footer', 'wp_print_head_scripts', 7);

}

//Opti End

function cc_mime_types($mime_types)
{
    $mime_types['svg'] = 'image/svg+xml';
//    $mime_types['svg'] = 'image/svg';
    return $mime_types;
}

add_filter('upload_mimes', 'cc_mime_types');


function remove_admin_login_header()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'remove_admin_login_header');

//create array of photos for lot
function lot_album_url_array($array)
{
    return array_map("get_url_from_img_id", $array);
}

// Only for geting img url
function get_url_from_img_id($id)
{
    return wp_get_attachment_image_url($id, 'full');
}

function get_page_id_by_template($template)
{
    $args = [
        'post_type' => 'page',
        'fields' => 'ids',
        'nopaging' => true,
        'meta_key' => '_wp_page_template',
        'meta_value' => $template
    ];
    $pages = get_posts($args);
    if (empty($pages)) {
        return '/';
    }
    return $pages[0];
}


function lb_menu_anchors($items, $args)
{
    return $items;
}

//add_filter('wp_nav_menu_objects', 'lb_menu_anchors', 10, 2);


//translate start

if (function_exists('pll_register_string')) {

    pll_register_string("Pages", "?????????? ????????", "globals");
    pll_register_string("Pages", "???????????????????? ????????????", "globals");
    pll_register_string("Pages", "??????????????", "globals");
    pll_register_string("Pages", "???????????????? ???? ????????????????", "globals");
    pll_register_string("Pages", "????????????", "globals");
    pll_register_string("Pages", "?????????????????? ??????", "globals");
    pll_register_string("Pages", "???????? ????????????????????", "globals");
    pll_register_string("Pages", "?????????????????????? ???? ???????? ??????????????", "globals");
    pll_register_string("Pages", "???????????? ?? ?????????? ????????????????, ?????????????????? ?? ?????????????? Zoom", "globals");
    pll_register_string("Pages", "??????????????????????", "globals");
    pll_register_string("Pages", "????????", "globals");
    pll_register_string("Pages", "??????????????", "globals");
    pll_register_string("Pages", "??????????????", "globals");
    pll_register_string("Pages", "?? ??????????????", "globals");
    pll_register_string("Pages", "????????????????", "globals");
    pll_register_string("Pages", "???????????????????????????? ?? ??????????????????????", "globals");
    pll_register_string("Pages", "???????????????????????????? ??????????????????", "globals");
    pll_register_string("Pages", "?????????????? ????????????", "globals");
    pll_register_string("Pages", "????????????????", "globals");
    pll_register_string("Pages", "????????????????????:", "globals");
    pll_register_string("Pages", "?????? ????????????:", "globals");
    pll_register_string("Pages", "?????? ????????????????????????????", "globals");
    pll_register_string("Pages", "????????????????", "globals");
    pll_register_string("Pages", "VC (?????????????????????? ????????????????)", "globals");
    pll_register_string("Pages", "???????????????????????? ?????????????????????? VC ???????????????????????? ???????????? ?????????????????????? ?????? ????????????????, ?? ?????????? ???????????????????????? ???????????? ?????????????????????? ?? ????????????????????????.", "globals");
    pll_register_string("Pages", "USD (???????????????????????????? ??????????)", "globals");
    pll_register_string("Pages", "???????????? ???????????????????????????? ?????????????????? ?????? ???????????? ?????????????? ?? ???????????????????? ????????????????. ?????????????????????? ?????????? ?? ????????????, ?????????????????? ???????????????????????? ???????????? ???????????????????? ???????????????????????? ???? ?????????? ????????????.", "globals");
    pll_register_string("Pages", "???????????????? eBAND", "globals");
    pll_register_string("Pages", "???????? - ???????????????????????? ???????????????? ?????? ???????????? ???? ?????????????????????????? ?????????????????? ?? ????????????.", "globals");
    pll_register_string("Pages", "??????????", "globals");
    pll_register_string("Pages", "???????????????????? ???????????? ???? ??????????????", "globals");
    pll_register_string("Pages", "??????????????", "globals");
    pll_register_string("Pages", "???? ???????????? ?????????????? ???????????? ???? ??????????????", "globals");
    pll_register_string("Pages", "?? ??????????????????, ???? ???????????? ?????????????? ???? ?????????????? ???????????????????? ??????????????????.", "globals");
    pll_register_string("Pages", "product", "globals");
    pll_register_string("Pages", "?? 2021 Zoom Store", "globals");
    pll_register_string("Pages", "???????????????????? ????????", "globals");
    pll_register_string("Pages", "??????????????", "globals");
    pll_register_string("Pages", "??????????????????", "globals");
    pll_register_string("Pages", "????????????????", "globals");
    pll_register_string("Pages", "???????? ??????????????:", "globals");
    pll_register_string("Pages", "????????????", "globals");

    pll_register_string("Pages", "???????????? ??????????????????", "globals");
    pll_register_string("Pages", "?????????????? ??????????????????????", "globals");
    pll_register_string("Pages", "???????? ?? ??????????????", "globals");
    pll_register_string("Pages", '??????????????, ????????<br><a href="tel:+380956357677">+380956357677</a><br><a href="mailto:admin@zoomstore.com.ua">admin@zoomstore.com.ua</a><br><a href="mailto:sales@zoomstore.com.ua">sales@zoomstore.com.ua</a>', "globals");


    //pll_e("");
}

//translate end


function add_recaptcha()
{
    //https://www.google.com/recaptcha/api.js
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', [], 1.0, false);
//    wp_enqueue_script('theme-helper-js', get_stylesheet_directory_uri() . '/assets/js/helper.js', [], 1.0, true);
}

//add_action('wp_enqueue_scripts', 'add_recaptcha');


function update_geo()
{
    require_once get_theme_file_path('/inc/api/sxgeo_update.php');
}

add_action('update_geo_ip', 'update_geo');

if (!wp_next_scheduled('update_geo_ip')) {
    wp_schedule_event(time(), 'daily', 'update_geo_ip');
}
//add_filter( 'use_block_editor_for_post', 'disable_gutenberg_for_post', 10, 2 );


/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Remove from TinyMCE
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}

add_action('init', 'disable_emojis');

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

function parsePlugin()
{
//    return;
    $time = get_option('xml_price_cron');
    $hour = 60 * 30 * 1; // 40 minutes
    $xml = new ImportXML();
//    $xml->parseGoogleDrive();
//    $xml->parseLocalFileAttributes();
//    $xml->copyAttributesRuToUk();
    if (empty($time) || $time + $hour < time()) {
        update_option('xml_price_cron', time());
        $xml->parseGoogleDrive();
        return;
        $xml->parseLocalFileData();
        die();
    }
}

add_action('init', 'parsePlugin', 69);

function removeDuplicates()
{
    foreach (pll_languages_list() as $lang) {
        $data = [];
        $posts = get_posts([
            'post_type' => 'product',
            'post_status' => ['publish', 'draft'],
            'posts_per_page' => -1,
            'lang' => $lang,
        ]);


        foreach ($posts as $post) {
            $post_id = $post->ID;
            $sku = get_post_meta($post_id, '_sku', true);
            if (in_array($sku, $data)) {
                wp_delete_post($post_id);
            } else {
                $data[] = $sku;
            }
        }
    }
}

//add_action('init', 'removeDuplicates', 69);

function is_set_cookie_compare($id)
{
    if (!empty($_COOKIE['br_products_compare'])) {
        $cookie = $_COOKIE['br_products_compare'];
        if (preg_match("/(^" . $id . ",)|(," . $id . "$)|(," . $id . ",)|(^" . $id . "$)/", $cookie)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function set_class_compare($id)
{
    if (is_set_cookie_compare($id)) {
        return "br_compare_added";
    }
    return "";
}


add_action('rest_api_init', 'registerProductsRoutes');

function registerProductsRoutes()
{
    register_rest_route('v1/products', 'get', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'getProducts',
        'permission_callback' => '__return_true'
    ));
}

function getProducts(WP_REST_Request $request)
{
//    if (wp_verify_nonce($_GET['security'], 'protection')) {
    $data = $_GET['data'];
    $lang = $_GET['language'];

    $result = [];


    $meta_query = ['relation' => 'AND'];
    $meta_query['_stock_status'] = [
        'key' => '_stock_status',
        'value' => 'instock',
        'compare' => '=',
    ];
    $order_by = [];

    switch ($data['filter']) {
        case "popular":
            $meta_query['popular'] = [
                'key' => 'popular',
                'compare' => 'IN',
                'value' => [0, 1, NULL, ""],
            ];
            $order_by['popular'] = [
                'popular' => 'DESC',
            ];
            break;
        case "new":
            $meta_query['new'] = [
                'key' => 'new',
                'value' => '1',
                'compare' => '=',
            ];
            break;
        case "discount":
            $meta_query['_sale_price'] = [
                'key' => '_sale_price',
                'value' => '0',
                'compare' => '>',
                'type' => 'numeric',
            ];
            break;
        case "rent":
            $meta_query['rent'] = [
                'key' => 'rent',
                'value' => '1',
                'compare' => '=',
            ];
            break;
    }


    $loop = new WP_Query(array(
            'post_type' => 'product',
            'posts_per_page' => 9,
            'paged' => !empty($data['page']) ? $data['page'] : 1,
            'orderby' => $order_by,
            'meta_query' => $meta_query,
            'lang' => [$lang],
        )
    );
    while ($loop->have_posts()) {
        $loop->the_post();
        global $post;
        $product = wc_get_product($post->ID);
        $sku = $product->get_sku();

        $post->guid = get_permalink($post->ID);
        $related_image_url = get_the_post_thumbnail_url($post->ID);
        if (!empty($related_image_url)) {
            $post->thumbnail_url = $related_image_url;
        } else {
            $post->thumbnail_url = wc_placeholder_img_src();
        }
//        woocommerce_get_product_thumbnail('full');
        $post->price_html = $product->get_price_html();
        $post->class_compare = set_class_compare($post->ID);
        $post->sku = $sku;
        $post->popular = get_post_meta($post->ID, 'popular', true);
        $post->rent_price = get_post_meta($post->ID, 'rent_price', true);
        $result['data'][] = $post;
    }
    $result['found_posts'] = $loop->found_posts;
//    $result['post_count'] = $loop->post_count;
    $result['max_num_pages'] = $loop->max_num_pages;
    wp_reset_query();

    wp_send_json($result);
//    }
    wp_send_json(false);

}

function updateProductsPriceSku()
{
    $posts = get_posts([
        'post_type' => 'product',
        'post_status' => ['publish', 'draft'],
        'posts_per_page' => -1,
        'lang' => ['ru', 'uk'] //'uk'
    ]);

    foreach ($posts as $post) {
        $productWp = wc_get_product($post->ID);
        $productWp->set_manage_stock(false);
        $productWp->save();
//        $post_id = $post->ID;
//        $post_id_uk = pll_get_post($post->ID, 'uk');
//        $price = get_post_meta($post_id, '_price', true);
//        $sku = get_post_meta($post_id, '_sku', true);
//        if (empty($price)) {
//            $price = get_post_meta($post_id, '_regular_price', true);
//        }
//        update_post_meta($post_id_uk, '_regular_price', $price);
//        update_post_meta($post_id_uk, '_price', $price);
//        update_post_meta($post_id_uk, '_sku', $sku);
    }
}

//add_action('init', 'updateProductsPriceSku', 69);

add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query()) {
//        $meta_query = ['relation' => 'AND'];
//        $meta_query['_price'] = [
//            'key' => '_price',
//            'value' => 20000,
//            'compare' => '>=',
//            'type' => 'NUMERIC'
//        ];
//        $query->set('meta_query', $meta_query);
    }
});


function get_filtered_price()
{
    global $wpdb;

    $args = wc()->query->get_main_query();

    $tax_query = isset($args->tax_query->queries) ? $args->tax_query->queries : array();
    $meta_query = isset($args->query_vars['meta_query']) ? $args->query_vars['meta_query'] : array();

    foreach ($meta_query + $tax_query as $key => $query) {
        if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
            unset($meta_query[$key]);
        }
    }

    $meta_query = new \WP_Meta_Query($meta_query);
    $tax_query = new \WP_Tax_Query($tax_query);

    $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
    $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

    $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
    $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
    $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('product')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('_price')
			AND price_meta.meta_value > '' ";
    $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

    $search = \WC_Query::get_main_search_query_sql();
    if ($search) {
        $sql .= ' AND ' . $search;
    }

    $prices = $wpdb->get_row($sql); // WPCS: unprepared SQL ok.

    return [
        'min' => floor($prices->min_price),
        'max' => ceil($prices->max_price)
    ];
}