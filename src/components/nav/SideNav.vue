<template>
	<v-navigation-drawer
		class="bg-deep-purple-darken-2"
		theme="dark"
	>
		<!--	Events	-->
		<event-nav/>

		<template v-slot:append>
			<v-col class="text-center mt-4" cols="12">
				&copy; <strong>ACLC 2023</strong>
			</v-col>
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