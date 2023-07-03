<template>
  <div class="callback-container">
    <h1>Callback</h1>
    <div v-if="loading" class="loading-spinner">
      Loading...
    </div>
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import axiosConfig from '../axios';

export default {
  data() {
    return {
      loading: false,
      error: ''
    };
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code');
    const state = urlParams.get('state');

    if (code && state) {
      this.loading = true;
      this.processLinkedInCode(code, state);
    } else {
      this.error = 'Invalid LinkedIn authorization response.';
    }
  },
  methods: {
    async processLinkedInCode(code, state) {
      try {
        const response = await axios.post(`${axiosConfig.baseURL}/linkedin-callback`, { code, state });
        const token = response.data.access_token;

        sessionStorage.setItem('Bearer_token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        this.loading = false;
         // Fetch the user
         const user = response.data.user;

        // Save user data to state
        this.$store.commit('setUser', user);

          // Redirect
          this.$router.push('/admin');
      } catch (error) {
        // handle error here
        console.error(error);
        this.loading = false;
        this.error = 'An error occurred. Please try again later.';
      }
    }
  }
};
</script>
