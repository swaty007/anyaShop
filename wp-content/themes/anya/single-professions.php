<?php
get_header();
the_post(); ?>

<?php
$parentCategoryList = get_the_category($post->ID);
$lang = get_query_var('lang');

//$post_id = pll_get_post($post->ID, 'ru');
$post_id = $post->ID;
if (!empty($lang) && !empty($lang_post_id = pll_get_post($post_id, $lang))) {
    $currency = get_post_meta($lang_post_id, 'currency', true);
    $discount_price = get_post_meta($lang_post_id, 'discount_price', true);
} else {
    $currency = get_post_meta($post_id, 'currency', true);
    $discount_price = get_post_meta($post_id, 'discount_price', true);
}



$cost = 0;

$ismonth = get_post_meta($post_id, 'ismonth', true);
$lessons = 0;
$date = get_post_meta($post_id, 'date', true); //repeater
//$about = get_post_meta($post_id, 'about', true);

$why_this_profession = get_post_meta($post_id, 'why_this_profession', true); //repeater advanced
$slider_title = get_post_meta($post_id, 'slider_title', true);
$slider_items = get_post_meta($post_id, 'slider_items', true); //repeater
$profession_courses = get_post_meta($post_id, 'profession_courses', true);
$how_you_learn_title = get_post_meta($post_id, 'how_you_learn_title', true);
$how_you_learn = get_post_meta($post_id, 'how_you_learn', true); //repeater
$after_you_can = get_post_meta($post_id, 'after_you_can', true); //repeater
$education_formula = get_post_meta($post_id, 'education_formula', true); //repeater
$education_plan_title = get_post_meta($post_id, 'education_plan_title', true);
$education_plan = get_post_meta($post_id, 'education_plan', true); //repeater
$teachers = get_post_meta($post_id, 'teachers', true);

