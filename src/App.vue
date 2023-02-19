<template>
  <v-app>
    <v-main>
      <router-link :to="`/`">Login</router-link> |
      <router-link :to="`/admin`">Admin</router-link> |
      <router-link :to="`/judge`">Judge</router-link> |
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import Login from "./views/Login.vue";

export default {
  name: 'App',
  components: {
    Login
  },
  data() {
    return {
    }
  },
  mounted() {
  }
}
</script>
<style scoped>

</style>