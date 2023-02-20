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
				Complexity 40%
			</th>
			<th class="text-center">
				Complexity 30%
			</th>
			<th class="text-center">
				Complexity 20%
			</th>
			<th class="text-center">
				Complexity 10%
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
		<tr>

		</tr>
		<tr class="">
			<td class="text-center">
				Fearless Dragons
			</td>
			<td class="text-center">
				<v-text-field
					variant="outlined"
					type="number"
					class="ma-0 text-center"
					single-line
				>
					{{ number }}
				</v-text-field>
			</td>
			<td class="text-center" >
				<v-text-field
					variant="outlined"
					type="number"
					class="ma-0 text-center"
					single-line
				>
					{{ number }}
				</v-text-field>
			</td>
			<td class="text-center" >
				<v-text-field
					variant="outlined"
					type="number"
					class="ma-0 text-center"
					single-line
				>
					{{ number }}
				</v-text-field>
			</td>
			<td class="text-center" >
				<v-text-field
					variant="outlined"
					type="number"
					class="ma-0 text-center"
					single-line
				>
					{{ number }}
				</v-text-field>
			</td>
			<td class="text-center" >
				<v-text-field
					variant="outlined"
					type="number"
					class="ma-0 text-center"
					single-line
				>
					{{ number }}
				</v-text-field>
			</td>

		</tr>
		<tr>
			<td class="text-center pa-3">

				Furious Elves
			</td>
			<td class="text-center d-flex align-content-center" >
				<v-text-field
					variant="outlined"
					type="number"
					class="text-center"
				>
					{{ number }}
				</v-text-field>
			</td>
		</tr>
		<tr>
			<td class="text-center pa-3">
				Wise Wizards
			</td>
			<td class="text-center d-flex align-content-center" >
				<v-text-field
					type="number"
					variant="outlined"
				>
					{{ number }}
				</v-text-field>
			</td>
		</tr>

		</tbody>
	</v-table>
</template>

<script>
export default {
	name: "JudgeScoreSheet",
	data() {
		return {
			number: 55
		}
	}
}
</script>

<style scoped>

</style>