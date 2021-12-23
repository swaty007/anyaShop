<?php
get_header(); ?>
    <section class="page page--err page--center section--blue text-center">
        <div class="container page__container">
            <img class="page__img" src="<?= get_template_directory_uri(); ?>/images/404.png" alt="404"/>
            <div class="fourth-title text-bold text-center"><?php pll_e("Такой страницы не найдено :(");?></div>
            <div class="sixth-title page__subtitle text-center"><?php pll_e("Возможно она была удалена или изменила адрес");?></div>
            <a href="<?= pll_home_url();?>" class="btn"><?php pll_e("Вернуться на главную");?></a>
        </div>
    </section>
<?php get_footer();
?>
