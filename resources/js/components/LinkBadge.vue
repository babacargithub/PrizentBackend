<template>
        <q-card class="">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Attribuer un Badge</div>
                    <AlertError v-if="error != null">{{error}}</AlertError>
                    <q-form @submit.prevent="submit">
                        <q-input label="Numéro Badge" v-model="data.badge_number"></q-input>
                        <q-input label="Téléphone Employé" v-model="data.employe_telephone"></q-input>
                        <q-btn color="primary" type="submit">Soumettre</q-btn>
                    </q-form>
                </div>
            </div>
        </q-card>
</template>

<script>
    import {Loading} from "quasar";
    import AlertError from "./AlertError.vue";
    import Swal from "sweetalert2";

    export default {
        name: "LinkBadge",
        components: {AlertError},
        data() {
            return {
                data: {
                    employe_telephone: null,
                    badge_number: null
                },
                error: null
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            submit(){
                Loading.show({message: "Chargement"})
                this.error = null
                window.axios.post("badges/link",this.data )
                    .then(r => {
                        Swal.fire({
                            text:"Attribué avec succès !",
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
