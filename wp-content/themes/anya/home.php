<?php


get_header('dark');
//the_post();
?>


    <section class="blog">
        <div class="container">
            <br>
            <br>
            <br>
            <br>
            <h1 class="title__xl text__white"><?php single_post_title(); ?></h1>
        </div>
    </section>

    <section class="banners news">
        <div class="container banners-title">
            <div class="row">
                <div class="col-md-12">
<!--                    <h2>--><?php //pll_e("Наши публикации"); ?><!--</h2>-->
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                    <?php
                    while (have_posts()) : the_post(); ?>

                        <div class="banner col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                            <a href="<?php the_permalink(); ?>" class="d-block">
                                <img width="100%" height="100%" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                <div class="hover transition-3s"></div>
                                <div class="description">
                                    <h4 class="description__title"><?php the_title(); ?></h4>
                                    <div><?= mb_substr(get_the_excerpt(), 0, 90); ?>...</div>
                                </div>
                            </a>
                        </div>

                    <?php endwhile;
                    wp_reset_query(); ?>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php the_posts_pagination([
                        'prev_text' => '&lsaquo;',//&laquo;
                        'next_text' => '&rsaquo;'//&raquo;
                    ]); ?>
                    <!--                    <button class="view-more-btn transition-3s">Загрузить еще (9)</button>-->
                </div>
            </div>
        </div>
    </section>


<!--    <script type="text/javascript">-->
<!--        window.addEventListener('load', function () {-->
<!---->
<!--            $('.responsive').slick({-->
<!--                dots: true,-->
<!--                infinite: false,-->
<!--                speed: 300,-->
<!--                slidesToShow: 3,-->
<!--                slidesToScroll: 1,-->
<!--                // centerPadding: '60px',-->
<!--                responsive: [-->
<!--                    {-->
<!--                        breakpoint: 1024,-->
<!--                        settings: {-->
<!--                            slidesToShow: 2,-->
<!--                            slidesToScroll: 1,-->
<!--                            infinite: true,-->
<!--                            dots: true-->
<!--                        }-->
<!--                    },-->
<!--                    {-->
<!--                        breakpoint: 600,-->
<!--                        settings: {-->
<!--                            slidesToShow: 1,-->
<!--                            slidesToScroll: 1-->
<!--                        }-->
<!--                    },-->
<!--                    {-->
<!--                        breakpoint: 480,-->
<!--                        settings: {-->
<!--                            slidesToShow: 1,-->
<!--                            slidesToScroll: 1-->
<!--                        }-->
<!--                    }-->
<!--                    // You can unslick at a given breakpoint now by adding:-->
<!--                    // settings: "unslick"-->
<!--                    // instead of a settings object-->
<!--                ]-->
<!--            });-->
<!--        })-->
<!---->
<!--    </script>-->

<?php
get_footer('dark');
