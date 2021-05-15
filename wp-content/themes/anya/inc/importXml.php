<?php
/*
Plugin Name: Import Xml
Author: Alex Lialiushko
Version: 2.00
*/


add_action('admin_bar_menu', 'import_xml_admin_bar', 500);
function import_xml_admin_bar(WP_Admin_Bar $admin_bar)
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $admin_bar->add_menu(array(
        'id' => 'akeneo-import',
        'parent' => null,
        'group' => null,
        'title' => 'Import XML', //you can use img tag with image link. it will show the image icon Instead of the title.
        'href' => '/wp-content/plugins/' . basename(plugin_dir_path(__FILE__)) . '/akeneo-cron.php',
        'meta' => [
            'title' => __('Run Import XML', 'textdomain'), //This title will show on hover
            'target' => "_blank"
        ]
    ));
}

add_action('product_cat_edit_form_fields', function ($term) {
    ?>
    <!--    <input type="text" name="" readonly="" value="--><?//=get_term_meta($term->term_id, 'akeneo_slug', true)?><!--">-->
    <?php
});

class ImportXML
{
    private $categories = []; // Array for collection prepared categories
    private $products = []; // Array for collection prepaired products

    function __construct()
    {
        $this->loadData();
        $this->importCategories();
//        $this->set_term_parents();
//        $this->importProducts();
    }

    function loadData()
    {
        $xml = simplexml_load_file(get_template_directory_uri() . '/test.xml', 'SimpleXMLElement');

//        $this->categories = $xml->shop->categories->category;
        $xmlCategories = $xml->shop->categories->category;
        foreach ($xmlCategories as $category) {
            $name = $category->__toString();
            $id = $category['id']->__toString();
            if (empty($category['parentld'])) {
                $parentId = null;
            } else {
                $parentId = $category['parentld']->__toString();
            }


            $this->categories[$id] = [
                'name' => $name,
                'id' => $id,
                'parent_id' => $parentId,
                'term_id' => null,
            ];
        }

        $this->products = $xml->shop->offers->offer;
    }


    function importProducts()
    {


        foreach ($this->products as $product) {


            $post = [
                'post_title' => $product->name->__toString(),
                'post_content' => trim($product->description->__toString()),
                'post_status' => 'publish',
                'post_type' => 'product'
            ];

            if ($product['available']->__toString() != true) {
                var_dump('available fail');
//                $post['post_status'] = "draft";
            }

            $sku = $product['id']->__toString();
            $post_id = $this->productExists($sku);
            if (!$post_id) {
                $post_id = wp_insert_post($post);
                update_post_meta($post_id, '_sku', $sku);
                $this->generateFeaturedImage($product->picture, $post_id);
            }

            update_post_meta($post_id, '_regular_price', $product->price->__toString());
            update_post_meta($post_id, '_stock', $product->stock_quantity->__toString());

            var_dump($product->vendor->__toString());


            foreach ($product->param as $parameter) {
                $paramName = $parameter['name']->__toString();
                $paramValue = $parameter->__toString();


                $attribute = $paramName;
                $taxonomy_name = "pa_" . apply_filters('sanitize_title', $attribute);
                $taxonomy_name = wc_attribute_taxonomy_name($attribute);
                if (!taxonomy_exists($taxonomy_name)) {
                    $taxonomy_id = wc_create_attribute( // создать атрибут
                        [
                            'name' => $attribute,
                            'type' => "select", // text
                        ]
                    );
                } else {
                    $taxonomy_id = wc_attribute_taxonomy_id_by_name($taxonomy_name);
                }


                $term_name = $paramValue;
                if (!term_exists($term_name, $taxonomy_name)) {
                    $term_id = (int)wp_insert_term($term_name, $taxonomy_name)['term_id'];
                } else {
                    $term_id = (int)get_term_by('name', $term_name, $taxonomy_name)->term_id;
                }

                $product = wc_get_product($post_id);

                function pricode_create_attributes($name, $options, $taxonomy_id)
                {
                    $attribute = new WC_Product_Attribute();
                    $attribute->set_id($taxonomy_id);
                    $attribute->set_name($name);
                    $attribute->set_options($options);
                    $attribute->set_visible(true);
                    $attribute->set_variation(false);
                    return $attribute;
                }

                $attributes = $product->get_attributes();
                $attributes[] = pricode_create_attributes($taxonomy_name, [$term_id], $taxonomy_id);

                $product->set_attributes($attributes);
                $product->save();
                if (!has_term($term_id, $taxonomy_name, $post_id)) {
                    var_dump('didnt has');
                    wp_set_object_terms($post_id, $term_id, $taxonomy_name, true);
                }
            }


            var_dump($product->categoryId->__toString());
            if (!empty($product['categories'])) { // if not empty categories set categories for inserted product
                $cat_ids = [];
                foreach ($product['categories'] as $category) {

                    $slug = $category . '-' . $this->languages[$lang]['code'];
                    echo '<p>Assigning category ' . $slug;
                    $term = get_term_by('slug', $slug, 'product_cat');
                    if (!$term) echo 'term not found';
                    //$term = $this->get_term_by_name_and_language($category, 'product_cat', $this->languages[$lang]['code'] );
                    if (!empty($term)) {
                        wp_set_post_terms($postId, [$term->term_id], 'product_cat', true);
                        $cat_ids[] = $term->term_id;
                    }
                }
                $p = wc_get_product($postId);
                $p->set_category_ids($cat_ids);
                $p->save();
            }


            die();
        }

    }


