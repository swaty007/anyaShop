<?php
get_header();
?>
<?php
 $term = get_queried_object();
 $term_id = $term->term_id;
 $color = get_term_meta($term->term_id, 'color', true);
 ?>
    <section>
        <div class="section--brand" style="background-color: <?= $color ;?>">
            <div class="container">
                <div class="card-list__banner">
                    <div class="card-list__banner-bg">
                        <svg width="1222" height="146" viewBox="0 0 1222 146" fill="none" xmlns="http://www.w3.org/2000/svg" style="filter: brightness(106%)">
                            <path d="M0.400001 143V2.99999H113V36H38.8V57.2H106V87.8H38.8V110H114V143H0.400001ZM133.798 143V2.99999H187.798C212.332 2.99999 231.598 9.39999 245.598 22.2C259.732 35 266.798 51.8 266.798 72.6C266.798 93.2667 259.665 110.2 245.398 123.4C231.132 136.467 211.665 143 186.998 143H133.798ZM172.598 108.6H188.398C200.132 108.6 209.465 105.467 216.398 99.2C223.465 92.9333 226.998 84.1333 226.998 72.8C226.998 61.7333 223.465 53 216.398 46.6C209.465 40.2 200.132 37 188.398 37H172.598V108.6ZM349.728 145.6C329.195 145.6 313.261 140.267 301.928 129.6C290.595 118.933 284.928 102.933 284.928 81.6V2.99999H324.328V80.8C324.328 90.6667 326.595 98.1333 331.128 103.2C335.795 108.133 342.128 110.6 350.128 110.6C358.128 110.6 364.395 108.2 368.928 103.4C373.595 98.6 375.928 91.4 375.928 81.8V2.99999H415.328V80.6C415.328 102.467 409.528 118.8 397.928 129.6C386.461 140.267 370.395 145.6 349.728 145.6ZM505.691 145.8C485.424 145.8 468.291 138.933 454.291 125.2C440.424 111.333 433.491 93.9333 433.491 73C433.491 52.4667 440.491 35.2 454.491 21.2C468.624 7.19999 486.224 0.199991 507.291 0.199991C532.224 0.199991 551.824 10.0667 566.091 29.8L537.691 51.8C529.024 41 518.757 35.6 506.891 35.6C497.157 35.6 489.157 39.2 482.891 46.4C476.624 53.6 473.491 62.4667 473.491 73C473.491 83.6667 476.624 92.6 482.891 99.8C489.157 106.867 497.157 110.4 506.891 110.4C513.691 110.4 519.491 109 524.291 106.2C529.091 103.267 533.824 99 538.491 93.4L567.691 114.2C560.357 124.2 551.824 132 542.091 137.6C532.357 143.067 520.224 145.8 505.691 145.8ZM573.184 143L632.784 1.99999H670.184L729.784 143H688.184L677.984 118H623.984L613.984 143H573.184ZM635.384 87.8H666.784L651.184 48L635.384 87.8ZM759.6 143V37H717.6V2.99999H840.4V37H798.4V143H759.6ZM858.231 143V2.99999H897.231V143H858.231ZM1047.06 124.6C1032.66 138.733 1014.73 145.8 993.261 145.8C971.794 145.8 953.861 138.8 939.461 124.8C925.194 110.667 918.061 93.4 918.061 73C918.061 52.7333 925.261 35.5333 939.661 21.4C954.194 7.26666 972.194 0.199991 993.661 0.199991C1015.13 0.199991 1032.99 7.26666 1047.26 21.4C1061.66 35.4 1068.86 52.6 1068.86 73C1068.86 93.2667 1061.59 110.467 1047.06 124.6ZM993.661 110.8C1004.19 110.8 1012.73 107.133 1019.26 99.8C1025.93 92.4667 1029.26 83.5333 1029.26 73C1029.26 62.6 1025.86 53.7333 1019.06 46.4C1012.26 38.9333 1003.66 35.2 993.261 35.2C982.861 35.2 974.328 38.8667 967.661 46.2C961.128 53.5333 957.861 62.4667 957.861 73C957.861 83.4 961.194 92.3333 967.861 99.8C974.661 107.133 983.261 110.8 993.661 110.8ZM1089.07 143V2.99999H1125.27L1182.87 77V2.99999H1221.27V143H1187.27L1127.47 66.2V143H1089.07Z"
                                  fill="<?= $color ;?>"/>
                        </svg>
                    </div>
                    <h1 class="card-list__banner-title title-lg text-bold"><?php single_term_title();?></h1>
                    <div class="card-list__banner-text">
                        <?= term_description($term);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="card-list card-list--direction">
        <div class="container card-list__container">
            <div class="card-list__top">
                <div class="tab">
                    <button class="tab__item text-medium tab__item--active" onclick="openTab(event, 'courses')"><?php pll_e("курсы");?></button>
                    <button class="text-medium tab__item" onclick="openTab(event, 'professions')"><?php pll_e("ПРОФЕССИИ");?></button>
                </div>
            </div>
            <div id="courses" class="tab__content">
                <div class="card-wrap">
                    <?php
                    $loop = new WP_Query(array(
                            'post_type' => 'courses',
                            'posts_per_page' => -1,
                            'tax_query' => [
                                [
                                    'taxonomy' => 'courses_category',
                                    'field' => 'term_id',
                                    'terms' => $term->term_id,
                                ],
                            ],
                            'orderby' => []
                        )
                    ); ?>
                    <?php while ($loop->have_posts()) : $loop->the_post();?>
                        <?php
                        set_query_var('course_id', $post->ID);
                        set_query_var('term_id', $term_id);
                        ?>
                        <?php get_template_part('template-parts/components', 'course-card'); ?>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>
            <?php
            $loop = new WP_Query(array(
                    'post_type' => 'professions',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => 'courses_category',
                            'field' => 'term_id',
                            'terms' => $term->term_id,
                        ],
                    ],
                    'orderby' => []
                )
            ); ?>
            <?php if($loop->found_posts):?>
            <div id="professions" class="tab__content" style="display:none;">
                <div class="card-wrap">

                    <?php while ($loop->have_posts()) : $loop->the_post();?>
                        <?php
                        set_query_var('course_id', $post->ID);
                        set_query_var('term_id', $term_id);
                        ?>
                        <?php get_template_part('template-parts/components', 'course-card'); ?>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>
            <?php endif;?>
        </div>
    </section>


    <script>
        function openTab(evt, tabName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tab__content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tab__item");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" tab__item--active", "");
            }

            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " tab__item--active";
        }
    </script>
<?php
get_footer();
