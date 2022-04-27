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
        <v-radio-group v-model="form.status_uuid" inline label="Status">
            <v-radio v-for="(status, sk) in statuses" :label="status.label" color="primary" :value="status.uuid" :key="`status_${sk}`"></v-radio>
        </v-radio-group>
        <v-file-input label="Upload Logo" @change="updateLogo"></v-file-input>
        <formValidationMessage :error="error" :success="success" class="mb-3" />
        <v-btn text color="teal accent-4" type="submit">
            <template v-if="isEdit">
                Save Company
            </template>
            <template v-else>
                Add Company
            </template>
        </v-btn>
    </v-form>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { decodeLaravelValidationErrors, isEmpty } from "@/utilities/helper";
export default {
    name: "CompanyForm",
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
        ...mapGetters("company", ["companyByUuid", "isCompanyDataLoaded"]),
        ...mapGetters("status", ["statuses"]),
    },
    methods: {
        ...mapActions("company", ["updateCompany", "createCompany"]),
        resetForm() {
            this.form = {
                name: null,
                email: null,
                website: null,
                logo: null,
                status_uuid: null,
            };
            if (this.isEdit) {
                const company = this.companyByUuid(this.$route.params.uuid);
                this.form = {
                    name: company ? company.name : null,
                    email: company ? company.email : null,
                    website: company ? company.website : null,
                    logo: company ? company.logo : null,
                    status_uuid: company ? company.status_uuid : null,
                };
            }
        },
        updateLogo(files) {
            console.log(files);
            this.form.logo = files[0];
        },
        async addCompany() {
            let form = this.form;
            let res = {}
            if (this.isEdit) {
                form.uuid = this.$route.params.uuid
                res = await this.updateCompany(form)
            } else {
                res = await this.createCompany(form)
            }
            if(!isEmpty(res.data)){
                if(res.status === 200){
                    this.$router.push({
                        name: "company-list",
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
    watch: {
        isCompanyDataLoaded(val) {
            if (val) {
                this.resetForm();
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