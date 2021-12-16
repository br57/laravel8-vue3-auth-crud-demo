<template>
  <div>
    <v-app-bar density="compact">
      <v-app-bar-title>Vuetify</v-app-bar-title>
      <v-spacer></v-spacer>
      <template v-if="isAuth">
        <v-btn :to="'/dashboad'" text>Dashboad</v-btn>
        <v-btn :to="'/company'">Comapnies</v-btn>
        <v-btn :to="'/employee'">Employees</v-btn>
      </template>
    </v-app-bar>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  computed: {
    ...mapGetters(["isAuth"]),
  },
  methods: {
    ...mapActions(["isAuthCheck"]),
  },
  created() {
    this.isAuthCheck();
  },
};
</script>