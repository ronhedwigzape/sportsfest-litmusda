<template>
    <v-app>
        <v-main>
            <router-link :to="`/`">Login</router-link>
            |
            <router-link :to="`/admin`">Admin</router-link>
            |
            <router-link :to="`/judge`">Judge</router-link>
            |
            <router-view/>
        </v-main>
    </v-app>
</template>

<script>
    import Login from './views/Login.vue';
    import $ from 'jquery';

    export default {
        name: 'App',
        components: {
            Login
        },
        data() {
            return {}
        },
        created() {
            $.ajax({
                url: `${this.$store.getters.appURL}/index.php`,
                type: 'GET',
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    getUser: ''
                },
                success: (data) => {
                    data = JSON.parse(data);
                    if(data.user) {
                        this.$store.commit('auth/setUser', data.user);
                        this.$router.replace({ name: data.user.userType });
                    }
                },
                error: (error) => {
                    alert(`ERROR ${error.status}: ${error.statusText}`);
                },
            });
        }
    }
</script>


<style>

</style>