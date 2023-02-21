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
                <v-card class="transparent mx-10 my-3 pa-10 elevation-5">
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
                        <v-code class="transparent" align="right">
                            <v-btn
                                class="mt-4 bg-amber-darken-1"
                                type="submit"
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
                        data = JSON.parse(data);
                        this.$store.commit('auth/setUser', data.user);
                        this.$router.replace({name: data.user.userType});
                    },
                    error: (error) => {
                        alert(`ERROR ${error.status}: ${error.statusText}`);
                    },
                });
            },
        }
    }
</script>


<style scoped>
.background-image {
    background-image: url('/bg-img.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-position: center center;
    height: 100vh;
    width: 100%;
}


@media (max-width: 768px) {
    .background-image {
        background-size: contain;
    }
}

.transparent {
    background-color: transparent;
}
</style>
