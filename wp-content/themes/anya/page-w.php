<?php
/* Template Name: Трудоустройство*/

get_header();
the_post(); ?>
<?php
$post_id = $post->ID;
$teachers = get_post_meta($post->ID, 'teachers', true);
$qs = get_field("quick_start");
$ip = get_field("itea_placement");
$prof = get_field("profession");
$help = get_field("help_choice");
$programing = get_field("programing");
$preparation = get_field("preparation");
$working = get_field('working');
$jungo = get_field('jungo');
$employment = get_field('employment');
$mobv = get_field('mobile_version');
//var_dump($mobv);
?>

    <section class='big_section'>
        <div class="container">
            <div class="big_section_wrapper">
                <div class="big_section_bg">
                    EDUCATION
                </div>
                <div class="big_section-left">
                    <div class="big_section_title small-width">
                        <h2> <?php echo $mobv['quick_start']['title']; ?> </h2>
                    </div>
                    <div class="big_section_title desctop-width">
                        <h2><?php echo $qs['title'] ?></h2>
                    </div>
                    <div class="big_section_text small-width">
<!--                        <p> Онлайн-академия эффективного обучения: от выбора направления до-->
<!--                            трудоустройства</p> -->
                        <p>  <?php echo $mobv['quick_start']['text']; ?></p>
                    </div>
                    <div class="big_section_text desctop-width">
                        <?php echo $qs['text'] ?>
                    </div>
                    <a href='<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>' class="big_section_consult desctop-width btn_inherit">консультация</a>
                </div>
                <div class="big_section-right">
                    <img src="<?= get_template_directory_uri(); ?>/images/bg/computer2.svg" alt="">
                    <a href='<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>' class="big_section_consult small-width btn_inherit">Консультация</a>
                </div>
            </div>
        </div>
    </section>
<?php if ($ip): ?>
    <section class='complex'>
        <div class="container">
            <div class="complex_header">
                <div class="complex_title work-title">
                    <h2><?php echo $ip['title'] ?></h2>
                </div>
                <div class="complex_text work-text">
                    <?php echo $ip['text'] ?>
                </div>
            </div>
            <div class="complex_items">
                <a href="#help" class="complex_item">
                    <div class="complex_numb">1</div>
                    <p> <?php echo $ip['block1']?></p></a>
                <a href="#programing" class="complex_item">
                    <div class="complex_numb">2</div>
                    <p><?php echo $ip['block2']?></p></a>
                <a href="#preparation" class="complex_item">
                    <div class="complex_numb">3</div>
                    <p><?php echo $ip['block3']?></p></a>
                <a href="#working" class="complex_item">
                    <div class="complex_numb">4</div>
                    <p><?php echo $ip['block4']?></p></a>
                <a href="#jungo" class="complex_item">
                    <div class="complex_numb">5</div>
                    <p><?php echo $ip['block5']?></p></a>
            </div>
        </div>

    </section>
