import axios from 'axios';

export function logout(router) {
  return new Promise((resolve, reject) => {
    try {
      localStorage.removeItem('vuex');
      delete axios.defaults.headers.common['Authorization'];

      resolve();
    } catch (e) {
      reject(e);
    }
  }).then(() => {
    // Navigate to login page after successful logout
    router.push({name: 'Login'});
  }).catch((e) => {
    console.error('Error logging out', e);
  });
}
