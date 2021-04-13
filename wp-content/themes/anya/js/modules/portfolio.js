

class Portfolio {
  constructor() {
    this.portfolio_filter = $('#portfolio__header')
    this.portfolio_wrap = $('#portfolio_wrap')
    this.activeClass = 'portfolio__header-item--active'
    this.events();
  }

  events() {
    this.portfolio_filter.on('click', '.portfolio__header-item', (e) => {
      let _this = $(e.currentTarget),
        direction = _this.attr('data-direction')
      _this.siblings().removeClass(this.activeClass)
      _this.addClass(this.activeClass)

      this.filterPortfolio()
    })
  }

  filterPortfolio () {
    let direction = this.portfolio_filter.find(`.${this.activeClass}`).attr('data-direction')
    this.portfolio_wrap.find('.portfolio__item').each((index, value) => {
      let _this = $(value),
        method = 'show'
      if (direction != 'all') {
        if (_this.attr('data-direction') != direction) {
          method = 'hide'
        }
      }
      _this[method](300)
    })
  }

}

export default Portfolio;
