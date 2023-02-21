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
		<tr>

		</tr>
		<tr class="">
			<td class="text-center">
				Team 1
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
		<tr class="">
			<td class="text-center">
				Team 2
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
		<tr class="">
			<td class="text-center">
				Team 3
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

		</tbody>
	</v-table>

</template>

<script>
export default {
	name: "JudgeScoreSheet",
	data() {
		return {
			number: 55,
			redTeamImg: '',
			greenTeamImg: '',
			blueTeamImg: ''
		}
	}
}
</script>

<style scoped>

</style>