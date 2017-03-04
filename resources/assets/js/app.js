import './bootstrap';

import App from './components/App.vue';
import router from './routes';
import auth from './auth';

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresUser)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!auth.loggedIn()) {
      next({
        name: 'login'
      });
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    // you can't acces some pages if you are logged in, exp. login page
    if (auth.loggedIn()) {
      next({
        name: 'home'
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

window.app = {
  loaded: false,
  loggedIn: auth.loggedIn(),
  user: {}
};

new Vue({
    el: "#app",
    data: app,
    router,
    render: h => h(App),
    watch: {
      // call again the method if the route changes
      '$route': function() {
          this.loaded = false;
      }
    }
});
