<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="6">
        <v-card class="mx-auto" max-width="344">
          <v-card-text>
            <div>Companies</div>
            <p class="text-h4 text--primary">
                Total Companies: {{companies.length}}
            </p>
          </v-card-text>
          <v-card-actions>
            <router-link :to="{name: 'company-list', params: {}}">
              Show All
            </router-link>
          </v-card-actions>
        </v-card>
        <v-card class="mx-auto" max-width="344">
          <v-card-text>
            <div>Employees</div>
            <p class="text-h4 text--primary">
                Total Employees: {{employees.length}}
            </p>
          </v-card-text>
          <v-card-actions>
            <router-link :to="{name: 'employee-list', params: {}}">
              Show All
            </router-link>
          </v-card-actions>
        </v-card>

          <v-expand-transition>
            <v-card
              class="transition-fast-in-fast-out v-card--reveal"
              style="height: 100%"
            >
              <v-card-text class="pb-0">
                <p class="text-h4 text--primary">Origin</p>
                <p>
                  late 16th century (as a noun denoting a place where alms were
                  distributed): from medieval Latin eleemosynarius, from late
                  Latin eleemosyna 'alms', from Greek eleēmosunē 'compassion'
                </p>
              </v-card-text>
              <v-card-actions class="pt-0">
                <v-btn text color="teal accent-4" @click="reveal = false">
                  Close
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-expand-transition>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: "dashboard",
  data: () => ({}),
  computed: {
      ...mapGetters('company', [
          'companies'
      ]),
      ...mapGetters('employee', [
          'employees'
      ])
  }
};
</script>