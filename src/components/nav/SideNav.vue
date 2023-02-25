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

		<div class="text-center mt-2 mx-4">
			<v-btn
				variant="text"
				class="my-2 mx-1 px-16"
				v-for="event in $store.getters['events/getEvents']"
				:prepend-icon="getIconForTitle(event.title)"
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
			foundationLogo: `${import.meta.env.BASE_URL}foundation-logo.png`
		}
	},
	methods: {
		getIconForTitle(title) {
			switch (title) {
				case "Oration":
				case "Balagtasan":
				case "Tigsik":
					return "mdi-script-text";
				case "Jazz Chant":
				case "Vocal Solo Male":
				case "Vocal Solo Female":
				case "Vocal Duet":
				case "Acoustic Band":
					return "mdi-music";
				case "Hip Hop":
				case "Jazz Dance":
				// Add more cases for other eventTitles
				default:
					return "mdi-dance-ballroom";
			}
		},
		handleEventChange(event) {
			this.$router.push({ name: 'judge', params: { eventSlug: event.slug }});
		}
	},
	// created() {
	// 	$.ajax({
	// 		url: `${this.$store.getters.appURL}/judge.php`,
	// 		type: 'GET',
	// 		xhrFields: {
	// 			withCredentials: true
	// 		},
	// 		data: {
	// 			getEvents: ''
	// 		},
	// 		success: (data) => {
	// 			data = JSON.parse(data);
	// 			this.$store.commit('events/setEvents', data.events)
	// 			console.log(data)
	// 		},
	// 		error: (error) => {
	// 			alert(`ERROR ${error.status}: ${error.statusText}`);
	// 		},
	// 	});
	// },
}
</script>

<style scoped>

</style>