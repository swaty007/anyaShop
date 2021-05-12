<?php
/*
Plugin Name: Import Xml
Author: Alex Lialiushko
Version: 2.00
*/


add_action( 'admin_bar_menu', 'import_xml_admin_bar', 500 );
function import_xml_admin_bar ( WP_Admin_Bar $admin_bar ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $admin_bar->add_menu( array(
        'id'    => 'akeneo-import',
        'parent' => null,
        'group'  => null,
        'title' => 'Import XML', //you can use img tag with image link. it will show the image icon Instead of the title.
        'href'  => '/wp-content/plugins/'.basename( plugin_dir_path(__FILE__ ) ).'/akeneo-cron.php',
        'meta' => [
            'title' => __( 'Run Import XML', 'textdomain' ), //This title will show on hover
            'target' => "_blank"
        ]
    ) );
}

add_action('product_cat_edit_form_fields', function($term){
    ?>
<!--    <input type="text" name="" readonly="" value="--><?//=get_term_meta($term->term_id, 'akeneo_slug', true)?><!--">-->
    <?php
});

class AkeneoImporter{
    private $languages = []; // Array for collection of WPML languages
    private $categories = []; // Array for collection prepared categories
    private $products = []; // Array for collection prepaired products
    private $raw= [];

    function __construct(){ // Contructor

//        $langs = icl_get_languages(); // Get languages from WPML
//        foreach ($langs as $lang){ $this->languages[$lang['default_locale']] = $lang; } // Prepare languages for work
        echo "Importing Categories .... </br>";
        $this->importCategories(); //Make iport of categories
        $this->set_term_parents();
        echo "Importing Products .... </br>";
        $this->importProducts(); //Make import for product
        echo "Finished Importing Products .... </br>";

    }

    function productExists($lang, $sku){ // Product exists method
        $posts = get_posts(['post_type'=>'product', 'post_status'=> array('publish', 'draft') , 'posts_per_page'=>-1, 'meta_query'=>[['key'=>'_sku', 'compare'=>'=', 'value'=>$sku]]]); // Get products by sku
        if(empty($posts)) return false; // if emty return false
        $translation = icl_object_id( $posts[0]->ID, 'product', false, $this->languages[$lang]['code'] ); // get post id for language
        //echo $lang.' - '.$sku.' - '.$translation; // Debug data
        return $translation; // !empty($translation);
    }

    function categoryExists($lang, $akeneo_slug){ // Category exists method

        $lang = $this->languages[$lang]['code']; // Get language from lang data array

        $terms = get_terms(['hide_empty'=>false, 'taxonomy'=>'product_cat', 'meta_query'=>[
            'key'=>'akeneo_slug',
            'value'=>$akeneo_slug,
            'compare'=>'='
        ]]); // Get category by akeneo slug
        $termsOut = []; // Initialize array for preparing categories
        foreach ($terms as $term) {
            $langTerm = apply_filters('wpml_object_id', $term->term_id, 'product_cat', false, $lang); // Get id of translation of product
            if($langTerm) $termsOut[] = get_term($langTerm); // if term exists, add to array
        }
        return (empty($termsOut))?false:$termsOut; // return empty or array of terms
    }


