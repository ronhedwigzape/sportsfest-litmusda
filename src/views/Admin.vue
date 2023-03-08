<template>
    <side-nav />
    <top-nav />
    <v-main>
        <!-- results -->
		<v-table v-if="$route.params.eventSlug && event" density="comfortable" :bordered="true" hover>
			<thead>
				<tr>
					<th colspan="20" class="text-h5 text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
						Results of {{ event.title }}
					</th>
				</tr>
				<tr>
					<td colspan="2" rowspan="2" class="text-center text-uppercase font-weight-bold text-deep-purple-darken-2">{{ event.title}} Teams</td>
					<td rowspan="2" class="text-center text-uppercase font-weight-bold text-red-darken-3">Deduct</td>
					<template v-for="judge in judges" :key="judge.id">
						<td colspan="2" class="text-center text-uppercase font-weight-bold">Judge {{ judge.number }}</td>
					</template>
					<td rowspan="2" class="text-center text-uppercase font-weight-bold text-green-darken-4">Average</td>
					<td rowspan="2" class="text-center text-uppercase font-weight-bold text-blue-darken-4">Total Rank</td>
					<td rowspan="2" class="text-center text-uppercase font-weight-bold text-grey-darken-1">Initial Rank</td>
					<td rowspan="2" class="text-center text-uppercase font-weight-bold">Final Rank</td>
				</tr>
				<tr>
					<template v-for="judge in judges" :key="judge.id">
						<td class="text-center text-green-darken-3">Total</td>
						<td class="text-center font-weight-bold text-blue-darken-2">Rank</td>
					</template>
				</tr>
			</thead>
			<tbody>
			<tr v-for="team in teams" :key="team.id">
				<td class="text-h5 text-center font-weight-bold text-deep-purple-darken-2">{{ team.id }}</td>
				<td class="text-center text-uppercase">{{ team.name }}</td>
				<td class="text-center text-uppercase font-weight-bold text-red-darken-3">{{ team.deductions.total.toFixed(2) }}</td>
				<template v-for="judge in judges" :key="judge.id">
					<td class="text-center text-green-darken-3">
						{{ team.ratings.inputs[`judge_${judge.id}`].final.original.toFixed(2) }}
					</td>
					<td class="text-center font-weight-bold text-blue-darken-2">
						{{ team.ratings.inputs[`judge_${judge.id}`].rank.fractional.toFixed(2) }}
					</td>
				</template>
				<td class="text-center font-weight-bold text-green-darken-4">{{ team.ratings.average.toFixed(2) }}</td>
				<td class="text-center font-weight-bold text-blue-darken-4">{{ team.rank.total.fractional.toFixed(2) }}</td>
				<td class="text-center font-weight-bold text-grey-darken-1">{{ team.rank.initial.fractional.toFixed(2) }}</td>
				<td class="text-center font-weight-bold">{{ team.rank.final.fractional }}</td>
			</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="20">
						<v-row>
							<template v-for="technical in technicals" :key="technical.id">
								<v-col>
									<v-card class="text-center mb-5" flat>
										<v-card-title class="pt-16 font-weight-bold">
											{{ technical.name }}
										</v-card-title>
										<v-card-text class="text-center">
											Technical Judge {{ technical.number }}
										</v-card-text>
									</v-card>
								</v-col>
							</template>

							<template v-for="judge in judges" :key="judge.id">
								<v-col>
									<v-card class="text-center mb-5" flat>
										<v-card-title class="pt-16 font-weight-bold">
											{{ judge.name }}
										</v-card-title>
										<v-card-text class="text-center">
											Judge {{ judge.number }} <template v-if="judge.is_chairman == 1">(Chairman)</template>
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
                color="primary"
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
                results: {},
                timer: null,
				teamIndex: 0,
				teams: [],
				judges: [],
				technicals: []
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

							console.log(this.teams)
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
