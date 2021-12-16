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
          :to="{ name: 'employee-add' }"
        >
          Add Employee
        </v-btn>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="12">
        <v-card>
          <table class="table">
            <thead>
              <tr>
                <th>Employee Name</th>
                <th class="text-left" v-for="(oi, ki) in headers" :key="ki">{{oi.text}}</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in employees" :key="item.uuid">
                <td>{{`${item.first_name} ${item.last_name}`}}</td>
                <td v-for="(oi, vi) in headers" :key="`vi_${vi}_${item.uuid}`">{{ item[oi.value] }}</td>
                <td>{{companyByUuid(item.company_uuid).name}}</td>
                <td>
                  <v-btn :to="{name: 'employee-edit', params: {uuid: item.uuid}}"
                  color="primary"
                  elevation="2"
                  fab
                  justify="end"
                  >Edit</v-btn>
                </td>
              </tr>
            </tbody>
          </table>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "employee-list",
  data: () => ({
    headers: [
      { text: "Email", value: "email" },
      { text: "Status", value: "status" },
    ],
  }),
  computed: {
    ...mapGetters("employee", ["employees"]),
    ...mapGetters("company", ["companyByUuid"]),
  },
};
</script>

<style>
.table{
  padding:  1rem;
  width: 100%;
}
.table thead{
  font-weight: bold;
}
.table td, .table th{
  padding: .8rem;
}
</style>