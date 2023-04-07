<template>
	<top-nav/>

	<side-nav/>

	<!--	Admin Results	-->
    <v-main v-if="$store.getters['auth/getUser'] !== null">
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
					<th colspan="2" class="text-center text-uppercase font-weight-bold text-grey-darken-4 text-h5 py-3">
						{{ event.title}}
					</th>
                    <th
                        v-for="(technical, technicalKey, technicalIndex) in technicals"
                        :key="technical.id"
                        class="text-center text-uppercase font-weight-bold text-red-darken-4 py-3"
                    >
                        Deduct {{ technicalIndex + 1 }}
                        <v-btn
                            class="unlock"
                            @click="unlockTechnicalDeductions(technical)"
                            variant="text"
                            size="x-small"
                            icon
                            style="position: absolute; top: 0; right: 1px"
                        >
                            <v-icon icon="mdi-lock-open-variant"/>
                        </v-btn>
                    </th>
					<template v-for="judge in judges" :key="judge.id">
						<th
							class="text-center text-uppercase py-3"
						>
                            <v-btn
                                class="unlock"
                                @click="unlockJudgeRatings(judge)"
                                variant="text"
                                size="x-small"
                                icon
                                style="position: absolute; top: 0; right: 1px"
                            >
                                <v-icon icon="mdi-lock-open-variant"/>
                            </v-btn>
							<div
								:class="{
                                'text-dark-darken-1': judge.is_chairman == 0,
                                'text-red-darken-3': judge.is_chairman == 1
                            	}"
							>
								Judge {{ judge.number }}<span v-if="judge.is_chairman == 1">*</span>
                                <div
                                    :class="{
                                        'text-dark-darken-1': judge.is_chairman == 0,
                                        'text-red-darken-4': judge.is_chairman == 1
                                    }"
                                >
                                    <small>Total</small>
                                </div>
                                <div class="text-blue-darken-2" style="margin-top: -10px;">
                                    <small>Rank</small>
                                </div>
							</div>
						</th>
					</template>
					<th class="text-center text-uppercase font-weight-bold text-green-darken-4 py-3">
						Average
					</th>
					<th class="text-center text-uppercase font-weight-bold text-blue-darken-4 py-3">
						Total<br>Rank
					</th>
					<th class="text-center text-uppercase font-weight-bold text-grey-darken-1 py-3">
						Initial<br>Rank
					</th>
					<th class="text-center text-uppercase font-weight-bold text-grey-darken-4 py-3">
						Final<br>Rank
					</th>
                    <th class="text-center text-uppercase font-weight-bold text-grey-darken-4 py-3">
                        Title
                    </th>
				</tr>
			</thead>
			<tbody>
                <tr v-for="(team, teamKey, teamIndex) in teams" :key="team.id">
                    <td
                        class="text-h5 text-center font-weight-bold"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        {{ teamIndex + 1 }}
                    </td>
                    <td :class="{ 'bg-yellow-lighten-3': team.title !== '' }">
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
                        v-for="(technical, technicalKey, technicalIndex) in technicals"
                        :key="technical.id"
                        class="text-center text-uppercase font-weight-bold text-red-darken-3"
                        :class="{
                            'bg-grey-lighten-3' : !team.deductions.inputs[technicalKey].is_locked,
                            'bg-white' : team.deductions.inputs[technicalKey].is_locked && team.title === '',
							'bg-yellow-lighten-3': team.deductions.inputs[technicalKey].is_locked && team.title !== ''
                        }"
                    >
                        {{ team.deductions.inputs[technicalKey].value.toFixed(2) }}
                    </td>
                    <td
                        v-for="judge in judges" :key="judge.id"
                        class="text-right"
                        :class="{
                            'bg-grey-lighten-3' : !team.ratings.inputs[`judge_${judge.id}`].final.is_locked,
                            'bg-white' : team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title === '',
							'bg-yellow-lighten-3' : team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title !== ''
                        }"
                    >
                        <div
                            :class="{
                                'text-dark-darken-1': judge.is_chairman == 0,
                                'text-red-darken-3': judge.is_chairman == 1
                            }"
                        >
                            {{ team.ratings.inputs[`judge_${judge.id}`].final.deducted.toFixed(2) }}
                        </div>

                        <div
                            class="text-right font-weight-bold text-blue-darken-2"
                            :class="{
                                'bg-grey-lighten-3' : !team.ratings.inputs[`judge_${judge.id}`].final.is_locked,
                                'bg-white' : team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title === '',
                                'bg-yellow-lighten-3' : team.ratings.inputs[`judge_${judge.id}`].final.is_locked && team.title !== ''
                            }"
                        >
                            {{ team.ratings.inputs[`judge_${judge.id}`].rank.fractional.toFixed(2) }}
                        </div>
                    </td>
                    <td
                        class="text-right font-weight-bold text-green-darken-4"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        <span class="pr-2">{{ team.ratings.average.toFixed(2) }}</span>
                    </td>
                    <td
                        class="text-right font-weight-bold text-blue-darken-4"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        <span class="pr-2">{{ team.rank.total.fractional.toFixed(2) }}</span>
                    </td>
                    <td
                        class="text-right font-weight-bold text-grey-darken-1"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        <span class="pr-2">{{ team.rank.initial.fractional.toFixed(2) }}</span>
                    </td>
                    <td
                        class="text-right font-weight-bold text-h6"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        <span class="pr-3">{{ team.rank.final.fractional }}</span>
                    </td>
                    <td
                        class="text-right font-weight-bold text-h6"
                        :class="{ 'bg-yellow-lighten-3': team.title !== '' }"
                    >
                        {{ team.title }}
                    </td>
                </tr>
				<tr>
					<td :colspan="(7 + totalTechnicals + totalJudges)">
						<v-row class="justify-center">
                            <v-col
                                v-for="technical in technicals" :key="technical.id"
                                md="3"
                            >
                                <v-card class="text-center mb-5" flat>
                                    <v-card-title class="pt-16 font-weight-bold">
                                        {{ technical.name }}
                                    </v-card-title>
                                    <v-card-text class="text-center">
                                        Technical Judge {{ technical.number }}
                                        <p class="mt-2 mb-0 online-status">
                                            <v-chip v-if="technical.online" size="x-small" color="success" variant="outlined">ONLINE</v-chip>
                                            <v-chip v-else size="x-small" color="error" variant="flat">OFFLINE</v-chip>
                                        </p>
                                    </v-card-text>
                                </v-card>
                            </v-col>

                            <v-col
                                v-for="judge in judges" :key="judge.id"
                                md="3"
                            >
                                <v-card class="text-center mb-5" flat>
                                    <v-card-title class="pt-16 font-weight-bold">
                                        {{ judge.name }}
                                    </v-card-title>
                                    <v-card-text class="text-center">
                                        Judge {{ judge.number }}<template v-if="judge.is_chairman == 1">* (Chairman)</template>
                                        <p class="mt-2 mb-0 online-status">
                                            <v-chip v-if="judge.online" size="x-small" color="success" variant="outlined">ONLINE</v-chip>
                                            <v-chip v-else size="x-small" color="error" variant="flat">OFFLINE</v-chip>
                                        </p>
                                    </v-card-text>
                                </v-card>
                            </v-col>
						</v-row>
					</td>
				</tr>
            </tbody>
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
                event: null,
                timer: null,
				openUnlockDialog: false,
				results: {},
				teams: [],
				judges: [],
				technicals: [],
				teamIndex: 0
            }
        },
		computed: {
			scoreSheetHeight() {
				return this.$store.getters.windowHeight - 64;
			},
            totalTechnicals() {
                return Object.values(this.technicals).length;
            },
            totalJudges() {
                return Object.values(this.judges).length;
            }
		},
        watch: {
            $route: {
                immediate: true,
                handler(to, from) {
                    this.event = null;
                    if(this.timer)
                        clearTimeout(this.timer);
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
                            this.event = data.event;
							this.teams = data.results.teams;
							this.judges = data.results.judges;
							this.technicals = data.results.technicals;

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
