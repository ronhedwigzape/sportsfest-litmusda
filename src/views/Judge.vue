<template>
    <top-nav/>

    <side-nav/>

	<!--	Judge Score Sheet	-->
	<v-main v-if="$store.getters['auth/getUser'] !== null">
		<v-table
			v-if="$route.params.eventSlug && event"
			density="comfortable"
			fixed-header
			:height="scoreSheetHeight"
		>
			<thead>
				<tr>
					<th colspan="2" class="text-uppercase text-center font-weight-bold text-h4 text-grey-darken-4 py-3">
						{{ event.title }}
					</th>
					<th
						v-for="(criterion, criterionIndex) in criteria"
						style="width: 13%"
						class="text-center text-uppercase py-3"
						:class="{ 'bg-grey-lighten-4': coordinates.x == criterionIndex && !scoreSheetDisabled }"
					>
						<div class="d-flex h-100 flex-column align-content-space-between">
							<p class="text-grey-darken-2" :class="$vuetify.display.mdAndDown ? 'text-subtitle-1' : ''">{{ criterion.title }}</p>
							<b class="text-grey-darken-4" :class="$vuetify.display.mdAndDown ? 'text-subtitle-2 font-weight-bold' : ''" style="margin-top: auto">{{ criterion.percentage }}%</b>
						</div>
					</th>
					<th
						style="width: 13%"
						class="text-uppercase text-center text-grey-darken-4 font-weight-bold py-3"
						:class="{ 'bg-grey-lighten-4': coordinates.x == criteria.length && !scoreSheetDisabled }, $vuetify.display.mdAndDown ? 'text-h6' : 'text-h4'"
					>
						Total
					</th>
					<th
						style="width: 13%"
						class="text-uppercase text-center text-grey-darken-4 font-weight-bold py-3"
						:class="$vuetify.display.mdAndDown ? 'text-h6' : 'text-h4'"

					>
						Rank
					</th>
				</tr>
			</thead>
			<tbody>
				<tr
					v-for="(team, teamIndex) in teams"
					:key="team.id"
					:class="{ 'bg-grey-lighten-4': coordinates.y == teamIndex && !scoreSheetDisabled }"
				>
					<td class="text-uppercase text-right text-h5 font-weight-bold text-grey-darken-4">
						{{ teamIndex + 1 }}
					</td>
					<td>
                        <div class="d-flex">
                            <v-avatar size="42" class="mr-2">
                                <v-img
                                    cover
                                    :src="`${$store.getters.appURL}/crud/uploads/${team.avatar}`"
                                />
                            </v-avatar>
                            <div>
                                <p class="ma-0 text-body-1 text-uppercase font-weight-bold">{{ team.country }}</p>
                                <p class="ma-0" style="margin-top: -5px !important;"><small>{{ team.name }}</small></p>
                            </div>
                        </div>
					</td>
					<td
						v-for="(criterion, criterionIndex) in criteria"
						:key="criterion.id"
						:class="{ 'bg-grey-lighten-4': coordinates.x == criterionIndex && !scoreSheetDisabled }"
					>
						<v-text-field
							type="number"
							class="font-weight-bold"
							variant="underlined"
							hide-details
							single-line
							:min="0"
							:max="criterion.percentage"
							@change="saveRating(ratings[`${event.slug}_${team.id}`][`${$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`], criterion.percentage, team)"
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
							@focus.passive="updateCoordinates(criterionIndex, teamIndex)"
						/>
					</td>
					<td :class="{ 'bg-grey-lighten-4': coordinates.x == criteria.length && !scoreSheetDisabled }">
						<v-text-field
							type="number"
							class="font-weight-bold"
							variant="outlined"
							hide-details
							single-line
							:loading="totals[`team_${team.id}`].loading"
							v-model.number="totals[`team_${team.id}`].value"
							:min="$store.state.rating.min"
							:max="$store.state.rating.max"
							@change="calculateTotalScores(team)"
							:class="{
								'text-error font-weight-bold': (
									totals[`team_${team.id}`].value < $store.state.rating.min
								|| totals[`team_${team.id}`].value > $store.state.rating.max
								),
								'text-success font-weight-bold': (
									totals[`team_${team.id}`].value >= $store.state.rating.min
								&& totals[`team_${team.id}`].value <= $store.state.rating.max
								)
							}"
							:error="(
								  totals[`team_${team.id}`].value.toString().trim() === ''
							   || totals[`team_${team.id}`].value < $store.state.rating.min
							   || totals[`team_${team.id}`].value > $store.state.rating.max
						   )"
							:disabled="totals[`team_${team.id}`].is_locked"
							:id="`input_${teamIndex}_${criteria.length}`"
							@keydown.down.prevent="moveDown(criteria.length, teamIndex)"
							@keydown.enter="moveDown(criteria.length, teamIndex)"
							@keydown.up.prevent="moveUp(criteria.length, teamIndex)"
							@keydown.right.prevent="moveRight(criteria.length, teamIndex)"
							@keydown.left.prevent="moveLeft(criteria.length, teamIndex)"
							@focus.passive="updateCoordinates(criteria.length, teamIndex)"
						/>
					</td>
					<td class="text-center"> {{ ranks[`team_${team.id}`] }}</td>
				</tr>
			</tbody>
			<!--	Dialog	  -->
			<tfoot>
				<td colspan="12">
					<v-col align="center"
						   justify="end"
					>
						<v-btn
							class="py-7 bg-grey-lighten-1 text-grey-darken-3"
							@click="openSubmitDialog"
							:disabled="scoreSheetDisabled"
							block
							flat
						>
						<p style="font-size: 1.2rem;">submit ratings</p>
						</v-btn>
						<v-dialog
							v-if="submitDialog"
							v-model="submitDialog"
							persistent
							max-width="400"
						>
							<v-card>
								<v-card-title class="bg-black">
									<v-icon id="remind">mdi-information</v-icon> Submit Ratings
								</v-card-title>
								<v-card-text>
									Please confirm that you wish to finalize the ratings for <b>{{ event.title }}</b>. This action cannot be undone.
								</v-card-text>
								<v-card-actions>
									<v-spacer></v-spacer>
                                    <v-btn
                                        class="text-red-darken-1"
                                        :disabled="submitLoading"
                                        @click="submitDialog = false"
                                    >
                                        Go Back
                                    </v-btn>
                                    <v-btn
                                        class="text-green-darken-1"
                                        :loading="submitLoading"
                                        @click="submitRatings"
                                    >
                                        Submit
                                    </v-btn>
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
									<v-icon id="warning">mdi-alert</v-icon>	Submit Ratings
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
				color="black"
				class="mb-16"
				indeterminate
			/>
		</div>
	</v-main>
