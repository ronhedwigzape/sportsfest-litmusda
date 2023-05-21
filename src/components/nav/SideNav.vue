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
			<v-row class="text-center mt-2 mb-1 mx-1">
				<v-col cols="12">
					<v-btn class="mb-2" variant="tonal" @click="coverRating" block>COVER</v-btn>
					<v-btn class="mb-2" variant="tonal" @click="refresh" block :loading="refreshing">REFRESH</v-btn>
					<div class="pt-2 text-disabled text-uppercase">
						&copy; {{ $store.state.app.org }}
					</div>
				</v-col>
			</v-row>
		</template>
	</v-navigation-drawer>
</template>

<script>
import $ from 'jquery';
import forceScreensaver from "@/screensaver";

export default {
	name: "SideNav",
	data() {
		return {
            refreshing: false
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

			// close sidebar when screen is mdAndDown
			if (this.$vuetify.display.mdAndDown)
				this.$store.state.app.sideNav = false;
		},
        refresh() {
            this.refreshing = true;
            window.location.reload();
        },
        coverRating() {
            forceScreensaver();
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
	}
}
</script>

<style scoped>

</style>