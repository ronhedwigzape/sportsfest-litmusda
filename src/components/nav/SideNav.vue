<template>
	<v-navigation-drawer
		class="bg-deep-purple-darken-2"
		theme="dark"
	>
		<v-col align="center">
			<v-img
				:src="foundationLogo"
				:lazy-src="foundationLogo"
				aspect-ratio="1"
				alt="foundation-logo"
				height="100"
				width="100"
			>
				<template v-slot:placeholder>
					<v-row
						class="fill-height ma-0"
						align="center"
						justify="center"
					>
						<v-progress-circular
							indeterminate
							color="grey-lighten-5"
						></v-progress-circular>
					</v-row>
				</template>
			</v-img>
			<h1 class="mt-2 font-weight-bold">Competitions</h1>
		</v-col>

		<v-divider />
		<!--	Events	-->

		<div class="text-center mx-4">
			<v-btn
				variant="text"
				class="my-2 mx-1 px-11"
				prepend-icon="mdi-dance-ballroom"
				v-for="eventTitle in eventTitles" :key="eventTitle"
			>
				{{ eventTitle }}
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
			foundationLogo: `${import.meta.env.BASE_URL}foundation-logo.png`
		}
	},
	computed: {
		eventTitles() {
			return this.$store.getters['events/eventTitles']
		}
	},
	created() {
		$.ajax({
			url: `${this.$store.getters.appURL}/judge.php`,
			type: 'GET',
			xhrFields: {
				withCredentials: true
			},
			data: {
				getEvents: ''
			},
			success: (data) => {
				data = JSON.parse(data);
				const events = data.events.reduce((acc, curr) => {
					acc[curr.slug] = {
						id: curr.id,
						category_id: curr.category_id,
						title: curr.title
					};
					return acc;
				}, {});
				this.$store.commit('events/setEvents', events)
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