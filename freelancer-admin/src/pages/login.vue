<template>
  <div class="login-container">
    <h2>Login</h2>
    <div class="error-message" v-for="errorMessage in errorMessages" :key="errorMessage">
      {{ errorMessage }}
    </div>
    <form @submit.prevent="login">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="form.password" required>
      </div>
      <div class="form-group">
        <label for="remember">Remember Me:</label>
        <input type="checkbox" id="remember" v-model="form.remember" style="width: 41px;">
      </div>
      <button type="submit" class="submit-btn">Login</button>
    </form>
    <hr>
    <router-link to="/register">
      Register Here
    </router-link>
  </div>
</template>





<script>
import axios from 'axios';
import axiosConfig from '../axios';

export default {
  data() {
    return {
      form : {
          email: '',
          password: '',
          remember: false,
      },
      errorMessages: []
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post(`${axiosConfig.baseURL}/login`, this.form);
        const token = response.data.access_token;
        // localStorage.setItem('Bearer_token', token);
        sessionStorage.setItem('Bearer_token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        this.form.email = '';
        this.form.password = '';
        this.form.remember = false;

        this.errorMessages = [];
        this.$router.push('/admin');

        // Fetch the user
        const user = response.data.user;

        // Save user data to state
        this.$store.commit('setUser', user);

        // Redirect
        this.$router.push('/admin');

      } catch (error) {
        if (error.response && error.response.data.message) {
          // Set the specific error message returned from the backend
          this.errorMessages = [error.response.data.message];
        } else {
          this.errorMessages = ['Something went wrong'];
        }
      }
    }
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background: #f7f7f7;
}

.login-container form {
  width: 100%;
  max-width: 300px;
  padding: 20px;
  background: white;
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.login-container label {
  font-weight: bold;
  color: #555;
}

.login-container input {
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  width: 100%;
}

.login-container .submit-btn {
  width: 100%;
  padding: 10px;
  background-color: #3490dc;
  border: none;
  color: white;
  cursor: pointer;
  border-radius: 5px;
  margin-top: 10px;
}

.login-container .submit-btn:hover {
  background-color: #227dc7;
}

.login-container hr {
  margin: 20px 0;
}

.login-container a {
  color: #3490dc;
}

.error-message {
  color: red;
}
</style>
