<template>
	<top-nav/>

	<side-nav/>

	<!--	Admin Results	-->
	<v-main
		v-if="$store.getters['auth/getUser'] !== null"
	>
		<!-- results -->
		<v-table
			v-if="$route.params.eventSlug && event"
			density="comfortable" :bordered="true"
			hover
			:height="scoreSheetHeight"
			fixed-header
		>
			<thead>
			<tr>
				<th
					colspan="2"
					class="text-center text-uppercase font-weight-bold text-grey-darken-4 py-3"
					:class="$vuetify.display.mdAndDown ? 'text-h6' : 'text-h5'"
				>
					{{ event.title }}
				</th>
				<template v-for="(technical, technicalKey, technicalIndex) in technicals" :key="technical.id">
					<th
						class="text-center text-uppercase font-weight-bold text-red-darken-4 py-3"
                        :class="{
                            'text-caption': $vuetify.display.mdAndDown,
                            'bg-red-lighten-3': !technical.online
                        }"
					>
                        <!-- technical unlock deductions -->
                        <v-btn
                            v-if="technicalSubmitted[technicalKey]"
                            class="unlock"
                            @click="unlockTechnicalDeductions(technical)"
                            variant="text"
                            size="x-small"
                            icon
                            :ripple="false"
                            style="position: absolute; top: -7px; right: -7px"
                        >
                            <v-icon icon="mdi-lock-open-variant"/>
                        </v-btn>
                        Deduct
                        <div>
                            {{ technicalIndex + 1 }}
                        </div>
                        &nbsp;

                        <!-- technical help status -->
                        <div class="help-status mt-1" v-if="technical.calling">
                            <v-chip
                                size="small"
                                color="warning"
                                variant="flat"
                            >
                                HELP
                            </v-chip>
                        </div>
					</th>
				</template>
				<template v-for="(judge, judgeKey, judgeIndex) in judges" :key="judge.id">
					<th
						class="text-center text-uppercase py-3"
                        :class="{
                            'text-caption': $vuetify.display.mdAndDown,
                            'bg-red-lighten-3': !judge.online
                        }"
					>
                        <!-- judge unlock ratings -->
						<v-btn
                            v-if="judgeSubmitted[judgeKey]"
							class="unlock"
							@click="unlockJudgeRatings(judge)"
							variant="text"
							size="x-small"
							icon
                            :ripple="false"
                            style="position: absolute; top: -7px; right: -7px"
						>
							<v-icon icon="mdi-lock-open-variant"/>
						</v-btn>
						<div
							:class="{
                                'text-dark-darken-1': judge.is_chairman == 0,
                                'text-red-darken-3': judge.is_chairman == 1
                            }"
						>
                            Judge
							<div>
                                {{ judge.number }}<span v-if="judge.is_chairman == 1">*</span>
							</div>
							<b
                                :class="{
                                    'text-dark-darken-1': judge.is_chairman == 0,
                                    'text-red-darken-4': judge.is_chairman == 1
                                }"
							>
								Total
							</b>

                            <!-- judge help status -->
                            <div class="help-status mt-1" v-if="judge.calling">
                                <v-chip
                                    size="small"
                                    color="warning"
                                    variant="flat"
                                >
                                    HELP
                                </v-chip>
                            </div>
						</div>
					</th>
					<th
						class="text-center text-uppercase py-3 text-blue-darken-2"
						:class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
					>
						Judge
						<div>
                            {{ judge.number }}<span v-if="judge.is_chairman == 1">*</span>
                        </div>
						<b class="text-blue-darken-3">Rank</b>
					</th>
				</template>
				<th
					class="text-center text-uppercase font-weight-bold text-green-darken-4 py-3"
					:class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
				>
					Average
				</th>
				<th
					class="text-center text-uppercase font-weight-bold text-blue-darken-4 py-3"
					:class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
				>
					Total Rank
				</th>
				<th
					class="text-center text-uppercase font-weight-bold text-grey-darken-1 py-3"
					:class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
				>
					Initial Rank
				</th>
				<th
					class="text-center text-uppercase font-weight-bold text-grey-darken-4 py-3"
					:class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
				>
					Final Rank
				</th>
                <th
                    class="text-center text-uppercase font-weight-bold text-grey-darken-4 py-3"
                    :class="$vuetify.display.mdAndDown ? 'text-caption' : ''"
                >
                    Title
                </th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="(team, teamKey, teamIndex) in teams" :key="team.id">
				<td
					class="text-center font-weight-bold"
					:class="`${$vuetify.display.mdAndDown ? 'text-h6' : 'text-h5'}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ teamIndex + 1 }}
				</td>
				<td
					class="text-center text-uppercase font-weight-bold"
					:style="{'color': `${team.color} !important` }"
					:class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ team.name }}
				</td>
				<template v-for="(technical, technicalKey, technicalIndex) in technicals" :key="technical.id">
					<td
						class="text-center text-uppercase font-weight-bold text-red-darken-3"
						:class="{
							'bg-grey-lighten-3' : !team.deductions.inputs[technicalKey].is_locked,
							'bg-white' : team.deductions.inputs[technicalKey].is_locked && team.title === '',
							'bg-yellow-lighten-3': allSubmitted && team.deductions.inputs[technicalKey].is_locked && team.title !== '',
						}, $vuetify.display.mdAndDown ? 'text-caption' : ''"
					>
						{{ team.deductions.inputs[technicalKey].value.toFixed(2) }}
					</td>
				</template>
				<template v-for="judge in judges" :key="judge.id">
					<td
						class="text-center"
						:class="{
							'bg-grey-lighten-3' : !team.ratings.inputs[`judge_${judge.id}`].final.is_locked,
							'bg-white' : team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title === '',
							'bg-yellow-lighten-3' : allSubmitted && team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title !== '',
							'text-dark-darken-1': judge.is_chairman == 0,
							'text-red-darken-3': judge.is_chairman == 1
						}, $vuetify.display.mdAndDown ? 'text-caption' : ''"
					>
						{{ team.ratings.inputs[`judge_${judge.id}`].final.deducted.toFixed(2) }}
					</td>
					<td
						class="text-center font-weight-bold text-blue-darken-2"
						:class="{
							'bg-grey-lighten-3': !team.ratings.inputs[`judge_${judge.id}`].final.is_locked,
							'bg-white': team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title === '',
							'bg-yellow-lighten-3': allSubmitted && team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title !== '',
						}, $vuetify.display.mdAndDown ? 'text-caption' : ''"
					>
						{{ team.ratings.inputs[`judge_${judge.id}`].rank.fractional.toFixed(2) }}
					</td>
				</template>
				<td
					class="text-center font-weight-bold text-green-darken-4"
					:class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ team.ratings.average.toFixed(2) }}
				</td>
				<td
					class="text-center font-weight-bold text-blue-darken-4"
					:class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ team.rank.total.fractional.toFixed(2) }}
				</td>
				<td
					class="text-center font-weight-bold text-grey-darken-1"
					:class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ team.rank.initial.fractional.toFixed(2) }}
				</td>
				<td
					class="text-center font-weight-bold"
					:class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
				>
					{{ team.rank.final.fractional }}
				</td>
                <td
                    class="text-center font-weight-bold"
                    :class="`${$vuetify.display.mdAndDown ? 'text-caption' : ''}${allSubmitted && team.title !== '' ? ' bg-yellow-lighten-3' : ''}`"
                >
                    {{ team.title }}
                </td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="20">
					<v-row>
						<template v-for="technical in technicals" :key="technical.id">
							<v-col>
								<v-card class="text-center mb-5" :class="{ 'text-warning': technical.calling }" flat>
									<v-card-title class="pt-16 font-weight-bold">
										{{ technical.name }}
									</v-card-title>
									<v-card-text class="text-center">
										Technical Judge {{ technical.number }}
										<p class="mt-2 mb-0 online-status">
											<v-chip v-if="technical.online" size="x-small" color="success"
													variant="outlined">ONLINE
											</v-chip>
											<v-chip v-else size="x-small" color="error" variant="flat">OFFLINE</v-chip>
										</p>
									</v-card-text>
								</v-card>
							</v-col>
						</template>
						<template v-for="judge in judges" :key="judge.id">
							<v-col>
								<v-card class="text-center mb-5" :class="{ 'text-warning': judge.calling }" flat>
									<v-card-title class="pt-16 font-weight-bold">
										{{ judge.name }}
									</v-card-title>
									<v-card-text class="text-center">
										Judge {{ judge.number }}
										<template v-if="judge.is_chairman == 1">* (Chairman)</template>
										<p class="mt-2 mb-0 online-status">
											<v-chip v-if="judge.online" size="x-small" color="success"
													variant="outlined">ONLINE
											</v-chip>
											<v-chip v-else size="x-small" color="error" variant="flat">OFFLINE</v-chip>
										</p>
									</v-card-text>
								</v-card>
							</v-col>
						</template>
					</v-row>
				</td>
			</tr>
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
import TopNav from "../components/nav/TopNav.vue";
import SideNav from "../components/nav/SideNav.vue";
import $ from 'jquery';

