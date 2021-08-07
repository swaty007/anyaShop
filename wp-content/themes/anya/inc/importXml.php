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
//        return;
        $this->loadData();
        $this->importCategories();
        $this->set_categories_parents();
//        $this->updateProductsPriceStock();
        $this->importProducts();
    }

    function loadData()
    {
        $xml = simplexml_load_file(get_template_directory_uri() . '/datafile2.xml', 'SimpleXMLElement');

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
        unset($xml);
        unset($xmlCategories);
    }

    function updateProductsPriceStock()
    {
        foreach ($this->products as $product) {
            $sku = $product['id']->__toString();
            $post_id = $this->productExists($sku);
            if ($post_id) {
                update_post_meta($post_id, '_regular_price', $product->price->__toString());
                $productWp = wc_get_product($post_id);
                $productWp->set_manage_stock(true);
                wc_update_product_stock($post_id, $product->stock_quantity->__toString());
                $productWp->save();
            }
            unset($product);
        }
        unset($this->products);
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
                // TODO: Image parsing to long
//                $this->generateFeaturedImage($product->picture, $post_id);
//                continue;


                $productWp = wc_get_product($post_id);
                $attributes = $productWp->get_attributes();
                foreach ($product->param as $parameter) {
                    $paramName = $parameter['name']->__toString();
                    $paramValue = $parameter->__toString();


                    $attribute = $paramName;
                    $taxonomy_name = "pa_" . apply_filters('sanitize_title', $attribute);
                    $taxonomy_name = mb_substr(wc_attribute_taxonomy_name($attribute), 0, 29, 'utf-8');
                    $taxonomy_slug = mb_substr(apply_filters('sanitize_title', $attribute), 0, 26, 'utf-8');


                    if (!taxonomy_exists($taxonomy_name)) {
                        $taxonomy_id = wc_create_attribute( // создать атрибут
                            [
                                'name' => $attribute,
                                'type' => "select", // text
                                'slug' => $taxonomy_slug, // text
                            ]
                        );
                        if (is_wp_error($taxonomy_id)) {
                            var_dump($taxonomy_id);
                            die();
                        }
                        register_taxonomy($taxonomy_name, ['product'], []);
//                    WC_Post_Types::register_taxonomies();
                    } else {
//                    WC_Post_Types::register_taxonomies();
                        $taxonomy_id = wc_attribute_taxonomy_id_by_name($taxonomy_name);
                    }


                    $termsArr = [];
                    foreach (explode(", ", $paramValue) as $term_name) {
                        if (empty($term_name)) continue;

                        $term_id = term_exists($term_name, $taxonomy_name);
                        if (!$term_id) {
                            $term_id = wp_insert_term($term_name, $taxonomy_name);
                            if (is_wp_error($term_id)) {
                                if ($term_id->error_data['term_exists']) {
                                    $term_id = $term_id->error_data['term_exists'];
                                } else {
                                    var_dump($term_id);
                                    var_dump($term_name);
                                    var_dump($taxonomy_name);
                                    var_dump(term_exists($term_name, $taxonomy_name));
                                    die();
                                    continue;
                                }
                            } else {
                                $term_id = (int)$term_id['term_id'];
                            }
                        } else {
                            $term_id = (int)$term_id['term_id'];
                        }
                        $termsArr[] = $term_id;

                        if (!has_term($term_id, $taxonomy_name, $post_id)) {
//                        var_dump('didnt has');
                            wp_set_object_terms($post_id, $term_id, $taxonomy_name, true);
                        }
                    }

                    $attributes[] = $this->pricode_create_attributes($taxonomy_name, $termsArr, $taxonomy_id);
                    unset($parameter);
                }
                $productWp->set_attributes($attributes);
                unset($attributes);

                $category_id = $product->categoryId->__toString();
                if ($category_id) {
                    $cat_ids = [];
                    $product_category_terms = get_terms([
                        'hide_empty' => false,
                        'taxonomy' => 'product_cat',
                        'meta_query' => [
                            'key' => 'xml_id',
                            'value' => $category_id,
                            'compare' => '='
                        ]]);
                    if (!empty($product_category_terms)) {
                        foreach ($product_category_terms as $product_term) {
                            $cat_ids[] = $product_term->term_id;
//                            wp_set_post_terms($post_id, [$product_term->term_id], 'product_cat', true);
                        }
                        $productWp->set_category_ids($cat_ids);
                    }
                }

            } else {
                $productWp = wc_get_product($post_id);
            }
            // TODO: Image parsing to long
