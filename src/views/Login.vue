<template>
    <v-container class="d-flex align-center justify-center fill-height">
      <v-row justify="center" align="center">
        <v-col xs="12" sm="10" md="8" lg="6">
          <v-img style="height: 300;" src="/src/assets/foundationlogo.png"></v-img>
          <v-card class="ma-16 pa-10">
            <form>
              <v-text-field
                  v-model="name"
                  :rules="[rules.required]"
                  label="Username"
                  variant="underlined"
                  required
              ></v-text-field>
              <v-text-field
                  v-model="password"
                  :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                  :rules="[rules.required]"
                  :type="show1 ? 'text' : 'password'"
                  name="input-10-1"
                  variant="underlined"
                  label="Password"
                  counter
                  @click:append="show1 = !show1"
              ></v-text-field>
              <v-code class="bg-white" align="right">
                <v-btn
                    class="mt-4 "
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

export default {
  name: 'Login',
  data () {
    return {
      show1: false,
      show2: true,
      name: '',
      password: '',
      rules: {
        required: value => !!value || 'Required.',
      },
    }
  },
}
</script>
<style scoped>

</style>
