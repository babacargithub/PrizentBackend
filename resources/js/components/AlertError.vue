<template xmlns="http://www.w3.org/1999/html">
<q-banner class="bg-red text-white rounded-borders">
  <template v-slot:avatar><i
      class="nav-icon la la-warning" style="font-size: 40px"></i></template>
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
