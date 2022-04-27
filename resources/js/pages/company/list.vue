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
                    :to="{ name: 'company-add' }"
                >
                    Add Company
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
                            <th>Website</th>
                            <th>Total Employee(s)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="company in companiesMapped"
                            :key="`company_uuid_${company.uuid}`"
                        >
                            <td>{{ company.name }}</td>
                            <td>{{ company.email }}</td>
                            <td>{{ company.website }}</td>
                            <td>
                                <template v-if="isStatusDataLoaded">
                                    {{ company.total_employees }}
                                </template>
                                <template v-else> Loading... </template>
                            </td>
                            <td>
                                <template v-if="isStatusDataLoaded">
                                    <template v-if="!isEmpty(company.status)">
                                        {{ company.status.label }}
                                    </template>
                                    <template v-else> No Found </template>
                                </template>
                                <template v-else> Loading... </template>
                            </td>
                            <td>
                                <v-btn
                                    :to="{
                                        name: 'company-edit',
                                        params: { uuid: company.uuid },
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
    name: "ListCompany",
    data: () => ({}),
    computed: {
        ...mapGetters("company", ["companiesMapped"]),
        ...mapGetters("status", ["isStatusDataLoaded"]),
        ...mapGetters("employee", ["isEmployeeDataLoaded"]),
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