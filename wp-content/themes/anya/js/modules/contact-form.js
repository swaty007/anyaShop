// import $ from 'jquery'
import * as Toastr from 'toastr'
import _ from 'lodash'

Toastr.options = {
    'closeButton': false,
    'debug': false,
    'newestOnTop': true,
    'progressBar': true,
    'positionClass': 'toast-top-left',
    'preventDuplicates': false,
    'onclick': null,
    'showDuration': '300',
    'hideDuration': '1000',
    'timeOut': '5000',
    'extendedTimeOut': '1000',
    'showEasing': 'swing',
    'hideEasing': 'linear',
    'showMethod': 'fadeIn',
    'hideMethod': 'fadeOut'
}

class ContactForm {
    constructor () {
        this.events()
    }

    checkPromo (e) {
        let _this = $(e.currentTarget),
          promo = _this.val(),
          form = _this.closest('form')
      if (!promo) return
        form.find('button').attr('disabled', true)
        $.ajax({
            url: iteaData.ajaxurl,
            data: {
                security: iteaData.nonce,
                action: 'check_promo',
                data: {
                    promo: promo,
                  target_id: form.find('input[name="target_id"]').val()
                }
            },
            type: 'POST',
            success: (res) => {
                if (res.success) {
                  let data = res.data,
                    promocodeEl = form.find('input[name="promocode"]'),
                    discountEl = form.find('input[name="discount"]'),
                    promocode = data.uuid,
                    discount = data.discountPercent

                  promocodeEl.val(promocode)
                  discountEl.val(discount)

                  let old_price = $('#current_price').text(),
                    new_price = old_price - (old_price / 100 * discount)
                  $('#promo_active').find('.old_price').text(old_price)
                  $('#promo_active').find('.new_price').text(new_price)
                  $('#promo_active').find('.promo').text(promo)
                  $('#promo_active').find('.promo_discount').text(discount)
                  $('#promo_active').show(300)
                }
            },
            always: () => {
                form.find('button').attr('disabled', false)
            }
        })
    }
    events () {
        $('input[name="promo"]').on('input', _.debounce(this.checkPromo, 700))



        $('#callback_submit').on('submit', (e) => {
            e.preventDefault()
            let phone = $("#callback_submit .iti__selected-dial-code").text() + $("#callback_submit input[type=tel]").val();
            $.ajax({
                url: iteaData.ajaxurl,
                data: {
                    security: iteaData.nonce,
                    action: 'callback',
                    language: iteaData.language,
                    data: {
                        phone: phone,
                        utm_source: $("#callback_submit input[name=sourceUuid]").val(),
                        host: window.location.host
                    }
                },
                type: 'POST',
                success: (data) => {
                    if (data) {
                        document.cookie = `fix_language=${iteaData.language}; path=/; max-age=3600`;
                        window.location.href = iteaData.thank_page_urls.consultation
                    }
                }
            })
        })

        $('#form_consult, #form_courses, #form_professions, #form_consult_modal').on('submit', (e) => {
            e.preventDefault()
            let _this = $(e.currentTarget),
                elements = {
                    phone : _this.find("input[type=tel]"),
                    email : _this.find("input[name=email]"),
                    name : _this.find("input[name=name]"),
                    checkbox : _this.find("input[type=checkbox]"),
                },
              target_id = _this.find("input[name=target_id]").val(),
              is_trial = _this.find("input[name=trial]").val(),
              is_consult = _this.find("input[name=consult]").val()
            if (!this.validate(Object.values(elements))) {
                return
            }

            $.ajax({
                url: iteaData.ajaxurl,
                data: {
                    security: iteaData.nonce,
                    action: 'contact_form',
                    language: iteaData.language,
                    data: {
                        name: elements.name.val(),
                        email: elements.email.val(),
                        phone: _this.find(".iti__selected-dial-code").text() + elements.phone.val(),
                        promo: _this.find("input[name=promo]").val(),
                        promocode: _this.find("input[name=promocode]").val(),
                        discount: _this.find("input[name=discount]").val(),
                        is_trial: is_trial,
                        is_consult: is_consult,
                        target_id: target_id,
                        utm_source: _this.find("input[name=sourceUuid]").val(),
                        host: window.location.host
                    }
                },
                type: 'POST',
                success: (data) => {
                    if (data) {
                        document.cookie = `fix_language=${iteaData.language}; path=/; max-age=3600`;
                        let yandex = false
                        let yandexParam = ''
                        if (target_id == 312 || target_id == 1017 || target_id == 1127 || target_id == 1190 || target_id == 1332 || target_id == 1345 ) {//HTML & CSS
                            yandex = true
                            yandexParam = 'html'
                        }
                        if (target_id == 461 || target_id == 1042 || target_id == 1238 || target_id == 1253 || target_id == 1379 || target_id == 1391 ) {//Python Basic
                             yandex = true
                            yandexParam = 'pythonbas'
                        }
                        if (target_id == 351|| target_id == 1033 || target_id == 1217 || target_id == 1228 || target_id == 1370 || target_id == 1382 ) {//QA Basic
                             yandex = true
                            yandexParam = 'qabasic'
                        }
                        if (target_id == 467|| target_id == 1045 || target_id == 1241 || target_id == 1256 || target_id == 1394 || target_id == 1409 ) {//Graphic
                            yandex = true
                            yandexParam = 'graphic'
                        }

                        if(is_trial && target_id) {
                            if (yandex) {
                                window.location.href = iteaData.thank_page_urls.trial + `?yandex=free${yandexParam}`
                            } else {
                                window.location.href = iteaData.thank_page_urls.trial
                            }

                        }
                        else if (target_id && !is_consult) {
                            if (yandex) {
                                window.location.href = iteaData.thank_page_urls.order + `?yandex=zayav${yandexParam}`
                            } else {
                                window.location.href = iteaData.thank_page_urls.order
                            }
                        } else {
                            if (yandex) {
                                window.location.href = iteaData.thank_page_urls.consultation + `?yandex=zayav${yandexParam}`
                            } else {
                                window.location.href = iteaData.thank_page_urls.consultation
                            }

                        }
                    }
                }
            })
        })

        document.addEventListener('wpcf7submit', function (event) {
            // console.log(event, 'submit')
            console.log(event.detail.apiResponse)
            const response = event.detail.apiResponse

            switch (response.status) {
                case 'validation_failed':
                    Toastr['error'](response.message)
                    break
                case 'mail_sent':
                    Toastr['success'](response.message)
                    break
                default:
                    Toastr['info'](response.message)
                    break
            }
            // response.message
            // var inputs = event.detail.inputs;
            // for ( var i = 0; i < inputs.length; i++ ) {
            // }
        }, false)
        document.addEventListener('wpcf7mailsent', function (event) {
            console.log(event, 'mailsent')
            // let details = event.detail
            // if (details.contactFormId == 218 || details.contactFormId == 292) {
            //     let name = details.inputs.find(i => i.name === 'your-name').value
            //     let email = details.inputs.find(i => i.name === 'your-email').value
            //     let productID = details.inputs.find(i => i.name === 'productid').value
            // }
        }, false)
    }

