<template>
  <form @submit.prevent="register">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" class="form-control" v-model="name">
      <p v-if="errors.name" v-for="error in errors.name" class="text-danger">{{ error }}</p>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" class="form-control" v-model="email">
      <p v-if="errors.email" v-for="error in errors.email" class="text-danger">{{ error }}</p>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" class="form-control" v-model="password">
      <p v-if="errors.password" v-for="error in errors.password" class="text-danger">{{ error }}</p>
    </div>

    <div class="form-group">
      <label for="password_confirmation">Confirm Password</label>
      <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</template>

<script>
  import alertify from 'alertifyjs';
  import auth from '../../auth';
  import router from '../../routes';

  export default {
    data () {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        errors: {}
      }
    },
    mounted() {
      this.$emit('loaded');
    },
    methods: {
      register() {
        auth.register({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })
        .then(response => {
            this.login(this.email, this.password);
        })
        .catch(response => {
            this.errors = response.data.error.message;
        });
      },
      login(email, password) {
        auth.login(email, password)
        .then(response => {
          alertify.success('Welcome ' + response.name);

          router.push({ name: 'dashboard' });
        })
        .catch(response => {
            router.push({ name: 'login' });
        });
      }
    }
  }
</script>
