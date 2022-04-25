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
                    :to="{ name: 'company-add' }"
                >
                    Add Company
                </v-btn>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12">
                <v-card>
                    <table class="table">
                        <thead>
                            <tr>
                                <th
                                    class="text-left"
                                    v-for="(oi, ki) in headers"
                                    :key="ki"
                                >
                                    {{ oi.text }}
                                </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in companiesMapped" :key="item.uuid">
                                <td
                                    v-for="(oi, vi) in headers"
                                    :key="`vi_${vi}_${item.uuid}`"
                                >
                                    {{ item[oi.value] }}
                                </td>
                                <td>{{item.status.label}}</td>
                                <td>
                                    <v-btn
                                        :to="{
                                            name: 'company-edit',
                                            params: { uuid: item.uuid },
                                        }"
                                        color="primary"
                                        elevation="2"
                                        fab
                                        justify="end"
                                        >Edit</v-btn
                                    >
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
    name: "company-list",
    data: () => ({
        headers: [
            { text: "Company Name", value: "name" },
            { text: "Email", value: "email" },
            { text: "Total Employee", value: "total_employees" },
        ],
    }),
    computed: {
        ...mapGetters("company", ["companiesMapped"]),
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