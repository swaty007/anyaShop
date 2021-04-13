<?php


get_header('dark');
//the_post();
?>


    <section class="blog">
        <div class="container">
            <h1 class="title__xl text__white"><?php single_post_title(); ?></h1>
        </div>
    </section>

    <section class="blog__content">
        <div class="container">

            <div class="blog__items--wrap">
                <h3 class="title__sm mb-2">
                    <?php pll_e("Industrial tests"); ?>
                </h3>
                <div class="blog__items">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                        <?php
                        $loop = new WP_Query(array(
                                'post_type' => 'youtube',
                                'posts_per_page' => 8,
                                'paged' => !empty($_GET['page_youtube']) ? $_GET['page_youtube'] : 1,
                            )
                        );
                        while ($loop->have_posts()) : $loop->the_post(); ?>
                            <div class="col blog__item">
                                <?php //the_modified_time('F jS, Y'); ?>
                                <?php $href = get_post_meta( $post->ID, 'href', true );?>
                                <a class="block__item--link" href="<?= $href ;?>" data-fancybox>
                                    <?php
                                    $imageUrl = get_the_post_thumbnail_url();
                                    if (empty($imageUrl)) {
                                        parse_str( parse_url( $href, PHP_URL_QUERY ), $youtubeArray );
                                        $videoId = $youtubeArray['v'];
                                        $imageUrl = "https://img.youtube.com/vi/$videoId/0.jpg";
                                    }?>
                                    <img src="<?= $imageUrl; ?>" class="blog__item--img blog__item--img-small">
                                    <h4 class="title__xm">
                                        <?php the_title(); ?>
                                    </h4>
                                </a>
                            </div>
                        <?php endwhile;
                        wp_reset_query(); ?>
                    </div>
                    <?php if ($loop->found_posts > 8): ?>
                    <div class="row">
                        <div class="col">
                            <div class="pagination">
                                <?= paginate_links(array(
//                'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?page_youtube=%#%',
                                    'current' => max(1, !empty($_GET['page_youtube']) ? $_GET['page_youtube'] : 1),
                                    'total' => $loop->max_num_pages,

                                    'prev_text' => '&lsaquo;',//&laquo;
                                    'next_text' => '&rsaquo;'//&raquo;
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!--                <div class="text-right">-->
                <!--                    <div class="blog__more title__xm">-->
                <!--                        <a href="#" class="blog__more--btn">-->
                <!--                            --><?php //pll_e("All tests"); ?>
                <!--                        </a>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>

            <div class="blog__items--wrap">
                <h3 class="title__sm mb-2">
                    <?php pll_e("Articles"); ?>
                </h3>
                <div class="blog__items">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3">
                        <?php
                        $loop = new WP_Query(array(
                                'post_type' => 'post',
                                'posts_per_page' => 8,
                                'paged' => !empty($_GET['page_post']) ? $_GET['page_post'] : 1,
                            )
                        );
                        while ($loop->have_posts()) : $loop->the_post(); ?>
                            <div class="col blog__item">
                                <?php //the_modified_time('F jS, Y'); ?>
                                <a class="block__item--link" href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url(); ?>" class="blog__item--img">
                                    <h4 class="title__xm">
                                        <?php the_title(); ?>
                                    </h4>
                                </a>
                            </div>
                        <?php endwhile;
                        wp_reset_query(); ?>
                    </div>
                    <?php if ($loop->found_posts > 8): ?>
                    <div class="row">
                        <div class="col">
                            <div class="pagination">
                                <?= paginate_links(array(
//                'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format' => '?page_post=%#%',
                                    'current' => max(1, !empty($_GET['page_post']) ? $_GET['page_post'] : 1),
                                    'total' => $loop->max_num_pages,

                                    'prev_text' => '&lsaquo;',//&laquo;
                                    'next_text' => '&rsaquo;'//&raquo;
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
<!--                <div class="text-right">-->
<!--                    <div class="blog__more title__xm">-->
<!--                        <a href="#" class="blog__more--btn">-->
<!--                            --><?php //pll_e("All articles"); ?>
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

        </div>
    </section>

<?php
get_footer('dark');
