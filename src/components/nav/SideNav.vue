<template>
	<v-navigation-drawer
		class="bg-deep-purple-darken-2"
		theme="dark"
	>


		<v-divider />

		<!--	Events	-->
		<event-nav/>

		<template v-slot:append>

		</template>
	</v-navigation-drawer>
</template>

<script>
import eventNav from "./EventNav.vue";

export default {
	name: "SideNav",
	components: {
		eventNav
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