//axios.js

// let baseURL;

// process.env.NODE_ENV === 'production'
//   ? (baseURL = 'https://yourliveapiurl.com')
//   : (baseURL = 'http://localhost:8000/api');


export default {
  baseURL: 'http://localhost:8000/api', // Change this to your server URL.
  imageBaseURL: 'http://localhost:8000', // Change this to your server URL.
  timeout: 5000 // Set a timeout value if needed
};