<?php endif; ?>
<?php if ($prof): ?>
    <section class='special'>
        <a id="special" class='anchor_link'></a>
        <div class="special_wrapper"
             style='background-image: radial-gradient(rgba(255,255,255,0.1) 2px, transparent 0);
                    background-size: 40px 40px;
                    background-position: -18px -18px;'>
            <div class="container">
                <div class="special_title">
                    <?php echo $prof['title'] ?>
                </div>
                <div class="special_text">
                    <?php echo $prof['text'] ?>
                </div>
                <div class="special_img">
                    <img src="<?php echo get_template_directory_uri() ?>/images/people/boy.png" alt="">
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<?php if ($help): ?>
    <section class='help'>
        <a id="help" class='anchor_link'></a>
        <div class="container">


            <div class="help_header">
                <div class="help_title work-title">
                    <?php echo $help['title'] ?>
                </div>
                <div class="help_text work-text">
                    <?php echo $help['text'] ?>
                </div>
            </div>
            <div class="help_items">
                <div class="help_item">
                    <img src="<?php echo get_template_directory_uri() ?>/images/Tilda_Icons_10cw_bubbles.png" alt=""
                         class="help_item_img">
                    <div class="help_item_title">
                        <?php echo $help['blocks'][0]['title'] ?>
                    </div>
                    <div class="help_item_text">
                        <?php echo $help['blocks'][0]['text'] ?>
                    </div>
                    <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" target="_blank" class='help_item_link btn_inherit'>Оставить заявку</a>
                </div>
                <div class="help_item">
                    <img src="<?php echo get_template_directory_uri() ?>/images/Tilda_Icons_40_IT_effective.png" alt=""
                         class="help_item_img">
                    <div class="help_item_title">
                        <?php echo $help['blocks'][1]['title'] ?>
                    </div>
                    <div class="help_item_text">
                        <?php echo $help['blocks'][1]['text'] ?>
                    </div>
                    <a href="https://pathfinder.work" target="_blank" class='help_item_link btn_inherit'>Узнать направление</a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ($programing): ?>
    <section class='programing'>
        <a id="programing" class='anchor_link'></a>
        <div class="container">
            <div class="programing_header">
                <div class="programing_title work-title">
                    <?php echo $programing['title']; ?>
                </div>
                <div class="programing_text work-text">
                    <?php echo $programing['text']; ?>
                </div>
                <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" class='programing_link desctop-width btn_inherit'>Консультация</a>
            </div>
            <div class="programing_footer">
                <img src='<?php echo get_template_directory_uri() ?>/images/rocket.svg' alt="" class="programing_img">
                <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" class='programing_link small-width btn_inherit'>Консультация</a>
            </div>

            <div class="programing_benefits">
                <!-- закоментируешь это -->
                <!--                <h2 class="title text-center benefites-list__title"> Обучение с ITEA - это:</h2>-->
                <!--                <div class="benefites-wrap">-->
                <!--                    <div class="benefites benefites--lg">-->
                <!--                        <div class="benefites__icon"><img-->
                <!--                                    src="https://onlineitea.com/wp-content/uploads/2020/10/mac-1.svg" class="lazyloaded"-->
                <!--                                    data-ll-status="loaded">-->
                <!--                            <noscript><img src=https://onlineitea.com/wp-content/uploads/2020/10/mac-1.svg></noscript>-->
                <!--                        </div>-->
                <!--                        <p class="sixth-title benefites__title text-medium"> Дистанционный формат онлайн-обучения</p>-->
                <!--                        <p class="text-md"></p>-->
                <!--                        <p>Для изучения нового материала по особенностям работы PM/CAMP уроки проводят в онлайн-режиме.-->
                <!--                            У тебя появится отличная возможность для нетворкинга как с преподавателями, так и с другими-->
                <!--                            студентами. Забудь про изматывающие поездки — просто запускай стрим в назначенное время из-->
                <!--                            удобного места с любого девайса.</p>-->
                <!--                        <p></p></div>-->
                <!--                    <div class="benefites benefites--lg">-->
                <!--                        <div class="benefites__icon"><img-->
                <!--                                    src="https://onlineitea.com/wp-content/uploads/2020/10/bubbles.svg"-->
                <!--                                    class="lazyloaded" data-ll-status="loaded">-->
                <!--                            <noscript><img src=https://onlineitea.com/wp-content/uploads/2020/10/bubbles.svg></noscript>-->
                <!--                        </div>-->
                <!--                        <p class="sixth-title benefites__title text-medium"> Интерактивный курс с упором на практику</p>-->
                <!--                        <p class="text-md"></p>-->
                <!--                        <p>Каждый разработчик или менеджер в IT-сфере должен обладать практическим опытом. Команда ITEA-->
                <!--                            поможет тебе в этом! Образовательный план включает интересный теоретический материал,-->
                <!--                            который эффективно подкрепляется практическими заданиями для разработки оптимальной системы-->
                <!--                            управления проектами.</p>-->
                <!--                        <p></p></div>-->
                <!--                    <div class="benefites benefites--lg">-->
                <!--                        <div class="benefites__icon"><img-->
                <!--                                    src="https://onlineitea.com/wp-content/uploads/2020/10/group.svg" class="lazyloaded"-->
                <!--                                    data-ll-status="loaded">-->
                <!--                            <noscript><img src=https://onlineitea.com/wp-content/uploads/2020/10/group.svg></noscript>-->
                <!--                        </div>-->
                <!--                        <p class="sixth-title benefites__title text-medium"> Мини-группы до 15 человек</p>-->
                <!--                        <p class="text-md"></p>-->
                <!--                        <p>Для комфортного изучения особенностей работы в направлении Project Management мы собираем-->
                <!--                            студентов в небольшие группы. Такой подход очень удобен как для учеников, так и для-->
                <!--                            преподавателей. Каждый получит необходимое количество внимания коуча и сможет проработать-->
                <!--                            сложные моменты программы под его руководством.</p>-->
                <!--                        <p></p></div>-->
                <!--                    <div class="benefites benefites--lg">-->
                <!--                        <div class="benefites__icon"><img-->
                <!--                                    src="https://onlineitea.com/wp-content/uploads/2020/10/company.svg"-->
                <!--                                    class="lazyloaded" data-ll-status="loaded">-->
                <!--                            <noscript><img src=https://onlineitea.com/wp-content/uploads/2020/10/company.svg></noscript>-->
                <!--                        </div>-->
                <!--                        <p class="sixth-title benefites__title text-medium"> Стажировка</p>-->
                <!--                        <p class="text-md"></p>-->
                <!--                        <p>Карьерный центр ITEA поможет тебе пройти стажировку в крутых компаниях, которые сотрудничают-->
                <!--                            с нами через портал JunGo. Чтобы упростить поиск работы, мы зарегистрируем тебя на этом-->
                <!--                            ресурсе после окончания курса. Ты сможешь найти место, где получишь еще больше опыта и где-->
                <!--                            не будет требоваться программирование.</p>-->
                <!--                        <p></p></div>-->
                <!--                </div>-->
                <!-- готовый код разкоментируй -->

                <h2 class="title text-center benefites-list__title">
                    <?php echo $programing['title2']; ?>
                </h2>
                <div class="benefites-wrap">
                    <?php
                    if (count($programing['cards'])):
                        foreach ($programing['cards'] as $card): ?>
                            <div class="benefites benefites--lg">
                                <div class="benefites__icon">
                                    <img src="<?= $card['icon']; ?>"/>
                                </div>
                                <p class="sixth-title benefites__title text-medium">
                                    <?= $card['title']; ?>
                                </p>
                                <p class="text-md" style='font-size:14px;'>
                                    <?= $card['description']; ?>
                                </p>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ($employment): ?>
    <section class='employment'>
        <div class="employment_wrapper"
             style='background-image:url("<?php echo get_template_directory_uri() ?>/images/bg/doted.svg");'>
            <div class="container">

                <div class="employment-left">
                    <div class="employment_title work-title text-bold">
                        <h2>  <?php echo $employment['title'] ?></h2>
                    </div>
                    <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" class='employment_link employment_link--desk'>Бесплатная консультация</a>
                </div>
                <div class="employment-right">
                    <div class="employment-items">
                        <?php foreach ($employment['strings'] as $string): ?>
                            <div class="employment-item">
                                <p> <?php echo $string['text']; ?></p>
                            </div>
                        <?php endforeach; ?>
                        <!--                        <div class="employment-item">-->
                        <!--                            <p>Помощь в составлении резюме и создании портфолио</p>-->
                        <!--                        </div>-->
                        <!--                        <div class="employment-item">-->
                        <!--                            <p> Консультации с ментором</p>-->
                        <!--                        </div>-->
                        <!--                        <div class="employment-item">-->
                        <!--                            <p>Помощь в трудоустройстве после завершения комплексных программ</p>-->
                        <!--                        </div>-->

                    </div>
                    <a href="https://itea-web-master.demo.gns-it.com/consultation/" class="employment_link employment_link--tab">Бесплатная консультация</a>
                </div>
            </div>
            <img src="<?php echo get_template_directory_uri() ?>/images/people/girl1.png" alt="" class="employment_img">
        </div>
    </section>