foreach ($profession_courses as $course) {
    if (!empty($lang) && !empty($lang_course_id = pll_get_post($course, $lang))) {
        $cost += get_post_meta($lang_course_id, 'cost', true);
    } elseif (!empty($lang_course_id = pll_get_post($course, pll_current_language()))) {
        $cost += get_post_meta($lang_course_id, 'cost', true);
    } else {
        $cost += get_post_meta($course, 'cost', true);
    }

    $lessons += get_post_meta($course, 'lessons', true);
}
?>


    <section class="main main--course">
        <img src="<?= get_template_directory_uri(); ?>/images/bg/macs.png" alt=""
             class="main__bg-image main__bg-image--course">
        <div class="main__overlay"></div>
        <div class="container  main__container main__container--flex">
            <div class="main__block">
                <div class="text-md appear"><?php pll_e("Онлайн обучение"); ?></div>
                <h1 class="title main__title main__title--course fadeFromLeft">
                    <?php the_title(); ?>
                </h1>
                <div class="text-md main__subtitle main__subtitle--lg appear">
                    <?php the_excerpt(); ?>
                </div>
                <div class="main__btns main__btns--hide">
                    <a href="#form" class="btn main__btn   fromBottom"><?php pll_e("Забронировать место"); ?></a>
                    <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-consult.php')));?>?target_id=<?= empty($lang_post_id) ? $post_id : $lang_post_id;?>&counsult=1"
                       class="btn btn-nobg main__btn main__btn-nobg fromBottom"><?php pll_e("Хочу консультацию"); ?></a>
                </div>
            </div>
            <div class="main__table anim4">
                <div class="main__table-tr">
                    <div class="main__table-label main__table-label--first">
                        <?php pll_e("КОГДА"); ?>
                    </div>
                    <div class="text-md main__table-title text-bold">
                        <?php pll_e("Старт"); ?>
                    </div>
                    <?php if (have_rows('date')):?>
                        <?php while (have_rows('date')): the_row();?>
                            <div class="main__table-td"><?php the_sub_field('date') ?></div>
                        <?php endwhile; ?>
                    <?php else:?>
                        <?php pll_e("Идет набор на курс");?>
                    <?php endif;?>
                </div>
                <div class="main__table-tr">
                    <div class="main__table-label main__table-label--second"><?php pll_e("СКОЛЬКО"); ?></div>
                    <div class="text-md main__table-title text-bold"><?= $lessons; ?> <?php 
                     $titles = array(' занятие', ' занятия', ' занятий');   
                     
                     echo declOfNum($lessons,$titles)

                    
                    ?></div>
                    <div class="main__table-td">2-3 раза в неделю</div>
                    <div class="main__table-td">с 19:00 до 22:00</div>
                </div>
                <div class="main__table-tr">
                    <div class="main__table-label main__table-label--third"><?php pll_e("ЦЕНА"); ?></div>
                    <?php if ($discount_price): ?>
                        <div class="main__table-title text-bold text-md main__table-title--crossed"><?= $cost; ?> <?= $currency; ?></div>
                        <div class="main__table-title text-bold text-md"><span id="current_price"><?= $discount_price; ?></span> <?= $currency; ?></div>
                    <?php else: ?>
                        <div class="main__table-title text-bold text-md"><span id="current_price"><?= $cost; ?></span> <?= $currency; ?></div>
                    <?php endif; ?>
                    <?php if ($ismonth): ?>
                        <div class="main__table-td main__table-td--added"><?php pll_e("Доступна оплата частями"); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="main__btns main__btns--mob">
                <a href="#form" class="btn main__btn   fromBottom"><?php pll_e("Забронировать место"); ?></a>
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-consult.php')));?>?target_id=<?= empty($lang_post_id) ? $post_id : $lang_post_id;?>&counsult=1"
                   class="btn btn-nobg main__btn main__btn-nobg fromBottom"><?php pll_e("Хочу консультацию"); ?></a>
            </div>
        </div>
    </section>
    <section class="program">
        <div class="container">
            <div class="program__top">
                <div class="title"><?php pll_e("Почему"); ?> <?php the_title(); ?>?</div>
            </div>
            <div class="program__info">
                <?php $count = 0;
                while (have_rows('why_this_profession')): the_row(); ?>
                    <div class="program__item program__item--lg fadeFromLeft">
                        <div class="program__item-circle">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.99844 16.2001L4.79844 12.0001L3.39844 13.4001L8.99844 19.0001L20.9984 7.0001L19.5984 5.6001L8.99844 16.2001Z"
                                      fill="#8E3DFF"/>
                            </svg>
                        </div>
                        <div>
                            <div class="program__item-title text-bold">
                                <?= get_sub_field('title') ?>
                            </div>
                            <div>
                                <?= get_sub_field('text') ?>
                            </div>
                        </div>
                    </div>
                    <?php $count++; endwhile; ?>
            </div>
        </div>
    </section>
    
    <section class='employment'>
        <div class="employment_wrapper">
            <div class="container">

                <div class="employment-left">
                    <div class="employment_title work-title">
                    <?= $slider_title;?>
                    </div>
                    <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-w.php'))); ?>" class='employment_link' style='    display: flex;
    align-items: center;
    justify-content: center;'>О трудоустройстве</a>
                </div>
                <div class="employment-right">
                    <div class="employment-items">
                    <?php while (have_rows('slider_items')): the_row(); ?>
                    <div class="employment-item">
                        <p>   <?= get_sub_field('text') ?></p> 
                    </div>
            <?php endwhile; ?>
                    </div>
                </div>
            </div>
            <img src="<?php echo get_template_directory_uri() ?>/images/people/girl1.png" alt="" class="employment_img">
        </div>
    </section>
    <section class="card-list">
        <div class="container">
            <div class="card-list__top">
                <div class="title card-list__top-title"><?php pll_e("Курсы для"); ?> <?php the_title(); ?></div>
                <a href="<?= get_permalink(pll_get_post(get_page_id_by_template('page-schedule.php'))); ?>"
                   class="btn btn-nobg">
                    <?php pll_e("Расписание курсов"); ?>
                </a>
            </div>
            <div class="card-wrap">
                <?php
                $count = 1;
                foreach ($profession_courses as $course):
                    $term = wp_get_post_terms($course, 'courses_category')[0];
                    $color = get_term_meta($term->term_id, 'color', true);
                    ?>
                    <a href="<?= get_the_permalink($course); ?>" class="card-list__block">
                        <div class="card-list__step">
                            <div class="card-list__step-arrow">
                                <svg width="16" height="33" viewBox="0 0 16 33" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.29289 32.7071C7.68342 33.0976 8.31658 33.0976 8.70711 32.7071L15.0711 26.3431C15.4616 25.9526 15.4616 25.3195 15.0711 24.9289C14.6805 24.5384 14.0474 24.5384 13.6569 24.9289L8 30.5858L2.34315 24.9289C1.95262 24.5384 1.31946 24.5384 0.928933 24.9289C0.538409 25.3195 0.538409 25.9526 0.928933 26.3431L7.29289 32.7071ZM7 4.37113e-08L7 32L9 32L9 -4.37113e-08L7 4.37113e-08Z"
                                          fill="#8E3DFF"/>
                                </svg>
                            </div>
                            <div class="fourth-title text-bold">0<?= $count; ?>. <?php pll_e("Шаг"); ?></div>
                        </div>
                        <div class="card"
                             style="background: linear-gradient(180deg, #FFFFFF 0%, <?= $color; ?>12 100%);">
                            <div class="card__label" style="background-color: <?= $color; ?>">
                                <div class="text-md card__label-text-md text-bold">
                                    <?= $term->name; ?>
                                </div>
                            </div>
                            <div class="card__info">
                                <div class="card__main">
                                    <div class="fifth-title text-bold card__column-title">
                                        <?= get_the_title($course); ?>
                                    </div>
                                    <p>
                                        <!--                                    --><?//= get_the_excerpt($course); ?>
                                        <?= get_post_meta($course, 'about_card', true); ?>
                                    </p>
                                </div>
                                <div class="card__column">
                                    <div class="card__column-title text-bold">
                                        <?php pll_e("Старт"); ?>
                                    </div>
                                    <?php if (have_rows('date', $course)):?>
                                        <?php while (have_rows('date', $course)): the_row();?>
                                            <p><?php the_sub_field('date') ?></p>
                                        <?php endwhile; ?>
                                    <?php else:?>
                                        <?php pll_e("Идет набор на курс");?>
                                    <?php endif;?>
                                </div>
                                <div class="card__column">
                                    <div class="card__column-title text-bold">
                                        <?php pll_e("Длительность курса"); ?>
                                    </div>
                                    <p>
                                        <?= get_post_meta($course, 'lessons', true); ?> <?php pll_e("занятий"); ?>
                                    </p>
                                </div>
                                <button
                                   class="btn btn--md btn-nobg card__btn fromBottom"><?php pll_e("Подробнее"); ?></button>
                            </div>
                        </div>
                    </a>
                    <?php $count++; endforeach; ?>
            </div>
        </div>
    </section>
    <section class="banner banner--dotted section--brand">
        <div class="container banner__container banner__container--flex">
            <div class="banner__info">
                <div class="second-title banner__title text-bold">
                    <?php pll_e("Комплексная программа со скидкой"); ?>
                </div>
                <h3 class="banner__subtitle text-medium">
                    <?php pll_e("Ты можешь пройти курсы по отдельности - в своем режиме. А можешь забронировать все курсы со скидкой - так выгодней"); ?>
                </h3>
            </div>
            <div class="banner__column text-center">
                <?php if ($discount_price): ?>
                    <div class="fourth-title text-crossed text-bold"><?= $cost; ?> <?= $currency; ?></div>
                    <div class="second-title text-bold banner__column-title"><?= $discount_price; ?> <?= $currency; ?></div>
                <?php else: ?>
                    <div class="second-title text-bold banner__column-title"><?= $cost; ?> <?= $currency; ?></div>
                <?php endif; ?>
                <a href="#form" class="btn btn--accent"><?php pll_e("Забронировать место"); ?></a>
            </div>
        </div>

    </section>
    <section class="program">
        <div class="container">
            <div class="program__top">
                <div class="title">
                    <?= $how_you_learn_title ;?>
                </div>
            </div>
            <p class="program__subtitle"></p>
            <div class="program__info">
                <?php $count = 0;
                while (have_rows('how_you_learn')): the_row(); ?>
                    <div class="program__item fadeFromLeft">
                        <div class="program__item-circle">
                            <?php if ($count === 0): ?>
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M40.1187 2.32495H7.7169C4.81355 2.32495 2.45117 4.68733 2.45117 7.59068V29.8905C2.45117 32.7934 4.81307 35.1553 7.7169 35.1553H19.2289V44.071H10.306C9.90948 44.071 9.58854 44.392 9.58854 44.7885C9.58854 45.185 9.90948 45.506 10.306 45.506H19.9464H27.8887H37.5291C37.9256 45.506 38.2466 45.185 38.2466 44.7885C38.2466 44.392 37.9256 44.071 37.5291 44.071H28.6062V35.1553H40.1182C43.0206 35.1553 45.382 32.7934 45.382 29.8905V7.59068C45.3825 4.68733 43.0211 2.32495 40.1187 2.32495ZM7.7169 3.75989H40.1187C42.23 3.75989 43.9476 5.47846 43.9476 7.59068V24.499H3.88658V7.59068C3.88658 5.47798 5.60468 3.75989 7.7169 3.75989ZM27.1717 44.071H20.6643V35.1553H27.1717V44.071ZM40.1187 33.7204H27.8892H19.9469H7.71738C5.60516 33.7204 3.88658 32.0023 3.88658 29.8905V25.9344H43.9476V29.8905C43.9476 32.0023 42.23 33.7204 40.1187 33.7204Z"
                                          fill="#8E3DFF"/>
                                    <path d="M23.9186 27.2898C22.4373 27.2898 21.2324 28.4942 21.2324 29.9741C21.2324 31.454 22.4373 32.6584 23.9186 32.6584C25.399 32.6584 26.6029 31.454 26.6029 29.9741C26.6029 28.4942 25.399 27.2898 23.9186 27.2898ZM23.9186 31.2234C23.2289 31.2234 22.6674 30.6629 22.6674 29.9741C22.6674 29.2853 23.2284 28.7247 23.9186 28.7247C24.6074 28.7247 25.168 29.2853 25.168 29.9741C25.168 30.6629 24.6074 31.2234 23.9186 31.2234Z"
                                          fill="#8E3DFF"/>
                                </svg>

                            <?php endif; ?>
                            <?php if ($count === 1): ?>
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.5594 11.76H11.1994C10.9766 11.76 10.7629 11.8485 10.6054 12.006C10.4479 12.1636 10.3594 12.3772 10.3594 12.6C10.3594 12.8228 10.4479 13.0364 10.6054 13.194C10.7629 13.3515 10.9766 13.44 11.1994 13.44H14.5594C14.7822 13.44 14.9958 13.3515 15.1533 13.194C15.3109 13.0364 15.3994 12.8228 15.3994 12.6C15.3994 12.3772 15.3109 12.1636 15.1533 12.006C14.9958 11.8485 14.7822 11.76 14.5594 11.76Z"
                                          fill="#8E3DFF"/>
                                    <path d="M22.3992 11.76H19.0392C18.8164 11.76 18.6028 11.8485 18.4452 12.006C18.2877 12.1636 18.1992 12.3772 18.1992 12.6C18.1992 12.8228 18.2877 13.0364 18.4452 13.194C18.6028 13.3515 18.8164 13.44 19.0392 13.44H22.3992C22.622 13.44 22.8357 13.3515 22.9932 13.194C23.1507 13.0364 23.2392 12.8228 23.2392 12.6C23.2392 12.3772 23.1507 12.1636 22.9932 12.006C22.8357 11.8485 22.622 11.76 22.3992 11.76Z"
                                          fill="#8E3DFF"/>
                                    <path d="M48.4052 15.1201H47.0388V10.6737C47.0373 9.92262 46.7383 9.20275 46.2072 8.67166C45.6761 8.14058 44.9562 7.84157 44.2052 7.84009H9.55235C8.80129 7.84157 8.08141 8.14058 7.55033 8.67166C7.01924 9.20275 6.72023 9.92262 6.71875 10.6737V33.0065C6.72023 33.7575 7.01924 34.4774 7.55033 35.0085C8.08141 35.5396 8.80129 35.8386 9.55235 35.8401H11.7588V42.2465C11.7602 42.9233 12.0297 43.5719 12.5083 44.0505C12.9869 44.5291 13.6355 44.7986 14.3124 44.8001H22.0852C22.762 44.7986 23.4106 44.5291 23.8892 44.0505C24.3678 43.5719 24.6373 42.9233 24.6388 42.2465V35.8401H28.5588V42.2465C28.5602 42.9233 28.8297 43.5719 29.3083 44.0505C29.7869 44.5291 30.4356 44.7986 31.1124 44.8001H48.4052C49.082 44.7986 49.7306 44.5291 50.2092 44.0505C50.6878 43.5719 50.9573 42.9233 50.9588 42.2465V17.6737C50.9573 16.9969 50.6878 16.3482 50.2092 15.8697C49.7306 15.3911 49.082 15.1216 48.4052 15.1201ZM22.0852 43.1201H14.3124C14.0811 43.1186 13.8598 43.0261 13.6962 42.8626C13.5327 42.6991 13.4402 42.4777 13.4388 42.2465V25.5137C13.4402 25.2824 13.5327 25.0611 13.6962 24.8976C13.8598 24.7341 14.0811 24.6416 14.3124 24.6401H22.0852C22.3164 24.6416 22.5377 24.7341 22.7013 24.8976C22.8648 25.0611 22.9573 25.2824 22.9588 25.5137V34.9945V42.2465C22.9573 42.4777 22.8648 42.6991 22.7013 42.8626C22.5377 43.0261 22.3164 43.1186 22.0852 43.1201ZM24.6388 34.1601V25.5137C24.6373 24.8369 24.3678 24.1882 23.8892 23.7097C23.4106 23.2311 22.762 22.9616 22.0852 22.9601H14.3124C13.6355 22.9616 12.9869 23.2311 12.5083 23.7097C12.0297 24.1882 11.7602 24.8369 11.7588 25.5137V34.1601H9.55235C9.2464 34.1601 8.95297 34.0385 8.73663 33.8222C8.52029 33.6059 8.39875 33.3124 8.39875 33.0065V10.6737C8.39875 10.3677 8.52029 10.0743 8.73663 9.85797C8.95297 9.64163 9.2464 9.52009 9.55235 9.52009H44.2052C44.5111 9.52009 44.8045 9.64163 45.0209 9.85797C45.2372 10.0743 45.3588 10.3677 45.3588 10.6737V15.1201H31.1124C30.4356 15.1216 29.7869 15.3911 29.3083 15.8697C28.8297 16.3482 28.5602 16.9969 28.5588 17.6737V34.1601H24.6388ZM49.2788 42.2465C49.2773 42.4777 49.1848 42.6991 49.0213 42.8626C48.8577 43.0261 48.6364 43.1186 48.4052 43.1201H31.1124C30.8811 43.1186 30.6598 43.0261 30.4962 42.8626C30.3327 42.6991 30.2402 42.4777 30.2388 42.2465V17.6737C30.2402 17.4424 30.3327 17.2211 30.4962 17.0576C30.6598 16.8941 30.8811 16.8016 31.1124 16.8001H48.4052C48.6364 16.8016 48.8577 16.8941 49.0213 17.0576C49.1848 17.2211 49.2773 17.4424 49.2788 17.6737V42.2465Z"
                                          fill="#8E3DFF"/>
                                    <path d="M39.7652 41.1611C40.5384 41.1584 41.163 40.5294 41.1603 39.7562C41.1576 38.983 40.5287 38.3584 39.7555 38.3611C38.9823 38.3638 38.3577 38.9928 38.3604 39.766C38.3631 40.5391 38.992 41.1638 39.7652 41.1611Z"
                                          fill="#8E3DFF"/>
                                </svg>

                            <?php endif; ?>
                            <?php if ($count === 2): ?>
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M44.012 8.62207H26.5546C25.188 8.62207 24.0764 9.73367 24.0764 11.1002V13.1828H4.52448C2.76956 13.1828 1.3418 14.6105 1.3418 16.3659V31.0611C1.3418 32.8155 2.76956 34.2428 4.52448 34.2428H7.58137V40.4054C7.58137 40.6895 7.74878 40.9464 8.0085 41.0616C8.10177 41.1028 8.20031 41.1229 8.29836 41.1229C8.47342 41.1229 8.64657 41.0588 8.78098 40.9363L16.1484 34.2428H28.9691C30.7235 34.2428 32.1513 32.8155 32.1513 31.0611V24.073H35.63L40.8326 28.7992C40.9675 28.9216 41.1402 28.9857 41.3153 28.9857C41.4133 28.9857 41.5123 28.9656 41.6056 28.9245C41.8653 28.8097 42.0327 28.5524 42.0327 28.2682V24.073H44.0115C45.3771 24.073 46.4882 22.9609 46.4882 21.5944V11.1002C46.4887 9.73367 45.378 8.62207 44.012 8.62207ZM30.7168 31.0606C30.7168 32.0239 29.9329 32.8074 28.9696 32.8074H15.8715C15.6931 32.8074 15.5213 32.8739 15.3889 32.994L9.01583 38.7839V33.5249C9.01583 33.1284 8.69488 32.8074 8.29836 32.8074H4.524C3.56021 32.8074 2.77625 32.0239 2.77625 31.0606V16.3655C2.77625 15.4017 3.56021 14.6172 4.524 14.6172H24.7867C24.7891 14.6172 24.7915 14.6177 24.7939 14.6177C24.7963 14.6177 24.7987 14.6172 24.8011 14.6172H28.9696C29.9334 14.6172 30.7168 15.4017 30.7168 16.3655V31.0606ZM45.0537 21.5944C45.0537 22.1698 44.5864 22.638 44.012 22.638H41.3157C40.9197 22.638 40.5983 22.959 40.5983 23.3555V26.6472L36.3901 22.8246C36.2581 22.705 36.0859 22.638 35.9075 22.638H32.1513V16.3659C32.1513 14.611 30.7235 13.1828 28.9691 13.1828H25.5114V11.1002C25.5114 10.5248 25.9796 10.057 26.5546 10.057H44.012C44.5864 10.057 45.0537 10.5248 45.0537 11.1002V21.5944Z"
                                          fill="#8E3DFF"/>
                                </svg>
                            <?php endif; ?>
                            <?php if ($count === 3): ?>
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M40.2665 7.25256C39.9113 6.89812 39.4839 6.62423 39.0135 6.44948C38.5431 6.27473 38.0406 6.20321 37.5401 6.23976C31.6965 6.67724 26.2069 9.20816 22.0793 13.3678L21.5369 13.9198H14.4617C14.3661 13.9198 14.2714 13.939 14.1832 13.9761C14.095 14.0132 14.0151 14.0674 13.9481 14.1358L6.44572 21.8158C6.34651 21.917 6.27937 22.0452 6.25273 22.1845C6.2261 22.3237 6.24114 22.4677 6.29599 22.5984C6.35083 22.7291 6.44303 22.8407 6.56103 22.9192C6.67903 22.9977 6.81758 23.0397 6.95932 23.0398H13.8617L15.7097 24.8878C12.9059 24.9907 10.2476 26.1618 8.27932 28.1614C2.39932 34.1134 7.03132 40.9054 7.07932 40.9726C7.16705 41.0982 7.2926 41.1927 7.4377 41.2421C7.58279 41.2914 7.73986 41.2932 7.88606 41.2472C8.03225 41.2011 8.15993 41.1096 8.25052 40.986C8.3411 40.8624 8.38987 40.713 8.38972 40.5598C8.38972 38.251 10.5545 36.0622 12.8393 36.0622C13.9363 36.0685 14.9859 36.5097 15.758 37.289C16.5301 38.0683 16.9616 39.122 16.9577 40.219C16.96 40.3491 16.9974 40.4762 17.0662 40.5868C17.1349 40.6973 17.2323 40.7871 17.348 40.8467C17.4637 40.9063 17.5935 40.9334 17.7234 40.9251C17.8533 40.9169 17.9785 40.8735 18.0857 40.7998C19.4694 39.7259 20.5911 38.3518 21.3661 36.781C22.141 35.2103 22.5491 33.484 22.5593 31.7326L24.4793 33.6526V40.5598C24.4794 40.7021 24.5217 40.8412 24.6009 40.9594C24.68 41.0777 24.7924 41.1699 24.9239 41.2244C25.0554 41.2788 25.2 41.2931 25.3396 41.2653C25.4792 41.2376 25.6074 41.1691 25.7081 41.0686L33.3881 33.3886C33.5209 33.256 33.5966 33.0769 33.5993 32.8894V25.9822L34.1513 25.4398C38.3109 21.3122 40.8419 15.8226 41.2793 9.97897C41.3159 9.47847 41.2444 8.97597 41.0696 8.50555C40.8949 8.03514 40.621 7.60781 40.2665 7.25256ZM14.7641 15.3598H20.0969L13.8569 21.5998H8.66812L14.7641 15.3598ZM18.2105 38.7982C17.9009 37.6068 17.2056 36.5514 16.233 35.7968C15.2605 35.0422 14.0655 34.6309 12.8345 34.627C10.4729 34.627 8.27452 36.2878 7.37212 38.467C6.53212 36.3694 5.85532 32.659 9.29212 29.1886C10.3119 28.1515 11.5551 27.3612 12.9269 26.8778C14.2986 26.3945 15.7627 26.231 17.2073 26.3998L21.0473 30.2398C21.2417 31.7875 21.0878 33.3592 20.597 34.8399C20.1062 36.3205 19.2909 37.6729 18.2105 38.7982ZM32.1593 32.5918L25.9193 38.8318V33.6622L32.1593 27.4222V32.5918ZM33.1193 24.4318L32.3705 25.1806L32.3465 25.2046L25.1993 32.3422L15.1769 22.3198L22.3337 15.163L22.3577 15.139L23.1065 14.3998C26.9848 10.4838 32.1453 8.09781 37.6409 7.67977C37.9363 7.65328 38.2338 7.69197 38.5126 7.79308C38.7913 7.8942 39.0445 8.05528 39.2541 8.26496C39.4638 8.47463 39.6249 8.72778 39.726 9.00653C39.8271 9.28528 39.8658 9.58283 39.8393 9.87817C39.4213 15.3738 37.0353 20.5343 33.1193 24.4126V24.4318Z"
                                          fill="#8E3DFF"/>
                                    <path d="M30.4795 12.9597C29.4245 12.9603 28.4024 13.3266 27.5873 13.9963C26.7721 14.6659 26.2144 15.5975 26.0091 16.6323C25.8038 17.6671 25.9636 18.741 26.4613 19.6712C26.9591 20.6013 27.7639 21.3301 28.7387 21.7334C29.7136 22.1367 30.7981 22.1895 31.8074 21.8828C32.8168 21.5762 33.6887 20.929 34.2744 20.0516C34.8602 19.1742 35.1236 18.1208 35.0197 17.071C34.9159 16.0212 34.4513 15.0398 33.7051 14.2941C33.2824 13.8695 32.7796 13.5329 32.226 13.3039C31.6723 13.0748 31.0787 12.9578 30.4795 12.9597ZM32.6875 19.7277C32.1775 20.2385 31.5063 20.5567 30.788 20.6281C30.0698 20.6995 29.349 20.5196 28.7485 20.1192C28.148 19.7187 27.7049 19.1224 27.4947 18.4319C27.2845 17.7414 27.3203 16.9994 27.5958 16.3323C27.8714 15.6652 28.3697 15.1142 29.0059 14.7733C29.6421 14.4324 30.3768 14.3226 31.0849 14.4627C31.7929 14.6027 32.4305 14.9839 32.8891 15.5414C33.3476 16.0988 33.5986 16.798 33.5995 17.5197C33.601 17.9298 33.5212 18.3361 33.3647 18.7151C33.2081 19.0941 32.978 19.4383 32.6875 19.7277Z"
                                          fill="#8E3DFF"/>
                                </svg>

                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="program__item-title text-bold"><?= get_sub_field('title') ?></div>
                            <div>
                                <?= get_sub_field('text') ?>
                            </div>
                        </div>
                    </div>
                    <?php $count++; endwhile; ?>
            </div>
        </div>
    </section>
    <section class="banner section--blue">
        <div class="container">
            <div class="title">
                <?php pll_e("После окончания комплексной программы ты сможешь"); ?>
            </div>
            <ul class="banner__wrap">
                <?php while (have_rows('after_you_can')): the_row(); ?>
                    <li class="text-bold banner__wrap-item">
                        <?= get_sub_field('text') ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>
    <section class="benefites-list benefites-list">
        <div class="container">
            <div class="title text-center benefites-list__title"><?php pll_e("Формула эффективного обучения ITEA:"); ?></div>
            <div class="benefites-wrap">
                <?php while (have_rows('education_formula')): the_row(); ?>
                    <div class="benefites benefites--lg">
                        <div class="benefites__icon">
                            <img src="<?= get_sub_field('icon') ?>" />
                        </div>
                        <h4 class="benefites__title text-medium">
                            <?= get_sub_field('title') ?>
                        </h4>
                        <div>
                            <?= get_sub_field('text') ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <section class="plan plan--prof section--light-purple">
        <div class="container">
            <div class="third-title text-bold plan__title">
                <?= $education_plan_title;?>
            </div>
            <div class="plan__show">
                <?php $count = 0;
                while (have_rows('education_plan')): the_row(); ?>
                    <div class="page__item page__item--narrow">
                        <div class="page__item-header">
                            <div class="sixth-title text-medium"><?php the_sub_field('title') ?></div>
                            <div class="btn-plus page__item-btn-plus"></div>
                        </div>
                        <div class="page__item-body">
                            <?php the_sub_field('text') ?>
                        </div>
                    </div>
                    <?php $count++; if ($count === 10) break; ?>
                <?php endwhile; ?>
            </div>
            <div class="plan__hidden plan__hidden--padd" style="display:none;">
