<template>
  <v-form @submit.prevent="addCompany">
    <v-text-field
      v-model="form.name"
      label="Company name"
      regular
    ></v-text-field>
    <v-text-field
      type="email"
      v-model="form.email"
      label="E-mail"
    ></v-text-field>
    <v-text-field v-model="form.website" label="Website"></v-text-field>
    <v-radio-group v-model="form.status" inline label="Status">
      <v-radio label="Active" color="success" value="Active"></v-radio>
      <v-radio label="In Active" color="error" value="InActive"></v-radio>
    </v-radio-group>
    <v-file-input label="Upload Logo" @change="updateLogo"></v-file-input>
    <formValidationMessage :error="error" :success="success" class="mb-3" />
    <v-btn color="primary" elevation="2" large type="submit">Add</v-btn>
  </v-form>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import formValidationMessage from "@/components/formValidationMessage";
import { decodeLaravelValidationErrors, isEmpty } from "@/utilities/helper";
export default {
  name: "companyForm",
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
    ...mapGetters("company", ["companyByUuid", 'isCompanyDataLoaded']),
  },
  methods: {
    ...mapActions("company", ["updateCompany", "createCompany"]),
    resetForm() {
      this.form = {
        name: null,
        email: null,
        website: null,
        logo: null,
        status: null,
      };
      if (this.isEdit) {
        const company = this.companyByUuid(this.$route.params.uuid);
        this.form = {
          name: company ? company.name : null,
          email: company ? company.email : null,
          website: company ? company.website : null,
          logo: company ? company.logo : null,
          status: company ? company.status : null,
        };
      }
    },
    updateLogo(files) {
      console.log(files);
      this.form.logo = files[0];
    },
    addCompany() {
      let form = this.form;
      if (this.isEdit) {
        form.uuid = this.$route.params.uuid;
        this.updateCompany(form)
          .then((r) => {
            const res = r.response.data;
            console.log(res, "dsdjfgdgj");
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
        this.createCompany(form)
          .then((r) => {
              console.log(r, "reeryrjr");
            const res = r.data || r.response.data;
            console.log(res, "dsdjfgdgj");
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
  watch:{
    isCompanyDataLoaded(val){
      if(val){
        this.resetForm();
      }
    }
  },
  created() {
    this.resetForm();
  },
};
</script>

<style>
</style>