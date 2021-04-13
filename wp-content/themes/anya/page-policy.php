<?php
/* Template Name: Privacy Policy */

get_header();
the_post();
?>


    <section class="page section--blue">
        <div class="container">
            <h1 class="title text-center page__title">
                <?php the_title();?>
            </h1>
            <div class="">
                <?php while (have_rows('content')): the_row();?>
                    <div class="page__item fromBottom">
                        <div class="page__item-header">
                            <div class="sixth-title text-medium"><?php the_sub_field('title') ?></div>
                            <div class="btn-plus page__item-btn-plus"></div>
                        </div>
                        <div class="page__item-body">
                            <?php the_sub_field('text') ?>
                        </div>
                        <!--<div class="text-md page__item-text">-->

                        <!--</div>-->
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

    </section>


<?php
get_footer();
