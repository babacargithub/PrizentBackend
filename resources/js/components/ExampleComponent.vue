<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <v-btn color="light"  @click="test" class="card-body">
                        I'm an example component.
                    </v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
