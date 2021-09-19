import Vue from 'vue'
import App from './MainPage.vue'
import ProductPopular from './ProductPopular.vue'
import ProductNew from './ProductNew.vue'
import ProductDiscount from './ProductDiscount.vue'
import ProductRent from './ProductRent.vue'
// const React = require('react');
// const ReactDOM = require('react-dom');
// const ItemsList = require('./ItemsList.jsx');

Vue.config.productionTip = false
Vue.config.runtimeCompiler = true


class Magazine_react {
    constructor() {
        if ($('#main-page-magazine')[0]) {
            this.main_page();
        }
        if ($('#product_popular_vue')[0]) {
            this.product_popular();
        }
        if ($('#product_new_vue')[0]) {
            this.product_new();
        }
        if ($('#product_discount_vue')[0]) {
            this.product_discount();
        }
        if ($('#product_rent_vue')[0]) {
            this.product_rent();
        }
    }


    main_page() {
        new Vue(App)

        // ReactDOM.render(
        //     React.createElement(ItemsList, { data: "Саша" }),
        //     document.getElementById('app')
        // );
    }

    product_popular() {
        new Vue(ProductPopular)
    }
    product_new() {
        new Vue(ProductNew)
    }
    product_discount() {
        new Vue(ProductDiscount)
    }
    product_rent() {
        new Vue(ProductRent)
    }

}

export default Magazine_react;