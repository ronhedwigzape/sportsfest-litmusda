<template>
	<v-layout style="height: 100vh;">
		<side-nav />

		<top-nav />

		<!--	Judge Score Sheet	-->
		<v-main v-if="$store.getters['auth/getUser'] !== null">
			<v-table
				v-if="$route.params.eventSlug && event"
				density="comfortable"
				fixed-header
				hover
				:height="680"
			>
				<thead>
					<tr>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">#</th>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
							{{ event.title }} Teams
						</th>
						<th class="text-center" v-for="criterion in criteria">
							<p class="text-uppercase text-deep-purple-lighten-1">{{ criterion.title }}</p>
							<b class="text-deep-purple-darken-2">({{ criterion.percentage }}%)</b>
						</th>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Total</th>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Rank</th>
					</tr>
				</thead>
				<tbody >
					<tr v-for="(team, teamIndex) in teams" :key="team.id">
						<td class="text-uppercase text-center text-h5 font-weight-bold text-deep-purple-darken-2">
							{{ teamIndex + 1 }}
						</td>
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
						<td v-for="criterion in criteria" :key="criterion.id">
							<v-text-field
								type="number"
								class="font-weight-bold"
								variant="underlined"
								hide-details
								single-line
								@change="save(ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`], criterion.percentage, team.id)"
								v-model.number="ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value"
								:class="{
									'text-error font-weight-bold': (
										ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value < 0 ||
										ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value > criterion.percentage
									),
									'text-grey-darken-2': ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value === 0
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
								type="number"
								class="font-weight-bold"
								variant="outlined"
								hide-details
								single-line
								:loading="loading"
								v-model.number="$store.state.total[team.id]"
								:min="$store.state.rating.min"
								:max="$store.state.rating.max"
								@change="teamsTotalScores(team)"
							>
							</v-text-field>
						</td>
						<td> </td>
					</tr>
				</tbody>
				<!--	Dialog	  -->
				<tfoot>
					<td colspan="12">
						<v-col align="center" justify="center">
							<v-btn
								class="px-16 mt-5 mb-10"
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
				event: null,
				timer: null,
				teams: [],
				criteria: [],
				ratings: {},
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
							this.criteria = data.criteria
							this.teams = data.teams
							this.ratings = data.ratings
							this.event = data.event
						},
						error: (error) => {
							alert(`ERROR ${error.status}: ${error.statusText}`);
						},
					});
				}
			},
			save(rating, percentage, teamId) {
				this.loading = true

				if (rating.value < 0 || rating.value === '') {
					rating.value = 0;
				}
				else if (rating.value > percentage) {
					rating.value = percentage;
				}
				$.ajax({
					url: `${this.$store.getters.appURL}/judge.php`,
					type: 'POST',
					xhrFields: {
						withCredentials: true
					},
					data: {
						rating
					},
					success: (data, textStatus, jqXHR) => {
						this.$store.state.total[teamId] += rating.value
						if(this.loading) {
							setTimeout(() => {
								this.loading = false;
							}, 1000);
						}
						console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			},
			teamsTotalScores(team) {

				if (this.$store.state.total[team.id] < 0 || this.$store.state.total[team.id] === '') {
					this.$store.state.total[team.id] = this.$store.state.rating.min;
				}
				else if (this.$store.state.total[team.id] > 100) {
					this.$store.state.total[team.id] = this.$store.state.rating.max;
				}

				for (let criterion of this.criteria) {
					const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];
					rating.value = this.$store.state.total[team.id] * (criterion.percentage / 100);
					this.save(rating, criterion.percentage)
				}
			}
		},
		computed: {
			/*******************************************************************************
			 *	I. Get dense rank:
			 *	1. Gather all unique total ratings U.
			 *	2. Sort U.
			 *	3. Scan the individual total ratings again, and find their (index + 1) in U.
			 *
			 *	example:
			 *	total_ratings = [12, 10, 5, 10, 6]
			 *
			 *	U = [12, 10, 5, 6]
			 *
			 *	sorted U = [5, 6, 10, 12]
			 *
			 *	total_ratings_rank = [4, 3, 1, 3, 2]
			 */
			ranks() {
				console.log(Object.values(this.$store.state.total).filter(value => !isNaN(value)))
			}
		}
	}
</script>

<style scoped>
	tbody td, th {
		height: 64px !important;
	}
	tbody td {
		border-bottom: 1px solid #ddd;
	}
</style>