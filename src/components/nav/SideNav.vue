<template>
	<v-navigation-drawer
		class="bg-deep-purple-darken-2"
		theme="dark"
	>
		<v-col align="center" class="text-h4 mt-2 font-weight-bold">
			Events
		</v-col>

		<v-divider />

		<!--	Events	-->
		<event-nav/>

		<template v-slot:append>
			<div class="ma-2 mb-5">
				<v-row justify="center">
					<v-dialog
						v-model="dialog"
						width="auto"
					>
						<template v-slot:activator="{ props }">
							<v-btn
								class="text-white bg-red-darken-3"
								v-bind="props"
							>
								log out
							</v-btn>
						</template>
						<v-card class="pa-3 bg-white">
							<v-card-title class="text-h5 ">
								Confirm Logout
							</v-card-title>
							<v-card-text>Are you sure you want to log out?</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn
									color="red-darken-1"
									variant="text"
									@click="dialog = false"
								>
									cancel
								</v-btn>
								<v-btn
									color="green-darken-1"
									variant="text"
									@click="signOut"
								>
									ok
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-dialog>
				</v-row>
			</div>
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