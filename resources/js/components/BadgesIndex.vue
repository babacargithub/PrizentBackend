<template>
    <q-badge color="primary" align="middle" label="Unused"></q-badge>
    <LinkBadge></LinkBadge>

</template>

<script>
    import LinkBadge from "./LinkBadge.vue";

    export default {
        components: {LinkBadge},
        mounted() {
        },
        methods:{
            test(){
                alert('test')
            }
        }
    }
</script>
