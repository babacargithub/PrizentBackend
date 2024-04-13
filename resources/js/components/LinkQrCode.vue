<template>
    <div class="q-ma-lg">
        <q-card class="">

            <div class="q-ma-lg">
                <q-card-section>
                    <AlertError v-if="error != null">{{ error }}</AlertError>
                    <p class="bg-white text-red">
                        <q-icon color="red" name="mdi-alert-circle"></q-icon>
                    </p>
                    <q-form @submit.prevent="submitRequest">
                        <q-input required label="Téléphone Société" v-model="data.company_telephone"
                                 hint="Numéro téléphone de la société à attribuer le qr code"></q-input>
                        <q-input required label="Numéro Qr code" v-model="data.qr_code_number"></q-input>
                        <q-input required label="Nom du QR code" v-model="data.nom"></q-input>
                        <q-input required label="Latitude" v-model="data.latitude"></q-input>
                        <q-input required label="Longitude" v-model="data.longitude"></q-input>
                        <q-btn color="primary" type="submit">Valider</q-btn>
                    </q-form>
                </q-card-section>
            </div>
        </q-card>
    </div>
</template>

<script>

import AlertError from "./AlertError.vue";

export default {
        name: "LinkQRCode",
    components: {AlertError},
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                error: null,
                data: {
                    nom:null,
                    company_telephone: null,
                    latitude: null,
                    longitude: null,
                    qr_code_number: null
                }
            }
        },
        methods:{
            submitRequest(){
                this.error = null
                window.axios.post("qr_codes/link_qr_code",this.data)
                    .then(r=>{
                        this.showAlertSuccess("Liaison faite avec succès")

                    }).catch(e=>{
                    this.error = e.data.message
                })
            }
        }
    }
</script>
