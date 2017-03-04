export default {
  loggedIn(){
      return localStorage.getItem('snippful_id_token') ? true : false;
  },
  login(email, password) {
    return new Promise((resolve, reject) => {
      axios.post('auth/login',{
          email: email,
          password: password
      }).then(response => {
        localStorage.setItem('snippful_id_token', response.data.meta.token);
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('snippful_id_token');
        app.loggedIn = this.loggedIn();

        resolve(response.data);
      }).catch(({response}) => {
          reject(response);
      });
    });
  },
  register({ name, email, password, password_confirmation }) {
    return new Promise((resolve, reject) => {
      axios.post('auth/register',{
          name,
          email,
          password,
          password_confirmation
      }).then(response => {
        resolve(response.data);
      }).catch(({response}) => {
        reject(response);
      });
    });
  },
  logout() {
    return new Promise((resolve, reject) => {
      localStorage.removeItem('snippful_id_token');
      app.loggedIn = this.loggedIn();

      resolve();
    });
  }
}
