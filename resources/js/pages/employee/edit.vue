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
          :to="{ name: 'employee-list' }"
        >
          All Employees
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <employeeForm :isEdit="true" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import employeeForm from '@/components/employee/employeeForm.vue'
export default {
  name: "employeeEdit",
  components: {
    employeeForm
  },
};
</script>

<style>
</style>