    function importCategories()
    {
//        return;
        $n = 0;
        foreach ($this->categories as &$category) {
//            echo "<pre>";
//            return;
            var_dump("category", $category);
            $term = get_term_by('name', $category['name'], 'product_cat');
            var_dump("term", $term);
            if (!empty($term)) {
                $term_id = $term->term_id;
            } else {
                $result = wp_insert_term($category['name'], 'product_cat');
                var_dump("result", $result);
                $term_id = $result['term_id'];
                $n++;
            }
//            $taxonomy_name = "pa_" . apply_filters('sanitize_title', $attribute);


            update_term_meta($term_id, 'xml_id', $category['id']);
            if (!empty($category['parent_id'])) {
                update_term_meta($term_id, 'term_parent', $category['parent_id']);
            }
            return;
        }
        unset($category);
    }

    function set_term_parents()
    {


        echo '<h3>Setting Category Parents</h3>';
        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'suppress_filters' => false,
        ]);
        foreach ($terms as $term) {
            //if ( isset( $term->parent ) ) continue;
//                echo "<h4>Setting parent for {$term->name} , {$term->slug}</h4>";
            $parent_slug = get_term_meta($term->term_id, 'term_parent', true);
            if ($parent_slug) {
                echo "<br/> Parent slug is {$parent_slug} ";
                $parent_term = get_term_by('slug', $parent_slug, 'product_cat');
                if (!$parent_term) {
                    echo '<br/> Parent ' . $parent_slug . ' not found';
                } else {
                    echo "<br/> Parent term id {$parent_term->term_id}";
                    $result = wp_update_term($term->term_id, 'product_cat', array('parent' => $parent_term->term_id));
                }

            } else {
//                    echo '<br/> meta not found';
            }
        }
        echo '<br/> finish set_term_parents';
    }

    function categoryExists($lang, $akeneo_slug)
    {

        $lang = $this->languages[$lang]['code']; // Get language from lang data array

        $terms = get_terms(['hide_empty' => false, 'taxonomy' => 'product_cat', 'meta_query' => [
            'key' => 'akeneo_slug',
            'value' => $akeneo_slug,
            'compare' => '='
        ]]); // Get category by akeneo slug
        $termsOut = []; // Initialize array for preparing categories
        foreach ($terms as $term) {
            $langTerm = apply_filters('wpml_object_id', $term->term_id, 'product_cat', false, $lang); // Get id of translation of product
            if ($langTerm) $termsOut[] = get_term($langTerm); // if term exists, add to array
        }
        return (empty($termsOut)) ? false : $termsOut; // return empty or array of terms
    }


    function productExists($sku)
    {
        $posts = get_posts(['post_type' => 'product', 'post_status' => array('publish', 'draft'), 'posts_per_page' => -1, 'meta_query' => [['key' => '_sku', 'compare' => '=', 'value' => $sku]]]); // Get products by sku
        if (empty($posts)) {
            return false;
        }
        return $posts[0]->ID;
//        $translation = icl_object_id($posts[0]->ID, 'product', false, $this->languages[$lang]['code']); // get post id for language
    }

    function generateFeaturedImage($images, $post_id)
    { // Set iamge method

        include_once(ABSPATH . 'wp-admin/includes/image.php');
        $n = 0;
        foreach ($images as $image) {
            $src = $image->__toString();
            if (!empty($src)) {


                $imageurl = $src;
                $mime = explode('/', getimagesize($imageurl)['mime']);
                $imagetype = end($mime);

                $filename = "product_$post_id." . $imagetype;
                $uploaddir = wp_upload_dir();
                $uploadfile = $uploaddir['path'] . '/' . $filename;
                $contents = file_get_contents($imageurl);
                if (file_exists($uploadfile)) {
                    $filename = "product_$post_id." . date('dmY') . '.' . $imagetype;
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
                $attach_id = wp_insert_attachment($attachment, $uploadfile); //,$post_id
                $imagenew = get_post($attach_id);
                $fullsizepath = get_attached_file($imagenew->ID);
                $attach_data = wp_generate_attachment_metadata($attach_id, $fullsizepath);
                wp_update_attachment_metadata($attach_id, $attach_data);


                if ($n === 0) {
                    set_post_thumbnail($post_id, $attach_id);
                } else {
                    $gallery = get_post_meta($post_id, '_product_image_gallery');
                    if (!empty($gallery)) {
                        $galleryItems = explode(",", $gallery);
                        $galleryItems[] = $attach_id;
                    } else {
                        $galleryItems = [$attach_id];
                    }
                    update_post_meta($post_id, '_product_image_gallery', join(',', $galleryItems));
                }

                $n++;
            }
        }
    }

}

function xml_import_init()
{
    new ImportXML();
    exit();
}

add_action('wp_ajax_akeneo_import', 'xml_import_init');
