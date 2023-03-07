<template>
    <v-layout style="height: 100vh;">
       <side-nav />
		<top-nav />
		<v-main v-if="$store.getters['auth/getUser'] !== null">
			<v-table
				v-if="$route.params.eventSlug && event"
				density="comfortable"
				fix-header
				hover
				:height="680"
			>
				<thead>
					<tr>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">#</th>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
							{{ event.title }} Teams
						</th>
						<th class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
							Deductions
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(team, teamIndex) in teams" :key="team.id">
						<td class="text-uppercase text-center font-weight-bold text-deep-purple-darken-2">
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
						<td>
							<v-text-field
								type="number"
								variant="outlined"
								align="center"
								justify="center"
								hide-details
								single-line
								:min="0"
								:max="100"
								:loading="loading"
								v-model.number="deductions[`${event.slug}_${team.id}`].value"
								@change="saveDeduction(deductions[`${event.slug}_${team.id}`])"
								:class="{
									'text-error font-weight-bold': (
										deductions[`${event.slug}_${team.id}`].value < 0 ||
										deductions[`${event.slug}_${team.id}`].value > 100
									),
									'text-grey-darken-2': deductions[`${event.slug}_${team.id}`].value === 0
								}"
								:error="(
									  deductions[`${event.slug}_${team.id}`].value.toString().trim() === ''
								   || deductions[`${event.slug}_${team.id}`].value < 0
								   || deductions[`${event.slug}_${team.id}`].value > 100
							   )"
							/>
						</td>
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
									Please confirm that you wish to finalize the deductions for {{ event.title }}. This action cannot be undone.
								</v-card-text>
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn color="primary" @click="dialog = false">Close</v-btn>
									<v-btn color="primary" @click="">Submit</v-btn>
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
			deductions: {}
		}
	},
	watch: {
		$route: {
			immediate: true,
			handler(to, from) {
				this.event = null;
				if(this.timer)
					clearTimeout(this.timer)
				this.fetchDeductionSheet();
			}
		}
	},
	methods: {
		fetchDeductionSheet() {
			if (this.$route.params.eventSlug) {
				$.ajax({
					url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
					type: 'GET',
					xhrFields: {
						withCredentials: true
					},
					data: {
						getDeductionSheet: this.$route.params.eventSlug
					},
					success: (data) => {
						data = JSON.parse(data);
						console.log(data)
						this.deductions = data.deductions;
						this.event = data.event;
						this.teams = data.teams;
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			}
		},
		saveDeduction(deductions) {
			this.loading = true

			if (deductions.value < 0 || deductions.value === '') {
				deductions.value = 0;
			}
			else if (deductions.value > 100) {
				deductions.value = 100;
			}
			$.ajax({
				url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					deductions
				},
				success: (data, textStatus, jqXHR) => {
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
