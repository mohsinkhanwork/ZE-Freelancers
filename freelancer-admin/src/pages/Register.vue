<template>
  <div class="app-container">
    <div class="error-message" v-for="errorMessage in errorMessages" :key="errorMessage">
      {{ errorMessage }}
    </div>
    <div class="login-container">
      <div class="logo-section">
        <div class="justify-center flex">
          <img src="/img/clock.svg" alt="clock" class="logo-img" />
        </div>
        <div class="logo-text">
          <div class="logo-text-part">Zeiten</div>
          <div class="logo-text-part logo-text-part-black">Erfassen</div>
        </div>
      </div>
      <span class="login-header">Register</span>
      <form @submit.prevent="register" class="login-form">
        <div class="input-group">
        <label for="name" class="input-label">Name:</label>
        <input type="text" class="input-field" id="name" v-model="form.name" required placeholder="Name">
      </div>
        <div class="input-group">
          <label for="email" class="input-label">Email</label>
          <input type="email" class="input-field" id="email" v-model="form.email" placeholder="Email" required>
        </div>
        <div class="input-group">
          <label for="password" class="input-label">Password</label>
          <input type="password" v-model="form.password" class="input-field" placeholder="Password" required id="password">
        </div>
        <div class="input-group">
        <label for="confirm-password" class="input-label">Confirm Password:</label>
        <input type="password" class="input-field" id="confirm-password" v-model="form.password_confirmation" required>
      </div>
        <button type="submit" class="submit-btn">Register</button>
      </form>
      <div class="separator">OR</div>
      <div class="social-box">
        <div class="social-login">
        <img src="/img/linkdin.svg" alt="LinkedIn" class="social-logo" />
        <button @click="linkedinRegister" class="social-btn">Register with LinkedIn</button>
      </div>
      </div>

      <div class="register-section">
        <span class="register-text">Already a User?</span>
        <router-link to="/login" class="register-link">
          Login Here
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>

.input-label {
  font-family: system-ui;
  background: white;
  padding-left: 3px;
}
.social-box {
  display: flex;
  justify-content: center;
}
.app-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  width: 100vw;
  background: #F7F7F7;
  overflow: auto;
  padding: 1rem;
  box-sizing: border-box;
}

.login-container {
  display: flex;
  flex-direction: column;
  max-width: 490px;
  width: 100%;
  max-height: 90vh;
  box-sizing: border-box;
  padding: 1rem;
}
.logo-section {
  text-align: center;
  margin-bottom: 1rem;
}
.logo-img {
  height: 50px;
  width: 50px;
}
.logo-text {
  display: flex;
  justify-content: center;
  align-items: center;
  color: #2E4EAC;
  font-size: 38.20px;
  font-family: Montserrat;
  font-weight: 600;
  text-transform: uppercase;
}
.logo-text-part-black {
  color: black;
}
.login-header {
  font-size: 30px;
  font-weight: 600;
  text-align: center;

}
.login-form {
  background: white;
  border-radius: 12px;
  padding: 16px;
  text-align: center;
}
.input-group {
  border-radius: 10px;
  margin-bottom: 20px;
}
.input-field {
    width: 100%;
    border: none;
    padding: 10px;
    border-radius: 10px;
    background: #F7F7F7;
}
.submit-btn {
  color: white;
    font-size: 21px;
    border: none;
    background: #2271B1;
    border-radius: 10px;
    padding: 7px 19px 7px 19px;
}
.separator {
  color: black;
  font-size: 16px;
  font-family: Poppins;
  font-weight: 400;
  text-transform: capitalize;
  margin-top: 30px;
  text-align: center;
}
.social-login {
    display: flex;
    -ms-flex-align: center;
    -ms-flex-pack: center;
    justify-content: center;
    background: #0077B5;
    border-radius: 10px;
    padding: 10px;
    margin-top: 20px;
    width: 75%;
}
.social-logo {
  height: 30px;
  width: 30px;
  margin-right: 10px;
}
.social-btn {
  color: white;
  font-size: 21px;
  font-weight: 500;
  border: none;
  background: none;
}
.register-section {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 30px;
}
.register-text {
  color: black;
  font-size: 16px;
  font-family: Poppins;
  font-weight: 400;
  text-transform: capitalize;
  margin-right: 10px;
}
.register-link {
  color: #0076B2;
  font-size: 16px;
  font-family: Poppins;
  font-weight: 500;
  text-transform: capitalize;
}
@media (max-width: 600px) {
  .logo-text {
    font-size: 20px;
  }
  .login-header {
    font-size: 20px;
  }
  .login-form {
    padding: 5px;
  }
  .input-field {
    height: 30px;
  }
  .submit-btn, .social-btn {
    font-size: 14px;
    padding: 5px 10px;
  }
  .separator {
    font-size: 10px;
  }
  .register-text, .register-link {
    font-size: 10px;
  }
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
    },
    linkedinRegister() {
      const clientId = '77qpmgymtgu6hy';
      const redirectUri = 'http://localhost:8080/callback';
      const state = 'dpjFfgNplIDtHCjf'; // generate a secure random string

      const scope = 'r_liteprofile r_emailaddress';
      const responseType = 'code';

      const authUrl = `https://www.linkedin.com/oauth/v2/authorization?response_type=${responseType}&client_id=${clientId}&redirect_uri=${redirectUri}&state=${state}&scope=${scope}`;

      // Open LinkedIn authorization URL in a new window or redirect the current window
      window.location.href = authUrl;
    },
  },

};

</script>


