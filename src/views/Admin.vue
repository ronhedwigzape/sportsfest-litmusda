<template>
    <v-layout style="height: 100vh;">
        <v-navigation-drawer
            class="bg-deep-purple-darken-2"
            theme="dark"
        >
            <v-col align="center">
                <v-avatar
                    size="150">
                    <v-img :src="avatar"/>
                </v-avatar>

                <h1 class="mt-5">
                    ADMIN_NAME
                    <v-chip
                        class="ma-2"
                        color="amber"
                    >
                        <v-icon start icon="mdi-account-circle"></v-icon>
                        SUPER USER
                    </v-chip>
                </h1>
            </v-col>

            <template v-slot:append>
                <div class="ma-2 mb-5">
                    <v-row justify="center">
                        <v-dialog
                            v-model="dialog"
                            width="auto"
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    class="text-red-darken-3 bg-deep-purple-lighten-4"
                                    v-bind="props"
                                >
                                    log out
                                </v-btn>
                            </template>
                            <v-card class="pa-3 bg-white">
                                <v-card-title class="text-h5">
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

        <v-app-bar title="ADMIN" color="deep-purple-darken-3"></v-app-bar>

        <v-main style="min-height: 300px;">

            <v-table fixed-header>
                <thead>
                <tr>
                    <th class="text-left">
                        Team Name
                    </th>
                    <th class="text-left">
                        Scores
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                <tr>
                    <td>Hello World!</td>
                    <td>Hello World!</td>
                </tr>
                </tbody>
            </v-table>
        </v-main>
    </v-layout>
</template>
<script>
    import $ from 'jquery';

    export default {
        name: 'Admin',
        data() {
            return {
                dialog: false,
                signedOut: false,
                avatar: `${import.meta.env.BASE_URL}no-avatar.jpg`
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
        mounted() {

        }
    }
</script>

<style scoped>

</style>
