<?php
/* Template Name: Портфолио */

get_header();
the_post();
?>

    <section class="portfolio">
        <div class="portfolio__banner">
            <div class="portfolio__banner-overlay"></div>
            <div class="container">
                <div class="portfolio__banner-title title-lg text-bold">Портфолио наших выпускников</div>
                <div class="portfolio__banner-subtitle fourth-title">Здесь вы можете посмотреть на уровень работ студентов всех направлений</div>
                <a href="#portfolio__header">
                    <div class="btn-down portfolio__banner-btn-down bounce-2" ></div>
                </a>
            </div>
        </div>
        <div class="container">
            <div id="portfolio__header" class="portfolio__header">
                <div class="portfolio__header-item portfolio__header-item--active" data-direction="all">
                    Все проекты
                </div>
                <div class="portfolio__header-item" data-direction="design">
                    Дизайн
                </div>
                <div class="portfolio__header-item" data-direction="front">
                    Front end
                </div>
                <div class="portfolio__header-item" data-direction="back">
                    Back end
                </div>
                <div class="portfolio__header-item" data-direction="game">
                    Game dev
                </div>
            </div>
        </div>
        <div class="container portfolio__container">
            <div class="portfolio__block">
                <div class="container">
                    <img class="portfolio__block-icon" src="<?= get_template_directory_uri(); ?>/images/icons/finger.svg" />
                </div>
                <div id="portfolio_wrap" class="portfolio__wrap">
                    <?php
                    $loop = new WP_Query(array(
                        'post_type' => 'portfolio',
                        'posts_per_page' => -1,
                    )); ?>
                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <?php
                        $technology = get_post_meta($post->ID, 'technology', true);
                        $course = get_post_meta($post->ID, 'course', true);
                        $student = get_post_meta($post->ID, 'student', true);
                        $teacher = get_post_meta($post->ID, 'teacher', true);
                        $href = get_post_meta($post->ID, 'href', true);
                        $direction = get_post_meta($post->ID, 'direction', true);
                        ?>
                        <div class="portfolio__item" data-direction="<?=$direction;?>">
                            <div class="portfolio__item-img">
                                <img src="<?= get_the_post_thumbnail_url($post->ID); ?>"/>
                                <div class="portfolio__item-name fourth-title text-bold">
                                    <?php //get_the_title($post->ID);?>
                                </div>
                            </div>
                            <div class="portfolio__item-title fourth-title text-bold">
                                <?= get_the_title($post->ID); ?>
                            </div>
                            <div class="portfolio__item-text">
                                <p>
                                    <?= get_the_excerpt($post->ID); ?>
                                </p>
                                <?php if (!empty($technology)): ?>
                                    <p>Технологии: <strong><?= $technology; ?></strong></p>
                                <?php endif; ?>
                                <?php if (!empty(get_the_title($course))): ?>
                                    <p>Курс: <strong><?= get_the_title($course); ?></strong></p>
                                <?php endif; ?>
                                <p>Студент: <strong><?= $student; ?></strong></p>
                                <?php if (!empty(get_the_title($teacher))): ?>
                                    <p>Преподаватель: <strong><?= get_the_title($teacher); ?></strong></p>
                                <?php endif; ?>
                            </div>
                            <a href="<?= $href; ?>" target="_blank" class="btn portfolio__item-btn">Смотреть работу</a>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
