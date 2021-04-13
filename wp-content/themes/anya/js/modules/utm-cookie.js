class UtmCookie {
    constructor () {
        this.events()
    }

    events () {

        document.addEventListener('DOMContentLoaded', function() {
            function getAllUrlParams(url) {

                // извлекаем строку из URL или объекта window
                var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

                // объект для хранения параметров
                var obj = {};

                // если есть строка запроса
                if (queryString) {

                    // данные после знака # будут опущены
                    queryString = queryString.split('#')[0];

                    // разделяем параметры
                    var arr = queryString.split('&');

                    for (var i=0; i<arr.length; i++) {
                        // разделяем параметр на ключ => значение
                        var a = arr[i].split('=');

                        // обработка данных вида: list[]=thing1&list[]=thing2
                        var paramNum = undefined;
                        var paramName = a[0].replace(/\[\d*\]/, function(v) {
                            paramNum = v.slice(1,-1);
                            return '';
                        });

                        // передача значения параметра ('true' если значение не задано)
                        var paramValue = typeof(a[1])==='undefined' ? true : a[1];

                        // преобразование регистра
                        paramName = paramName.toLowerCase();
                        paramValue = paramValue.toLowerCase();

                        // если ключ параметра уже задан
                        if (obj[paramName]) {
                            // преобразуем текущее значение в массив
                            if (typeof obj[paramName] === 'string') {
                                obj[paramName] = [obj[paramName]];
                            }
                            // если не задан индекс...
                            if (typeof paramNum === 'undefined') {
                                // помещаем значение в конец массива
                                obj[paramName].push(paramValue);
                            }
                            // если индекс задан...
                            else {
                                // размещаем элемент по заданному индексу
                                obj[paramName][paramNum] = paramValue;
                            }
                        }
                        // если параметр не задан, делаем это вручную
                        else {
                            obj[paramName] = paramValue;
                        }
                    }
                }

                return obj;
            };
            //    Cookie aut start
            function getCookie(name) {
                var matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            }



            //UTM parameters save in cookie
            (function SaveUtmCookie() {

                var UrlParams = getAllUrlParams();

                var utm_source_input = document.querySelectorAll('input[name="sourceUuid"]');
                // var utm_medium_input = document.querySelectorAll('input[name="utm_medium"]');
                // var utm_term_input = document.querySelectorAll('input[name="utm_term"]');
                // var utm_campaign_input = document.querySelectorAll('input[name="utm_campaign"]');
                // var utm_content_input = document.querySelectorAll('input[name="utm_content"]');
                // var url_referrer_input = document.querySelectorAll('input[name="url_referrer"]');

                var utm_parameters = {},
                    utm_source = "";
                // utm_medium = "",
                // utm_term = "",
                // utm_campaign = "",
                // utm_content = "",
                // url_referrer = "";

                var cookie_utm = getCookie("utm_parameters");
                // var cookie_referrer = getCookie("url_referrer");
                // var referrer = document.referrer;
                // if (cookie_referrer !== undefined) {
                //   url_referrer = cookie_referrer;
                // }
                // if (referrer.indexOf('smartcloudconnect.io') == -1 && referrer != "" && referrer !== " ") {
                //   let params_ = referrer;
                //   let d_ = new Date();
                //   let exdays_ = 30;
                //   d_.setTime(d_.getTime() + (exdays_ * 24 * 60 * 60 * 1000));
                //   let expires_ = "expires=" + d_.toUTCString();
                //   document.cookie = "url_referrer=" + params_ + ";" + expires_ + ";domain=smartcloudconnect.io;path=/;";
                //   url_referrer = referrer;
                // }
                if (Object.keys(UrlParams).length) {
                    if (UrlParams.utm_source) {
                        utm_source = UrlParams.utm_source;
                        utm_parameters.utm_source = utm_source;
                    }
                    // if (UrlParams.utm_medium) {
                    //   utm_medium = UrlParams.utm_medium;
                    //   utm_parameters.utm_medium = utm_medium;
                    // }
                    // if (UrlParams.utm_term) {
                    //   utm_term = UrlParams.utm_term;
                    //   utm_parameters.utm_term = utm_term;
                    // }
                    // if (UrlParams.utm_campaign) {
                    //   utm_campaign = UrlParams.utm_campaign;
                    //   utm_parameters.utm_campaign = utm_campaign;
                    // }
                    // if (UrlParams.utm_content) {
                    //   utm_content = UrlParams.utm_content;
                    //   utm_parameters.utm_content = utm_content;
                    // }
                }
                if (cookie_utm !== undefined) {
                    cookie_utm = JSON.parse(cookie_utm);
                    if (cookie_utm.utm_source && utm_source == "") {
                        utm_source = cookie_utm.utm_source;
                    }
                    // if (cookie_utm.utm_medium && utm_medium == "") {
                    //   utm_medium = cookie_utm.utm_medium;
                    // }
                    // if (cookie_utm.utm_term && utm_term == "") {
                    //   utm_term = cookie_utm.utm_term;
                    // }
                    // if (cookie_utm.utm_campaign && utm_campaign == "") {
                    //   utm_campaign = cookie_utm.utm_campaign;
                    // }
                    // if (cookie_utm.utm_content && utm_content == "") {
                    //   utm_content = cookie_utm.utm_content;
                    // }
                }

                for (var i1 = 0;i1 < utm_source_input.length; ++i1) {
                    utm_source_input[i1].value = utm_source;
                }
                // for (var i = 0;i < utm_medium_input.length; ++i) {
                //   utm_medium_input[i].value = utm_medium;
                // }
                // for (var i2 = 0;i2 < utm_term_input.length; ++i2) {
                //   utm_term_input[i2].value = utm_term;
                // }
                // for (var i3 = 0;i3 < utm_campaign_input.length; ++i3) {
                //   utm_campaign_input[i3].value = utm_campaign;
                // }
                // for (var i4 = 0;i4 < utm_content_input.length; ++i4) {
                //   utm_content_input[i4].value = utm_content;
                // }
                // for (var i5 = 0;i5 < url_referrer_input.length; ++i5) {
                //   url_referrer_input[i5].value = url_referrer;
                // }

                if (Object.keys(utm_parameters).length) {
                    var params = JSON.stringify(utm_parameters);
                    var d = new Date();
                    var exdays = 30;
                    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                    var expires = "expires=" + d.toUTCString();
                    document.cookie = "utm_parameters=" + params + ";" + expires + ";domain="+window.location.host+";path=/;";
                }

            })();
//UTM parameters save in cookie
        })

    }


}

export default UtmCookie

