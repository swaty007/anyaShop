<?php
/* Template Name: About */

get_header();
the_post();

$teachers = get_post_meta($post->ID, 'teachers', true);
?>

    <section class="main main--about">
        <div class="container">
            <img src="<?= get_template_directory_uri(); ?>/images/bg/about.png" alt="" class="main__bg-image main__bg-image--about rellax fromRight" data-rellax-speed="5">
            <h1 class="title text-bold main__title fadeFromLeft">
                <?php the_title();?>
            </h1>
            <div class="text-md main__subtitle main__subtitle--md appear">
                <?php the_excerpt();?>
            </div>
            <div class="main__controls">
                <a href="#about" class="btn main__btn fromBottom"><?php pll_e("Узнать больше");?></a>
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-consult.php')));?>"
                   class="btn btn-nobg main__btn main__btn-nobg fromBottom"><?php pll_e("Хочу консультацию");?></a>
            </div>
        </div>
    </section>
    <section id="about" class="about about--about">
        <div class="container">
            <div class="title text-center fromBottom">
                <?php pll_e("IT Education Academy (ITEA) — это:");?>
            </div>
            <div class="about__wrap about__wrap--about">
                <div class="about__item about__item--sm">
                    <div class="about__item-number fromBottom">30+</div>
                    <div class="text-md fromBottom">комплексных программ подготовки к профессиям</div>
                </div>
                <div class="about__item about__item--sm">
                    <div class="about__item-number fromBottom">200+</div>
                    <div class="text-md fromBottom">преподавателей из топовых IT-компаний</div>
                </div>
                <div class="about__item about__item--sm">
                    <div class="about__item-number fromBottom">95%</div>
                    <div class="text-md fromBottom">Именно такое количество студентов трудоустраивается, пройдя комплексную программу Roadmap</div>
                </div>
                <div class="about__item about__item--sm">
                    <div class="about__item-number fromBottom">170+</div>
                    <div class="text-md fromBottom">уникальных обучающих курсов</div>
                </div>
                <div class="about__item about__item--sm">
                    <div class="about__item-number fromBottom">16000+</div>
                    <div class="text-md fromBottom">успешных выпускников</div>
                </div>
            </div>
            <div class="about__block">
                <div class="about__block-info">
                    <img  src="<?= get_template_directory_uri(); ?>/images/people/bykov.png" class="about__block-photo fromBottom">
                    <div class="text-md fromBottom">Мирослав <strong>Быков</strong> CEO IT Education Academy</div>
                </div>
                <div class="second-title text-bold fromBottom">
                    "Мы постоянно адаптируем систему обучения под непрерывно прогрессирующий рынок, поэтому самые актуальные знания, эффективные программы обучения и преподаватели-практики — залог успеха наших студентов"
                </div>
            </div>
        </div>
    </section>
    <section class="benefites-list benefites-list--about section--blue">
        <div class="container">
            <div class="title text-bold benefites-list__title"><?php pll_e("Преимущества обучения в ITEA онлайн");?></div>
            <div class="benefites-wrap">
                <?php while (have_rows('advantages')): the_row(); ?>
                    <div class="benefites benefites--flex benefites--md fadeFromLeft">
                        <div class="benefites__icon">
                            <img src="<?= get_sub_field('icon') ?>" />
                        </div>
                        <div class="benefites__info">
                            <h4 class="benefites__name"><?= get_sub_field('title'); ?></h4>
                            <div class="text-md benefites__text fadeFromLeftLong">
                                <?= get_sub_field('text'); ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section id="top_teachers" class="section--blue teachers-list teachers-list--about">
        <div class="container">
            <div class="title teachers-list__title"><?php pll_e("Топовые преподаватели");?></div>
            <div class="text-md teachers-list__subtitle">
                <?php pll_e("Команда ITEA собрала лучших практиков: руководителей, senior-специалистов и экспертов с многолетним опытом");?>
            </div>
            <div class="teachers-list__wrap">
                <?php
                foreach ($teachers as $teacher):?>
                    <div class="teacher">
                        <div class="teacher__photo">
                            <img src="<?= get_the_post_thumbnail_url($teacher);?>" />
                            <div class="teacher__photo-info">
                                <?= get_post_meta($teacher, 'short_description', true);?>
<!--                               --><?php //the_content();?>
                            </div>
                        </div>
                        <div class="fourth-title teacher__title text-bold"><?= get_the_title($teacher);?></div>
                        <div class="sixth-title teacher__subtitle"><?= get_the_excerpt($teacher);?></div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </section>
<?php get_template_part('template-parts/components', 'companies'); ?>
    <section class="section--blue feeds-list feeds-list--padding">
        <div class="container">
            <div class="title text-bold text-center"><?php pll_e("Отзывы компаний");?></div>
            <div class="slider regular-three feeds-wrap">
                <?php
                $loop = new WP_Query(array(
                    'post_type' => 'partners',
                    'posts_per_page' => -1,
                    'meta_query' => [
                        'AND',
                        [
                            'key' => 'review',
                            'value'	  	=>  true,
                            'compare' 	=> '=',
                        ]
                    ],
                )); ?>
                <?php $count = 0; while ($loop->have_posts()) : $loop->the_post(); ?>
                    <div class="feeds <?php if($count <= 2) {echo 'fromRight';};?>">
                        <div class="feeds__header">
                            <img src="<?php the_post_thumbnail_url(); ?>" />
                        </div>
                        <div class="feeds__body">
                            <div class="fifth-title feeds__title text-bold">
                                <?php the_title();?>
                            </div>
                            <div class="text-md">
                                <?php the_excerpt();?>
                            </div>
                        </div>
                    </div>
                    <?php $count++; endwhile;
                wp_reset_query(); ?>
            </div>
        </div>
    </section>
    <section class="feeds-list">
        <div class="second-title text-bold text-center"><?php pll_e("Отзывы студентов");?></div>
        <div class="container">
            <div class="lazy slider feeds-wrap">
                <?php
                $loop = new WP_Query(array(
                    'post_type' => 'reviews',
                    'posts_per_page' => -1,
                )); ?>
                <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                    <div class="feeds feeds--wide">
                        <img src="<?php the_post_thumbnail_url();?>" class="feeds__photo" />
                        <div class="feeds__main">
                            <div class="fourth-title feeds__title text-bold">
                                <?php the_title();?>
                            </div>
                            <div class="text-md"><?php the_excerpt();?></div>
                            <div class="sixth-title text-center feeds__text">
                                <?php the_content();?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile;
                wp_reset_query(); ?>
            </div>
        </div>
    </section>
<?php
get_footer();
