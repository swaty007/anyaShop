

class Header {
  constructor() {
    this.events();
  }

  events() {
    $('.header__icon').on('click', (e) => {e.preventDefault()
      $('header.header').toggleClass('header--open')
    })
    $(document).on('click', '.header--open .menu-item-has-children>a', (e) => {
      let _this = $(e.currentTarget)
      if (_this.outerWidth() - 50 <= e.offsetX) { //e.currentTarget.offsetWidth
        e.preventDefault()
        _this.siblings('.sub-menu').toggle('show')
      }

    })
  }

}

export default Header;
