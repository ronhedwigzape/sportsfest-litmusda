<template>
    <div class="text-left">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn 
                    variant="button"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Cheer dance
                </v-btn>
            </template>
        </v-menu>
    </div>
    <div class="text-left">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="ma-2"
                    v-bind="props"
                    prepend-icon="mdi-vuetify"
                >
                    Literary
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'ORATION IN ENGLISH'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'BALAGTASAN'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'TIGSIK'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'JAZZ CHANT'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-left">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
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
    <div class="text-left">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
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