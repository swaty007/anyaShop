import Vue from 'vue'
import App from './App.vue'
const React = require('react');
const ReactDOM = require('react-dom');
const ItemsList = require('./ItemsList.jsx');

Vue.config.productionTip = false


class Magazine_react {
    constructor() {
        this.events();
    }

    events() {
        new Vue(App)

        ReactDOM.render(
            React.createElement(ItemsList, { data: "Саша" }),
            document.getElementById('app')
        );
    }

}

export default Magazine_react;