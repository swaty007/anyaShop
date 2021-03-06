<?php

get_header();
?>
<div class="wrapper">
    <?php
    while (have_posts()):
        the_post(); ?>
        <section class="page section--blue vh100 py-5">
            <div class="container">
                <h1 class="title__xl my-5">
                    <?php the_title(); ?>
                </h1>
                <div class="wordpress__content">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

    <?php endwhile;
    ?>
</div>
<?php
get_footer();

?>
