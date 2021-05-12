<?php

//strings for wp-config.php
//define('MAIN_SITE_URL', 'https://jungo-master.demo.gns-it.com');
//define('API_URL', 'https://api.jungo-dev.demo.gns-it.com/api/v1');

require get_theme_file_path('/inc/widgets.php');
require get_theme_file_path('/inc/polylang-slug.php');
require get_theme_file_path('/inc/itea-settings.php');
require_once get_theme_file_path('/inc/api/ErpItea.php');
require_once get_theme_file_path('/inc/api/Bitrix.php');
require_once get_theme_file_path('/inc/api/ScheduleErp.php');


add_action('init', 'create_taxonomy');
function create_taxonomy()
{
    // create a new taxonomy
    register_taxonomy(
        'courses_category',
        ['courses', 'professions', 'webinars'],
        array(
            "hierarchical" => true,
            "label" => "Courses Category",
            "singular_label" => "Course",
//            "rewrite" => array('slug' => 'courses/category', 'with_front' => false, 'hierarchical' => false)
            "rewrite" => array('slug' => 'courses', 'with_front' => false)//, 'hierarchical' => true
        )
    );
}

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
            'menu-1' => esc_html__('Header', 'itea'),
        ));
        register_nav_menus(array(
            'menu-2' => esc_html__('Footer', 'itea'),
        ));
        register_nav_menus(array(
            'menu-support' => esc_html__('Client Support', 'itea'),
        ));


    }
endif;
add_action('after_setup_theme', 'itea_setup');

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

add_action('customize_register', 'your_theme_customizer_setting');


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
            'favorite' => pll__('Favorite equipment'),
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
    wp_deregister_script('jquery');
    wp_register_script('jquery', false);
//    wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
//    wp_enqueue_script('jquery');
}

//add_filter('script_loader_tag', 'add_async_attribute', 49, 3);
function add_async_attribute($tag, $handle, $src)
{
    if (is_admin()) {
        return $tag;
    }
    // добавьте дескрипторы (названия) скриптов в массив ниже
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
    } //если в админке

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
remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress

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
//  remove_action('wp_head', 'wp_print_styles',8);
    remove_action('wp_head', 'wp_print_head_scripts', 9);
//    wp_enqueue_style
//    style_loader_tag
    add_action('wp_footer', 'wp_print_scripts', 4);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
//  add_action('wp_footer','wp_print_styles',6);
    add_action('wp_footer', 'wp_print_head_scripts', 7);

}

//Opti End

