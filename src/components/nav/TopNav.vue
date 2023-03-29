<template>
	<v-app-bar color="black">
		<v-app-bar-nav-icon @click.stop="$store.state.app.sideNav = !$store.state.app.sideNav" />
		<h3 v-if="$vuetify.display.mdAndUp" id="topnav" class="ms-5">{{ $store.getters.appName }}</h3>
		<h4 v-else-if="$vuetify.display.mdAndDown" id="topnav" class="ms-5">{{ $store.getters.appName }}</h4>
		<v-spacer />
		<div v-if="$store.getters['auth/getUser'] !== null">
			<v-spacer />
			<v-chip
				class="ma-2 me-4"
				:color="$store.getters['auth/getUser'] !== null ?
					$store.getters['auth/getUser'].userType === 'admin' ? 'amber' :
					$store.getters['auth/getUser'].userType === 'judge' ? 'green-lighten-2' :
					'red-lighten-2' : ''"
			>
				<v-icon start icon="mdi-account-circle" />
				{{ $store.getters['auth/getUser'].name }}
			</v-chip>

			<v-avatar
				size="35"
				v-if="$vuetify.display.mdAndUp"
			>
				<v-img
					:src="`${$store.getters.appURL}/crud/uploads/${$store.getters['auth/getUser'].avatar}`"
				/>
			</v-avatar>
		</div>

		<!--	Sign out	-->
		<v-dialog
			v-model="dialog"
			max-width="400"
		>
			<template v-slot:activator="{ props }">
				<v-menu>
					<template
						v-slot:activator="{ props }"
						class="position-fixed"
						style="right: 0;"
					>
						<v-btn class="ma-3" icon="mdi-dots-vertical" v-bind="props" />
					</template>
					<v-list>
						<v-list-item
							v-bind="props"
							class="text-red-darken-3 text-uppercase"
							style="font-size: 1rem;"
							variant="text"
						><v-icon icon="mdi-logout"/>
							Logout
						</v-list-item>
					</v-list>
				</v-menu>
			</template>
			<v-card class="bg-dark">
				<v-card-title class="bg-black">
				<v-icon>mdi-alert-circle</v-icon> Confirm Logout
				</v-card-title>
				<v-card-text>Are you sure you want to log out?</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn
						color="green-darken-1"
						variant="text"
						@click="dialog = false"
					>
						Go Back
					</v-btn>
					<v-btn
						color="red-darken-1"
						variant="text"
						@click="signOut"
					>
						Log Out
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
			signedOut: false,
			group: null
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
		},
	},
	watch: {
		group () {
			this.$store.state.app.sideNav = false;
		},
	},
}
</script>

<style scoped>
#topnav {
	background: linear-gradient(-45deg, #e73c7e, #23a6d5, #23d5ab, #e8af45);
	background-size: 200% 200%;

	text-fill-color: transparent;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;

	animation: shine 10s ease infinite;
}
@keyframes shine {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}
</style>