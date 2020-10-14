<template>
	<div id="signup">
    <h2>Register</h2>
    <div class="signup-form">
      <form @submit.prevent="onSubmit">
        <div class="input">
          <label for="email">Name: </label>
          <input
             type="text"
             id="name"
             v-model="name">
        </div>
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
        <div class="input">
          <label for="password">Password: </label>
          <input
            type="password"
            id="password_confirmation"
            v-model="password_confirmation">
        </div>
        <div class="submit">
          <button type="submit">Submit</button>
        </div>
      </form>
      <p>I have an account? <router-link to="/login">Login</router-link></p>
    </div>
  </div>
</template>

<script>
export default {

  name: 'Register',

  data () {
    return {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    }
  },

  methods: {
    onSubmit() {
      this.register()
    },
    register() {
      const formData = {
          name : this.name,
          email : this.email,
          password : this.password,
          password_confirmation : this.password_confirmation,
      }

      console.log(formData)

      const url = `api/register`
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
        .then(data => {this.authRedirect(data)})
    },
    authRedirect(data) {
      if (!data.access_token) {
        alert('An error occured. Try again.')
        return
      }
      this.$router.push({ path: '/login' })
    }
  }
}
</script>

<style lang="css" scoped>
</style>