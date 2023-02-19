<template>
    <v-layout
        style="height: 100vh;">
      <v-navigation-drawer
          class="bg-deep-purple"
          theme="dark"
      >
          <v-col align="center" >
            <v-avatar
                size="150">
              <v-img :src="avatar" />
            </v-avatar>

            <h1 class="mt-5">ADMIN_NAME</h1>
          </v-col>

        <v-list color="transparent">
          <v-list-item prepend-icon="mdi-view-dashboard" title="Events"></v-list-item>
        </v-list>

        <template v-slot:append>
          <div class="pa-2">
            <v-btn block @click="signOut">
              Logout
            </v-btn>
          </div>
        </template>
      </v-navigation-drawer>

      <v-app-bar title="ADMIN" style="background-color: #1e1e1e; color: white;"></v-app-bar>

      <v-main style="min-height: 300px;"></v-main>
    </v-layout>

</template>
<script>
import $ from 'jquery';

  export default {
      name: 'Admin',
      data() {
          return {
            signedOut: false,
            avatar: `${import.meta.env.BASE_URL}no-avatar.jpg`
          }
      },
      methods: {
        signOut() {
          $.ajax({
            url: `${this.$store.getters.appURL}/index.php`,
            type: 'POST',
            xhrFields: {
              withCredentials: true
            },
            data: {
              signOut: this.signedOut
            },
            success: (data) => {
              data = JSON.parse(data);
                this.$store.commit('auth/setUser', data.user = null);
                this.$router.push('/');
            },
            error: (error) => {
              alert(`ERROR ${error.status}: ${error.statusText}`);
            },
          })
        }
      }
  }
</script>

<style scoped>

</style>