//            $this->generateFeaturedImage($product->picture, $post_id);
//            continue;

            update_post_meta($post_id, '_regular_price', $product->price->__toString());
            update_post_meta($post_id, '_price', $product->price->__toString());


//            var_dump($product->vendor->__toString());


            $productWp->set_manage_stock(true);
            $productWp->save();
//            $productWp->set_price($product->price->__toString());
            wc_update_product_stock($post_id, $product->stock_quantity->__toString());


            unset($product);
        }
        unset($this->products);
    }

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


    function importCategories()
    {
        $n = 0;
        foreach ($this->categories as &$category) {
            $term = get_term_by('name', $category['name'], 'product_cat');
            if (!empty($term)) {
                $term_id = $term->term_id;
            } else {
                $result = wp_insert_term($category['name'], 'product_cat');
                var_dump("result", $result);
                $term_id = $result['term_id'];
                $n++;
            }

            update_term_meta($term_id, 'xml_id', $category['id']);
            if (!empty($category['parent_id'])) {
                update_term_meta($term_id, 'term_parent', $category['parent_id']);
            }
        }
        unset($category);
        unset($this->categories);
    }

    function set_categories_parents()
    {
        $categories = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'suppress_filters' => false,
        ]);
        foreach ($categories as $category) {
            $parent_id = get_term_meta($category->term_id, 'term_parent', true);
            if ($parent_id) {

                $parent_terms = get_terms([
                    'hide_empty' => false,
                    'taxonomy' => 'product_cat',
                    'meta_query' => [
                        'key' => 'xml_id',
                        'value' => $parent_id,
                        'compare' => '='
                    ]]);


                if (!empty($parent_terms)) {
                    foreach ($parent_terms as $parent_term) {
                        if ($parent_term->term_id !== $category->parent) {
                            $result = wp_update_term($category->term_id, 'product_cat', ['parent' => $parent_term->term_id]);
                        }
                    }
                } else {
                    echo '<br/> Parent ' . $parent_id . ' not found';
                }

            }
        }
        unset($categories);
    }


    function productExists($sku)
    {
        $posts = get_posts([
            'post_type' => 'product',
            'post_status' => ['publish', 'draft'],
            'posts_per_page' => -1,
            'meta_query' => [
                [
                    'key' => '_sku',
                    'compare' => '=',
                    'value' => $sku,
                ]
            ]
        ]); // Get products by sku
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


                $imageurl = str_replace("?dl=0", "", $src);
                $mime = explode('/', getimagesize($imageurl)['mime']);
                $imagetype = end($mime);

                $filename = "product_$post_id." . $imagetype;
                if (empty($imagetype)) {
                    continue;
                }
                $uploaddir = wp_upload_dir();
                $uploadfile = $uploaddir['path'] . '/' . $filename;

                if (file_exists($uploadfile)) {
                    $filename = "product_$post_id." . date('dmY') . '.' . $imagetype;
                    $uploadfile = $uploaddir['path'] . '/' . $filename;
                }
                $contents = file_get_contents($imageurl);
                $savefile = fopen($uploadfile, 'w');
                fwrite($savefile, $contents);
                fclose($savefile);
                $wp_filetype = wp_check_filetype(basename($filename), null);
                $attachment = [
//            'guid' => $uploaddir . '/' . basename( $filename ),
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => $filename,
                    'post_content' => $imageurl,
                    'post_status' => 'inherit',
                ];
                $attach_id = wp_insert_attachment($attachment, $uploadfile); //,$post_id
                $imagenew = get_post($attach_id);
                $fullsizepath = get_attached_file($imagenew->ID);
                $attach_data = wp_generate_attachment_metadata($attach_id, $fullsizepath);
                wp_update_attachment_metadata($attach_id, $attach_data);


                if ($n === 0) {
                    set_post_thumbnail($post_id, $attach_id);
                } else {
                    $gallery = get_post_meta($post_id, '_product_image_gallery', true);
                    if (!empty($gallery)) {
                        var_dump("gallery");
                        var_dump($gallery);
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
