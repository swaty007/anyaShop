

class PrivacyPolicy {
  constructor() {
    this.policyModal = $('#modalPrivacyPolicy')
    this.submitBtn = $('#acceptCookiePolicy')
    this.events();
  }

  events() {
    this.submitBtn.on('click', () => {
      document.cookie = "policy_accept=1; domain="+window.location.host+"; path=/; max-age=7776000";
      this.policyModal.modal('hide')
    })

    function getCookie(name) {
      var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
      ));
      return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    let cookie = getCookie('policy_accept')

    if (!cookie) {
      this.policyModal.modal('show')
    }

  }

}

export default PrivacyPolicy;
