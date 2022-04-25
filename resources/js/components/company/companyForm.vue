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
        addCompany() {
            let form = this.form;
            if (this.isEdit) {
                form.uuid = this.$route.params.uuid;
                this.updateCompany(form)
                    .then((r) => {
                        const res = r.response.data;
                        if (!isEmpty(res)) {
                            this.$router.push({
                                name: "company-list",
                            });
                        } else {
                            let errors = decodeLaravelValidationErrors(
                                res.errors
                            );
                            if (errors) {
                                this.error = errors;
                            }
                        }
                    })
                    .catch((e) => {});
            } else {
                this.createCompany(form)
                    .then((r) => {
                        const res = r.data || r.response.data;
                        if (!isEmpty(res.success)) {
                            this.$router.push({
                                name: "company-list",
                            });
                        } else {
                            let errors = decodeLaravelValidationErrors(
                                res.errors
                            );
                            if (errors) {
                                this.error = errors;
                            }
                        }
                    })
                    .catch((e) => {});
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