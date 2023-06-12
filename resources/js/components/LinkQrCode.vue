<template>
    <v-container class="container">
        <q-card class="">

            <q-card-section>
                <p v-if="error != null" class="bg-white text-red" ><q-icon color="red" name="mdi-alert-circle"></q-icon>{{error}}</p>
                <q-form @submit.prevent="submitRequest">
                    <q-input label="Société" v-model="data.company_telephone"></q-input>
                    <q-input label="Numéro Qr Code" v-model="data.qr_code_number"></q-input>
                    <q-input label="Latitude" v-model="data.latitude"></q-input>
                    <q-input label="Longitude" v-model="data.longitude"></q-input>
                    <q-btn color="primary" type="submit">Valider</q-btn>
                </q-form>
            </q-card-section>
        </q-card>
    </v-container>
</template>

<script>
    import {Loading} from "quasar";

    export default {
        name: "LinkQRCode",
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                error: null,
                data: {
                    company_telephone: null,
                    latitude: null,
                    longitude: null,
                    qr_code_number: null
                }
            }
        },
        methods:{
            submitRequest(){
                Loading.show({message: "Chargement"})
                this.error = null
                window.axios.post("link_qr_code",this.data)
                    .then(r=>{

                    }).catch(e=>{
                    this.error = e.response.data.message
                }).finally(()=>{
                    Loading.hide()
                })
            }
        }
    }
</script>
