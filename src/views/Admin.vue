<template>
    <side-nav />
    <top-nav />
    <v-main>
        <!-- results -->
        <v-container v-if="event" fluid>
			<v-table v-if="$route.params.eventSlug" density="comfortable" :bordered="true" hover>
				<thead>
					<tr>
						<th colspan="20" class="text-h5 text-uppercase text-center font-weight-bold">
							{{ event.title }}
						</th>
					</tr>
					<tr>
						<td colspan="2" class="text-center">Teams</td>
						<td>Deduct</td>
						<template v-for="judge in judges" :key="judge.id">
							<td>Judge {{ judge.id }}</td>
							<td>Judge {{ judge.id}} Rank</td>
						</template>
						<td>Total</td>
						<td>Average</td>
						<td>Total Rank</td>
						<td>Initial Rank</td>
						<td>Final Rank</td>
					</tr>
				</thead>
				<tbody>
				<tr v-for="team in teams">
					<td>{{ team.id }}</td>
					<td>{{ team.name }}</td>
					<td>{{ team.deductions.total }}</td>
					<template v-for="judge in judges" :key="judge.id">
						<td>
							{{ team.ratings.inputs[`judge_${judge.id}`].final.original }}
						</td>
						<td>
							{{ team.ratings.inputs[`judge_${judge.id}`].rank.fractional }}
						</td>
					</template>
					<td>{{ team.ratings.total }}</td>
					<td>{{ team.ratings.average }}</td>
					<td>{{ team.rank.total.fractional }}</td>
					<td>{{ team.rank.initial.fractional }}</td>
					<td>{{ team.rank.final.fractional }}</td>
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
        </v-container>

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

</style>
