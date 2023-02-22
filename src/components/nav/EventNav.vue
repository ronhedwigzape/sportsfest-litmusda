<template>
	<v-col align="center">
    <v-avatar size="">
		<img src="/foundation-logo.png" alt="foundation-logo" style="width: 100%; height: 100%;">
	</v-avatar>
		<p class="text-h4 mt-2 font-weight-bold">Events</p>
		<p>Categories</p>
	</v-col>

    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
					class="my-2 mx-1 px-11"
                    v-bind="props"
                    prepend-icon="mdi-dance-ballroom"
                >
                    Cheerdance
                </v-btn>
            </template>
        </v-menu>
    </div>
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template class="text-center" v-slot:activator="{ props }">
                <v-btn 
                    variant="text"
                    class="my-2 mx-2 px-14"
                    v-bind="props"
                    prepend-icon="mdi-book-open-page-variant"
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
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-3 px-16"
                    v-bind="props"
                    prepend-icon="mdi-music"
                >
                    Music
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'VOCAL SOLO (MALE)'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'VOCAL SOLO (FEMALE)'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'VOCAL DUET'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'ACOUSTIC BAND'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text "
                    class="my-2 mx-4 px-15"
                    v-bind="props"
                    prepend-icon="mdi-human-female-dance"
                >
                    Dance
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'JAZZ'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'FOLK DANCE'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'HIPHOP'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-2 px-11"
                    v-bind="props"
                    prepend-icon="mdi-tennis-ball"
                >
                    Ball Games
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'BASKETBALL'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'VOLLEYBALL'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'TABLE TENNIS'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'BADMINTON'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'SEPAK TAKRAW'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-1 px-10"
                    v-bind="props"
                    prepend-icon="mdi-chess-queen"
                >
                    Board Games
                </v-btn>
            </template>
            <v-list>
                <v-list-item link>
                    <v-list-item-title v-text="'CHESS'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'SCIDAMA'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'GAMES OF THE GENERAL'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'WORD FACTORY'"></v-list-item-title>
                </v-list-item>
                <v-list-item link>
                    <v-list-item-title v-text="'SUNGKA'"></v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-left mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-2 px-12"
                    v-bind="props"
                    prepend-icon="mdi-run-fast"
                >
                    Athletics
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
    <br><br>
    <v-col class="text-center mt-4" cols="12">
        &copy; <strong>ACLC 2023</strong>
    </v-col> 
</template>


<script>
    export default {
        name: 'EventNav',
		data() {
			return {
				links: ['Event_1','Event_2','Event_3','Event_4']
			}
		}
    }
</script>

<style scoped>

</style>