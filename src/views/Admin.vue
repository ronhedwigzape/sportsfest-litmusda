<template>
    <v-layout style="height: 100vh;">
		<side-nav />
		<top-nav />
		<v-main  style="min-height: 300px;">
			<admin-results />
		</v-main>
    </v-layout>
</template>
<script>
	import topNav from "../components/nav/TopNav.vue";
	import sideNav from "../components/nav/SideNav.vue";
	import adminResults from "../components/ratings/AdminResults.vue";

    export default {
        name: 'Admin',
		components: {
			topNav,
			sideNav,
			adminResults
		},
        data() {
            return {

            }
        },
        methods: {

		}
    }
</script>

<style scoped>

</style>
