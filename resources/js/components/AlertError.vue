<template>
<q-banner class="bg-red text-white rounded-borders">
  <template v-slot:avatar><q-icon name="mdi-alert"></q-icon></template>
    <slot />
</q-banner>
</template>

<script>
export default {
  name: "AlertError",
  props: {
    icon: {
      default: ""
    },
  }
};
</script>

<style scoped>

</style>
