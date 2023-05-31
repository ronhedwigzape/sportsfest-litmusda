<template>
	<v-app>
		<!-- loader -->
		<div v-if="loading" class="d-flex justify-center align-center" style="height: 100vh;">
			<v-sheet width="240">
				<v-progress-linear
					indeterminate
					rounded
					height="6"
				/>
			</v-sheet>
		</div>

		<!-- router view -->
		<router-view v-else @startPing="startPing"/>
	</v-app>
</template>

<script>
import $ from 'jquery';

export default {
	name: 'App',
	data() {
		return {
			loading: true,
			pingTimer : null
		}
	},
	methods: {
		handleWindowResize() {
			this.$store.commit('setWindowHeight', window.innerHeight);

			// check sidebar
			if (this.$vuetify.display.mdAndDown)
				this.$store.state.app.sideNav = false;
		},
		startPing() {
			this.stopPing();
			this.ping();
		},
		stopPing() {
			if (this.pingTimer)
				clearTimeout(this.pingTimer);
		},
		ping() {
			const user = this.$store.getters['auth/getUser'];
			if (!user)
				this.stopPing();
			else if (user.userType !== 'judge' && user.userType !== 'technical')
				this.stopPing();
			else {
				$.ajax({
					url: `${this.$store.getters.appURL}/${user.userType}.php`,
					type: 'POST',
					xhrFields: {
						withCredentials: true
					},
					data: {
						ping: true,
                        eventSlug: this.$route.params.eventSlug ? this.$route.params.eventSlug : null
					},
					success: (data) => {
						data = JSON.parse(data);
						if (data.pinged) {
							// set calling property of user
							if (data.calling != null)
								this.$store.state['auth'].user.calling = data.calling;

                            // store current timestamp
                            this.$store.commit('auth/setUserPingTimestamp', Date.now());

							// repeat after m milliseconds
							const m = 5000;
							this.pingTimer = setTimeout(() => {
								this.ping();
							}, m);
						}
					}
				});
			}
		}
	},
	created() {
		// check for authenticated user
		$.ajax({
			url: `${this.$store.getters.appURL}/index.php`,
			type: 'GET',
			xhrFields: {
				withCredentials: true
			},
			data: {
				getUser: ''
			},
			success: (data) => {
				data = JSON.parse(data);
				if (data.user) {
					this.$store.commit('auth/setUser', data.user);
                    this.$store.commit('auth/setUserPingTimestamp', Date.now());
                    this.$store.commit('auth/setUserCurrentTimestamp', Date.now());
					this.$router.replace({
						name: data.user.userType
					});
				}
				setTimeout(() => {
					this.loading = false;
				}, 1000);
			},
			error: (error) => {
				alert(`ERROR ${error.status}: ${error.statusText}`);
				this.loading = false;
			},
		});
	},
	mounted() {
		window.addEventListener('resize', this.handleWindowResize);
		this.handleWindowResize();

		// manage sidebar
		if (this.$vuetify.display.lgAndUp)
			this.$store.state.app.sideNav = true;
	},
	destroyed() {
		window.removeEventListener('resize', this.handleWindowResize);
	}
}
</script>

<style scoped>
</style>