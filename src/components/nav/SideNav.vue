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
import $ from "jquery";
import eventNav from "./EventNav.vue";

export default {
	name: "SideNav",
	components: {
		eventNav
	},
	data() {
		return {
			dialog: false,
			signedOut: false,
			avatar: `${import.meta.env.BASE_URL}no-avatar.jpg`,
			appName: `${this.$store.getters.appName}`,
			judgeName: 'JUDGE'
		}
	},
	methods: {
		signOut() {
			$.ajax({
				url: `${this.$store.getters.appURL}/index.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					signOut: this.signedOut
				},
				success: (data) => {
					data = JSON.parse(data);
					this.$store.commit('auth/setUser', data.user = null);
					this.$router.push('/');
				},
				error: (error) => {
					alert(`ERROR ${error.status}: ${error.statusText}`);
				},
			})
		}
	}
}
</script>

<style scoped>

</style>