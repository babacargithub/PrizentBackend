<template>
    <v-container class="container">
        <q-card class="">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Générer un lot de Badges</div>
                    <AlertError v-if="error != null">{{error}}</AlertError>
                    <q-form @submit.prevent="submitRequest">
                        <q-input label="Nombre à générer" required v-model.number="quantity"></q-input>
                        <q-btn type="submit" color="primary">Générer</q-btn>
                    </q-form>
                </div>
            </div>
        </q-card>
    </v-container>
</template>

<script>
    import {Loading} from "quasar";
    import Swal from "sweetalert2";
    import AlertError from "./AlertError.vue";

    export default {
        name: "GenerateBadge",
        components: {AlertError},
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                error: null,
                quantity: 0,
            }
        },
        methods:{
            submitRequest(){
                Loading.show({message: "Chargement"})
                this.error = null
                window.axios.post("generate", {quantity:this.quantity})
                    .then(r => {
                        Swal.fire({
                            text:"Généré avec succès !",
                            icon:"success",
                        })
                    }).catch(e => {
                    this.error = e.response.data.message
                }).finally(() => {
                    Loading.hide()
                })
            }
        }
    }
</script>
