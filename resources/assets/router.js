import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import Welcome from './views/Welcome.vue'

Vue.use(VueRouter)

export default new VueRouter({
	mode: 'history',
	base: __dirname,
	routes: [
		{path: '/', component: Welcome},
		{path: '/books', component: Home, beforeEnter: requireAuth},
		{path: '/login', component: Login},
		{path: '/register', component: Register},
		{path: '/logout', beforeEnter: logout}
	]
})

function requireAuth(to, from, next) {
	if (!localStorage.getItem('book-management-token')) {
		next({
			path: '/login',
		})
	} else {
		next()
	}
}

function logout(to, from, next) {
	localStorage.removeItem('book-management-token')

	const url = `api/logout`
	fetch(url, {
	    method: 'POST',
	  	headers: {
		    // 'Authorization': this.token_type + ' ' + this.token,
		    'Accept': 'application/json',
		    'Content-Type': 'application/json'
	  	}
	})
	.then(response => response.json())
	.then(data => {
	  next({
			path: '/login',
		})
	})

}
