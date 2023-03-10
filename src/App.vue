<template>
    <v-app>
        <router-view/>
    </v-app>
</template>

<script>
    import $ from 'jquery';

    export default {
        name: 'App',
        data() {
            return {}
        },
        created() {
            // check for authenticated user
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
                    if (data.user) {
                        this.$store.commit('auth/setUser', data.user);
                        this.$router.replace({
                            name: data.user.userType
                        });
                    }
                },
                error: (error) => {
                    alert(`ERROR ${error.status}: ${error.statusText}`);
                },
            });
        },
        methods: {
            handleWindowResize() {
                this.$store.commit('setWindowHeight', window.innerHeight);
            }
        },
        mounted() {
            window.addEventListener('resize', this.handleWindowResize);
            this.handleWindowResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleWindowResize);
        },
    }
</script>


<style>

</style>