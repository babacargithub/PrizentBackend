<template>
    <v-container class="container">
        <v-card class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <LinkBadge></LinkBadge>
                    <v-btn color="light"  @click="test" class="card-body">
                        BUUOOOO
                    </v-btn>
                </div>
            </div>
        </v-card>
    </v-container>
</template>

<script>
    import LinkBadge from "./LinkBadge.vue";

    export default {
        components: {LinkBadge},
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            test(){
                alert('test')
            }
        }
    }
</script>