    function importProducts(){

        global $sitepress; // Global wpml

        echo 'Found Total Products : ' . count($this->products);
        echo '<div style="height:250;overflow:scroll"><pre>'; print_r($this->products); echo '</pre></div>';
        //exit();
        foreach ($this->products as $product) {

            echo "<h4>Processing Product : {$product['sku']}</h4>";
            if (! $product['enabled'] == 1) {
                echo 'Skiping product is not enabled <br/>';
                continue;
            }
            $mainPostId = 0; // Def post id
            $trId = 0; // Def translation id
            $thumbnailId = 0; // Dev thumbnail id
            foreach ($this->languages as $lang => $langData) { //foreach data for every installed language

                echo "<p style='color:green'>Trying to Save Product in {$lang} Language </p>";



                $post = [
                    'post_title'=>$product['title'][$lang],
                    'post_content'=>$product['description'][$lang],
                    'post_status'=>'publish',
                    'post_type'=>'product'
                ]; // Preapre data array for insert post



                if (! $product['show_in_website'] == 1 ) {$post['post_status'] = "draft";}

                $postId = 0;
                $postId = $this->productExists($lang, $product['sku']);
                var_dump('post_id' . $postId);
                if(!$postId){ // Check if product exists
                    echo '<p style="color:blue">Product Not found creating new. </p>';
                    $postId = wp_insert_post($post); // Insert post and get od

                    if($mainPostId == 0){ // if post id is empty set default current
                        $mainPostId = $postId;
                        $trId = $sitepress->get_element_trid($mainPostId);
                    }
                    $sitepress->set_element_language_details($postId, 'post_product', $trId, $langData['code']); //set translations relationship
                    update_post_meta($postId, '_sku', $product['sku']); // write sku to post meta

                    if(!empty($product['image'])){ // if not empty image link, generating image
                        $this->generateFeaturedImage($product['image'], $postId); //Call set image method
                    }
                    if(!empty($product['gallery_images'])){
                        echo '<p>adding gallery images</p>';
                        foreach($product['gallery_images'] as $img){
                            echo "<p>adding gallery image: {$img}</p>";
                            $this->generateFeaturedImage($img, $postId , false);
                        }
                    }

                }else{
                    echo "<p style='color:blue'>Product Exists, Post id : {$postId}  Updating. </p>";
                    $post['ID'] = $postId;
                    wp_update_post($post);
                    echo '<br/> Adding meta';
                }

                update_post_meta($postId, '_regular_price', $product['price']); // write price
                update_post_meta($postId, '_price', $product['price']); // write price
                update_post_meta($postId, '_short_description', $product['description'][$lang]); //write shirt description
                update_post_meta($postId, 'application', $product['application'][$lang]); // write applications

                update_field( 'tab_-__how_to_apply', $product['application'][$lang], $postId );
                update_field( '_description', $product['description'][$lang], $postId );
                update_field( 'tab_-_ingredients', $product['ingredients'][$lang], $postId );
                update_field( 'ingredients', $product['full_ingredients'][$lang], $postId );

                update_field( 'size', $product['weight_text'], $postId );
                update_field( 'application', $product['application'][$lang], $postId );
                update_field( 'benefits', $product['benefits'][$lang], $postId );
                update_field( 'use_with', $product['use_with'][$lang], $postId );
                update_field( 'effectivness', $product['effectiveness'][$lang], $postId );
                update_field( 'youtube_video_url', $product['video_url_2'][$lang], $postId );

                if(!empty($product['categories'])){ // if not empty categories set categories for inserted product
                    $cat_ids = [];
                    foreach ($product['categories'] as $category) {

                        $slug = $category.'-'. $this->languages[$lang]['code'];
                        echo '<p>Assigning category '. $slug;
                        $term = get_term_by('slug', $slug , 'product_cat');
                        if(!$term ) echo 'term not found';
                        //$term = $this->get_term_by_name_and_language($category, 'product_cat', $this->languages[$lang]['code'] );
                        if(!empty($term)){
                            wp_set_post_terms($postId, [$term->term_id], 'product_cat', true);
                            $cat_ids[] = $term->term_id;
                        }
                    }
                    $p = wc_get_product($postId);
                    $p->set_category_ids($cat_ids);
                    $p->save();


                }
            }
        }

    }
    function get_term_by_name_and_language($name, $taxonomy, $lang){
        $term = get_term_by('name', $name , $taxonomy);

        if($term != false){
            $term_id = $term->term_id;
            $term_id = apply_filters( 'wpml_object_id', intval($term_id) , $taxonomy , false , $lang  );
            //mediart_logs($lang . ' term ID ' . $term_id );
            if ($term_id > 0 )
                $translated_term = get_term_by('id', $term_id , $taxonomy);

            return $translated_term;
        }
        return false;
    }
    function set_term_parents(){
        global $sitepress;
        foreach ($this->languages as $lang=>$langdata){

            $sitepress->switch_lang($langdata['code']);

            echo '<h3>Setting Category Parents</h3>';
            $terms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => false, 'suppress_filters' => false
            ) );
            foreach ($terms as $term){
                //if ( isset( $term->parent ) ) continue;
//                echo "<h4>Setting parent for {$term->name} , {$term->slug}</h4>";
                $parent_slug = get_term_meta($term->term_id, 'term_parent' , true);
                if ($parent_slug) {
                    echo "<br/> Parent slug is {$parent_slug} ";
                    $parent_term = get_term_by('slug' , $parent_slug , 'product_cat' );
                    if (!$parent_term){
                        echo '<br/> Parent '. $parent_slug. ' not found';
                    }else{
                        echo "<br/> Parent term id {$parent_term->term_id}";
                        $result = wp_update_term( $term->term_id, 'product_cat', array('parent' => $parent_term->term_id) );
                    }

                }else{
//                    echo '<br/> meta not found';
                }
            }
            echo '<br/> finish set_term_parents';
        }
    }
    function importCategories(){

        global $sitepress; // Global wpml

        $finalCategories = $this->raw[get_field('main_category', 'option')] ;
        echo 'Parent Category : ' . get_field('main_category', 'option') . '<br/>';
        echo 'Total Categories in tree : ' . count($finalCategories);
        echo '<div style="height:250;overflow:scroll"><pre>';
        print_r($finalCategories); echo '</pre></div>';
        //exit();

        echo '<div style="height:250;overflow:scroll">';
        foreach ($finalCategories as $category) { // Foreach categories

            echo 'Processing Category <br/>';

            $titles= $category['title'];
            $first_cat = reset($titles);
            $first_lang = Key($titles);
            $term = $this->get_term_by_name_and_language($first_cat, 'product_cat', $this->languages[$first_lang]['code'] );
            if (!$term ){

                echo "Creating Category {$first_cat}  {$this->languages[$first_lang]['code'] }<br/>";

                $result = wp_insert_term($first_cat, 'product_cat' , ['slug'=>$category['meta_akeneo_slug'][$first_lang].'-'. $this->languages[$first_lang]['code']]  );
                $trId = $sitepress->get_element_trid($result['term_id'], 'tax_product_cat');
                //echo "trid for english id " . $trId . '<br/>';
                update_term_meta($result['term_id'], 'term_parent', $category['parent'][$first_lang].'-'. $this->languages[$first_lang]['code']);
                $sitepress->set_element_language_details($insearted_term_id, 'tax_product_cat', $trId, $this->languages[$lang]['code'], $sitepress->get_default_language()); // Set translation

                foreach($category['title'] as $lang=>$cat){
                    if ( $lang == $first_lang) continue;

                    echo "Creating Category {$cat}  {$this->languages[$lang]['code'] }<br/>";

                    //if (! term_exists($cat, 'product_cat') ) {
                    $result = wp_insert_term($cat.'_'.$lang, 'product_cat', ['slug'=>$category['meta_akeneo_slug'][$lang].'-'. $this->languages[$lang]['code']] );
                    if (is_wp_error($result))	{print_r($result) ; exit();}
                    $insearted_term_id = $result['term_id'];
                    $result = wp_update_term( $insearted_term_id, 'product_cat', array('name' => $cat,) );

                    update_term_meta($insearted_term_id, 'term_parent', $category['parent'][$lang].'-'. $this->languages[$lang]['code']);

                    update_term_meta($insearted_term_id, 'akeneo_slug', $category['meta_akeneo_slug'][$lang]); // Update akeneo slug
                    $sitepress->set_element_language_details($insearted_term_id, 'tax_product_cat', $trId, $this->languages[$lang]['code'], $sitepress->get_default_language()); // Set translation

                }

            }else{
                echo 'Category already exists <br/>';
            }
        }
        echo '</div>';
    }

    function generateFeaturedImage($image_url, $post_id, $featured = true){ // Set iamge method
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($image_url);
        $filename = 'thumb_'.$post_id.'.png';
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);

        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => 'thumb_'.$post_id,
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
        if ($featured) {
            $res2= set_post_thumbnail( $post_id, $attach_id );
        }else{
            /// save as gallery image
            $gallery = get_post_meta($post_id, '_product_image_gallery');
            if(!empty($gallery)) {
                $galleryItems = explode(",", $gallery);
                $galleryItems[] = $attach_id;
            } else {
                $galleryItems = [$attach_id];
            }
            update_post_meta($post_id, '_product_image_gallery', join(',', $galleryItems));
        }
    }

}
function akeneo_import_init(){
    new AkeneoImporter();
    exit();
}
add_action('wp_ajax_akeneo_import', 'akeneo_import_init');
