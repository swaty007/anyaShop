import intlTelInput from 'intl-tel-input';


class Phone {
  constructor() {
    this.events();
  }
  events() {
    document.addEventListener("DOMContentLoaded", () => {
      //phone
      try {
        $("input[type=tel]").each(function() {
          intlTelInput(this,{
            // initialCountry: "ua",
            initialCountry: "ru",
            separateDialCode: true,
            preferredCountries: ["by", "ru", "kz"],
            geoIpLookup: function (callback) {
              $.get('https://ipinfo.io', function () {
              }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
              });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js"
          });
          $(this).on("countrychange", function (e, countryData) {
            $(this).val('');
            $(this).mask($("#phone").attr('placeholder').replace(/[0-9]/g, 0));
          });
          // $(this).mask("00 000 0000"); //UA
          $(this).mask("000 000-00-00"); //ru


        })

      } catch (e) {
        console.log('phone err', e)
      }

      //расписание page + single professions
      try {
        intlTelInput(document.getElementById('demo'));
      } catch (e) {
        console.log('schedule error', e)
      }
    })
  }


}

export default Phone;
