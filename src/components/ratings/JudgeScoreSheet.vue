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
				Criteria#1 40%
			</th>
			<th class="text-center">
				Criteria#2 30%
			</th>
			<th class="text-center">
				Criteria#3 20%
			</th>
			<th class="text-center">
				Criteria#4 10%
			</th>
			<th class="text-center">
				Total
			</th>
			<th class="text-center">
				Average
			</th>
			<th class="text-center">
				Rank
			</th>
		</tr>

		</thead>
		<tbody>
		<tr class="">
			<td class="text-center">
				Team 1
			</td>
			<td class="text-center">
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
		</tr>
		<tr class="">
			<td class="text-center">
				Team 1
			</td>
			<td class="text-center">
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
		</tr>
		<tr class="">
			<td class="text-center">
				Team 1
			</td>
			<td class="text-center">
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
			<td class="text-center" >
				{{ number }}
			</td>
		</tr>

		</tbody>
	</v-table>

</template>

<script>
// import $ from 'jquery';

export default {
	name: "JudgeScoreSheet",
	data() {
		return {
			number: 5,
			redTeamImg: '',
			greenTeamImg: '',
			blueTeamImg: ''
		}
	},
	// mounted() {
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