<?php
get_header();
the_post(); ?>

<?php
$post_id = $post->ID;
$post_thumbnail_url = get_the_post_thumbnail_url();
$about_image = get_post_meta( $post->ID, 'about_image', true );
$is_free = get_post_meta($post_id, 'is_free', true);
$show_on_main = get_post_meta($post_id, 'show_on_main', true);
$cost = get_post_meta($post_id, 'cost', true);
$currency = get_post_meta($post_id, 'currency', true);
$date = get_post_meta($post_id, 'date', true); //repeater
$about = get_post_meta($post_id, 'about', true);
$questions = get_post_meta($post_id, 'questions', true); //repeater
$teachers = get_post_meta($post_id, 'teachers', true);
$education_formula = get_post_meta($post_id, 'education_formula', true); //repeater
$discount = get_post_meta($post_id,'discount', true);
$recommended_courses = get_post_meta($post_id, 'recommended_courses', true);
$script = get_post_meta($post_id, 'script_js', true);
if(!isset($_GET["getcourse"])){
    $_GET["getcourse"] ='';
}
 if(!empty($script) and $_GET["getcourse"]== 1 ):
    echo $script;?>
    <style>
    .header-fixed  {
        display: block !important;
    }
</style>
<?php
else:
?>

<section class="main main--course">
    <?php if(!empty($post_thumbnail_url)):?>
        <img src="<?= $post_thumbnail_url; ?>" class="main__bg-image main__bg-image--course" />
    <?php else:?>
        <img src="<?= get_template_directory_uri(); ?>/images/bg/table.png" class="main__bg-image main__bg-image--course">
    <?php endif;?>
    <div class="main__overlay"></div>
    <div class="container  main__container main__container--flex">
        <div class="main__block">
            <div class="text-md appear"><?php pll_e("ITEA webinar"); ?></div>
            <h1 class="title main__title main__title--course main__title--wide fadeFromLeft">
                <?php the_title(); ?>
            </h1>
            <!-- <div class="text-md main__subtitle main__subtitle--lg appear">
                <?php the_excerpt(); ?>
            </div> -->
            <div class="main__btns main__btns--hide">
                <?php if(empty($script)): ?>
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-consult.php')));?>?target_id=<?=$post_id;?>"
                   class="btn main__btn fromBottom zz--btn"><?php pll_e("Зарегистрироваться"); ?></a>
                <?php else:?>
                    <a href="<?= get_permalink();?>?getcourse=1"
                   class="btn main__btn fromBottom zz--btn"><?php pll_e("Зарегистрироваться"); ?></a>
                   <?php endif;?>
            </div>
        </div>
        <div class="main__table anim4">
            <div class="main__table-tr">
                <div class="main__table-label main__table-label--first"><?php pll_e("КОГДА"); ?></div>
                <div class="text-md main__table-title text-bold"><?php pll_e("Время"); ?></div>
                <?php $count = 0;
                while (have_rows('date')): the_row();
                    $count++; ?>
                    <div class="main__table-td">
                        <?= date_i18n( 'F j / H:i', strtotime(get_sub_field('date', false))); ?> <?php pll_e("по МСК");?>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="main__table-tr">
                <div class="main__table-label main__table-label--second"><?php pll_e("СКОЛЬКО"); ?></div>
               
                <?php if ($is_free): ?>
                    <div class="text-md main__table-title text-bold"><?php pll_e("Стоимость"); ?></div>
                    <div class="main__table-td main__table-td--label"><?php pll_e("Бесплатно"); ?></div>
                    <?php elseif($discount): ?>
                        <div class="main__table-title text-bold main__table-title--crossed"><?= $cost; ?> <?= $currency; ?></div>
                        <div class="main__table-title text-bold" ><?= $discount; ?> <?= $currency; ?></div>
                    <?php else: ?>
                    <div class="main__table-title text-bold"><?= $cost; ?> <?= $currency; ?></div>
               
                
                <?php endif; ?>
            </div>
            <div class="main__table-tr">
                <div class="main__table-label main__table-label--third"><?php pll_e("ГДЕ"); ?></div>
                <div class="text-md main__table-title text-bold"><?php pll_e("Формат"); ?></div>
                <div class="main__table-td"><?php pll_e("Онлайн-трансляция"); ?></div>
            </div>
        </div>
        <div class="main__btns main__btns--mob">
            <button class="btn main__btn fromBottom"><?php pll_e("Зарегистрироваться"); ?></button>
        </div>
    </div>
