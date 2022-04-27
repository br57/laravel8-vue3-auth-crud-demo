<template>
  <v-app>
    <appHeader class="app_header" />
    <router-view />
  </v-app>
</template>

<script>
import appHeader from "@/layouts/header";
import { mapGetters, mapActions } from 'vuex'
export default {
  name: "Application",
  components: {
    appHeader,
  },

  computed: {
    ...mapGetters(['isAuth']),
  },
  methods: {
    ...mapActions('user', ['commonCall'])
  },
  mounted(){
    if(this.isAuth) this.commonCall()
  }
};
</script>

<style scoped>
.app_header{
  margin-bottom: 5rem;
}
</style>