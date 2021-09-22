

class Compare {
    constructor() {
        $(() => {
            this.compare_items = jQuery.cookie('br_products_compare')
            this.events();
        })
    }

    events() {
        if (this.compare_items && typeof this.compare_items === "string" && this.compare_items.split(",").length) {
            $('#compare__counter').text(this.compare_items.split(",").length).show()
        } else {
            $('#compare__counter').hide()
        }
    }

}

export default Compare;
