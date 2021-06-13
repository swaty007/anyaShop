class Product {
    constructor() {
        this.amount_checker = $('#amount_checker')
        this.buy_btn = $('.buy-btn')
        this.widget_shopping = $('div.widget_shopping_cart_content')
        this.events();
        // $(() => {
            this.wc_fragment_refresh()
        // });

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
                this.wc_fragment_refresh()
            })
                .fail((jqXHR, textStatus, errorThrown) => {

                })
                .always((jqXHR, textStatus, errorThrown) => {
                    _this.attr('disabled', false)
                });
        })

        $(document.body).on('wc_fragments_refreshed wc_fragment_refresh removed_from_cart adding_to_cart wc_fragments_loaded', (e) => {
            console.log('wc_fragment_refresh', e)
            this.wc_fragment_refresh()
        })

        $(document).on('berocket_compare-after_load', (e) => {
            console.log('berocket_compare-after_load')
        })
        $(document).on('berocket_compare-after_remove', (e) => {
            console.log('berocket_compare-after_remove')
        })
    }

    wc_fragment_refresh() {
        let itemsL = $('div.widget_shopping_cart_content li.woocommerce-mini-cart-item.mini_cart_item').length
        console.log(itemsL)
        if (itemsL) {
            $('#cart__counter').text(itemsL).show()
        } else {
            $('#cart__counter').hide()
        }

    }

}

export default Product;