    validate (elements) {
        let success = true,
            errorClass = 'error'
        elements.forEach((item) => {
            let type = item.attr('type'),
                maxLength = item.attr('max-length')
            if (!item.length) {
                return
            }
            switch (type) {
                case 'email':
                    let re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    if (item.val()) {
                        item.removeClass(errorClass)
                        if (!re.test(item.val())){
                            success = false
                            item.addClass(errorClass)
                        }
                    } else {
                        item.addClass('error')
                        success = false
                    }
                case 'text':
                case 'textarea':
                    if (item.val()) {
                        item.removeClass(errorClass)
                        if (maxLength) {
                            if (item.val().length > maxLength) {
                                success = false
                                item.addClass(errorClass)
                            }
                        }
                    } else {
                        item.addClass(errorClass)
                        success = false
                    }
                    break;
                case 'tel':
                    if (item.val()) {
                        item.removeClass(errorClass)
                        if (item.attr('placeholder') && item.attr('placeholder').length !== item.val().length) {
                            item.addClass(errorClass)
                            success = false
                        }
                    } else {
                        item.addClass('error')
                        success = false
                    }
                    break;
                case 'checkbox':
                    if (item.prop('checked')) {
                        item.removeClass(errorClass)
                    } else {
                        item.addClass('error')
                        success = false
                    }
                    break;
            }
        })
        return success
    }

}

export default ContactForm