</section>
<section class="banner">
    <div class="container">
        <div class="banner__container banner__container--col">
            <div class="title banner__block-title banner__block-title--mob"><?php pll_e("О вебинаре"); ?></div>
            <div class="banner__block banner__block--wrap">
                <?php if(!empty($about_image)):?>
                    <img src="<?= get_url_from_img_id($about_image) ?>" class="banner__block-img" />
                <?php else:?>
                    <img src="<?= get_template_directory_uri(); ?>/images/web1.png" class="banner__block-img">
                    <img src="<?= get_template_directory_uri(); ?>/images/web2.png" class="banner__block-img">
                    <img src="<?= get_template_directory_uri(); ?>/images/web3.png" class="banner__block-img">
                    <img src="<?= get_template_directory_uri(); ?>/images/web4.png" class="banner__block-img">
                <?php endif?>
            </div>
            <div class="banner__block banner__block--md">
                <div class="title banner__block-title banner__block-title--hide"><?php pll_e("О вебинаре"); ?></div>
                <div class="banner__block-tr">
                    <?= $about; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="program section--blue">
    <div class="container">
        <div class="program__top">
            <div class="second-title text-bold"><?php pll_e("Какие вопросы рассмотрим?"); ?></div>
        </div>
        <div class="program__wrap">
            <?php $count = 1;
            while (have_rows('questions')): the_row(); ?>
                <div class="program__wrap-item fadeFromLeft">
                    <div class="program__wrap-circle">
                        <?= $count; ?>
                    </div>
                    <h3 class="program__wrap-info"><?= get_sub_field('text') ?></h3>
                </div>
                <?php $count++; endwhile; ?>
        </div>
    </div>
</section>
<?php if (!empty($teachers)): ?>
    <section class="teachers-list teachers-list--padding">
        <div class="container">
            <div class="teachers-list__top">
                <div class="title teachers-list__top-title"><?php pll_e("Кто будет делиться опытом?"); ?></div>
            </div>
            <?php foreach ($teachers as $teacher): ?>
                <div class="teachers-list__item teachers-list__item--flex">
                    <div class="teachers-list__item-main">
                        <div class="teachers-list__item-photo">
                            <img class="" src="<?= get_the_post_thumbnail_url($teacher); ?>"/>
                        </div>
                        <div class="teachers-list__item-mob">
                            <div class="fourth-title text-bold teachers-list__item-title"><?= get_the_title($teacher); ?></div>
                            <h3 class="teachers-list__item-subtitle"><?= get_the_excerpt($teacher); ?></h3>
                        </div>
                    </div>
                    <div class="teachers-list__item-info">
                        <div>
                            <div class="teachers-list__item-hide">
                                <div class="fourth-title text-bold teachers-list__item-title"><?= get_the_title($teacher); ?></div>
                                <h3 class="teachers-list__item-subtitle"><?= get_the_excerpt($teacher); ?></h3>
                            </div>
                            <?= apply_filters('the_content', get_post_field('post_content', $teacher)); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
<section class="banner banner--dotted section--brand">
    <div class="container banner__container banner__container--sm banner__container--between banner__container--center">
        <div class="second-title banner__title banner__title--xl text-bold">
            <?php pll_e("Участие в вебинаре бесплатное при условии предварительной регистрации"); ?>
        </div>
        <div class="text-center">
        <?php if(empty($script)): ?>
            <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-consult.php')));?>?target_id=<?=$post_id;?>"
               class="btn btn--accent z--btn"><?php pll_e("Забронировать место"); ?></a>
                <?php else:?>
                    <a href="<?= get_permalink();?>?getcourse=1"
                    class="btn btn--accent z--btn"><?php pll_e("Забронировать место"); ?></a>
                <?php endif;?>
            
        </div>
    </div>

