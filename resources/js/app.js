require('./bootstrap');

window.Vue = require('vue');

Vue.component('hello', require('./components/Hello.vue').default)
new Vue({
	el: "#app"
})