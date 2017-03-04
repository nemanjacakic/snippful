<template>
<div>

</div>
</template>

<script>
import auth from '../../auth';
import router from '../../routes';

  export default {
    mounted() {
      this.$emit('loaded');
      auth.logout().then(() => {
        router.push({ name: 'home' });
      });
    }
  }
</script>
