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
          :to="{ name: 'company-list' }"
        >
          All Companies
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <CompanyForm :isEdit="true" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import CompanyForm from '@/components/company/CompanyForm.vue'
export default {
  name: "EditCompany",
  components: {
    CompanyForm
  },
};
</script>

<style>
</style>