<?php endif; ?>

<?php if ($preparation) : ?>
    <section class='preparation'>
        <a id="preparation" class='anchor_link'></a>
        <div class="container">


            <div class="preparation_header ">
                <div class="preparation_title work-title">
                    <h2>
                        <?php echo $preparation['title']; ?>
                    </h2>
                </div>
                <div class="preparation_text work-text">
                    <p>
                        <?php echo $preparation['text']; ?>
                    </p>
                </div>
                <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" class="preparation_link desctop-width">
                    Консультация
                </a>
            </div>
            <div class="preparation_content">
                <img src="<?php echo get_template_directory_uri() ?>/images/comp6.svg" alt="" class="preparation_img">
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ($working) : ?>
    <section class='working'>
        <a id="working" class='anchor_link'></a>
        <div class="container">
            <div class="working_header">
                <div class="working_title work-title">
                    <h2>
                        <?php echo $working['title']; ?>
                    </h2>
                </div>
                <div class="working_text work-text">
                    <?php echo $working['text']; ?>
                </div>
            </div>
            <div class="working_content">
                <a href="<?php echo get_permalink(pll_get_post(get_page_id_by_template('page-consult.php'))); ?>" style='display:none;' class="working_link work-link btn_inherit">
                    Консультация
                </a>
                <img src="<?php echo get_template_directory_uri() ?>/images/crane.svg" alt=""
                     class="working_img work-img">
            </div>
            <?php get_template_part('template-parts/components', 'companies2'); ?>
        </div>
    </section>
<?php endif; ?>
<?php if ($jungo): ?>
    <section class='jungo section--blue'>
        <a id="jungo" class='anchor_link'></a>
        <div class="container">
            <div class="jungo_header">
                <div class="jungo_title work-title">
                    <h2>
                        <?php echo $jungo['title']; ?>
                    </h2>
                </div>
                <div class="jungo_text work-text">
                    <?php echo $jungo['text']; ?>
                </div>
            </div>
            <div class="jungo_content work-content">
                <a href="https://www.jungo.dev" target="_blank" class="jungo_link work-link btn_inherit">Больше о JunGО</a>
                <ul class="jungo_ul">
                    <?php foreach ($jungo['list'] as $item): ?>
                        <li>  <?php echo $item['text'] ?></li>
                    <?php endforeach; ?>
                    <!--                    <li>ты сможешь открыть свое резюме для поиска вакансий уже после своего первого базового курса;</li>-->
                    <!--                    <li>ты найдешь предложения с помощью удобного агрегатора вакансий. Это дает возможность-->
                    <!--                        рассматривать вакансии для начинающих не только на JunGO (вакансии зарегистрированных в системе-->
                    <!--                        работодателей), но и на других ресурсах по поиску работы и всех сайтов в интернете;-->
                    <!--                    </li>-->
                    <!--                    <li>после каждого завершенного курса, система будет автоматически обновлять твои данные;</li>-->
                    <!--                    <li>у тебя будет возможность получить работу различного формата: стажировка, фриланс или полный день-->
                    <!--                        в офисе компании. Работодатели предлагают работу как на территории СНГ, так и за границей.-->
                    <!--                    </li>-->
                </ul>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
get_footer();