function cc_mime_types($mime_types)
{
//    $mime_types['svg'] = 'image/svg+xml';
    $mime_types['svg'] = 'image/svg';
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

add_action('wp_ajax_nopriv_check_promo', 'check_promo');
add_action('wp_ajax_check_promo', 'check_promo');
function check_promo()
{
    if (wp_verify_nonce($_POST['security'], 'protection')) {
        $erp = new ErpItea();
        $post_id = $_POST['data']['target_id'];
        $result = $erp->checkPromoCode($_POST['data']['promo']);
        if ($result['success']) {
            $success = false;
            $promoData = json_decode($result['message']);
            $uuid = get_post_meta($post_id, 'uuid_for_itea_crm', true);
            foreach ($promoData->courses as $course) {
                if ($course->uuid == $uuid) {
                    $success = true;
                }
            }
            foreach($promoData->roadmaps as $roadmap) {
                if ($roadmap->uuid == $uuid) {
                    $success = true;
                }
            }
            if ($success) {
                wp_send_json([
                    'data' => $promoData,
                    'success' => $success
                ]);
            }
            wp_send_json([
                'data' => $promoData,
                'success' => $success
            ]);
        }
        wp_send_json(false);
    }
    wp_send_json(false);
}



add_action('wp_ajax_nopriv_contact_form', 'contact_form');
add_action('wp_ajax_contact_form', 'contact_form');
function contact_form()
{
    if (wp_verify_nonce($_POST['security'], 'protection')) {
        $post_id = $_POST['data']['target_id'];
        $data = [
            'post_id' => $post_id,
            'name' => $_POST['data']['name'],
            'email' => $_POST['data']['email'],
            'phone' => $_POST['data']['phone'],
            'promo' => $_POST['data']['promo'],
            'promocode' => $_POST['data']['promocode'],
            'discount' => $_POST['data']['discount'],
            'is_trial' => $_POST['data']['is_trial'],
            'is_consult' => $_POST['data']['is_consult'],
            'utm_source' => $_POST['data']['utm_source'],
            'host' => $_POST['data']['host'],
            'post_name' => '',
            'roadmap_uuid' => '',
            'courses_uuid' => '',
            'price' => '',
            'discount_price' => '',
        ];
        if (!empty($post_id)) {
            $price = 0;
            $courses_uuid = [];
            $post_type = get_post_type($post_id);
            $data['post_name'] = get_the_title($post_id);
            switch ($post_type) {
                case "webinars":

                    break;

                case "professions":
//                    $price += get_post_meta($post_id, 'cost', true);
                    $data['roadmap_uuid'] = get_post_meta($post_id, 'uuid_for_itea_crm', true);
                    $cost = get_post_meta($post_id, 'discount_price', true);
                    if (!empty($cost)) {
                        $price += $cost;
                    }
                    foreach (get_post_meta($post_id, 'profession_courses', true) as $course) {
                        if (empty($price)) {
                            $price += get_post_meta($course, 'cost', true);
                        }
                        $courses_uuid[] = get_post_meta($course, 'uuid_for_itea_crm', true);
                    }
                    break;
                case "courses":
                    $discount_price = get_post_meta($post_id, 'discount_price', true);
                    if (empty($discount_price)) {
                        $price += get_post_meta($post_id, 'cost', true);
                    } else {
                        $price += $discount_price;
                    }
                    if ($data['is_trial'] == 1 and !empty(get_field('first_mail', $post_id))){

                        sendEmailWithTrial($data);
                        global $wpdb;
                        $wpdb->query("
                        INSERT table_cron (`courseID`, `userMAIL`) 
                        VALUES ( '" . $post_id ."',  '". $data['email'] . "');

                        ");

                    } else {
                        sendEmailToUser($data);
                    }

                    $courses_uuid[] = get_post_meta($post_id, 'uuid_for_itea_crm', true);
                    break;
            }
            $data['post_type'] = $post_type;
            $data['currency'] = get_post_meta($post_id, 'currency', true);
            $data['price'] = $price;
            if ($data['is_trial'] || $data['is_consult']) {
                $data['price'] = 0;
            }
            $data['courses_uuid'] = $courses_uuid;

            $erp = new ErpItea();
            $result = $erp->sendOrder($data);
            $bitrix = new Bitrix();
            $bitrix->createLeadBitrix($data['host'], $data);
            sendEmail($data);
//            wp_send_json($data);
        } else {
            $erp = new ErpItea();
            $result = $erp->sendCallbackOrder($data);
            $bitrix = new Bitrix();
            $bitrix->createLeadBitrix($data['host'].' Callback', $data);

            sendEmail($data);


//            wp_send_json($result);
        }


        wp_send_json(true);
    }
    wp_send_json(false);
}

function lb_menu_anchors($items, $args) {
    return $items;
}
//add_filter('wp_nav_menu_objects', 'lb_menu_anchors', 10, 2);

// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
// global $wpdb;
// $tablename = "table_cron";
// $main_sql_create = "CREATE TABLE " . $tablename . '(
//     Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
//     courseID INT NOT NULL,
//     userMAIL VARCHAR(50) NOT NULL,
//     DATE TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
//     )';
// maybe_create_table($wpdb->prefix . $tablename, $main_sql_create );


add_action('wp_ajax_nopriv_callback', 'callback');
add_action('wp_ajax_callback', 'callback');
function callback()
{
    if (wp_verify_nonce($_POST['security'], 'protection')) {


        $data = [
            'name' => $_POST['data']['phone'],
            'phone' => $_POST['data']['phone'],
//            'utm_source' => $_POST['data']['utm_source'],
            'cityUuid' => get_option('true_options')['department_uuid'],
        ];
        $erp = new ErpItea();
        $result = $erp->sendCallbackOrder($data);
        $bitrix = new Bitrix();
            $bitrix->createLeadBitrix($data['host'].' Callback', $data);
//        wp_send_json($result);
        sendEmail($data);
        wp_send_json(true);
    }
    wp_send_json(false);
}


add_action('wp_ajax_delete_all_dates', 'delete_all_dates');
function delete_all_dates() {
    if (wp_verify_nonce($_POST['security'], 'protection')) {
        $courses = get_posts([
            'post_type' => 'courses',
            'posts_per_page' => -1,
        ]);

        foreach ($courses as $course) {
            while (have_rows('date', $course->ID)): the_row();
            delete_row('date', get_row_index(), $course->ID);
            endwhile;
        }
        wp_send_json(true);
    }
    wp_send_json(false);
}


//translate start

if (function_exists('pll_register_string')) {

    pll_register_string("Pages", "КРУТИ ВНИЗ", "Globals");



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


add_action('rest_api_init', function () {
    register_rest_route('pre-order/v1', 'pre-order', array(
        'methods' => 'POST',
        'callback' => 'send_pre_order'
    ));
});
function send_pre_order(WP_REST_Request $request)
{

}


function update_geo() {
    require_once get_theme_file_path('/inc/api/sxgeo_update.php');
}
add_action('update_geo_ip', 'update_geo');

if (!wp_next_scheduled('update_geo_ip')) {
    wp_schedule_event( time(), 'daily', 'update_geo_ip' );
}
add_filter( 'use_block_editor_for_post', 'disable_gutenberg_for_post', 10, 2 );


// добавляем функцию к указанному хуку
add_action( 'send_email_two_days', 'my_hour_f' );

if( ! wp_next_scheduled( 'send_email_two_days' ) ) {
    wp_schedule_event( time(), 'hourly', 'send_email_two_days');
}



/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function parse_xml () {
    $xml = simplexml_load_file(get_template_directory_uri().'/test.xml', 'SimpleXMLElement');
    $categories = [];
    $xmlCategories = $xml->shop->categories->category;
    $xmlProducts = $xml->shop->offers->offer;
    foreach ($xmlCategories as $category) {
        $name = $category->__toString();
        $id = $category['id']->__toString();
        $parentId = $category['parentld'];
        if (empty($parentId)) {
            $categories[$id] = [
                'name' => $name,
                'children' => [],
            ];
        } else {
            if (empty($categories[$parentId->__toString()])) {

                foreach($categories as $parentKey => $childCat) {
                    foreach($childCat['children'] as $key => $child) {
                        if ($key === $parentId->__toString()) {

                            $categories[$parentKey]['children'][$parentId->__toString()]['children'][$id] = [
                                'name' => $name,
                                'children' => [],
                            ];

                        }
                    }
                }
//                var_dump($xmlCategories[]);$parentId->__toString()
//                $categories[  ]['children'][] = [
//                    'name' => $name,
//                ];
            } else {
                $categories[$parentId->__toString()]['children'][$id] = [
                    'name' => $name,
                    'children' => [],
                ];
            }

        }

    }


    foreach ($xmlProducts as $product) {

    }

    echo '<pre>';
//    var_dump($categories);
//    var_dump($xml->shop->categories->category[2]);

    echo '</pre>';
    echo '<pre>';
    var_dump($xml->shop);

    echo '</pre>';
}

add_action( 'init', 'parse_xml' );