<?php if($count >= 10):?>
                <?php while (have_rows('education_plan')): the_row();
                    $count++; ?>
                    <div class="page__item page__item--narrow">
                        <div class="page__item-header">
                            <div class="sixth-title text-medium">
                                <?php the_sub_field('title'); ?>
                            </div>
                            <div class="btn-plus page__item-btn-plus"></div>
                        </div>
                        <div class="page__item-body">
                            <?php the_sub_field('text'); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
<?php endif;?>
            </div>
            <?php if ($count > 10): ?>
                <button class="btn btn-nobg plan__btn" onclick="">
                    <?php pll_e("Детальнее"); ?>
                </button>
            <?php endif; ?>
        </div>
    </section>
<?php if (!empty($teachers)): ?>
    <section class="teachers-list">
        <div class="container">
            <div class="title teachers-list__title">
                <?php pll_e("Преподаватели направления"); ?> <?php the_title(); ?>
            </div>
            <div class="text-md teachers-list__subtitle">
                <?php pll_e("Команда ITEA собрала лучших практиков: руководителей, senior-специалистов и экспертов с многолетним опытом"); ?>
            </div>
            <div class="teachers-list__wrap">
                <?php foreach ($teachers as $teacher): ?>
                    <div class="teacher">
                        <div class="teacher__photo">
                            <img src="<?= get_the_post_thumbnail_url($teacher); ?>"/>
                            <div class="teacher__photo-info">
                                <?= get_the_excerpt($teacher); ?>
                            </div>
                        </div>
                        <div class="fourth-title teacher__title text-bold"><?= get_the_title($teacher); ?></div>
                        <div class="sixth-title teacher__subtitle">
                            <?= get_post_meta($teacher, 'short_description', true);?>
