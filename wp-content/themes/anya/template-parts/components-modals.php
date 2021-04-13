<div class="modal fade" id="modalConsultForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title title__sm" id="exampleModalLabel">

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_consult_modal" class="">
                    <div class="">
                        <div class="third-title text-bold text-center">
                            БЕСПЛАТНАЯ КОНСУЛЬТАЦИЯ
                        </div>
                        <div class="text-md text-center form__subtitle">
                            Остались вопросы о курсе?<br>
                            Запишись на бесплатную консультацию!<br>
                            Поможем выбрать курс для тебя
                        </div>
                        <div class="">
                            <input type="hidden" name="sourceUuid">
                            <div>
                                <input type="text" name="name" class="default-input form__group-input" placeholder="Имя" required>
                            </div>
                            <div class="form__group-input">
                                <input type="tel" name="phone" id="phone" required>
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
                            <button class="btn form__btn">Записаться</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
            <!--                <button type="button" class="btn btn-primary">Send request</button>-->
            <!--            </div>-->
        </div>
    </div>
</div>

<?php 
 


if(!empty(get_query_var('eu_country')) and get_query_var('eu_country') != 'ua' ): ?>

<div class="modal fade" id="modalPrivacyPolicy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="border: 0;">
                <h5 class="modal-title title__sm" id="exampleModalLabel">

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="">
                        <h4 class="fourth-title text-bold text-center">
                            Политика конфиденциальности
                        </h4>
                        <div class="text-center form__subtitle">
                            Академия обучения ИТ ITEA стремится открыто и в понятной форме сообщать своим пользователям о том, как собираются и обрабатываются их персональные данные. Мы ценим Вашу уверенность в том, что мы будем делать это тщательно и разумно.
                            <br><br>
                            Политика конфиденциальности предназначена для того, чтобы способствовать формированию у Вас понимания того, каким образом мы осуществляем сбор, раскрытие и обеспечение безопасности информации о Вас, получаемой нами в ходе посещения и просмотра Вами нашего веб-ресурса.
                            <br>
                            <br>
                            Продолжая использовать данный сайт и нажимая кнопку "Принять", Вы подтверждаете, что ознакомились с
                            <a href="<?= get_privacy_policy_url();?>">Политикой Конфиденциальности</a> и согласны на обработку Ваших персональных данных на изложенных в
                            <a href="<?= get_privacy_policy_url();?>">Политике Конфиденциальности</a> условиях.
                        </div>
                <button id="acceptCookiePolicy" class="btn form__btn">Принять</button>
            </div>
        </div>
    </div>
</div>
<?php 
else : ?>
<div class="modal" id="modalPrivacyPolicy" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style='margin: calc(100vh - 230px) 0 1.5rem 0;padding:15px;bottom:0;'>
        <div class="modal-content">
           
            <div class="modal-body">
                    <div class="">
                        <h4 class="fourth-title text-bold text-center">
                            
                        </h4>
                        <div class="text-center form__subtitle">
                        Пользуясь нашим сайтом, вы соглашаетесь с
                            <a href="<?= get_privacy_policy_url();?>">Политикой конфиденциальности</a> и
                            <a href="<?= get_privacy_policy_url();?>">Политикой использования Cookies</a>
                        </div>
                <button id="acceptCookiePolicy" class="btn form__btn">ОК</button>
            </div>
        </div>
    </div>
</div>
    
<?php
endif; ?>