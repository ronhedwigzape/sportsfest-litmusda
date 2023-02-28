<template>
	<v-layout style="height: 100vh;">
		<side-nav />

		<top-nav />

		<!--	Judge Score Sheet	-->
		<v-main v-if="$store.getters['auth/getUser'] !== null">
			<v-table v-if="$route.params.eventSlug && event" density="comfortable" hover>
				<thead>
					<tr>
						<th colspan="12" class="text-h5 text-uppercase text-center font-weight-bold">
							{{ event.title }}
						</th>
					</tr>
					<tr>
						<th class="text-uppercase text-center font-weight-bold">
							Teams
						</th>
						<th class="text-uppercase text-center" v-for="criterion in criteria">
							<b>{{ criterion.title }}</b> ({{ criterion.percentage }}%)
						</th>
						<th class="text-uppercase text-center font-weight-bold">Total</th>
						<th class="text-uppercase text-center font-weight-bold">Rank</th>
					</tr>
				</thead>
				<tbody >
					<tr v-for="team in teams" :key="team.id">
						<td class="text-uppercase text-center font-weight-bold">
							<v-col align="center">
								<v-img
									:src="`${$store.getters.appURL}/crud/uploads/${team.logo}`"
									:lazy-src="`${$store.getters.appURL}/crud/uploads/${team.logo}`"
									aspect-ratio="1"
									:alt="`${team.name} Logo`"
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
											>
											</v-progress-circular>
										</v-row>
									</template>
								</v-img>
							</v-col>
							{{ team.name }}
						</td>
						<td	v-for="criterion in criteria"
							:key="criterion.id"
						>
							<v-text-field
								id="ratings"
								type="number"
								class="font-weight-bold"
								variant="underlined"
								hide-details
								single-line
								@change="save(ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`], ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value, criterion.percentage)"
								v-model.number="ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value"
								:class="{
									'text-error font-weight-bold': (
										ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value < 0 ||
										ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value > criterion.percentage
									),
									'text-grey-darken-4': ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value === 0
								}"
								:error="(
									  ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value.toString().trim() === ''
								   || ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value < 0
								   || ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value > criterion.percentage
							   )"
							>
							</v-text-field>
						</td>
						<td>
							<v-text-field
								variant="outlined"
							>
							</v-text-field>
						</td>
						<td></td>
					</tr>
				</tbody>
				<!--	Dialog	  -->
				<tfoot>
					<td colspan="12">
						<v-col align="center" justify="center">
							<v-btn
								class="my-5"
								color="deep-purple-darken-1"
								@click="dialog = true"
							>
							submit ratings
							</v-btn>
							<v-dialog
								v-model="dialog"
								persistent
								width="auto"
							>
								<v-card class="pa-2">
									<v-card-title>
										Submit Ratings
									</v-card-title>
									<v-card-text>
										Please confirm that you wish to finalize the ratings for {{ event.title }}. This action cannot be undone.
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn color="primary" @click="dialog = false">Close</v-btn>
										<v-btn color="primary"  @click="">Submit</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
						</v-col>
					</td>
				</tfoot>
			</v-table>

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
	</v-layout>
</template>

<script>
	import topNav from "../components/nav/TopNav.vue";
	import sideNav from "../components/nav/SideNav.vue";
	import $ from "jquery";

	export default {
		name: 'Judge',
		components: {
			topNav,
			sideNav
		},
		data() {
			return {
				dialog: false,
				loading: false,
				criteria: [],
				teams: [],
				ratings: {},
				event: null,
				timer: null
			}
		},
		watch: {
			$route: {
				immediate: true,
				handler(to, from) {
					this.event = null;
					if(this.timer)
						clearTimeout(this.timer)
					this.fetchScoreSheet();
				}
			}
		},
		methods: {
			fetchScoreSheet() {
				// fetch scoresheet from backend
				if (this.$route.params.eventSlug) {
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
							this.ratings = data.ratings
							this.event = data.event

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
			},
			save(rating, value, percentage) {
				$.ajax({
					url: `${this.$store.getters.appURL}/judge.php`,
					type: 'POST',
					xhrFields: {
						withCredentials: true
					},
					data: {
						rating
					},
					success: (data) => {
						console.log(data)

						if (value < 0) {
							value = 0;
						}
						else if (value > percentage) {
							value = percentage;
						}
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			},
			getIconForEvent(title) {
				switch (title) {
					case "Oration":
					case "Balagtasan":
					case "Tigsik":
					case "Jazz Chant":
						return "mdi-script-text";
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
		}
	}
</script>

<style scoped>
	tbody td {
		height: 64px !important;
	}
	input{
		text-align: center !important;
	}
	th, td {
		border: 1px solid #ddd;
	}
</style>