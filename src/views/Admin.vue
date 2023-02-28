<template>
    <side-nav />
    <top-nav />
    <v-main>
        <!-- results -->
        <v-container v-if="event">
            <small>
                <pre>{{ results }}</pre>
            </small>
        </v-container>

        <!-- loader -->
        <div v-else-if="this.$route.params.eventSlug" class="d-flex justify-center align-center" style="height: 100vh;">
            <v-progress-circular
                :size="80"
                color="primary"
                class="mb-16"
                indeterminate
            />
        </div>
    </v-main>
</template>
<script>
	import TopNav from "../components/nav/TopNav.vue";
	import SideNav from "../components/nav/SideNav.vue";
    import $ from 'jquery';

    export default {
        name: 'Admin',
		components: {
            TopNav,
            SideNav
		},
        data() {
            return {
                event: null,
                results: {},
                timer: null
            }
        },
        watch: {
            $route: {
                immediate: true,
                handler(to, from) {
                    this.event = null;
                    if(this.timer)
                        clearTimeout(this.timer);
                    this.tabulate();
                }
            }
        },
        methods: {
            async tabulate() {
                // tabulate selected event
                if (this.$route.params.eventSlug) {
                    await $.ajax({
                        url: `${this.$store.getters.appURL}/admin.php`,
                        type: 'GET',
                        xhrFields: {
                            withCredentials: true
                        },
                        data: {
                            tabulate: this.$route.params.eventSlug
                        },
                        success: (data) => {
                            data = JSON.parse(data);
                            this.event = data.event;
                            this.results = data.results;

                            // request again
                            if(data.event.slug === this.$route.params.eventSlug) {
                                this.timer = setTimeout(() => {
                                    this.tabulate();
                                }, 2400);
                            }
                        },
                        error: (error) => {
                            alert(`ERROR ${error.status}: ${error.statusText}`);
                        },
                    });
                }
            }
		}
    }
</script>

<style scoped>

</style>
