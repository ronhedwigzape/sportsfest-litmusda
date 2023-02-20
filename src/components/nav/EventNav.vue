<template>
    <div class="text-center">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="outlined"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Cheer dance
                </v-btn>
            </template>
        </v-menu>
    </div>
    <div class="text-center">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="outlined"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Literacy
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="outlined"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Music
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="outlined"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Dance
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'Event_Name'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    export default {
        name: 'EventNav'
    }
</script>

<style scoped>

</style>