</template>


<script>
    import topNav from '../components/nav/TopNav.vue';
    import sideNav from '../components/nav/SideNav.vue';
    import $ from 'jquery';

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
                coordinates: {
                    x: -1,
                    y: -1
                }
            }
        },
        computed: {
            ranks() {
                const teamRanks = {};

                // get unique totals
                const uniqueTotals = [];
                for (let i = 0; i < this.teams.length; i++) {
                    const team = this.teams[i];
                    const teamKey = `team_${team.id}`;
                    const total = this.totals[teamKey].value;
                    if (!uniqueTotals.includes(total))
                        uniqueTotals.push(total);

                    // push to teamRanks
                    teamRanks[teamKey] = 0;
                }

                // sort uniqueTotals in descending order
                uniqueTotals.sort((a, b) => b - a);

                // prepare rankGroup
                const rankGroup = {};

                // get dense rank of each team
                const denseRanks = {};
                for (let i = 0; i < this.teams.length; i++) {
                    const team = this.teams[i];
                    const teamKey = `team_${team.id}`;
                    const total = this.totals[teamKey].value;
                    const denseRank = 1 + uniqueTotals.indexOf(total);
                    denseRanks[denseRank] = denseRank;

                    // push to rankGroup
                    const rankGroupKey = `rank_${denseRank}`;
                    if (!rankGroup[rankGroupKey])
                        rankGroup[rankGroupKey] = [];
                    rankGroup[rankGroupKey].push(teamKey);
                }

                // get fractional rank
                let ctr = 0;
                for (let i = 0; i < uniqueTotals.length; i++) {
                    const key = `rank_${(i + 1)}`;
                    const group = rankGroup[key];
                    const size = group.length;
                    const fractionalRank = ctr + (((size * (size + 1)) / 2) / size);

                    // write fractionalRank to group members
                    for (let j = 0; j < size; j++) {
                        teamRanks[group[j]] = fractionalRank;
                    }
                    ctr += size;
                }
                return teamRanks;
            },
            scoreSheetHeight() {
                return this.$store.getters.windowHeight - 64;
            },
            scoreSheetDisabled() {
                // initialize disable
                let disabled = true;
                // get ratings.is_locked and pass value to disabled variable
                for (let i = 0; i < this.teams.length; i++) {
                    const ratings = this.ratings[`${this.event.slug}_${this.teams[i].id}`];
                    for (let j = 0; j < this.criteria.length; j++) {
                        const criterion = this.criteria[j];
                        const rating = ratings[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${this.teams[i].id}`]
                        if (!rating.is_locked) {
                            disabled = false;
                            break;
                        }
                    }
                }
                // return value
                return disabled;
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
                            // create total score for ratings
                            for (let i = 0; i < this.teams.length; i++) {
                                let total = 0;
                                this.totals[`team_${this.teams[i].id}`] = {};
                                const rating = this.ratings[`${this.event.slug}_${this.teams[i].id}`];
                                for (let j = 0; j < this.criteria.length; j++) {
                                    const criterion = this.criteria[j];
                                    const value = rating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${this.teams[i].id}`].value
                                    this.totals[`team_${this.teams[i].id}`].is_locked = rating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${this.teams[i].id}`].is_locked
                                    total += value;
                                }
                                this.totals[`team_${this.teams[i].id}`].value = total;
                                this.totals[`team_${this.teams[i].id}`].loading = false;
                            }
                        },
                        error: (error) => {
                            alert(`ERROR ${error.status}: ${error.statusText}`);
                        },
                    });
                }
            },
            saveRating(rating, percentage, team) {
                this.totals[`team_${team.id}`].loading = true;
                // validates rating
                if (rating.value < 0 || rating.value === '') {
                    rating.value = 0;
                } else if (rating.value > percentage) {
                    rating.value = percentage;
                }
                // auto-save ratings
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
                        let total = 0;

                        // accumulate ratings to total score
                        const teamRating = this.ratings[`${this.event.slug}_${team.id}`];
                        for (let j = 0; j < this.criteria.length; j++) {
                            const criterion = this.criteria[j];
                            total += teamRating[`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`].value
                        }

                        // accumulate total adds into totals object
                        this.totals[`team_${team.id}`].value = total;

                        // set timeout for loading
                        if (this.totals[`team_${team.id}`].loading) {
                            setTimeout(() => {
                                this.totals[`team_${team.id}`].loading = false;
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
                // set loading state
                this.totals[`team_${team.id}`].loading = true;

                // validates total scores
                if (this.totals[`team_${team.id}`].value < this.$store.state.rating.min || this.totals[`team_${team.id}`].value === '') {
                    this.totals[`team_${team.id}`].value = this.$store.state.rating.min;
                } else if (this.totals[`team_${team.id}`].value > this.$store.state.rating.max) {
                    this.totals[`team_${team.id}`].value = this.$store.state.rating.max;
                }

                // total score divided and distributed based on criteria percentage
                let ratings = [];
                for (let criterion of this.criteria) {
                    const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];
                    rating.value = this.totals[`team_${team.id}`].value * (criterion.percentage / 100);
                    // Ratings are pushed to array
                    ratings.push(rating);
                }

                // auto-save total score
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
                        if (this.totals[`team_${team.id}`].loading) {
                            setTimeout(() => {
                                this.totals[`team_${team.id}`].loading = false;
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
                // define minRating and maxRating
                let minRating = this.$store.state.rating.min;
                let maxRating = this.$store.state.rating.max;

                // open dialog according to ratings
                for (let i = 0; i < this.teams.length; i++) {
                    if (this.totals[`team_${this.teams[i].id}`].value < minRating || this.totals[`team_${this.teams[i].id}`].value > maxRating) {
                        this.inspectDialog = true
                        this.submitDialog = false;
                        break;
                    } else {
                        this.submitDialog = true
                    }
                }
            },
            submitRatings() {
                // set loading state
                this.submitLoading = true;

                // prepare ratings array
                let ratings = [];
                for (let i = 0; i < this.teams.length; i++) {
                    const team = this.teams[i];
                    for (let criterion of this.criteria) {
                        const rating = this.ratings[`${this.event.slug}_${team.id}`][`${this.$store.getters['auth/getUser'].id}_${criterion.id}_${team.id}`];
                        ratings.push(rating);
                    }
                }

                // send data
                $.ajax({
                    url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
                    type: 'POST',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        ratings,
                        locking: true
                    },
                    success: (data, textStatus, jqXHR) => {
                        if (this.submitLoading) {
                            setTimeout(() => {
                                this.submitLoading = false
                                this.submitDialog = false;

                                // lock all ratings after submission
                                for (let i = 0; i < ratings.length; i++) {
                                    ratings[i].is_locked = true;
                                }

                                // lock all total scores for each rating
                                for (let i = 0; i < this.teams.length; i++) {
                                    this.totals[`team_${this.teams[i].id}`].is_locked = true;
                                }
                            }, 600);
                        }
                        console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
                    },
                    error: (error) => {
                        this.submitLoading = false
                        alert(`ERROR ${error.status}: ${error.statusText}`);
                    }
                })
            },
            move(x, y, focus = true) {
                // move to input
                const nextInput = document.querySelector(`#input_${y}_${x}`);
                if (nextInput) {
                    if (focus)
                        nextInput.focus();
                    if (Number(nextInput.value) <= 0)
                        nextInput.select();
                }
            },
            moveDown(x, y) {
                // move to input below
                y += 1;
                if (y < this.teams.length)
                    this.move(x, y);
            },
            moveUp(x, y) {
                // move to input above
                y -= 1;
                if (y >= 0)
                    this.move(x, y);
            },
            moveRight(x, y) {
                // move to input to the right
                x += 1;
                if (x <= this.criteria.length)
                    this.move(x, y);
            },
            moveLeft(x, y) {
                // move to input to the left
                x -= 1;
                if (x >= 0)
                    this.move(x, y);
            },
            updateCoordinates(x, y) {
                // get input coordinates
                this.coordinates.x = x;
                this.coordinates.y = y;
                this.move(x, y, false);
            }
        },
        mounted() {
            this.$emit('startPing');
        }
    }
</script>


<style scoped>
    tbody td, th {
        height: 64px !important;
    }

    tbody td {
        border-bottom: 1px solid #ddd;
        padding: 1rem !important;
    }

    #warning {
        animation: tilt-shaking 1ms linear infinite;
    }

    #remind {
        animation: tilt-shaking 1s linear infinite;
    }

    @keyframes tilt-shaking {
        0% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(6deg);
        }
        50% {
            transform: rotate(0deg);
        }
        75% {
            transform: rotate(-6deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }

    @keyframes shine {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
</style>