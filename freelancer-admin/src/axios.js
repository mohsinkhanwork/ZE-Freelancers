// Axios.js
require('dotenv').config();

let baseURL;
let imageBaseURL;

if (process.env.NODE_ENV === 'production') {
  baseURL = process.env.VUE_APP_API_BASE_URL;
  imageBaseURL = process.env.VUE_APP_API_BASE_URL.replace('/api', '');
} else {
  baseURL = 'http://localhost:8000/api';
  imageBaseURL = 'http://localhost:8000';
}

export default {
  baseURL,
  imageBaseURL,
  timeout: 5000 // Set a timeout value if needed
};
