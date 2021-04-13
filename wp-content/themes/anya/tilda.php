<?php 
the_post();
/* Template Name: tilda*/
//  get_header();
// var_dump(get_the_category($post->id));
// var_dump(in_category('tilda'));
?>
    
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   
    <section id="tilda-content-block" class="tilda-content-block">
    <?= $content = apply_filters('the_content', get_post_field('post_content', $post->ID));?>

