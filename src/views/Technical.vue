<template>
    <v-layout style="height: 100vh;">
       <side-nav />
		<top-nav />
		<v-main  style="min-height: 300px;">

		</v-main>
    </v-layout>
</template>
<script>
import topNav from "../components/nav/TopNav.vue";
import sideNav from "../components/nav/SideNav.vue";

export default {
	name: 'Judge',
	components: {
		topNav,
		sideNav
	},
	data() {
		return {

		}
	},

}
</script>

<style scoped>

</style>