<!--                            --><?//= apply_filters('the_content', get_post_field('post_content', $teacher)); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php get_template_part('template-parts/components', 'companies'); ?>
<!--    <form id="form_professions" class="form section--brand">-->
<!--        <div id="form" class="container form__container">-->
<!--            <div class="third-title text-bold text-center fromBottomHalf">--><?php //pll_e("Успей забронировать свое место в группе"); ?><!--</div>-->
<!--            <div class="text-md text-center form__subtitle fromBottomHalf">-->
<!--                --><?php //pll_e("Если после первого занятия ты почувствуешь, что этот курс не для тебя (например, не подходит по сложности), то мы вернем деньги."); ?>
<!--            </div>-->
<!--            <p id="promo_active" class="text-md text-center form__subtitle" style="display: none;">-->
<!--                <span>Старая цена:</span> <span class="old_price"></span>-->
<!--                <span>Новая цена:</span> <span class="new_price"></span>-->
<!--                <span>Промокод:</span> <span class="promo"></span>-->
<!--                <span>Процент скидки:</span> <span class="promo_discount"></span>-->
<!--            </p>-->
<!--            <div class="form__group fromBottomHalf">-->
<!--                <input type="hidden" name="target_id" value="--><?//= empty($lang_post_id) ? $post_id : $lang_post_id;?><!--" />-->
<!--                <input type="hidden" name="sourceUuid">-->
<!--                <input type="hidden" name="promocode">-->
<!--                <input type="hidden" name="discount">-->
<!--                <div>-->
<!--                    <input type="text" name="name" class="default-input form__group-input" placeholder="Имя" required>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <input type="email" name="email" class="default-input form__group-input" placeholder="Email" required>-->
<!--                </div>-->
<!--                <div class="form__group-input">-->
<!--                    <input type="tel" name="phone" placeholder="912 345-67-89" id="phone" required>-->
<!--                </div>-->
<!--                <div class="form__group-text" style='margin-bottom: 20px;'>-->
<!--                    <span>Введите номер телефона в формате +<strong>7-916-</strong>.., если ваш номер <strong>8-916-</strong>.-->
<!--                    </span>-->
<!--                </div>-->
<!--                <div>-->
<!--                    <input type="text" name="promo" class="default-input" placeholder="Введите промокод">-->
<!--                </div>-->
<!--                <div class="form__group-text"><label for=""-->
<!--                                                     class="default-checkbox default-checkbox--inline default-checkbox--light form__group-checkbox">-->
<!--                        <input id="" type="checkbox" value="" class="default-checkbox__check">-->
<!--                        <span class="default-checkbox__title">Подписанием и отправкой этой заявки я подтверждаю, что я ознакомлен с-->
<!--                            <a class="link link--grey"-->
<!--                               target="_blank"-->
<!--                               href="--><?//= get_privacy_policy_url(); ?><!--">-->
<!--                                --><?php //pll_e("Политикой конфиденциальности"); ?>
<!--                            </a> и принимаю её условия, включая регламентирующие обработку моих персональных данных, и согласен с ней. Я даю своё согласие на обработку персональных данных в соответствии с данной Политикой конфиденциальности.</span>-->
<!--                    </label></div>-->
<!--                <button class="btn form__btn">--><?php //pll_e("Забронировать место"); ?><!--</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
    <form id="form_professions" class="form section--brand">
        <div class="container">
            <div class="form__content">
                <div class="form__main text-white">
                    <p class="title-md text-bold form__title">
                        <?php pll_e("Успей забронировать свое место в группе"); ?>
                    </p>
                    <div class="form__info">
                        <div class="form__block">
                            <div class="form__block-icon">
                                <img src="<?= get_template_directory_uri(); ?>/images/icons/form.svg" alt="">
                            </div>
                            <div class="form__main-content">
                                <div class="form__block-title text-bold">Гарантия возврата</div>
                                <div class="text-md form__block-text text-light-purple">
                                    Если после первого занятия ты почувствуешь, что этот курс не для тебя (например, не подходит по сложности), мы вернем деньги.
                                </div>
                            </div>
                        </div>
                        <div class="form__block">
                            <div class="form__block-icon">
                                <img src="<?= get_template_directory_uri(); ?>/images/icons/form.svg" alt="">
                            </div>
                            <div class="form__main-content">
                                <div class="form__block-title text-bold">Оплата одним или двумя платежами</div>
                                <div class="text-md form__block-text text-light-purple">
                                    В договоре на обучение можно выбрать оплату сразу на весь курс или двумя платежами.
                                </div>
                            </div>
                        </div>
                        <div class="form__block">
                            <div class="form__block-icon">
                                <img src="<?= get_template_directory_uri(); ?>/images/icons/form.svg" alt="">
                            </div>
                            <div class="form__main-content">
                                <div class="form__block-title text-bold">Беспроцентная рассрочка от партнеров</div>
                                <div class="text-md form__block-text text-light-purple">
                                    Выбирай удобную рассрочку на 12 месяцев и получай знания с комфортом.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form__table">
                        <div class="form__table-element">
                            <div class="fourth-title text-white text-bold form__table-title">Стоимость курса</div>
                            <div class="text-crossed form__table-text-crossed">147 000 руб</div>
                            <div class="text-bold fourth-title form__table-text">110 000 руб</div>

                        </div>
                        <div class="form__table-element">
                            <div class="fourth-title text-white text-bold form__table-title">Стоимость курса <br>с рассрочкой</div>
                            <div class="text-bold fourth-title form__table-text">от 30 000 руб/месяц</div>

                        </div>
                    </div>
                </div>
                <div id="form" class="form__container form__container--half">
                    <div class="form__group">
                        <input type="hidden" name="target_id" value="<?= empty($lang_post_id) ? $post_id : $lang_post_id;?>"/>
                        <input type="hidden" name="sourceUuid">
                        <input type="hidden" name="promocode">
                        <input type="hidden" name="discount">
                        <div>
                            <input type="text" name="name" class="default-input form__group-input" placeholder="Имя" required>
                        </div>
                        <div>
                            <input type="email" name="email" class="default-input form__group-input" placeholder="Email" required>
                        </div>
                        <div class="form__group-input">
                            <input type="tel" name="phone" placeholder="912 345-67-89" id="phone" required>
                        </div>
                        <div class="form__group-text" style='margin-bottom: 20px;'>
                <span>Введите номер телефона в формате +<strong>7-916-</strong>.., если ваш номер <strong>8-916-</strong>.
                </span>
                        </div>
                        <div>
                            <input type="text" name="promo" class="default-input" placeholder="Введите промокод">
                        </div>
                        <div class="form__group-text"><label for=""
                                                             class="default-checkbox default-checkbox--inline default-checkbox--light form__group-checkbox">
                                <input id="" type="checkbox" value="" class="default-checkbox__check">
                                <span class="default-checkbox__title">Подписанием и отправкой этой заявки я подтверждаю, что я ознакомлен с
                        <a class="link link--grey"
                           target="_blank"
                           href="<?= get_privacy_policy_url(); ?>">
                            <?php pll_e("Политикой конфиденциальности"); ?>
                        </a> и принимаю её условия, включая регламентирующие обработку моих персональных данных, и согласен с ней. Я даю своё согласие на обработку персональных данных в соответствии с данной Политикой конфиденциальности.</span>
                            </label></div>
                        <button class="btn form__btn"><?php pll_e("Забронировать место"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php
get_footer();
