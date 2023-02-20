<template>
	<v-app-bar :title="appName" color="deep-purple-darken-3">
		<h3 class="me-5">{{ judgeName }}</h3>
		<v-chip
			class="ma-2"
			color="green"
		>
			<v-icon start icon="mdi-account-circle"></v-icon>
			JUDGE
		</v-chip>
		<v-avatar
			class="me-5"
			size="35">
			<v-img :src="avatar"/>
		</v-avatar>
	</v-app-bar>
</template>

<script>
export default {
	name: "TopNav",
	data() {
		return {
			avatar: `${import.meta.env.BASE_URL}no-avatar.jpg`,
			appName: `${this.$store.getters.appName}`,
			judgeName: 'JUDGE'
		}
	}
}
</script>

<style scoped>

</style>