<template>
    <v-layout style="height: 100vh;">
       <side-nav />
		<top-nav />
		<v-main  style="min-height: 300px;">
			<technical-deduction-sheet />
		</v-main>
    </v-layout>
</template>
<script>
import topNav from "../components/nav/TopNav.vue";
import sideNav from "../components/nav/SideNav.vue";
import technicalDeductionSheet from "../components/record/TechnicalDeductionSheet.vue";

export default {
	name: 'Judge',
	components: {
		topNav,
		sideNav,
		technicalDeductionSheet
	},
	data() {
		return {

		}
	},

}
</script>

<style scoped>

</style>
