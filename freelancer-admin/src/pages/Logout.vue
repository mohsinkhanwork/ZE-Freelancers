<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required>
      </div>
      <div class="form-group">
        <label for="remember">Remember Me:</label>
        <input type="checkbox" id="remember" v-model="remember">
      </div>
      <button type="submit">Login</button>
    </form>
    <hr>
    <router-link to="/register">
      Register Here
    </router-link>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      remember: false
    };
  },
  methods: {
    login() {
      // Perform login logic here
      console.log('Email:', this.email);
      console.log('Password:', this.password);
      console.log('Remember Me:', this.remember);
      // Reset form fields
      this.email = '';
      this.password = '';
      this.remember = false;
    }
  }
};
</script>

<style>
.login-container {
  max-width: 300px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.form-group {
  margin-bottom: 10px;
}

label {
  display: block;
  font-weight: bold;
}

input[type="email"],
input[type="password"],
button {
  width: 100%;
  padding: 8px;
  border-radius: 4px;
}

button {
  background-color: #4CAF50;
  color: white;
  border: none;
}
</style>
