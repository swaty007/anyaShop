<?php
/* Template Name: Рассписание */

get_header();
the_post();
$lang = get_query_var('lang');
?>


    <section class="section--blue schedule">
        <div class="container">
            <h1 class="title schedule__title text-center">
                <?php the_title(); ?>
            </h1>
            <div class="schedule__header">
                <div class="schedule__table-td schedule__table-td--name text-bold"><?php pll_e("Название курса");?></div>
                <div class="schedule__table-td schedule__table-td--long schedule__table-td--nopadd text-bold">
                    <?php pll_e("Длительность");?>
                </div>
                <div class="schedule__table-td schedule__table-td--price schedule__table-td--nopadd text-bold">
                    <?php pll_e("Стоимость курса");?>
                </div>
                <?php 
                            $m = date("m") > 12 ? 1 : date("m");
                            $next_month = date("m")+1 > 12 ? 1 : date("m")+1;
                            $post_next_month = $next_month+1 > 12 ? 1 : $next_month+1;
                            $post_next_month2 = $post_next_month+1 > 12 ? 1 : $post_next_month+1;
                            $months = [ $m,$next_month,$post_next_month,$post_next_month2];
                            for ($num = 0; $num < 4; $num++): ?>
                    <div class="schedule__table-td schedule__table-td--mounth text-bold">
                        <?= date_i18n("F",mktime(0,0,0,$months[$num],1,2011)); ?>
                    </div>
                <?php endfor; ?>
            </div>
            <?php
            $courses_terms = get_terms([
                'taxonomy' => 'courses_category',
            ]);
            foreach ($courses_terms as $term):?>
            <div class="schedule__table">

                    <div class="schedule__table-title text-medium fourth-title"><?= $term->name; ?></div>
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
                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <?php
                        $post_id = $post->ID;
                        if (!empty($lang) && !empty($lang_post_id = pll_get_post($post_id, $lang))) {
                            $cost = get_post_meta($lang_post_id, 'cost', true);
                            $currency = get_post_meta($lang_post_id, 'currency', true);
                            $discount_price = get_post_meta($lang_post_id, 'discount_price', true);
                        } else {
                            $cost = get_post_meta($post_id, 'cost', true);
                            $currency = get_post_meta($post_id, 'currency', true);
                            $discount_price = get_post_meta($post_id, 'discount_price', true);
                        }

                        $ismonth = get_post_meta($post_id, 'ismonth', true);
                        $hours = get_post_meta($post_id, 'hours', true);
                        $lessons = get_post_meta($post_id, 'lessons', true);
                        $date = get_post_meta($post_id, 'date', true); //repeater
                        $dates = [];
                        while (have_rows('date', $post_id)): the_row();
                            $dates[] = get_sub_field('date', false);
                        endwhile;
                        ?>
                        <a href="<?php the_permalink();?>" class="schedule__table-tr">
                            <div class="schedule__table-td schedule__table-td--name">
                                <div class="text-bold schedule__table-mob"><?php pll_e("Название курса");?></div>
                                <div class=""><span class=""><?php the_title(); ?></span></div>
                                <?php if ($discount_price): ?>
                                    <span class="schedule__table-label schedule__table-label--hide text-bold">
                                        -<?= number_format(($cost - $discount_price) * 100 / $cost);?>%
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="schedule__table-td schedule__table-td--long">
                                <div class="text-bold schedule__table-mob"><?php pll_e("Длительность");?></div>
                                <div><?=$hours;?> ч</div>
                            </div>
                            <div class="schedule__table-td schedule__table-td--price">
                                <div class="text-bold schedule__table-mob"><?php pll_e("Стоимость курса");?></div>
                                <div>
                                    <?php if ($discount_price): ?>
                                        <div class="text--xxs text-crossed"><?= $cost; ?> <?= $currency; ?></div>
                                        <div>
                                            <span class="text-pink text-md text-bold"><?= $discount_price; ?> </span> <?= $currency; ?>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <span class="text-pink text-md text-bold"><?= $cost; ?> </span> <?= $currency; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($discount_price): ?>
                                        <span class="schedule__table-label schedule__table-label--mob text-bold">  -<?= number_format(($cost - $discount_price) * 100 / $cost);?>%</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php for ($num = 0; $num < 4; $num++): ?>
                                <?php $month_str = strtotime("+$num month", time()); ?>
                                
                                <div class="schedule__table-td schedule__table-td--mounth">
                                    <div class="text-bold schedule__table-mob"><?= date_i18n("F",mktime(0,0,0,$months[$num],1,2011)); ?></div>
                                   <div class="schedule__table-td--col">
                                    <?php foreach ($dates as $date):
                                        if (date("m", strtotime($date)) === date("m",mktime(0,0,0,$months[$num],1,2011))):?>
                                            <?= date_i18n('d.m.Y', strtotime($date)); ?>
                                        <?php endif;
                                    endforeach; ?>
                                   </div>
                                </div>
                            <?php endfor; ?>
                        </a>
                    <?php endwhile;
                    wp_reset_query(); ?>

            </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php
get_footer();
