class Product {
    constructor() {
        this.amount_checker = $('#amount_checker')
        this.buy_btn = $('.buy-btn')
        this.widget_shopping = $('div.widget_shopping_cart_content')
        this.events();
    }

    events() {
        this.amount_checker.on('click', '.minus', (e) => {
            let _this = $(e.currentTarget),
                value = Number(_this.siblings('.amount-value').text()),
                min = this.amount_checker.data('min')
            --value
            if (value < min) {
                value = min
            }
            _this.siblings('.amount-value').text(value)
        })
        this.amount_checker.on('click', '.plus', (e) => {
            let _this = $(e.currentTarget),
                value = Number(_this.siblings('.amount-value').text()),
                max = this.amount_checker.data('max')
            ++value
            if (max !== -1 && value > max) {
                value = max
            }
            _this.siblings('.amount-value').text(value)
        })

        $(document).on('click', '.buy-btn', (e) => {
            let _this = $(e.currentTarget),
                sku = _this.data('sku'),
                id = _this.data('id'),
                quantity = 1

            _this.attr('disabled', true)
            let formData = new FormData();
            if (this.amount_checker[0]) {
                quantity = Number(this.amount_checker.find('.amount-value').text())
            }
            formData.append('product_sku', sku)
            formData.append('product_id', id)
            formData.append('quantity', quantity)

            $.ajax({
                url: "/?wc-ajax=add_to_cart",
                method: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done((data, textStatus, jqXHR) => {
                // $(document.body).trigger('wc_fragment_refresh');
                console.log(data, textStatus, jqXHR)
                console.log(data.fragments['div.widget_shopping_cart_content'])
                console.log(this.widget_shopping)
                // this.widget_shopping.html(data.fragments['div.widget_shopping_cart_content'])
                $('div.widget_shopping_cart_content').replaceWith(data.fragments['div.widget_shopping_cart_content'])
            })
                .fail((jqXHR, textStatus, errorThrown) => {

                })
                .always((jqXHR, textStatus, errorThrown) => {
                    _this.attr('disabled', false)
                });
        })
    }

}

export default Product;
