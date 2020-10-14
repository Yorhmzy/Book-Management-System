<template>
	<div id="signup">
    <h2>Login</h2>
    <div class="signup-form">
      <form @submit.prevent="onSubmit">
        <div class="input">
          <label for="email">Email: </label>
          <input
             type="email"
             id="email"
             v-model="email">
        </div>
        <div class="input">
          <label for="password">Password: </label>
          <input
            type="password"
            id="password"
            v-model="password">
        </div>
        <div class="submit">
          <button type="submit">Submit</button>
        </div>
      </form>
      <p>Not Registered? <router-link to="/register">Sign Up</router-link></p>
    </div>
  </div>
</template>

<script>
export default {

  name: 'Login',

  data () {
    return {
        email: '',
        password: ''
    }
  },

  methods: {
    onSubmit() {
      this.login()
    },
    login() {
      const formData = {
          email : this.email,
          password : this.password,
      }

      const url = `api/login`
      fetch(url, {
            method: 'POST',
            body: JSON.stringify(formData),
          headers: {
            // 'Authorization': this.token_type + ' ' + this.token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          this.authenticate(data)
        })
    },
    authenticate(data) {
      if (!data.access_token) {
        alert('Incorrect Email/Password')
        localStorage.removeItem('book-management-token')
        return
      }
      localStorage.setItem('book-management-token', data.access_token)
      this.$router.push({ path: '/books' })
    }
  }
}
</script>

<style lang="css" scoped>
</style>