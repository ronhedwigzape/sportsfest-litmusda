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
				:height="1000"
			>
				<thead>
					<tr>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">#</th>
						<th rowspan="2" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
							{{ event.title }} Teams
						</th>
						<th v-for="criterion in criteria" style="width: 13%" class="text-center font-weight-bold text-uppercase">
							<p class="text-deep-purple-darken-2" style="font-size: 0.8rem;">{{ criterion.title }}</p>
							<b class="text-deep-purple-darken-4">{{ criterion.percentage }}%</b>
						</th>
						<th rowspan="2" style="width: 13%" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Total</th>
						<th rowspan="2" style="width: 13%" class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">Rank</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(team, teamIndex) in teams" :key="team.id">
						<td class="text-uppercase text-center text-h5 font-weight-bold text-deep-purple-darken-2">
							{{ teamIndex + 1 }}
						</td>
						<td class="text-uppercase text-center">
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
						<td v-for="(criterion, criterionIndex) in criteria" :key="criterion.id">
							<v-text-field
								type="number"
								class="font-weight-bold"
								variant="underlined"
								hide-details
								single-line
								:min="0"
								:max="criterion.percentage"
								@change="saveRating(ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`], criterion.percentage, team.id)"
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
							   	:disabled="ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].is_locked"
								:id="`input_${teamIndex}_${criterionIndex}`"
								@keydown.down.prevent="moveDown(criterionIndex, teamIndex)"
								@keydown.enter="moveDown(criterionIndex, teamIndex)"
								@keydown.up.prevent="moveUp(criterionIndex, teamIndex)"
								@keydown.right.prevent="moveRight(criterionIndex, teamIndex)"
								@keydown.left.prevent="moveLeft(criterionIndex, teamIndex)"
							/>
						</td>
						<td>
							<v-text-field
								type="number"
								class="font-weight-bold"
								variant="outlined"
								hide-details
								single-line
								:loading="totals[`loading_${team.id}`]"
								v-model.number="totals[`team_${team.id}`]"
								:min="$store.state.rating.min"
								:max="$store.state.rating.max"
								@change="calculateTotalScores(team)"
								:class="{
									'text-error font-weight-bold': (
										totals[`team_${team.id}`] < $store.state.rating.min
									|| totals[`team_${team.id}`] > $store.state.rating.max
									),
									'text-success font-weight-bold': (
										totals[`team_${team.id}`] >= $store.state.rating.min
									&& totals[`team_${team.id}`] <= $store.state.rating.max
									)
								}"
								:error="(
									  totals[`team_${team.id}`].toString().trim() === ''
								   || totals[`team_${team.id}`] < $store.state.rating.min
								   || totals[`team_${team.id}`] > $store.state.rating.max
							   )"
								:disabled="totals['is_locked']"
								:id="`input_${teamIndex}_${criteria.length}`"
								@keydown.down.prevent="moveDown(criteria.length, teamIndex)"
								@keydown.enter="moveDown(criteria.length, teamIndex)"
								@keydown.up.prevent="moveUp(criteria.length, teamIndex)"
								@keydown.right.prevent="moveRight(criteria.length, teamIndex)"
								@keydown.left.prevent="moveLeft(criteria.length, teamIndex)"
							/>
						</td>
						<td class="text-center text-deep-purple-darken-1"> {{ ranks[`team_${team.id}`].toFixed(2) }}</td>
					</tr>
				</tbody>
				<!--	Dialog	  -->
				<tfoot>
					<td colspan="12">
						<v-col align="center"
							   justify="end"
						>
							<v-btn
								class="py-6"
								color="deep-purple-darken-2"
								@click="openSubmitDialog"
								:disabled="totals['is_locked']"
								block
							>
							submit ratings
							</v-btn>
							<v-dialog
								v-if="submitDialog"
								v-model="submitDialog"
								persistent
								max-width="400"
							>
								<v-card>
									<v-card-title class="bg-deep-purple-darken-3">
										Submit Ratings
									</v-card-title>
									<v-card-text>
										Please confirm that you wish to finalize the ratings for <b class="text-deep-purple-darken-3">{{ event.title }}</b>. This action cannot be undone.
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn color="primary" prepend-icon="mdi-close" @click="submitDialog = false">Close</v-btn>
										<v-btn color="primary" :loading="submitLoading" @click="submitRatings">Submit</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
							<v-dialog
								v-if="inspectDialog"
								v-model="inspectDialog"
								persistent
								max-width="400"
							>
								<v-card>
									<v-card-title class="bg-red-darken-4">
										Submit Ratings
									</v-card-title>
									<v-card-text>
										<p class="mb-2 text-red-darken-4">
											Sorry, your ratings for {{ event.title}} cannot be submitted as they must be between
											<b>{{ $store.state.rating.min }}</b> and <b>{{ $store.state.rating.max }}</b>.
										</p>
										<p class="text-red-darken-4">Please adjust your ratings and try submitting again.</p>
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn color="red-darken-4" prepend-icon="mdi-close" @click="inspectDialog = false">Close</v-btn>
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
			submitDialog: false,
			submitLoading: false,
			inspectDialog: false,
			event: null,
			timer: null,
			teams: [],
			criteria: [],
			ratings: {},
			totals: {},
		}
	},
	watch: {
		$route: {
			immediate: true,
			handler(to, from) {
				this.event = null;
				if (this.timer)
					clearTimeout(this.timer)
				this.fetchScoreSheet();
			}
		}
	},
	methods: {
		fetchScoreSheet() {

			// fetch scoreSheet from backend
			if (this.$route.params.eventSlug) {
				$.ajax({
					url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
					type: 'GET',
					xhrFields: {
						withCredentials: true
					},
					data: {
						getScoreSheet: this.$route.params.eventSlug
					},
					success: (data) => {
						data = JSON.parse(data);
						this.criteria = data.criteria;
						this.teams = data.teams;
						this.ratings = data.ratings;
						this.event = data.event;
						this.totals = {}

						// Create total score for ratings
						for (let i = 0; i < this.teams.length; i++) {
							let total = 0;
							const rating = this.ratings[`${this.event.slug}_${this.teams[i].id}`];
							for (let j = 0; j < this.criteria.length; j++) {
								const criterion = this.criteria[j];
								const value = rating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${this.teams[i].id}`].value
								this.totals['is_locked'] = rating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${this.teams[i].id}`].is_locked
								total += value;
							}
							this.totals[`team_${this.teams[i].id}`] = total;
							this.totals[`loading_${this.teams[i].id}`] = false;
						}

					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			}
		},
		saveRating(rating, percentage, teamId) {
			this.totals[`loading_${teamId}`] = true;

			// Ratings are evaluated before saving.
			if (rating.value < 0 || rating.value === '') {
				rating.value = 0;
			} else if (rating.value > percentage) {
				rating.value = percentage;
			}

			// Auto-save ratings
			$.ajax({
				url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					rating
				},
				success: (data, textStatus, jqXHR) => {

					// Accumulate ratings to total score
					let total = 0;
					const teamRating = this.ratings[`${this.event.slug}_${teamId}`];
					for (let j = 0; j < this.criteria.length; j++) {
						const criterion = this.criteria[j];
						total += teamRating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${teamId}`].value
					}

					// Accumulated total adds into totals object
					this.totals[`team_${teamId}`] = total;

					if(this.totals[`loading_${teamId}`]) {
						setTimeout(() => {
							this.totals[`loading_${teamId}`] = false;
						}, 1000);
					}

					console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				},
			});
		},
		calculateTotalScores(team) {
			this.totals[`loading_${team.id}`] = true;

			// Check teams total score
			if (this.totals[`team_${team.id}`] < 50 || this.totals[`team_${team.id}`] === '') {
				this.totals[`team_${team.id}`] = this.$store.state.rating.min;
			}
			else if (this.totals[`team_${team.id}`] > 100) {
				this.totals[`team_${team.id}`] = this.$store.state.rating.max;
			}

			// Total score distributes to each rating according to criteria
			let ratings = [];
			for (let criterion of this.criteria) {
				const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];
				rating.value = this.totals[`team_${team.id}`] * (criterion.percentage / 100);
				// Ratings are pushed to array
				ratings.push(rating);
			}

			// Calls request to submit ratings
			$.ajax({
				url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					ratings
				},
				success: (data, textStatus, jqXHR) => {

					if(this.totals[`loading_${team.id}`]) {
						setTimeout(() => {
							this.totals[`loading_${team.id}`] = false;
						}, 1000);
					}

					console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				}
			})
		},
		openSubmitDialog() {

			// Define minRating and maxRating
			let minRating = this.$store.state.rating.min;
			let maxRating = this.$store.state.rating.max;

			// Opens dialog according to ratings
			for (let i = 0; i < this.teams.length; i++) {
				if (this.totals[`team_${this.teams[i].id}`] < minRating || this.totals[`team_${this.teams[i].id}`] > maxRating) {
					this.inspectDialog = true
					this.submitDialog = false;
					break;
				}
				else {
					this.submitDialog = true
				}
			}
		},
		submitRatings() {
			this.submitLoading = true;

			// Ratings are locked.
			let ratings = [];
			for (let i = 0; i < this.teams.length; i++) {
				const team = this.teams[i];
				for (let criterion of this.criteria) {
					const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];

					rating.is_locked = true;
					ratings.push(rating);
					this.totals['is_locked'] = true;
				}
			}

			// Calls request to submit ratings after ratings is locked.
			$.ajax({
				url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					ratings
				},
				success: (data, textStatus, jqXHR) => {

					if(this.submitLoading) {
						setTimeout(() => {
							this.submitLoading = false
							this.submitDialog = false;
						}, 600);
					}

					console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				}
			})
		},
		move (x, y, focus = true) {
			// Move to input
			const nextInput = document.querySelector(`#input_${y}_${x}`);
			if(nextInput) {
				if(focus)
					nextInput.focus();
				if(Number(nextInput.value) <= 0)
					nextInput.select();
			}
		},
		 moveDown (x, y) {
			// Move to input below
			y += 1;
			if(y < this.teams.length)
				this.move(x, y);
		},
		moveUp (x, y)  {
			// Move to input above
			y -= 1;
			if(y >= 0)
				this.move(x, y);
		},
		moveRight (x, y) {
			// Move to input to the right
			x += 1;
			if(x <= this.criteria.length)
				this.move(x, y);
		},
		moveLeft (x, y) {
			// Move to input to the left
			x -= 1;
			if(x >= 0)
				this.move(x, y);
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
					fractionalRank[id] = denseRank[id] + ((count - 1) / 2);
				});

				// Return fractional rank with team id as keys
				const result = {};
				Object.keys(totals).forEach((id) => {
					result[id] = fractionalRank[id];
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

			// Return ranks
			return filterObject(getFractionalRank(this.totals));

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