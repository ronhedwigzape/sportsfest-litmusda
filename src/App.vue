<template>
  <v-app>
    <v-app-bar class="secondary" :elevation="2"></v-app-bar>
    <v-main>
        <login />
    </v-main>
  </v-app>
</template>

<script>
import $ from 'jquery';
import Login from "./views/Login.vue";

export default {
  name: 'App',
  components: {
    Login
  },
  data() {
    return {
      data: '',
      error: ''
    }
  },
  mounted() {
    $.ajax({
      url: 'php/index.php',
      method: 'GET',
      dataType: 'json',
      success: (response) => {
        this.data = response.data
        console.log(this.data)
      },
      error: (jqXHR, textStatus, errorThrown) => {
        this.error = errorThrown
        console.log(errorThrown)
      }
    });
  }
}
</script>
<style scoped>

</style>