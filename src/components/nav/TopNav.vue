<template>
	<v-app-bar :title="appName" color="deep-purple-darken-3">
		<h3 class="me-5">{{ name }}</h3>
		<v-chip
			class="ma-2"
			color="amber"
			v-if="$store.getters['auth/getUser'] !== null"
		>
			<v-icon start icon="mdi-account-circle"></v-icon>
			{{ $store.getters['auth/getUser'].name }}
		</v-chip>
		<v-avatar
			size="35">
			<v-img :src="avatar"/>
		</v-avatar>

		<!--	Sign out	-->
		<v-dialog
			v-model="dialog"
			width="auto"
		>
			<template v-slot:activator="{ props }">
				<v-menu>
					<template v-slot:activator="{ props }">
						<v-btn class="ma-2" icon="mdi-dots-vertical" v-bind="props"></v-btn>
					</template>
					<v-list>
						<v-list-item
							v-bind="props"
							class="text-red-darken-3 text-uppercase"
							style="font-size: 1rem;"
							variant="text"
							><v-icon icon="mdi-logout"/>Logout</v-list-item>
					</v-list>
				</v-menu>
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
	</v-app-bar>
</template>

<script>
import $ from "jquery";

export default {
	name: "TopNav",
	data() {
		return {
			dialog: false,
			avatar: `${import.meta.env.BASE_URL}no-avatar.jpg`,
			appName: `${this.$store.getters.appName}`,
			name: '',
			signedOut: false
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
	},
	computed: {

	},
}
</script>

<style scoped>

</style>