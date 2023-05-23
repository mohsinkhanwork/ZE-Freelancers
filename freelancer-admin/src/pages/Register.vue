<template>
  <div class="container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" v-model="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" v-model="password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" class="form-control" id="confirm-password" v-model="confirmPassword" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div>
      <hr>
      <router-link to="/logout">
        Login Here
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import axiosConfig from '../axios';


export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirmPassword: ''
    };
  },
  methods: {
    async register() {
     try {
      const response = await axios.post(`${axiosConfig.baseURL}/register`, {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.confirmPassword
      });

      console.log(response.data);
    } catch (error) {
      console.log(error);
    }
  }
  }
};
</script>

<style>
.container {
  margin-top: 50px;
  max-width: 400px;
}
</style>
