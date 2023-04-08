<template>
	<v-navigation-drawer
		theme="dark"
		v-model="$store.state.app.sideNav"
		:permanent="$vuetify.display.lgAndUp"
	>
		<v-col class="d-flex justify-center">
			<v-img
				:src="`/${$store.getters.appName}/foundation-logo.png`"
				alt="foundation-logo"
				:height="$vuetify.display.mdAndDown ? 120 : 90"
				:width="$vuetify.display.mdAndDown ? 120 : 90"
			/>
		</v-col>

		<v-divider/>

		<v-list class="pa-0">
			<template v-for="(group, groupIndex) in $store.getters['events/getCategorizedEvents']">
				<v-list-subheader class="mt-2 text-subtitle-1">
					{{ group.category.title }}
				</v-list-subheader>
				<v-list-item
					v-for="event in group.events"
					:key="event.id"
					:variant="$route.params.eventSlug === event.slug ? 'tonal' : 'text'"
					class="text-center"
					:class="`justify-center text-center text-button${$route.params.eventSlug === event.slug ? ' text-yellow' : ''}`"
					block
					@click="handleEventChange(event)"
				>
					{{ event.title }}
				</v-list-item>
				<v-divider v-if="groupIndex < ($store.getters['events/getCategorizedEvents'].length - 1)" class="mt-2"/>
			</template>
		</v-list>
		<template v-slot:append>
			<v-col class="text-center mt-4" cols="12">
				&copy; <strong class="text-uppercase">ACLC Iriga 2023</strong>
			</v-col>
		</template>
	</v-navigation-drawer>
</template>

<script>
import $ from 'jquery';

export default {
	name: "SideNav",
	data() {
		return {}
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

			// close sidebar when screen is mdAndDown
			if (this.$vuetify.display.mdAndDown)
				this.$store.state.app.sideNav = false;
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
				this.$store.commit('events/setCategories', data.categories);
				this.$store.commit('events/setEvents', data.events);
				const activeEvent = localStorage.getItem('active-event');
				if (activeEvent !== undefined) {
					const event = data.events.find(event => event.slug === activeEvent);
					if (event)
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