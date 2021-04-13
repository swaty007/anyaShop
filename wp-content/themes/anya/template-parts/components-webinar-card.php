<?php
$webinar_id = get_query_var('webinar_id');
?>
<a href="<?php the_permalink();?>" class="card-web">
    <div class="card-web__label third-title text-bold">
        <div class="card-web__label-overlay"></div>
        <span>
            <?= wp_get_post_terms($webinar_id, 'courses_category')[0]->name; ?>
        </span>
    </div>
    <div class="card-web__main">
        <div class="fourth-title text-medium"><?= get_the_title($webinar_id); ?></div>
        <div class="card-web__main-info">
            <div class="card-web__main-col">
                <div class="card-web__main-title text-medium text-md">
                    <?php pll_e("Дата");?>
                </div>
                <div class="text-md">
                    <?php while (have_rows('date', $webinar_id)): the_row();?>
                        <div class="main__table-td">
                            <?= date_i18n( 'F j', strtotime(get_sub_field('date', false))); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="card-web__main-col">
                <div class="card-web__main-title text-medium text-md">
                    <?php pll_e("Время");?>
                </div>
                <div class="text-md">
                    <?php while (have_rows('date', $webinar_id)): the_row();?>
                        <div class="main__table-td">
                            <?= date('H:i', strtotime(get_sub_field('date', false))); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="card-web__main-col">
                <div class="card-web__main-title text-medium text-md">
                    <?php pll_e("Стоимость");?>
                </div>
                <div class="text-md">
                    <?php if (get_post_meta($webinar_id, 'is_free', true)): ?>
                        <div class="main__table-td main__table-td--label"><?php pll_e("Бесплатно");?></div>
                    <?php else: ?>
                        <?= get_post_meta($webinar_id, 'cost', true);?> <?= get_post_meta($webinar_id, 'currency', true);?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-web__column">
        <div class="card-web__column-text">
            <?= get_the_excerpt($webinar_id); ?>
        </div>
        <button class="btn btn-nobg"><?php pll_e("Подробнее");?></button>
    </div>
</a>
