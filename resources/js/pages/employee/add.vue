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
          rounded
          :to="{ name: 'employee-list' }"
        >
          All Employees
        </v-btn>
      </v-col>
      <v-col cols="12" md="4">
        <employeeForm />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import employeeForm from '@/components/employee/employeeForm.vue'
export default {
  name: "employeeAdd",
  components: {
    employeeForm
  },
};
</script>

<style>
</style>