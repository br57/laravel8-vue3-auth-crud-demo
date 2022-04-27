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
                    :to="{ name: 'employee-add' }"
                >
                    Add Employee
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12">
                <v-table fixed-header>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="emp in employeesMapped"
                            :key="`emp_uuid_${emp.uuid}`"
                        >
                            <td>{{ emp.display_name }}</td>
                            <td>{{ emp.email }}</td>
                            <td>{{ emp.phone }}</td>
                            <td>
                                <template v-if="isCompanyDataLoaded">
                                    <template v-if="!isEmpty(emp.company)">
                                        {{ emp.company.name }}
                                    </template>
                                    <template v-else> No Found </template>
                                </template>
                                <template v-else> Loading... </template>
                            </td>
                            <td>
                                <template v-if="isStatusDataLoaded">
                                    <template v-if="!isEmpty(emp.status)">
                                        {{ emp.status.label }}
                                    </template>
                                    <template v-else> No Found </template>
                                </template>
                                <template v-else> Loading... </template>
                            </td>
                            <td>
                                <v-btn
                                    :to="{
                                        name: 'employee-edit',
                                        params: { uuid: emp.uuid },
                                    }"
                                    color="primary"
                                    elevation="2"
                                    fab
                                    justify="end"
                                  >
                                    Edit
                                  </v-btn>
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: "ListEmployee",
    data: () => ({}),
    computed: {
        ...mapGetters("employee", ["employeesMapped"]),
        ...mapGetters("company", ["isCompanyDataLoaded"]),
        ...mapGetters("status", ["isStatusDataLoaded"]),
    },
};
</script>

<style>
.table {
    padding: 1rem;
    width: 100%;
}
.table thead {
    font-weight: bold;
}
.table td,
.table th {
    padding: 0.8rem;
}
</style>