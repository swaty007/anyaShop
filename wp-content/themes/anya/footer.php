<?php
?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">Контакты</div>
                <p class="address">Голосеевский проспект, <br>Киев, <br>03038, <br>Украина, <br>+38(044) 502 51 51, <br>info@prophoto.ua
                </p>
            </div>
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">Навигация</div>
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
                <div class="title">Каталог</div>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-catalog',
                    'menu_id' => 'menu-footer-catalog',
                    'container' => 'ul',
                    'menu_class' => 'links',
                ]);
                ?>
            </div>
            <div class="col-sm-4 col-md-3 content-wrapper">
                <div class="title">Социальные сети</div>
                <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
    <div class="copyright">
        <span>© 2018 Prophoto</span>
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

</body>
</html>
