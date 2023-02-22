<template>
	<v-table class="background-image">
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
				<v-avatar size="36">
					<img src="/blue.png" alt="blue" style="width: 100%; height: 100%;">
				</v-avatar>
				Wise Wizards
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
				<v-avatar size="36">
					<img src="/red.png" alt="red" style="width: 100%; height: 100%;">
				</v-avatar>
				Fearless Dragons
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
				<v-avatar size="36">
					<img src="/green.png" alt="green" style="width: 100%; height: 100%;">
				</v-avatar>
				Furious Elves
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
		<tfoot>
		<tr></tr>
		</tfoot>
	</v-table>
</template>
<script>
// import $ from 'jquery';

export default {
	name: "AdminResults",
	data() {
		return {
			number: '5',
			redTeamImg: '',
			greenTeamImg: '',
			blueTeamImg: ''
		}
	},
	// created() {
	// 	// $.ajax({
	// 	// 	url: `${this.$store.getters.appURL}/admin.php`,
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
	.background-image {
    background-image: url('/bg-img.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-position: center center;
    height: 100vh;
    width: 100%;
	}

	@media (max-width: 768px) {
		.background-image {
			background-size: contain;
		}
	}

	.transparent {
		background-color: transparent;
	}
</style>