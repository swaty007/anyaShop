

class AllCourses {
  constructor() {
    this.courses_filter = $('#courses_filter')
    this.courses_wrap = $('#courses_wrap')
    this.courses_newbie = $('#courses_newbie')
    this.courses_advanced = $('#courses_advanced')
    this.events();
  }

  events() {
    this.courses_filter.on('click', '.card-filter__item', (e) => {
      let _this = $(e.currentTarget),
          id = _this.attr('data-id'),
          slug = _this.attr('data-slug')
      // _this.siblings().removeClass('active')

      _this.toggleClass('active')
      if (id == 'all') {
        _this.siblings().removeClass('active')
        _this.addClass('active')
      } else {
        _this.siblings('[data-id="all"]').removeClass('active')
        if (!this.courses_filter.find('.active').length) {
          _this.siblings('[data-id="all"]').addClass('active')
        }
      }

      this.filterCourses()
    })
    this.courses_newbie.on('change', () => {
      this.filterCourses()
    })
    this.courses_advanced.on('change', () => {
      this.filterCourses()
    })

    $('#filter_open, #filter_close').on('click', (e) => {
      e.preventDefault()
      $('body').toggleClass('modal__open')
      $('#card-filter').slideToggle()
    })
  }

  filterCourses () {
    let newbie = this.courses_newbie.prop('checked'),
        advanced = this.courses_advanced.prop('checked'),
        ids = [],
        slug = this.courses_filter.find('.active').attr('data-slug');
    this.courses_filter.find('.active').each((i, el) => {
      ids.push($(el).attr('data-id'))
    })
    // console.log(newbie, advanced, id, slug)
    this.courses_wrap.find('.card').each((index, value) => {
      let _this = $(value),
          method = 'show'
      if (!ids.includes('all')) {
        if (!_this.attr('data-id').split(',').some(i => ids.includes(i))) {
          method = 'hide'
        }
      }
      if (newbie !== advanced) {
        if (newbie) {
          if (_this.attr('data-advanced') != 0) {
            method = 'hide'
          }
        } else {
          if (_this.attr('data-advanced') == 0) {
            method = 'hide'
          }
        }
      }
      _this[method](300)
    })
  }

}

export default AllCourses;
