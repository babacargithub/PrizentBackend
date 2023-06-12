<template>
    <v-container class="container">
        <v-card class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Link Badge</div>

                    <v-text-field color="dark"  label="Badge Number">
                    </v-text-field>
                </div>
            </div>
        </v-card>
    </v-container>
</template>

<script>
    export default {
        name: "LinkBadge",
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
