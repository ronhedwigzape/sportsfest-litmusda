<template>
    <v-layout>
        <v-app-bar
            color="primary"
            prominent
        >
            <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>LitMusDa</v-toolbar-title>

            <v-btn variant="text" icon="mdi-dots-vertical" type="button"></v-btn>
        </v-app-bar>
        <v-navigation-drawer>
            <v-list>
                <v-list-item>
                    <div class="v-navigator-drawer_content">
                        <div
                            class="v-sheet v-theme--light d-flex flex-column justify-center align-center align-center my-5 mx-3">
                            <div class="v-avatar v-theme v-avatar--dencitydefault v-avatar--variant-flat mb-3"
                                 style="width: 120px; height: 120px;">
                                <div class="v-responsive v-img">
                                    <div class="v-responsive_sizer" style="padding-bottom: 100%;" id="app"></div>
                                    <v-img src="/src/assets/no-avatar.jpg"></v-img>
                                </div>
                                <span class="v-avatar_underlay"></span>
                            </div>
                            <div class="text-center">
                                <p class="text-h6 text-uppercase">
                                    Judge 01
                                </p>
                            </div>
                        </div>
                    </div>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main style="min-height: 300px;">
            <v-table>
                <thead>
                <tr>
                    <th colspan="2" class="py-2">
                        <div class="text-h5 text-center text-primary text-uppercase font-weight-bold">Oration</div>
                    </th>
                    <th class="py-2 text-center text-primary" style="width:13%">Delivery <br> 40%</th>
                    <th class="py-2 text-center text-primary" style="width:13%">Craftmanship <br> 30%</th>
                    <th class="py-2 text-center text-primary" style="width:13%">Personality <br> 20%</th>
                    <th class="py-2 text-center text-primary" style="width:13%">Overall Impact <br> 10%</th>
                    <th class="py-2 text-center text-primary" style="width:13%">Total</th>
                    <th class="py-2 text-center text-primary" style="width:13%">Rank</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="py-2 text-center" style="width:13%"></td>
                </tr>
                </tbody>
            </v-table>
        </v-main>
    </v-layout>
</template>


<script>
    export default {
        name: 'Judge'
    }
</script>


<style scoped>

</style>