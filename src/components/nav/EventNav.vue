<template>
	<v-col align="center">
		<v-img
			:src="foundationLogo"
			:lazy-src="foundationLogo"
			aspect-ratio="1"
			alt="foundation-logo"
			height="100"
			width="100"
		>
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
		<p class="text-h4 mt-2 font-weight-bold">Competitions</p>
	</v-col>
	<v-divider />
	<div class="text-center mx-4">
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
    <div class="text-center mx-4">
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
				<v-list-item v-for="literaryEvent in literaryEvents" :key="literaryEvent" link>
					<v-list-item-title>{{ literaryEvent }}</v-list-item-title>
				</v-list-item>
			</v-list>
        </v-menu>
	</div>
    <div class="text-center mx-4">
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
				<v-list-item v-for="musicEvent in musicEvents" :key="musicEvent" link>
					<v-list-item-title>{{ musicEvent }}</v-list-item-title>
				</v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center mx-4">
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
				<v-list-item v-for="danceEvent in danceEvents" :key="danceEvent" link>
					<v-list-item-title>{{ danceEvent }}</v-list-item-title>
				</v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-2 px-11"
                    v-bind="props"
                    prepend-icon="mdi-tennis-ball"
					disabled
                >
                    Ball Games
                </v-btn>
            </template>
            <v-list>
				<v-list-item v-for="ballGame in ballGames" :key="ballGame" link>
					<v-list-item-title>{{ ballGame }}</v-list-item-title>
				</v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-1 px-10"
                    v-bind="props"
                    prepend-icon="mdi-chess-queen"
					disabled
                >
                    Board Games
                </v-btn>
            </template>
            <v-list>
				<v-list-item v-for="boardGame in boardGames" :key="boardGame" link>
					<v-list-item-title>{{ boardGame }}</v-list-item-title>
				</v-list-item>
            </v-list>
        </v-menu>
    </div>
    <div class="text-center mx-4">
        <v-menu transition="scroll-y-transition">
            <template v-slot:activator="{ props }">
                <v-btn
                    variant="text"
                    class="my-2 mx-2 px-12"
                    v-bind="props"
                    prepend-icon="mdi-run-fast"
					disabled
                >
                    Athletics
                </v-btn>
            </template>
            <v-list>
				<v-list-item v-for="athleticEvent in athleticEvents" :key="athleticEvent" link>
					<v-list-item-title>{{ athleticEvent }}</v-list-item-title>
				</v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>


<script>
    export default {
        name: 'EventNav',
		data() {
			return {
				foundationLogo: `${import.meta.env.BASE_URL}foundation-logo.png`,
				links: ['Event_1','Event_2','Event_3','Event_4']
			}
		},
		methods: {
			handleChangeEvent() {
				
			}
		},
		computed: {
			literaryEvents() {
				return this.$store.getters['events/getEvents'].literary;
			},
			musicEvents() {
				return this.$store.getters['events/getEvents'].music;
			},
			danceEvents() {
				return this.$store.getters['events/getEvents'].dance;
			},
			ballGames() {
				return this.$store.getters['events/getEvents'].ballGames;
			},
			boardGames() {
				return this.$store.getters['events/getEvents'].boardGames;
			},
			athleticEvents() {
				return this.$store.getters['events/getEvents'].athletics;
			}

		}
    }
</script>

<style scoped>

</style>