</section>
<?php if (!empty($recommended_courses)): ?>
    <section class="card-list">
        <div class="container card-list__container">

            <div class="card-list__top">
                <div class="title-md text-bold title card-list__top-title"><?php pll_e("Возможно, тебе будут интересны и эти курсы:"); ?></div>
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-schedule.php'))); ?>"
                   class="btn btn-nobg">
                    <?php pll_e("Расписание курсов"); ?>
                </a>
            </div>
            <div class="card-wrap">
                <?php foreach ($recommended_courses as $course):
                    set_query_var('course_id', $course); ?>
                    <?php get_template_part('template-parts/components', 'course-card'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<section class="about about--main">
    <div class="container about__container">
        <div class="about__info">
            <div class="title about__info-title fromBottom"><?php pll_e("Старт в IT? C ITEA"); ?></div>
            <div class="fromTopLeft">
                <p class="about__text">IT Education Academy - это международный образовательный проект, который готовит
                    специалистов-практиков IT сферы.
                </p>

                <p class="about__text">Мы уже более 6-ти лет на рынке IT-образования и всё это время мы учились вместе
                    со своими студентами: улучшали процесс занятий, запускали новые направления и курсы, повышали
                    уровень сотрудников и открывали новые филиалы. Благодаря нашему постоянному развитию, мы разработали
                    <strong>эффективные и действенные программы подготовки IT-специалистов</strong>.
                </p>
                <p class="about__text">
                    В нашем подходе, у нас получилось соединить лучшие практики оффлайн и онлайн-образования и таким
                    образом достичь высоких результатов.

                </p>
            </div>
            <div class="about__btns main__btns--hide">
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-about.php'))); ?>#top_teachers"
                   class="btn fromBottom zzz-btn">
                    <?php pll_e("Узнать больше"); ?>
                </a>
            </div>
        </div>
        <div class="about__wrap about__wrap--main">
            <div class="about__item about__item--main">
                <div class="about__item-number fromBottom">30+</div>
                <p class="fromBottom">комплексных программ подготовки к профессиям</p>
            </div>
            <div class="about__item about__item--main">
                <div class="about__item-number fromBottom">200+</div>
                <p class="fromBottom">преподавателей из топовых IT-компаний</p>
            </div>
            <div class="about__item about__item--main">
                <div class="about__item-number fromBottom">170+</div>
                <p class="fromBottom">уникальных обучающих курсов</p>
            </div>
            <div class="about__item about__item--main">
                <div class="about__item-number fromBottom">16000+</div>
                <p class="fromBottom">успешных выпускников</p>
            </div>
            <div class="about__item about__item--main">
                <div class="about__item-number fromBottom">95%</div>
                <p class="fromBottom">Именно такое количество студентов трудоустраивается, пройдя комплексную программу
                    Roadmap</p>
            </div>
        </div>
        <div class="about__btns main__btns--mob">
            <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-about.php'))); ?>#top_teachers"
               class="btn fromBottom">
                <?php pll_e("Узнать больше"); ?>
            </a>
        </div>
    </div>
</section>
<section class="benefites-list">
    <div class="container">
        <div class="title benefites-list__title text-center"><?php pll_e("Эффективное обучение? С ITEA!"); ?></div>
        <div class="benefites-wrap">
            <?php while (have_rows('education_formula')): the_row(); ?>
                <div class="benefites benefites--md">
                    <div class="benefites__icon"><img src="<?= get_sub_field('icon') ?>" /></div>
                    <div class="sixth-title benefites__title text-medium"><?= get_sub_field('title') ?></div>
                    <div>
                        <?= get_sub_field('text') ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


<?php 
endif;
get_footer(); ?>
