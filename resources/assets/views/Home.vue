<template>
	<div>
		<h1>Dashboard</h1>
		<router-link to="/logout">Logout</router-link>
		<Books />
	</div>
</template>

<script>
import Books from '../components/Books.vue'
export default {
	components: { Books }
}
</script>

<style lang="css" scoped>
</style>s