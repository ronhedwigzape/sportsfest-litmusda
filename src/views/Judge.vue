<template>
	<v-layout style="height: 100vh;">
		<side-nav />

		<top-nav />

		<!--	Judge Score Sheet	-->
		<v-main v-if="$store.getters['auth/getUser'] !== null">
			<v-table
				v-if="$route.params.eventSlug && event"
				density="comfortable"
				fix-header
				hover
				:height="680"
			>
				<thead class="position-relative">
					<tr>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">#</th>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
							{{ event.title }} Teams
						</th>
						<template v-for="criterion in criteria">
							<th class="text-center font-weight-bold text-uppercase text-deep-purple-lighten-1">
								{{ criterion.title }}
							</th>
						</template>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Total</th>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Rank</th>
					</tr>
					<tr>
						<template v-for="criterion in criteria">
						<th class="text-center font-weight-bold text-deep-purple-darken-2">{{ criterion.percentage }}%</th>
						</template>
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
							<keep-alive>
							<v-text-field
								type="number"
								class="font-weight-bold"
								variant="outlined"
								hide-details
								single-line
								:loading="loading"
								v-model.number="total[team.id]"
								:min="$store.state.rating.min"
								:max="$store.state.rating.max"
								@change="teamsTotalScores(team)"
								:class="{
									'text-error font-weight-bold': (
										total[team.id] < $store.state.rating.min
									|| total[team.id] > $store.state.rating.max
									),
									'text-success font-weight-bold': (
										total[team.id] >= $store.state.rating.min
									&& total[team.id] <= $store.state.rating.max
									)
								}"
								:error="(
									  total[team.id].toString().trim() === ''
								   || total[team.id] < $store.state.rating.min
								   || total[team.id] > $store.state.rating.max
							   )"
							>
							</v-text-field>
							</keep-alive>
						</td>
						<td class="text-center text-deep-purple-darken-1"> {{ ranks[team.id].toFixed(2) }}</td>
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
				ranking: {},
				total: {
					1: 0,
					2: 0,
					3: 0
				}
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
							console.log(data)
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
						this.total[teamId] += rating.value
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

				if (this.total[team.id] < 50 || this.total[team.id] === '') {
					this.total[team.id] = this.$store.state.rating.min;
				}
				else if (this.total[team.id] > 100) {
					this.total[team.id] = this.$store.state.rating.max;
				}

				for (let criterion of this.criteria) {
					const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];
					rating.value = this.total[team.id] * (criterion.percentage / 100);
					this.save(rating, criterion.percentage)
				}
			}
		},
		computed: {
			ranks() {
				// Dense rank function
				const getDenseRank = (totals) => {

					// Get total ratings
					const total_ratings = Object.values(totals);

					// Gather all unique total ratings U.
					const U = [...new Set(total_ratings)];

					// Sort U.
					const sortedU = U.sort((a, b) => b - a);

					// Scan the individual total ratings and find their (index + 1) in U.
					const totalRatingsRank = total_ratings.map((rating) =>
						sortedU.indexOf(rating) + 1
					);

					// Assign dense rank to team id's keys
					const total_ratings_rank = {};
					Object.keys(totals).forEach((id, index) => {
						total_ratings_rank[id] = totalRatingsRank[index];
					});

					// return total ratings rank
					return total_ratings_rank;
				}

				// Fractional rank function
				const getFractionalRank = (totals) => {

					// Get dense rank
					const denseRank = getDenseRank(totals);

					// Calculate fractional rank
					const fractionalRank = {};
					Object.entries(totals).forEach(([id, value]) => {
						const count = Object.values(totals).filter((x) => x === value).length;
						const ordinalRank = denseRank[id];
						fractionalRank[id] = ordinalRank + (count - 1) / 2;
					});

					// Return fractional rank with team id as keys
					const result = {};
					Object.keys(totals).forEach((key, index) => {
						result[key] = fractionalRank[key];
					});

					// Return result
					return result;
				}

				// Filter Object if `NaN` and `undefined` is present
				const filterObject = (obj) => {
					// Remove NaN and undefined in the Object
					const filteredArray = Object.entries(obj).filter((value) => {
						return value !== undefined && !Number.isNaN(value);
					});
					return Object.fromEntries(filteredArray);
				}

				// Call fractional rank function
				const fractional_rank = getFractionalRank(this.total)

				// Return ranks
				return filterObject(fractional_rank);
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
		padding-bottom: 1rem !important;
	}
</style>