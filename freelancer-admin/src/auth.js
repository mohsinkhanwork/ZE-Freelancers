export function logout(router) {
  return new Promise((resolve, reject) => {
    try {
      sessionStorage.removeItem('Bearer_token');
      resolve();
    } catch (e) {
      reject(e);
    }
  }).then(() => {
    router.push({name: 'Login'});
  }).catch((e) => {
    console.log('Error logging out', e);
  });
}
