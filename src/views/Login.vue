<template>
    <div class="background-image">
    <v-container class="d-flex align-center justify-center fill-height">
        <v-row justify="center" align="center">
            <v-col xs="12" sm="10" md="8" lg="6">
                <v-img height="250" :src="img">
                    <template v-slot:placeholder>
                        <v-row
                            class="fill-height ma-0"
                            align="center"
                            justify="center"
                        >
                            <v-progress-circular
                                indeterminate
                                color="grey-lighten-5"
                            ></v-progress-circular>
                        </v-row>
                    </template>
                </v-img>

                <v-card class="mx-10 my-3 pa-10 elevation-10">
                    <v-form @submit.prevent="handleSubmit">
                        <v-text-field
                            v-model="username"
                            :rules="[rules.required]"
                            label="Username"
                            variant="outlined"
                            required
                            autofocus
                        ></v-text-field>
                        <v-text-field
                            v-model="password"
                            :append-inner-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[rules.required]"
                            :type="show1 ? 'text' : 'password'"
                            name="input-10-1"
                            variant="outlined"
                            label="Password"
                            counter
                            required
                            @click:appendInner="show1 = !show1"
                        ></v-text-field>
                        <v-code class="transparent bg-white" align="right">
                            <v-btn
                                class="mt-4 bg-amber-darken-1"
                                type="submit"
								:loading="loading"
								:disabled="loading"
                            >
                                log in
                            </v-btn>
                        </v-code>
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
    background: url('/bg-img.png') no-repeat center fixed !important;
    height: 100vh;
}

</style>
