<?php
/* Template Name: Consult */

get_header();
the_post();
?>


    <form id="form_consult" class="form section--blue">
        <div class="container form__container form__container--shadowed">
                <?php if(!empty($_GET['trial'])):?>
                    <div class="third-title text-bold text-center fromBottomHalf">Оставь свои данные</div>
                    <div class="text-md text-center form__subtitle fromBottomHalf">
                        и мы вышлем тебе запись занятий, чтобы ты лично
                    </div>
                    <div class="text-md text-center form__subtitle fromBottomHalf">
                         убедился в эффективности наших курсов
                    </div>
                    
                <?php else: ?>
                    <div class="third-title text-bold text-center fromBottomHalf">Оставь свои данные</div>
                    <div class="text-md text-center form__subtitle fromBottomHalf">
                и мы свяжемся с тобой в ближайшее время!
            </div>
                <?php endif;?>
            
            <div class="form__group fromBottomHalf">
                <?php if(!empty($_GET['target_id'])):?>
                    <input type="hidden" name="target_id" value="<?=$_GET['target_id'];?>"/>
                <?php endif;?>
                <?php if(!empty($_GET['trial'])):?>
                    <input type="hidden" name="trial" value="1"/>
                <?php endif;?>
                <?php if(!empty($_GET['consult'])):?>
                    <input type="hidden" name="consult" value="1"/>
                <?php endif;?>
                <input type="hidden" name="sourceUuid">
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
                <div class="form__group-text">
                    <label for=""
                           class="default-checkbox default-checkbox--inline default-checkbox--light form__group-checkbox">
                        <input id="" type="checkbox" value="" class="default-checkbox__check">
                        <span class="default-checkbox__title">
                        Подписанием и отправкой этой заявки я подтверждаю, что я ознакомлен с
                        <a class="link link--grey"
                           target="_blank"
                           href="<?= get_privacy_policy_url(); ?>"><?php pll_e("Политикой конфиденциальности"); ?></a>
                        и принимаю её условия, включая регламентирующие обработку моих персональных данных, и согласен с ней. Я даю своё согласие на обработку персональных данных в соответствии с данной Политикой конфиденциальности.
                        </span>
                    </label>
                </div>
                <button class="btn form__btn">Получить консультацию</button>
            </div>
        </div>
    </form>
<?php
get_footer();
