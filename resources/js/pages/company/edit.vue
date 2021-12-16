<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12">
        <v-btn
          color="primary"
          elevation="2"
          fab
          large
          justify="center"
          rounded
          :to="{ name: 'company-list' }"
        >
          All Companies
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <comapnyForm :isEdit="true" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import comapnyForm from '@/components/company/companyForm.vue'
export default {
  name: "comapnyEdit",
  components: {
    comapnyForm
  },
};
</script>

<style>
</style>