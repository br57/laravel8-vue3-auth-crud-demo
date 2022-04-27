<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12">
        <v-btn
          color="primary"
          elevation="2"
          fab
          large
          justify="end"
          :to="{ name: 'employee-list' }"
        >
          All Employees
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <EmployeeForm />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import EmployeeForm from '@/components/employee/EmployeeForm.vue'
export default {
  name: "AddEmployee",
  components: {
    EmployeeForm
  },
};
</script>

<style>
</style>