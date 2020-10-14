<template>
	<div>
		<h1>Welcome to your Book Management System</h1>
		<div v-if="isAuthenticated">
			<router-link to="/books">Books</router-link>
			<router-link to="/logout">Logout</router-link>
		</div>
		<div v-else>
			<router-link to="/login">Login</router-link>
			<router-link to="/register">Register</router-link>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			isAuthenticated: (localStorage.getItem('book-management-token')) ? true : false
		}
	}
}
</script>

<style lang="css" scoped>
</style>