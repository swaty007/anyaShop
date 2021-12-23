<?php
?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">
                    <?php pll_e("Контакты");?>
                </div>
                <p class="address">
                    <?php pll_e('Украина, Киев<br><a href="tel:+380956357677">+380956357677</a><br><a href="mailto:admin@zoomstore.com.ua">admin@zoomstore.com.ua</a><br><a href="mailto:sales@zoomstore.com.ua">sales@zoomstore.com.ua</a>');?>
                </p>
            </div>
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">
                    <?php pll_e("Навигация");?>
                </div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-navigation',
                    'menu_id' => 'menu-footer-navigation',
                    'container' => 'ul',
                    'menu_class' => 'links',
                ]);
                ?>
            </div>
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">
                    <?php pll_e("Каталог");?>
                </div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-catalog',
                    'menu_id' => 'menu-footer-catalog',
                    'container' => 'ul',
                    'menu_class' => 'links',
                ]);
                ?>
            </div>
            <?php dynamic_sidebar( 'social_widget' ); ?>
        </div>
    </div>
    <div class="copyright">
        <span><?php pll_e("© 2021 Zoom Store");?></span>
    </div>
</footer>


<?php wp_footer(); ?>

<!--<script src="--><?//= get_template_directory_uri(); ?><!--/js/jquery.min.js" type="text/javascript"></script>-->
<!-- Bootstrap carousel -->
<script src="<?= get_template_directory_uri(); ?>/plugins/bootstrap-carousel/carousel.min.js" type="text/javascript"></script>

<!-- Countdown timer -->
<script src="<?= get_template_directory_uri(); ?>/plugins/countdown-timer/countdown-timer.js" type="text/javascript"></script>

<!-- Slick slider -->
<script src="<?= get_template_directory_uri(); ?>/plugins/slick-slider/slick.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.8.3/min/tiny-slider.js"></script>

<!-- Product frontend -->
<script src="<?= get_template_directory_uri(); ?>/js/global/product-anim.js" type="text/javascript"></script>

<!-- Global -->
<!--<script src="--><?//= get_template_directory_uri(); ?><!--/js/global/banners-slider.js" type="text/javascript"></script>-->
<script src="<?= get_template_directory_uri(); ?>/js/global/products.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/global/menu.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/global/price-range-slider.js" type="text/javascript"></script>
<script src="<?= get_template_directory_uri(); ?>/js/global/custom-select.js" type="text/javascript"></script>


<?php get_template_part('template-parts/components', 'modals'); ?>
<!--<script defer type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" id="fancybox-js"></script>-->
</body>
</html>
