<style>

</style>

<template>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <router-link class="navbar-brand" :to="{ name: 'home'}">
                    Snippful
                </router-link>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <router-link v-if="!app.loggedIn" tag="li" :to="{ name: 'login'}">
                    <a>Login</a></router-link>
                    <router-link v-if="!app.loggedIn" tag="li" :to="{ name: 'register'}">
                    <a>Register</a></router-link>
                    <router-link  v-if="app.loggedIn" tag="li" :to="{ name: 'dashboard'}">
                    <a>Dashboard</a></router-link>
                    <router-link v-if="app.loggedIn" tag="li" :to="{ name: 'tags'}">
                    <a>Tags</a></router-link>
                    <router-link v-if="app.loggedIn" tag="li" :to="{ name: 'logout'}">
                    <a>Logout</a></router-link>
                </ul>
            </div>
            </div>
        </nav>
</template>

<script>
    export default {
        data() {
            return {
                app: app
            }
        }
    }
</script>