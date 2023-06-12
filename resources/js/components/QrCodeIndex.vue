<template>
    <q-badge color="primary" align="middle" label="Unused"></q-badge>
    <LinkQRCode></LinkQRCode>

</template>

<script>
    import LinkQRCode from "./LinkQrCode.vue";

    export default {
        components: {LinkQRCode},
        mounted() {
        },
        methods:{
            test(){
                alert('test')
            }
        }
    }
</script>
