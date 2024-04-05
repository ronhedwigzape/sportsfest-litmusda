<template>
    <div class="background-image">
        <v-container class="d-flex align-center justify-center fill-height">
            <v-row justify="center" align="center">
                <v-col xs="12" sm="10" md="8" lg="6">
                    <v-card id="card-login" class="mx-10 my-3 pa-1 elevation-10">
                        <v-card-title>
                            <h4 class="text-h4 font-weight-bold text-center text-white">{{ $store.state.app.title }}</h4>
                        </v-card-title>
                        <v-form
                            class="bg-white rounded"
                            @submit.prevent="handleSubmit"
                            :class="$vuetify.display.mdAndDown ? 'ps-6 pe-6 pt-6 pb-3' : 'ps-12 pe-12 pt-12 pb-6'"
                        >
                            <v-text-field
                                v-model="username"
                                :rules="[rules.required]"
                                label="Username"
                                variant="outlined"
                                prepend-inner-icon="mdi-account"
                                required
                                autofocus
                            />
                            <v-text-field
                                v-model="password"
                                :append-inner-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                variant="outlined"
                                label="Password"
                                counter
                                prepend-inner-icon="mdi-lock"
                                required
                                @click:appendInner="show1 = !show1"
                            />
                            <v-btn
                                class="mt-4 login-btn text-white"
                                variant="outlined"
                                type="submit"
                                size="large"
                                :loading="loading"
                                :disabled="loading"
                                block
                            >
                                Log in
                            </v-btn>
                            <div class="d-flex align-center justify-center text-disabled pt-3 pt-lg-6">
                                &copy; {{ $store.state.app.org }}
                            </div>
                        </v-form>

                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>


<script>
import $ from 'jquery';

export default {
	name: 'Login',
	data() {
		return {
			loading: false,
			show1: false,
			show2: true,
			username: '',
			password: '',
			img: `${import.meta.env.BASE_URL}foundation-logo.png`,
			rules: {
				required: value => !!value || 'Required.',
			},
		}
	},
	methods: {
		async handleSubmit() {
			this.loading = true;
			await $.ajax({
				url: `${this.$store.getters.appURL}/index.php`,
				type: 'POST',
				xhrFields: {
					withCredentials: true
				},
				data: {
					username: this.username,
					password: this.password,
				},
				success: (data) => {
					if(this.loading) {
						setTimeout(() => {
							this.loading = false;
						}, 1000);
					}
					data = JSON.parse(data);
					this.$store.commit('auth/setUser', data.user);
                    this.$store.commit('auth/setUserPingTimestamp', Date.now());
                    this.$store.commit('auth/setUserCurrentTimestamp', Date.now());
					this.$router.replace({name: data.user.userType});
				},
				error: (error) => {
					if(this.loading) {
						setTimeout(() => {
							this.loading = false;
							alert(`ERROR ${error.status}: ${error.statusText}`);
						}, 500);
					}
				},
			});
		},
	}
}
</script>


<style scoped>
.background-image {
    height: 100vh;
    background-image: url("/bg-img.png");
    background-size: cover;
}

#card-login {
	--borderWidth: 8px;
	position: relative;
	border-radius: var(--borderWidth);
}

#card-login:after {
	content: '';
	position: absolute;
	top: calc(-1 * var(--borderWidth));
	left: calc(-1 * var(--borderWidth));
	height: calc(100% + var(--borderWidth) * 2);
	width: calc(100% + var(--borderWidth) * 2);
	background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
	border-radius: calc(2 * var(--borderWidth));
	z-index: -1;
	animation: animatedGradient 3s ease alternate infinite;
	background-size: 300% 300%;
}

.login-btn {
	background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
	animation: animatedGradient 3s ease alternate infinite;
	background-size: 300% 300%;
}

@keyframes animatedGradient {
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
