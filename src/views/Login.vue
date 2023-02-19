<template>
    <v-container class="d-flex align-center justify-center fill-height">
      <v-row justify="center" align="center">
        <v-col xs="12" sm="10" md="8" lg="6">
          <v-img height="250" :src="img">
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
          <v-card class="ma-16 pa-10">
            <form @submit.prevent="handleSubmit">
              <v-text-field
                  v-model="username"
                  :rules="[rules.required]"
                  label="Username"
                  variant="outlined"
                  required
              ></v-text-field>
              <v-text-field
                  v-model="password"
                  :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                  :rules="[rules.required]"
                  :type="show1 ? 'text' : 'password'"
                  name="input-10-1"
                  variant="outlined"
                  label="Password"
                  counter
                  required
                  @click:append="show1 = !show1"
              ></v-text-field>
              <v-code class="bg-white" align="right">
                <v-btn
                    class="mt-4"
                    type="submit"
                >
                  log in
                </v-btn>
              </v-code>
            </form>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
</template>

<script>
import $ from 'jquery';

export default {
  name: 'Login',
  data () {
    return {
      show1: false,
      show2: true,
      username: '',
      password: '',
      img: 'assets/foundation-logo.png',
      rules: {
        required: value => !!value || 'Required.',
      },
    }
  },
  methods: {
    async handleSubmit() {
      $.ajax({
        url: 'php/login.php',
        type: 'POST',
        data: {
          username: this.username,
          password: this.password,
        },
        success: (response) => {
            // The username and password are valid
          console.log(response.data);
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.log(errorThrown);
        },
      });
    },
  },
  mounted() {
    $.ajax({
      url: 'php/login.php',
      type: 'GET',
      success: (response) => {
        console.log(response.data)
      },
      error: (jqXHR, textStatus, errorThrown) => {
        console.log(textStatus + errorThrown);
      },
    })
  }
}
</script>
<style scoped>

</style>
