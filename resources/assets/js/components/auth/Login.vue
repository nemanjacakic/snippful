<template>
<div>
  <div class="alert alert-danger" v-if="error">
    <p>Could not sign you in with those details.</p>
  </div>
  <form v-on:submit.prevent="login">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" class="form-control" v-model="email">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" class="form-control" v-model="password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
  </form>
  </div>
</template>

<script>
  import alertify from 'alertifyjs';
  import auth from '../../auth';
  import router from '../../routes';

  export default {
    data () {
      return {
        email: '',
        password: '',
        error: false
      }
    },
    mounted() {
      this.$emit('loaded');
    },
    methods: {
      login() {
        auth.login(this.email, this.password)
            .then(response => {
              alertify.success('Welcome ' + response.name);

              router.push({ name: 'dashboard' });
            })
            .catch(response => {
                this.error = true;
            });
      }
    }
  }
</script>
