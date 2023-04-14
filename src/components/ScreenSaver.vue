<template>
	<v-row justify="center" align="center">
		<v-col
			justify="center"
		   	align="center"
		   	class="gradient text-center d-flex justify-center align-items-center align-content-center"
		   	style="height: 100vh;"
		>
			<v-img :src="img" class="fade-in" style="height: 50rem;"/>
		</v-col>
	</v-row>
</template>

<script>
export default {
	name: "ScreenSaver",
	data() {
		return {
			img: `${import.meta.env.BASE_URL}aclc_iriga.png`
		}
	},
	mounted() {
		document.body.style.overflow = "hidden";
	}
}
</script>

<style scoped>
@keyframes fade-in {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

.fade-in {
	animation: fade-in 3s;
}

.gradient {
	background: linear-gradient(
		315deg,
		rgb(154, 24, 144) 3%,
		rgb(58, 133, 211) 38%,
		rgba(48,238,226,1) 68%,
		rgba(255,25,25,1) 98%
		) fixed;
	animation: animate-gradient 15s ease infinite;
	background-size: 400% 400%;
}

@keyframes animate-gradient {
	0% {
		background-position: 0% 0%;
	}
	50% {
		background-position: 100% 100%;
	}
	100% {
		background-position: 0% 0%;
	}
}

</style>