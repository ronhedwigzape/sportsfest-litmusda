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

        <h1 class="mt-5">TECHNICAL_NAME</h1>
      </v-col>

      <v-list color="transparent">
        <v-list-item prepend-icon="mdi-view-dashboard" title="Events"></v-list-item>
      </v-list>

      <template v-slot:append>
        <div class="ma-2 mb-5">
          <v-row justify="center">
            <v-dialog
                v-model="dialog"
                width="auto"
            >
              <template v-slot:activator="{ props }">
                <v-btn
                    color="danger"
                    class="text-red"
                    v-bind="props"
                >
                  log out
                </v-btn>
              </template>
              <v-card class="pa-3">
                <v-card-title class="text-h5">
                  Confirm Logout
                </v-card-title>
                <v-card-text>Are you sure you want to log out?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                      color="red-darken-1"
                      variant="text"
                      @click="dialog = false"
                  >
                    cancel
                  </v-btn>
                  <v-btn
                      color="green-darken-1"
                      variant="text"
                      @click="signOut"
                  >
                    ok
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar title="TECHNICAL" style="background-color: #1e1e1e; color: white;"></v-app-bar>

    <v-main style="min-height: 300px;"></v-main>
  </v-layout>

</template>
<script>
import $ from 'jquery';

export default {
  name: 'Technical',
  data() {
    return {
      dialog: false,
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