export default {
	name: 'Admin',
	components: {
		TopNav,
		SideNav
	},
	data() {
		return {
			event     : null,
			teams     : [],
			judges    : [],
			technicals: [],
			winners   : {},

			timer: null,
			openUnlockDialog: false,
		}
	},
	computed: {
		scoreSheetHeight() {
			return this.$store.getters.windowHeight - 64;
		},
        technicalSubmitted() {
            const status = {};
            for(const technicalKey in this.technicals) {
                let submitted = true;
                for(const teamKey in this.teams) {
                    if(!this.teams[teamKey].deductions.inputs[technicalKey].is_locked) {
                        submitted = false;
                        break;
                    }
                }
                status[technicalKey] = submitted;
            }
            return status;
        },
        judgeSubmitted() {
            const status = {};
            for(const judgeKey in this.judges) {
                let submitted = true;
                for(const teamKey in this.teams) {
                    if(!this.teams[teamKey].ratings.inputs[judgeKey].rank.rating.is_locked) {
                        submitted = false;
                        break;
                    }
                }
                status[judgeKey] = submitted;
            }
            return status;
        },
        allSubmitted() {
            let status = true;
            const submissions = {...this.technicalSubmitted, ...this.judgeSubmitted};
            for(const key in submissions) {
                if(!submissions[key]) {
                    status = false;
                    break;
                }
            }
            return status;
        }
	},
	watch: {
		$route: {
			immediate: true,
			handler(to, from) {
				if (this.timer)
					clearTimeout(this.timer);
					
				this.event      = null;
				this.teams      = [];
				this.judges     = [];
				this.technicals = [];
				this.winners    = {};
				this.tabulate();
			}
		}
	},
	methods: {
		async tabulate() {
			// tabulate selected event
			if (this.$route.params.eventSlug) {
				await $.ajax({
					url: `${this.$store.getters.appURL}/admin.php`,
					type: 'GET',
					xhrFields: {
						withCredentials: true
					},
					data: {
						tabulate: this.$route.params.eventSlug
					},
					success: (data) => {
						data = JSON.parse(data);
						this.event      = data.event;
						this.teams      = data.results.teams;
						this.judges     = data.results.judges;
						this.technicals = data.results.technicals;
                        this.winners    = data.results.winners;

						// request again
						if (data.event.slug === this.$route.params.eventSlug) {
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
		unlockJudgeRatings(judge) {
			// ask admin for unlock ratings
			if (confirm(`Are you sure to unlock ratings for ${judge.name} (Judge ${judge.number}) in ${this.event.title}?`)) {
				$.ajax({
					url: `${this.$store.getters.appURL}/admin.php`,
					type: 'POST',
					xhrFields: {
						withCredentials: true
					},
					data: {
						unlock_judge_id: judge.id,
						unlock_event_id: this.event.id
					},
					success: (data, textStatus, jqXHR) => {
						console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			}
		},
		unlockTechnicalDeductions(technical) {
			// ask admin for unlock ratings
			if (confirm(`Are you sure to unlock deductions for ${technical.name} (Technical ${technical.number}) in ${this.event.title}?`)) {
				$.ajax({
					url: `${this.$store.getters.appURL}/admin.php`,
					type: 'POST',
					xhrFields: {
						withCredentials: true
					},
					data: {
						unlock_technical_id: technical.id,
						unlock_event_id: this.event.id
					},
					success: (data, textStatus, jqXHR) => {
						console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			}
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
	padding: 1rem !important;
}

th, td {
	border: 1px solid #ddd;
}

</style>
