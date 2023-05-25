<template>
  <div class="login-container">
    <h2>Register</h2>
    <div class="error-message" v-for="errorMessage in errorMessages" :key="errorMessage">
      {{ errorMessage }}
    </div>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" v-model="form.name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="form.password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" class="form-control" id="confirm-password" v-model="form.password_confirmation" required>
      </div>
      <button type="submit" class="submit-btn">Register</button>
    </form>
    <hr>
    <router-link to="/login">
      Login Here
    </router-link>
  </div>
</template>

<style scoped>
.error-message {
  color: red;
}
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
</style>

<script>
import axios from 'axios';
import axiosConfig from '../axios';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      errorMessages: []
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post(`${axiosConfig.baseURL}/register`, this.form);
        this.errorMessages = [];
        this.$router.push('/login');
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errorMessages = Object.values(error.response.data.errors).flat();
        } else {
          this.errorMessages = ['Something went wrong. Please try again'];
        }
      }
    }
  }
};

</script>


