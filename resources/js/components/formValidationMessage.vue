<template>
  <div>
    <template v-if="error">
      <template v-if="typeof error === 'object'">
        <v-alert
          border="left"
          color="red"
          type="error"
          class="mb-1"
          v-for="(err, i) in error"
          :key="`p_${i}`"
        >
          {{ err }}
        </v-alert>
      </template>
      <template v-else-if="typeof error === 'string'">
        <v-alert border="left" color="red" type="error" class="mb-1">
          {{ error }}
        </v-alert>
      </template>
    </template>
    <template v-if="success">
      <v-alert border="left" color="green" type="success" class="mb-1">
        {{ success }}
      </v-alert>
    </template>
  </div>
</template>

<script>
export default {
  name: "formValidationMessage",
  props: {
    error: {
      type: [Object, Array, String],
      required: false,
      default: null,
    },
    success: {
      type: String,
      required: false,
      default: null,
    },
  },
};
</script>
