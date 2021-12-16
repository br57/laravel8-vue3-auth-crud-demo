<template>
  <select v-model="form.companyUuid">
      <option v-for="(i, k) in companies" :key="i.uuid+k" :value="i.uuid">{{i.name}}</option>
    </select>
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
    <select v-model="form.companyUuid">
    <option disabled value="">Please select one</option>
    <option>A</option>
    <option>B</option>
    <option>C</option>
  </select>
    <v-radio-group v-model="form.status" inline label="Status">
      <v-radio label="Active" color="success" value="Active"></v-radio>
      <v-radio label="In Active" color="error" value="InActive"></v-radio>
    </v-radio-group>
    <formValidationMessage :error="error" :success="success" class="mb-3" />
    <v-btn color="primary" elevation="2" large type="submit">Add</v-btn>
  </v-form>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import formValidationMessage from "@/components/formValidationMessage";
import { decodeLaravelValidationErrors, isEmpty } from "@/utilities/helper";
export default {
  name: "employeeForm",
  components: {
    formValidationMessage,
  },
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
  },
  methods: {
    ...mapActions("employee", ["updateEmployee", "createEmployee"]),
    resetForm() {
      this.form = {
        name: null,
        email: null,
        companyUuid: null,
        status: null,
      };
      if (this.isEdit) {
        const employee = this.employeeByUuid(this.$route.params.uuid);
        this.form = {
          firstName: employee ? employee.first_name : null,
          lastName: employee ? employee.last_name : null,
          email: employee ? employee.email : null,
          companyUuid: employee ? employee.company_uuid : null,
          status: employee ? employee.status : null,
        };
      }
    },
    updateLogo(files) {
      console.log(files);
      this.form.logo = files[0];
    },
    addEmployee() {
      let form = this.form;
      if (this.isEdit) {
        form.uuid = this.$route.params.uuid;
        this.updateEmployee(form)
          .then((r) => {
            const res = r.response.data;
            if (!isEmpty(res)) {
            } else {
              let errors = decodeLaravelValidationErrors(res.errors);
              if (errors) {
                this.error = errors;
              }
            }
          })
          .catch((e) => {});
      } else {
        this.createEmployee(form)
          .then((r) => {
            const res = r.data || r.response.data;
            if (!isEmpty(res.success)) {
            } else {
              let errors = decodeLaravelValidationErrors(res.errors);
              if (errors) {
                this.error = errors;
              }
            }
          })
          .catch((e) => {});
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