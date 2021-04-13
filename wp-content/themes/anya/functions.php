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

function sendEmail($data) {
    $send_to = implode(',', array_map('trim', preg_split('/,|\n/',get_option('true_options')['emails_to'])));
    $siteUrl = str_replace(['http://','https://'], '', get_site_url());
    $headers = array("From: Online Itea <wordpress@$siteUrl>", 'Content-Type: text/html; charset=UTF-8');

    if ($data['post_id']) {
        $subject = "Заявка на курс";
    } else {
        $subject = "Форма обратной связи";
    }

    $message = "";
    foreach ($data as $key => $value) {
        if (!empty($value)) {
            $message.= "$key: $value <br>";
        }
    }

    $success = wp_mail($send_to,$subject,$message,$headers);
}

function sendEmailToUser($data) {
    $send_to = $data['email'];
    $subject = 'Спасибо за заявку на onlineitea.com!';
    $headers = array('From: ITEA <noreply@onlineitea.com>',"content-type: text/html");

    $message =
    'Привет. 
    <br><br>
    Мы получили твою заявку и совсем скоро свяжемся с тобой по телефону, чтобы обсудить детали твоего обучения. 
    <br><br>
    А пока наш менеджер набирает твой номер, хотим обратить твоe внимание на то, что тебя ждет на курсах ITEA Online.
    <ul style="list-style-type:decimal;">
       <li> Мы не используем записанные видеоуроки в процессе обучения. Для этой задачи существуют бесплатные курсы и видео на YouTube. <strong>Наше обучение - это живое общение с преподавателем на онлайн-занятиях </strong>. Запись занятий мы также предоставляем. </li>
    
       <li> Занятия академии <strong>начинаются в 20:00 и заканчиваются в 23:00 по МСК</strong>. Всё это время теория сразу же подкрепляется практическими задачами, чтобы студенты могли лучше запомнить материал. И никакой начитки лекций!</li>
    
       <li> <strong>После каждого занятия преподаватель задаёт домашнее задание</strong>, выполнение которого — обязательный пункт. Студенты получают оценку за задание и развернутую обратную связь. Самые популярные ошибки преподаватель открыто обсуждает на следующем занятии.</li>
    
       <li> Мы формируем <strong>небольшие группы — до 10-15 человек</strong>. Таким образом, преподаватель уделяет достаточно внимания каждому студенту, успевает внимательно проверить все задания и ответить на вопросы.</li>
    
       <li> По окончании курса и после защиты проекта мы выдаем сертификат об успешном прохождении курса. Также лучшие студенты получают наши <strong>рекомендации для стажировки и трудоустройства в компании-партнеры ITEA Online</strong>.</li>
    </ul>
    <br><br>
    Ну а чтобы познакомиться поближе, приглашаем на нашу <a href="https://vk.com/iteaonline"> страницу ВК</a> или <a href="https://t.me/ITEAonline">телеграм канал</a> .
    <br><br>
    Учиться в удовольствие? Вместе с ITEA!
    
    ';

    wp_mail($send_to,$subject,$message,$headers);
}
function sendEmailWithTrial($data){
    $send_to = $data['email'];
    $subject = 'Запись занятия «' . get_the_title( $data['post_id'] ) . '»';
    $headers = array('From: ITEA Online <noreply@onlineitea.com>',"content-type: text/html");
    $message = get_field('first_mail', $data['post_id']);
    wp_mail($send_to,$subject,$message,$headers);
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
    pll_register_string("Pages", "Подобрать курсы", "Globals");
    pll_register_string("Pages", "Расписание курсов", "Globals");
    pll_register_string("Pages", "Все вебинары", "Globals");
    pll_register_string("Pages", "Ближайшие события", "Globals");
    pll_register_string("Pages", "Ближайшие", "Globals");
    pll_register_string("Pages", "курсы", "Globals");
    pll_register_string("Pages", "ПРОФЕССИИ", "Globals");
    pll_register_string("Pages", "вебинары", "Globals");
    pll_register_string("Pages", "Старт", "Globals");
    pll_register_string("Pages", "Длительность", "Globals");
    pll_register_string("Pages", "Длительность курса", "Globals");
    pll_register_string("Pages", "занятий", "Globals");
    pll_register_string("Pages", "Подробнее", "Globals");
    pll_register_string("Pages", "Дата", "Globals");
    pll_register_string("Pages", "Время", "Globals");
    pll_register_string("Pages", "Стоимость", "Globals");
    pll_register_string("Pages", "Стоимость курса", "Globals");
    pll_register_string("Pages", "Бесплатно", "Globals");
    pll_register_string("Pages", "Эффективное обучение? С ITEA!", "Globals");
    pll_register_string("Pages", "Узнать больше", "Globals");
    pll_register_string("Pages", "Все курсы", "Globals");
    pll_register_string("Pages", "Все курсы по направлениям", "Globals");
    pll_register_string("Pages", "Популярные курсы среди новичков", "Globals");
    pll_register_string("Pages", "Направление", "Globals");
    pll_register_string("Pages", "Отзывы компаний", "Globals");
    pll_register_string("Pages", "Отзывы студентов", "Globals");
    pll_register_string("Pages", "Хочу консультацию", "Globals");
    pll_register_string("Pages", "Хочу бесплатный урок", "Globals");
    pll_register_string("Pages", "Название курса", "Globals");
    pll_register_string("Pages", "Статус/Название", "Globals");
    pll_register_string("Pages", "Компании, в которых работают наши выпускники", "Globals");
    pll_register_string("Pages", "Бесплатная консультация", "Globals");
    pll_register_string("Pages", "Направления обучения", "Globals");
    pll_register_string("Pages", "Политика конфиденциальности", "Globals");
    pll_register_string("Pages", "Пользовательское соглашение", "Globals");
    pll_register_string("Pages", "Возможно, тебе будут интересны и эти курсы:", "Globals");
    pll_register_string("Pages", "Тебе могут подойти эти курсы:", "Globals");
    pll_register_string("Pages", "Забронировать место", "Globals");
    pll_register_string("Pages", "Команда ITEA собрала лучших практиков: руководителей, senior-специалистов и экспертов с многолетним опытом", "Globals");
    pll_register_string("Pages", "Кто преподаватели?", "Globals");
    pll_register_string("Pages", "Детальнее", "Globals");
    pll_register_string("Pages", "Твой план обучения на курсе", "Globals");
    pll_register_string("Pages", "Формула эффективного обучения ITEA:", "Globals");
    pll_register_string("Pages", "Программа курса", "Globals");
    pll_register_string("Pages", "Как наши студенты изучают", "Globals");
    pll_register_string("Pages", "Для кого этот курс:", "Globals");
    pll_register_string("Pages", "Доступна оплата частями", "Globals");
    pll_register_string("Pages", "ЦЕНА", "Globals");
    pll_register_string("Pages", "СКОЛЬКО", "Globals");
    pll_register_string("Pages", "ГДЕ", "Globals");
    pll_register_string("Pages", "КОГДА", "Globals");
    pll_register_string("Pages", "Онлайн обучение", "Globals");
    pll_register_string("Pages", "Вернуться на главную", "Globals");
    pll_register_string("Pages", "Посмотреть весь текст", "Globals");
    pll_register_string("Pages", "Закрыть", "Globals");
    pll_register_string("Pages", "Заявка успешно отправлена!", "Globals");
    pll_register_string("Pages", "Обычно мы отвечаем в течение 10-ти минут", "Globals");
    pll_register_string("Pages", "СКИДКА", "Globals");
    pll_register_string("Pages", "по МСК", "Globals");
    pll_register_string("Pages", "Идет набор на курс", "Globals");
//    pll_register_string("Pages", "", "Globals");

    pll_register_string("Pages", "Отвечаем на самые часто задаваемые вопросы", "Single Courses");

    pll_register_string("Form", "Политикой конфиденциальности", "Form");
    pll_register_string("Form", "Успей забронировать свое место в группе", "Form");
    pll_register_string("Form", "Записаться на курс", "Form");
    pll_register_string("Form", "Зарегистрироваться", "Form");
    pll_register_string("Form", "Если после первого занятия ты почувствуешь, что этот курс не для тебя (например, не подходит по сложности), то мы вернем деньги.", "Form");

    pll_register_string("All courses", "Фильтры", "All courses");
    pll_register_string("All courses", "Уровень сложности", "All courses");
    pll_register_string("All courses", "Для новичков", "All courses");
    pll_register_string("All courses", "Для продвинутых", "All courses");

    pll_register_string("404", "Такой страницы не найдено :(", "404");
    pll_register_string("404", "Возможно она была удалена или изменила адрес", "404");
    pll_register_string("404", "Мы готовим что-то интересное для тебя.", "404");
    pll_register_string("404", "Немного терпения :)", "404");

//    pll_register_string("Single Course", "", "Globals");

    pll_register_string("Single Profession", "Преподаватели направления", "Single Profession");
    pll_register_string("Single Profession", "После окончания комплексной программы ты сможешь", "Single Profession");
    pll_register_string("Single Profession", "Ты можешь пройти курсы по отдельности - в своем режиме. А можешь забронировать все курсы со скидкой - так выгодней", "Single Profession");
    pll_register_string("Single Profession", "Комплексная программа со скидкой", "Single Profession");
    pll_register_string("Single Profession", "Шаг", "Single Profession");
    pll_register_string("Single Profession", "Курсы для", "Single Profession");
    pll_register_string("Single Profession", "Почему", "Single Profession");
//    pll_register_string("Single Profession", "", "Globals");

    pll_register_string("Single Webinar", "Старт в IT? C ITEA", "Single Webinar");
    pll_register_string("Single Webinar", "Участие в вебинаре бесплатное при условии предварительной регистрации", "Single Webinar");
    pll_register_string("Single Webinar", "Кто будет делиться опытом?", "Single Webinar");
    pll_register_string("Single Webinar", "Какие вопросы рассмотрим?", "Single Webinar");
    pll_register_string("Single Webinar", "О вебинаре", "Single Webinar");
    pll_register_string("Single Webinar", "Онлайн-трансляция", "Single Webinar");
    pll_register_string("Single Webinar", "Формат", "Single Webinar");
    pll_register_string("Single Webinar", "ITEA webinar", "Single Webinar");
//    pll_register_string("Single Webinar", "", "Globals");

    pll_register_string("Footer", "Не знаешь, с чего начать свой путь в IT?", "Footer");
    pll_register_string("Footer", "Поможем в выборе направления прямо сейчас. Записывайся на бесплатную консультацию!", "Footer");
    pll_register_string("Footer", "Поддержка клиентов", "Footer");
    pll_register_string("Footer", "© 2014-2020 IT Education Academy. Все права защищены ITEA WORLD LLP", "Footer");


    pll_register_string("Pages", "Топовые преподаватели", "About");
    pll_register_string("Pages", "ITEA — авторизованный партнер", "About");
    pll_register_string("Pages", "Мы единственный украинский учебный центр, который является официальным авторизованным партнером компании Cisco", "About");
    pll_register_string("Pages", "Преимущества обучения в ITEA онлайн", "About");
    pll_register_string("Pages", "IT Education Academy (ITEA) — это:", "About");
    pll_register_string("Pages", "", "About");


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

function setTermTranslates () {
    die();
    require_once(ABSPATH . '/wp-admin/includes/taxonomy.php');
    $courses_terms = get_terms([
        'taxonomy' => 'courses_category',
        'lang' => 'ru'
    ]);
    var_dump($courses_terms);

    foreach ($courses_terms as $term) {
        $color = get_term_meta($term->term_id, 'color', true);
        $catBe = wp_insert_category([
            'cat_name' => $term->name,
            'category_description' => $term->description,
            'category_nicename' => $term->slug.'-be',
            'taxonomy' => 'courses_category'
        ]);
        update_term_meta($catBe, 'color', $color);


        $catKz = wp_insert_category([
            'cat_name' => $term->name,
            'category_description' => $term->description,
            'category_nicename' => $term->slug.'-kz',
            'taxonomy' => 'courses_category'
        ]);
        update_term_meta($catKz, 'color', $color);

        $catUz = wp_insert_category([
            'cat_name' => $term->name,
            'category_description' => $term->description,
            'category_nicename' => $term->slug.'-uz',
            'taxonomy' => 'courses_category'
        ]);
        update_term_meta($catUz, 'color', $color);

        pll_set_term_language($catBe, 'be');
        pll_set_term_language($catKz, 'kz');
        pll_set_term_language($catUz, 'uz');

        pll_save_term_translations([
            'ru' => $term->term_id,
            'be' => $catBe,
            'kz' => $catKz,
            'uz' => $catUz,
        ]);

    }
}

function update_geo() {
    require_once get_theme_file_path('/inc/api/sxgeo_update.php');
}
add_action('update_geo_ip', 'update_geo');

if (!wp_next_scheduled('update_geo_ip')) {
    wp_schedule_event( time(), 'daily', 'update_geo_ip' );
}
add_filter( 'use_block_editor_for_post', 'disable_gutenberg_for_post', 10, 2 );
function disable_gutenberg_for_post( $use, $post ){
	if( $post->ID == 577 )
		return false;

	return $use;
}
function declOfNum($number, $titles)
{
   $cases = array (2, 0, 1, 1, 1, 2);
    $format = $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    return sprintf($format, $titles);
};
function sendEmailWithTrialSecond($email,$post__ID){
    get_post( intval($post__ID) );
    $send_to = $email;
    $subject = 'Спасибо за заявку на onlineitea.com!';
    $headers = array('From: ITEA Online <noreply@onlineitea.com>',"content-type: text/html");
    $message =  get_field('second_mail', $post__ID);
    $send_mail = wp_mail($send_to,$subject,$message,$headers);
}
add_action( 'wp_mail_failed', 'debug_mail', 10, 1 );
function debug_mail($wp_error) {
    $send_to = 'mikhail.khripun@gmail.com';
    $subject = 'Ошибка отправки';
    $headers = array('From: ITEA Online <noreply@onlineitea.com>',"content-type: text/html");
    $message = $wp_error;
    $send_mail = wp_mail($send_to,$subject,$message,$headers);
};
add_filter( 'cron_schedules', 'my_interval');
function my_interval( $shed ) {

	$shed['every_hour'] = array(
		'interval' => 3600,
		'display' => ''
	);
	/* пример еженедельного интервала
	$raspisanie['nedelya'] = array(
		'interval' => 604800,
		'display' => 'Раз в неделю'
	);
	*/
	return $shed;

}

// добавляем функцию к указанному хуку
add_action( 'send_email_two_days', 'my_hour_f' );

if( ! wp_next_scheduled( 'send_email_two_days' ) ) {
    wp_schedule_event( time(), 'hourly', 'send_email_two_days');
}



function my_hour_f() {
    global $wpdb;
    $resultForCron = $wpdb->get_results("
    SELECT * FROM `table_cron`
    ");
    selectTwoDaysQuerys($resultForCron);

};


function selectTwoDaysQuerys($resultForCron){
    global $wpdb;
    $days2_ago = strtotime("-48 hours");
    foreach ($resultForCron as $singleResult) {
        if($days2_ago > strtotime($singleResult->DATE)){
            sendEmailWithTrialSecond($singleResult->userMAIL,$singleResult->courseID);
            $curID = $singleResult->Id;
            $table ='table_cron';
            $wpdb->delete($table, array( 'Id' => $curID),'%d');
        };
    }
};
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
