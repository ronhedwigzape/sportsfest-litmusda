<template>
    <v-layout style="height: 100vh;">

		<side-nav />
		<top-nav />
		<v-main style="height: 100vh;">
			<judge-score-sheet />
		</v-main>

    </v-layout>
</template>


<script>
	import topNav from "../components/nav/TopNav.vue";
	import sideNav from "../components/nav/SideNav.vue";
	import judgeScoreSheet from "../components/ratings/JudgeScoreSheet.vue";

    export default {
        name: 'Judge',
        components: {
			topNav,
			sideNav,
			judgeScoreSheet
        },
        data() {
            return {

            }
        },
    }
</script>


<style scoped>

</style>