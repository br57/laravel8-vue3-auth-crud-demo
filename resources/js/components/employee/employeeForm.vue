<template>
    <v-form @submit.prevent="addEmployee">
        <v-text-field
            v-model="form.firstName"
            label="Employee first name"
            regular
        ></v-text-field>
        <v-text-field
            v-model="form.lastName"
            label="Employee last name"
            regular
        ></v-text-field>
        <v-text-field
            type="email"
            v-model="form.email"
            label="E-mail"
        ></v-text-field>
        <v-radio-group v-model="form.companyUuid" label="Company">
        <v-radio
          v-for="(company, clk) in companies"
          :key="`clk_${clk}`"
          :label="company.name"
          name=""
          :value="company.uuid"
        ></v-radio>
        </v-radio-group>
        <v-radio-group v-model="form.status_uuid" inline label="Status">
            <v-radio v-for="(status, sk) in statuses" :label="status.label" color="primary" :value="status.uuid" :key="`status_${sk}`"></v-radio>
        </v-radio-group>
        <formValidationMessage :error="error" :success="success" class="mb-3" />
        <v-btn text color="teal accent-4" type="submit">
            <template v-if="isEdit">
                Save Employee
            </template>
            <template v-else>
                Add Employee
            </template>
        </v-btn>
    </v-form>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { decodeLaravelValidationErrors, isEmpty } from "@/utilities/helper";
export default {
    name: "employeeForm",
    props: {
        isEdit: {
            type: Boolean,
            default: false,
            required: false,
        },
    },
    data: () => ({
        form: {},
        success: null,
        error: null,
    }),
    computed: {
        ...mapGetters("employee", ["employeeByUuid"]),
        ...mapGetters("company", ["companies"]),
        ...mapGetters("status", ["statuses"]),
        companyOpts(){
          return this.companies.map(i => {
            return {
              name: i.name,
              value: i.uuid
            }
          })
        }
    },
    methods: {
        ...mapActions("employee", ["updateEmployee", "createEmployee"]),
        resetForm() {
            this.form = {
                firstName: null,
                lastName: null,
                email: null,
                companyUuid: null,
                status_uuid: null,
            };
            if (this.isEdit) {
                const employee = this.employeeByUuid(this.$route.params.uuid);
                this.form = {
                    firstName: employee ? employee.first_name : null,
                    lastName: employee ? employee.last_name : null,
                    email: employee ? employee.email : null,
                    companyUuid: employee ? employee.company_uuid : null,
                    status_uuid: employee ? employee.status_uuid : null,
                };
            }
        },
        updateLogo(files) {
            console.log(files);
            this.form.logo = files[0];
        },
        async addEmployee() {
            let form = this.form;
            let res = {}
            if (this.isEdit) {
                form.uuid = this.$route.params.uuid
                res = await this.updateEmployee(form)
            } else {
                res = await this.updateEmployee(form)
            }
            if(!isEmpty(res.data)){
                if(res.status === 200){
                    this.$router.push({
                        name: "employee-list",
                    });
                    return
                }
                let errors = decodeLaravelValidationErrors(
                    res.data.errors
                );
                if (errors) {
                    this.error = errors;
                }
            }
        },
    },
    created() {
        this.resetForm();
    },
};
</script>

<style>
</style>