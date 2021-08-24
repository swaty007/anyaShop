import Vue from 'vue'
import App from './App.vue'
// const React = require('react');
// const ReactDOM = require('react-dom');
// const ItemsList = require('./ItemsList.jsx');

Vue.config.productionTip = false
Vue.config.runtimeCompiler = true


class Magazine_react {
    constructor() {
        if ($('#main-page-magazine')[0]) {
            this.events();
        }
    }


    events() {
        new Vue(App)

        // ReactDOM.render(
        //     React.createElement(ItemsList, { data: "Саша" }),
        //     document.getElementById('app')
        // );
    }

}

export default Magazine_react;