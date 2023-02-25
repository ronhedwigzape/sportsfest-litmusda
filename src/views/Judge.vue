<template>
    <v-layout style="height: 100vh;">

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
		<top-nav />

		<!--	Judge Score Sheet	-->
		<v-main>
			<v-table v-if="$route.params.eventSlug" hover>
				<thead>
				<tr>
					<th colspan="7"
						class="text-h5 text-uppercase text-center font-weight-bold"
					>
						{{ event.title }}
					</th>
				</tr>
				<tr>
					<th class="text-uppercase text-center font-weight-bold"
					>
						Team Name
					</th>
					<th class="text-uppercase text-center"
						v-for="criterion in criteria">
						<b>{{ criterion.title }}</b> ({{ criterion.percentage }}%)
					</th>
					<th class="text-uppercase text-center font-weight-bold">Average</th>
					<th class="text-uppercase text-center font-weight-bold">Rank</th>
				</tr>
				</thead>
				<tbody >
					<tr
						v-for="(eventRating, eventTeam) in ratings"
						:key="eventTeam"
					>
						<td
							class="text-uppercase text-center font-weight-bold"
						>
						<v-col align="center">
							<v-img
								v-if="eventTeam.endsWith('_1')"
								:src="redTeamLogo"
								:lazy-src="redTeamLogo"
								aspect-ratio="1"
								alt="Fearless-Dragons-Logo"
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
							<v-img
								v-else-if="eventTeam.endsWith('_2')"
								:src="greenTeamLogo"
								:lazy-src="greenTeamLogo"
								aspect-ratio="1"
								alt="Furious-Elves-Logo"
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
							<v-img
								v-else-if="eventTeam.endsWith('_3')"
								:src="blueTeamLogo"
								:lazy-src="blueTeamLogo"
								aspect-ratio="1"
								alt="Wise-Wizards-Logo"
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
						</v-col>
							<span>{{ teamName(eventTeam) }}</span>
						</td>
						<td
							v-for="criterion in eventRating"
							:key="criterion.id"
						>
							<v-text-field
								type="number"
								variant="outlined"
								:value="criterion.value"
							>
							</v-text-field>
						</td>
					</tr>
				</tbody>
			</v-table>
		</v-main>

    </v-layout>
</template>


<script>
	import topNav from "../components/nav/TopNav.vue";
	import $ from "jquery";

    export default {
        name: 'Judge',
        components: {
			topNav
        },
        data() {
            return {
				foundationLogo: `${import.meta.env.BASE_URL}foundation-logo.png`,
				redTeamLogo: `${import.meta.env.BASE_URL}red.png`,
				greenTeamLogo: `${import.meta.env.BASE_URL}green.png`,
				blueTeamLogo: `${import.meta.env.BASE_URL}blue.png`,
				criteria: [],
				teams: [],
				ratings: {},
				event: {}
            }
        },
		watch: {
			$route: {
				immediate: true,

				handler(to, from) {
					this.fetchScoreSheet();
				}
			}
		},
		methods: {
			fetchScoreSheet() {
				// fetch scoresheet from backend
				if(this.$route.params.eventSlug) {
					$.ajax({
						url: `${this.$store.getters.appURL}/judge.php`,
						type: 'GET',
						xhrFields: {
							withCredentials: true
						},
						data: {
							getScoreSheet: this.$route.params.eventSlug
						},
						success: (data) => {
							data = JSON.parse(data);
							console.log(data)
							this.criteria = data.criteria
							this.teams = data.teams
							this.ratings  = data.ratings
							this.event = data.event
						},
						error: (error) => {
							alert(`ERROR ${error.status}: ${error.statusText}`);
						},
					});
				}
			},
			teamName(eventTeam) {
				return eventTeam.endsWith('_1') ? 'Fearless Dragons' :
					eventTeam.endsWith('_2') ? 'Furious Elves' :
					eventTeam.endsWith('_3') ? 'Wise Wizards' :
					'Unknown Team';
			},
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
					this.$store.commit('events/setEvents', data.events)
					console.log(data)
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