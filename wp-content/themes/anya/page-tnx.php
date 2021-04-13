<?php
/* Template Name: Thanks */

if (!empty($lang = $_COOKIE['fix_language'])) {
    PLL()->curlang = PLL()->model->get_language( $lang );
    setcookie('pll_language', $lang, time()+9999999, '/');
    add_filter('locale', function($language) {
        return PLL()->curlang->locale;
    });
}


get_header();
the_post();
?>


<section class="page page--center text-center section--blue">
    <div class="container page__container">
        <img src="<?= get_template_directory_uri(); ?>/images/panda.png" />
        
        <?php  if (get_field('is_trial') == 0 ){ ?>
            <h1 class="title text-center page__title">
            <?php pll_e("Заявка успешно отправлена!");?>
        </h1>
        <div class=" text-md text-center"><?php pll_e("Мы перезвоним вам в ближайшее время");?></div>

       <?php } else { ?>
        
            <h1 class="title text-center page__title">
            <?php pll_e("Мы получили твою заявку на запись урока!");?>
        </h1>
            <div class=" text-md text-center"><?php pll_e("Проверяй свой имейл - там будет ссылка на запись.");?></div>
            <div class=" text-md text-center"><?php pll_e("Обязательно проверь спам, если не найдешь наше письмо в общей папке.");?></div>
      <?php  }  ?>
       
        <a href="<?= pll_home_url();?>" class="btn page__btn"><?php pll_e("Вернуться на главную");?></a>
    </div>
</section>
<?php if ($_GET['yandex']):?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
          ym(69924283,'reachGoal','<?=$_GET['yandex'];?>')
        })
    </script>
<?php endif;?>


<?php
get_footer();