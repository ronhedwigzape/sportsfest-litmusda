<template>
	<v-app-bar :title="appName" color="deep-purple-darken-3">
		<h3 class="me-5">{{ judgeName }}</h3>
		<v-chip
			class="ma-2"
			color="green"
		>
			<v-icon start icon="mdi-account-circle"></v-icon>
			JUDGE
		</v-chip>
		<div class="text-right">
			<v-menu transition="scroll-y-transition">
				<template v-slot:activator="{ props }">
					<v-btn
						variant="text"
						class="ma-2"
						v-bind="props"
					>
					<v-avatar
						class="me-5"
						size="35">
						<v-img :src="avatar"/>
					</v-avatar>
					</v-btn>
				</template>
				<v-list>
					<v-list-item link @click="dialog = true">
						<v-list-item-title v-text="'Sign Out'"></v-list-item-title>
					</v-list-item>
				</v-list>
				<v-dialog
					v-model="dialog"
					width="auto"
				>
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
			</v-menu>
		</div>
	</v-app-bar>
</template>

<script>
import $ from "jquery";
import eventNav from "./EventNav.vue";

export default {
	name: "TopNav",
	data() {
		return {
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