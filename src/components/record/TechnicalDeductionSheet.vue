<template>
	<v-table>
		<thead>
			<tr>
				<th colspan="8" class="text-center">
					Event_Name Criteria
				</th>
			</tr>
			<tr>
				<th class="text-center">
					Team Name
				</th>
				<th class="text-center">
					Deduction
				</th>

			</tr>
		</thead>
		<tbody>
			<tr class="">
				<td class="text-center">
					Team 1
				</td>
				<td class="text-center">
					<v-text-field>

					</v-text-field>
				</td>

			</tr>
			<tr class="">
				<td class="text-center">
					Team 2
				</td>
				<td class="text-center">
					<v-text-field>

					</v-text-field>
				</td>

			</tr>
			<tr class="">
				<td class="text-center">
					Team 3
				</td>
				<td class="text-center">
					<v-text-field>

					</v-text-field>
				</td>
			</tr>
		</tbody>
	</v-table>

</template>

<script>
// import $ from 'jquery';

export default {
	name: "TechnicalDeductionSheet",
	data() {
		return {
			number: 5,
			redTeamImg: '',
			greenTeamImg: '',
			blueTeamImg: ''
		}
	},
	// created() {
	// 	// $.ajax({
	// 	// 	url: `${this.$store.getters.appURL}/judge.php`,
	// 	// 	type: 'GET',
	// 	// 	xhrFields: {
	// 	// 		withCredentials: true
	// 	// 	},
	// 	// 	data: {},
	// 	// 	success: (data) => {
	// 	// 		data = JSON.parse(data);
	// 	// 		console.log(data)
	// 	// 	},
	// 	// 	error: (error) => {
	// 	// 		alert(`ERROR ${error.status}: ${error.statusText}`);
	// 	// 	},
	// 	// });
	// },
	// updated() {
	//
	// }

}
</script>

<style scoped>

</style>