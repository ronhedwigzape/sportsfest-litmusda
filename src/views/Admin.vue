<template>
    <v-layout style="height: 100vh;">
		<side-nav />
		<top-nav />
    </v-layout>
</template>
<script>
    import $ from 'jquery';
	import topNav from "../components/nav/TopNav.vue";
	import sideNav from "../components/nav/SideNav.vue";

    export default {
        name: 'Admin',
		components: {
			topNav,
			sideNav
		},
        data() {
            return {

            }
        },
        methods: {

		}
    }
</script>

<style scoped>

</style>
