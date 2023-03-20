<template>
    <v-app>
        <router-view @startPing="startPing"/>
    </v-app>
</template>

<script>
    import $ from 'jquery';

    export default {
        name: 'App',
        data() {
            return {
                pingTimer: null
            }
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
            },

            startPing() {
                this.stopPing();
                this.ping();
            },

            stopPing() {
                if(this.pingTimer)
                    clearTimeout(this.pingTimer);
            },

            ping() {
                const user = this.$store.getters['auth/getUser'];
                if(!user)
                    this.stopPing();
                else if(user.userType !== 'judge' && user.userType !== 'technical')
                    this.stopPing();
                else {
                    $.ajax({
                        url: `${this.$store.getters.appURL}/${user.userType}.php`,
                        type: 'POST',
                        xhrFields: {
                            withCredentials: true
                        },
                        data: {
                            ping: true
                        },
                        success: (data) => {
                            data = JSON.parse(data);
                            if(data.pinged) {
                                // repeat after m milliseconds
                                const m = 5000;
                                this.pingTimer = setTimeout(() => {
                                    this.ping();
                                }, m);
                            }
                        }
                    });
                }
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