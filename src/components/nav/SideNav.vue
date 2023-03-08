<template>
	<v-navigation-drawer
		class="bg-deep-purple-darken-2"
		theme="dark"
        permanent
	>
		<v-col class="d-flex justify-center">
			<v-img
				:src="`/${$store.getters.appName}/foundation-logo.png`"
				alt="foundation-logo"
				height="100"
				width="100"
			/>
		</v-col>

		<v-divider />

		<div class="text-center mt-2 mx-4">
			<v-btn
                :variant="$route.params.eventSlug === event.slug ? 'tonal' : 'text'"
                :color="$route.params.eventSlug === event.slug ? 'yellow' : 'white'"
				block
				class="my-1 mx-1 px-16"
				v-for="event in $store.getters['events/getEvents']"
				:key="event.id"
				@click="handleEventChange(event)"
			>
				{{ event.title }}
			</v-btn>
		</div>
		<template v-slot:append>
			<v-col class="text-center mt-4" cols="12">
				&copy; <strong class="text-uppercase">aclc iriga 2023</strong>
			</v-col>
		</template>
	</v-navigation-drawer>
</template>

<script>
    import $ from 'jquery';

    export default {
        name: "SideNav",
        data() {
            return {

            }
        },
        methods: {
            handleEventChange(event) {
                localStorage.setItem('active-event', event.slug);
                this.$router.push({
                    name: this.$store.getters['auth/getUser'].userType,
                    params: {
                        eventSlug: event.slug
                    }
                });
            }
        },
        created() {
            $.ajax({
                url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
                type: 'GET',
                xhrFields: {
                    withCredentials: true
                },
                data: {
                    getEvents: ''
                },
                success: (data) => {
                    data = JSON.parse(data);
                    this.$store.commit('events/setEvents', data.events);
                    const activeEvent = localStorage.getItem('active-event');
                    if(activeEvent !== undefined) {
                        const event = data.events.find(event => event.slug === activeEvent);
                        if(event)
                            this.handleEventChange(event);
                    }
                },
                error: (error) => {
                    alert(`ERROR ${error.status}: ${error.statusText}`);
                },
            });
        },
    }
</script>

<style scoped>

</style>