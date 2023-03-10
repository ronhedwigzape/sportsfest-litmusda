<template>
	<top-nav />

	<side-nav />

	<!--	Technical Deduction Sheet	-->
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
							style="width: 1rem;"
							class="text-uppercase text-center text-grey-darken-4 text-h4 py-3"
						>
							Deduction
						</th>
					</tr>
				</thead>
				<tbody>
					<tr
						v-for="(team, teamIndex) in teams"
						:key="team.id"
						:class="{ 'bg-grey-lighten-4': coordinates.y == teamIndex }"
					>
						<td class="text-uppercase text-center text-grey-darken-4 font-weight-bold text-h4" style="width: 0.2rem;">
							{{ teamIndex + 1 }}
						</td>
						<td class="text-uppercase text-center font-weight-bold" style="width: 1rem;">
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
								:loading="deductions[`loading_${team.id}`]"
								v-model.number="deductions[`${event.slug}_${team.id}`].value"
								@change="saveDeduction(deductions[`${event.slug}_${team.id}`], team.id)"
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
							   :disabled="deductions[`${event.slug}_${team.id}`].is_locked"
								:id="`input_${teamIndex}`"
								@keydown.down.prevent="moveDown(teamIndex)"
								@keydown.enter="moveDown(teamIndex)"
								@keydown.up.prevent="moveUp(teamIndex)"
								@focus.passive="updateCoordinates(teamIndex)"
							/>
						</td>
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
							@click="submitDialog = true"
							:disabled="submitDeduction['is_locked']"
							block
							flat
						>
							<p style="font-size: 1.2rem;">submit deductions</p>
						</v-btn>
						<v-dialog
							v-model="submitDialog"
							persistent
							max-width="400"
						>
							<v-card>
								<v-card-title class="bg-black">
									<v-icon>mdi-information</v-icon> Submit Deductions
								</v-card-title>
								<v-card-text>
									Please confirm that you wish to finalize the deductions for <b>{{ event.title }}</b>. This action cannot be undone.
								</v-card-text>
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn prepend-icon="mdi-close" class="text-red-darken-1" @click="submitDialog = false">Close</v-btn>
									<v-btn class="text-green-darken-1" :loading="submitLoading" @click="submitDeductions">Submit</v-btn>
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
			event: null,
			timer: null,
			teams: [],
			deductions: {},
			submitDeduction: {},
			coordinates: {
				x: -1,
				y: -1
			}
		}
	},
	computed: {
		scoreSheetHeight() {
			return this.$store.getters.windowHeight - 64;
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
						this.deductions = data.deductions;
						this.event = data.event;
						this.teams = data.teams;
						this.submitDeduction = {};
						console.log(data)

						for (let i = 0; i < this.teams.length; i++) {
							const team = this.teams[i];
							let deduction = this.deductions[`${this.event.slug}_${team.id}`];
							this.deductions[`loading_${team.id}`] = false;
							this.submitDeduction['is_locked'] = deduction.is_locked;
						}
						
					},
					error: (error) => {
						alert(`ERROR ${error.status}: ${error.statusText}`);
					},
				});
			}
		},
		saveDeduction(deduction, teamId) {
			this.deductions[`loading_${teamId}`] = true

			if (deduction.value < 0 || deduction.value === '') {
				deduction.value = 0;
			}
			else if (deduction.value > 100) {
				deduction.value = 100;
			}
			$.ajax({
				url: `${this.$store.getters.appURL}/${this.$store.getters['auth/getUser'].userType}.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					deduction: deduction
				},
				success: (data, textStatus, jqXHR) => {
					if(this.deductions[`loading_${teamId}`]) {
						setTimeout(() => {
							this.deductions[`loading_${teamId}`] = false;
						}, 1000);
					}
					console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				},
			});
		},
		submitDeductions() {
			this.submitLoading = true;

			// Deductions are locked.
			let deductions = [];
			for (let i = 0; i < this.teams.length; i++) {
				const team = this.teams[i];
					const deduction = this.deductions[`${this.event.slug}_${team.id}`] 
					deduction.is_locked = true;
					deductions.push(deduction);
			}

			// Calls request to submit deductions after deduction is locked.
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

					if(this.submitLoading) {
						setTimeout(() => {
							this.submitLoading = false
							this.submitDialog = false;
						}, 600);
					}

					this.submitDeduction['is_locked'] = true;
					console.log(`${jqXHR.status}: ${jqXHR.statusText}`);
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				}
			})
		},
		move (y, focus = true) {
			// Move to input
			const nextInput = document.querySelector(`#input_${y}`);
			if(nextInput) {
				if(focus)
					nextInput.focus();
				if(Number(nextInput.value) <= 0)
					nextInput.select();
			}
		},
		moveDown (y) {
			// Move to input below
			y += 1;
			if(y < this.teams.length)
				this.move(y);
		},
		moveUp (y)  {
			// Move to input above
			y -= 1;
			if(y >= 0)
				this.move(y);
		},
		updateCoordinates (y) {
			this.coordinates.y = y;
			this.move(y, false);
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

#submit {
	background: linear-gradient(-45deg, #e73c7e, #23a6d5, #23d5ab, #e8af45);
	background-size: 200% 200%;

	text-fill-color: transparent;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;

	animation: shine 10s ease infinite;
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
