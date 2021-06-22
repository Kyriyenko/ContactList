
require('./bootstrap');

window.Vue = require('vue').default;


import App from './components/App'
import Navbar from './components/parts/Navbar'
import Table from './components/parts/Table'
import Modal from './components/parts/Modal'


Vue.component('v-navbar',Navbar);
Vue.component('v-table',Table);
Vue.component('v-modal',Modal);



const app = new Vue({
    el: '#app',
    render:h =>h(App)
});
