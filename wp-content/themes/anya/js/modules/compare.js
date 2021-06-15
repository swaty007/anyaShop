

class Compare {
    constructor() {
        $(() => {
            this.compare_items = jQuery.cookie('br_products_compare')
            this.events();
        })
    }

    events() {
        let items_length = this.compare_items.split(",").length
        if (items_length) {
            $('#compare__counter').text(items_length).show()
        } else {
            $('#compare__counter').hide()
        }
    }

}

export default Compare;
