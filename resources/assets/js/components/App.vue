<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <router-view v-show="app.loaded" @loaded="updateLoaded"></router-view>
            <div v-show="!app.loaded">
                <loader></loader>
            </div>
        </div>
    </div>
</template>

<script>
import auth from '../auth';
import router from '../routes';

    export default {
        data(){
            return {
                app
            }
        },
        mounted() {
            if (app.loggedIn) {
                axios.get('user')
                  .then(response => {
                    this.app.user = response.data;
                }).catch(response => {
                    auth.logout();

                    router.push({ name: 'login' });
                });
            }
        },
        methods: {
        updateLoaded() {
                this.app.loaded = true;
            }
        }
    }
</script>