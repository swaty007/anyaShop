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
                    'compare' => 'LIKE',
                    'value' => $sku,
                ],
            ],
        ]);

        if (empty($posts)) {
            wp_send_json([
                'error' => '404',
                'value' => $sku,
            ]);
        } else {
            $post_id = $posts[0]->ID;
        }

        $attachments = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_list_name',
                    'value' => $listName,
                ],
                [
                    'key' => '_img_name',
                    'value' => $imgFile['name'],
                ],
            ]
        ]);

//        wp_send_json([
//            $posts,
//            $attachments,
//        ]);

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
//            wp_send_json("Attach finded $attach_id");
        }

        $post_thumbnail = get_post_meta($post_id, '_thumbnail_id', true);
        if (empty($post_thumbnail)) {
//            update_post_meta($post_id, '_thumbnail_id', $attach_id);
            set_post_thumbnail($post_id, $attach_id);
        } elseif ((int)$post_thumbnail !== $attach_id) {
            $gallery = get_post_meta($post_id, '_product_image_gallery', true);
            if (!empty($gallery)) {
                $galleryItems = explode(",", $gallery);
                if (in_array($attach_id, $galleryItems)) {
                    wp_send_json($attach_id);
                }
                $galleryItems[] = $attach_id;
            } else {
                $galleryItems = [$attach_id];
            }
            update_post_meta($post_id, '_product_image_gallery', implode(',', array_unique($galleryItems)));
        }


        wp_send_json($attach_id);
    } catch (Exception $e) {
        wp_send_json([
            'error' => '404',
            'value' => "Catch Error: {$e->getMessage()}",
        ]);
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