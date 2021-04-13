<?php
$course_id = get_query_var('course_id');
//$course_id_main = pll_get_post($course_id, 'ru');
$term_id = get_query_var('term_id');
$all_terms_id = [];
if (empty($term_id)) {
    $terms = wp_get_post_terms($course_id, 'courses_category');
    $term = $terms[0];
    if ($term->parent !== 0) {
        $term = get_term($term->parent);
    }
    foreach ($terms as $child) {
        $all_terms_id[] = $child->term_id;
        $all_terms_id[] = $child->parent;
    }
} else {
    $term = get_term($term_id);
    $all_terms_id[] = $term->term_id;
    $all_terms_id[] = $term->parent;
}

$all_terms_id = array_unique($all_terms_id);

$color = get_term_meta($term->term_id, 'color', true);
$cost = get_post_meta($course_id, 'cost', true);
$discount_price = get_post_meta($course_id, 'discount_price', true);
$lessons = 0;
if (get_post_type($course_id) == 'professions') {
    foreach (get_post_meta($course_id, 'profession_courses', true) as $course) {
        $lessons += get_post_meta($course, 'lessons', true);
        $cost += get_post_meta($course, 'cost', true);
    }
} else {
    $lessons = get_post_meta($course_id, 'lessons', true);
}

?>
<a href="<?= get_the_permalink($course_id);?>" class="card" style="background: linear-gradient(180deg, #FFFFFF 0%, <?=$color;?>12 100%);"
   data-id="<?= implode(',',$all_terms_id);?>"
   data-advanced="<?= get_post_meta($course_id, 'advanced', true); ?>"
   data-slug="<?= $term->slug;?>">
    <div class="card__label" style="background: <?= $color;?>;">
        <div class="text-md card__label-text-md text-bold card__label-text-md--upper">
            <?php if ($discount_price): ?>
                <?php pll_e("СКИДКА");?> -<?= number_format(($cost - $discount_price) * 100 / $cost);?>%
            <?php else: ?>
                <?= $term->name; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="card__info">
        <div class="card__main">
            <h3 class="fourth-title text-medium card__column-title">
                <?= get_the_title($course_id); ?>
            </h3>
            <div>
                <?php if (empty(get_post_meta($course_id, 'about_card', true))):?>
                    <?= get_the_excerpt($course_id);?>
                <?php else:?>
                    <?= get_post_meta($course_id, 'about_card', true); ?>
                <?php endif;?>

            </div>
        </div>
        <div class="card__column">
            <div class="card__column-title text-medium">
                <?php pll_e("Старт");?>
            </div>
            <?php if (have_rows('date', $course_id)):?>
            <?php while (have_rows('date', $course_id)): the_row();?>
                <div><?php the_sub_field('date') ?></div>
            <?php endwhile; ?>
            <?php else:?>
                <?php pll_e("Идет набор на курс");?>
            <?php endif;?>
        </div>
        <div class="card__column">
            <div class="card__column-title text-medium">
                <?php pll_e("Длительность курса");?>
            </div>
            <div>
                <?= $lessons; ?> <?php pll_e("занятий");?>
            </div>
        </div>
        <button class="btn btn--md btn-nobg card__btn">
            <?php pll_e("Подробнее"); ?>
        </button>
    </div>
</a>