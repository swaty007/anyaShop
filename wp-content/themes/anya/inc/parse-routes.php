<?php

add_action('rest_api_init', 'parserRegisterRoute');

function parserRegisterRoute()
{
    register_rest_route('parse/v1', 'save', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'insertResult',
    ));
}


function insertResult($request)
{


    try {
        $sku = $_POST['sku'];
        $listName = $_POST['listName'];
        $imgFile = $_FILES['img'];


        $post_id = null;
        $attach_id = null;

        $posts = get_posts([
            'post_type' => 'product',
            'post_status' => ['publish', 'draft'],
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_sku',
                    'compare' => '=',
                    'value' => $sku,
                ],
            ],
        ]);

        if(!empty($posts)) {
            wp_send_json(false);
        }

        $attachments = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_list_name',
                    'value' => $listName
                ],
                [
                    'key' => '_img_name',
                    'value' => $imgFile['name']
                ],
            ]
        ]);

        wp_send_json([
            $posts,
            $attachments,
        ]);

        if (empty($attachments)) {
            if (!function_exists('wp_generate_attachment_metadata')) {
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            }
            $attach_id = media_handle_upload('img', 0);
            update_post_meta($attach_id, '_list_name', $listName);
            update_post_meta($attach_id, '_img_name', $imgFile['name']);
        } else {
            $attach_id = $attachments[0]->ID;
        }


        wp_send_json($attach_id);
//    add_post_meta($pid, 'meta_key_to_attach_image_to', $attach_id, false);
//    update_post_meta($pid,'_thumbnail_id',$attach_id);
//    set_post_thumbnail($post_id, $attach_id);
        wp_send_json(true);
    } catch (Exception $e) {
        wp_send_json(false);
    }
}


function shapeSpace_customize_image_sizes($sizes)
{
    unset($sizes['thumbnail']);    // disable thumbnail size
    unset($sizes['medium']);       // disable medium size
    unset($sizes['large']);        // disable large size
    unset($sizes['medium_large']); // disable medium-large size
    unset($sizes['1536x1536']);    // disable 2x medium-large size
    unset($sizes['2048x2048']);    // disable 2x large size
    return $sizes;
}

add_filter('intermediate_image_sizes_advanced', 'shapeSpace_customize_image_sizes');
// disable scaled image size
add_filter('big_image_size_threshold', '__return_false');


// disable other image sizes
function shapeSpace_disable_other_image_sizes()
{
    remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size()
//    remove_image_size('another-size');   // disable any other added image sizes
}

add_action('init', 'shapeSpace_disable_other_image_sizes');
// disable srcset on frontend
function disable_wp_responsive_images()
{
    return 1;
}

add_filter('max_srcset_image_width', 'disable_wp_responsive_images');
// thumbnail disable end


function parseResult($request)
{
    $parameters = $request->get_query_params();
    $mydb = new wpdb('mysql191993', '&Jwh3;~rB6ZR', 'mysql191993', 'mysql191993.mysql.sysedata.no');
    $rowcount = $mydb->get_var("SELECT COUNT(*) FROM wp_posts WHERE post_type='post' AND post_status='publish'");
//    $result = $mydb->get_results("
//SELECT * FROM wp_posts LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID AND wp_postmeta.meta_key = '_thumbnail_id' LEFT JOIN wp_posts AS image ON image.ID = wp_postmeta.meta_value
//WHERE wp_posts.post_type='post' AND wp_posts.post_status='publish' LIMIT 100");
    $result = $mydb->get_results("
SELECT * FROM wp_posts LEFT JOIN wp_postmeta ON wp_postmeta.post_id = wp_posts.ID AND wp_postmeta.meta_key = '_thumbnail_id'
WHERE wp_posts.post_type='post' AND wp_posts.post_status='publish' LIMIT 2");
    var_dump($rowcount);
    include_once(ABSPATH . 'wp-admin/includes/image.php');
    foreach ($result as $item) {
        $resultImage = $mydb->get_row("SELECT * FROM wp_posts WHERE ID ='" . $item->meta_value . "'");

        $post_id = wp_insert_post(array(
            'post_type' => 'post',
            'post_title' => $item->post_title,
            'post_content' => $item->post_content,
            'post_date_gmt' => $item->post_date_gmt,
            'post_excerpt' => $item->post_excerpt,
//	'post_name'      => <the name>,
            'post_status' => 'publish',
            'post_category' => array(1),
            'tags_input' => array('tag'),
        ));


//        $attachment_id = media_handle_upload('image', $post_id);
//        set_post_thumbnail( $post_id, $attachment_id );


        $imageurl = $resultImage->guid;
        $mime = explode('/', getimagesize($imageurl)['mime']);
        $imagetype = end($mime);
//        $uniq_name = date('dmY').''.(int) microtime(true);
        $filename = $resultImage->post_title . '.' . $imagetype;
        $uploaddir = wp_upload_dir();
        $uploadfile = $uploaddir['path'] . '/' . $filename;
        $contents = file_get_contents($imageurl);
        if (file_exists($uploadfile)) {
            $filename = $resultImage->post_title . date('dmY') . '.' . $imagetype;
            $uploadfile = $uploaddir['path'] . '/' . $filename;
        }
        $savefile = fopen($uploadfile, 'w');
        fwrite($savefile, $contents);
        fclose($savefile);
        $wp_filetype = wp_check_filetype(basename($filename), null);
        $attachment = array(
//            'guid' => $uploaddir . '/' . basename( $filename ),
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment($attachment, $uploadfile);
        $imagenew = get_post($attach_id);
        $fullsizepath = get_attached_file($imagenew->ID);
        $attach_data = wp_generate_attachment_metadata($attach_id, $fullsizepath);
        wp_update_attachment_metadata($attach_id, $attach_data);


        set_post_thumbnail($post_id, $attach_id);
        pll_set_post_language($post_id, 'da');

    }

}
