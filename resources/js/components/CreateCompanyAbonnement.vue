<template>
    <div class="q-ma-lg">
        <q-card class="">

            <div class="q-ma-lg">
                <q-card-section>
                    <div class="text-h6">{{ type }}</div>
                    <AlertError v-if="error != null">{{ error }}</AlertError>
                    <p class="bg-white text-red">
                        <q-icon color="red" name="mdi-alert-circle"></q-icon>
                    </p>
                    <q-form @submit.prevent="submitRequest">

                        <q-select :required="!custom" :options="formules" label="Formule"
                                  option-label="nom"
                                    option-value="id"
                                  v-if="!custom"
                                  v-model="data.formule"></q-select>
                        <div class="form-group">
                            <label for="prix">Prix de l'abonnement</label>
                            <input type="text" class="form-control" id="prix" aria-describedby="emailHelp"  required
                                   v-model="data.prix" :disabled="!custom"/>
                            <small id="emailHelp" class="form-text text-muted">C'est le prix à payer par le
                                client</small>
                        </div>
                        <div class="form-group">
                            <label >Maximum d'employés</label>
                            <input type="text" class="form-control" required  :disabled="!custom"
                                     v-model="data.limite"/>

                        </div>



                        <div class="form-group" >
                            <label>L'abonnement sera en </label>
                            <select class="custom-select" v-model="data.unite" :disabled="!custom">
=                            <option value="jour">JOUR</option>
                            <option value="mois">MOIS</option>
                            <option value="annee">ANNÉE</option>

                        </select>

                        </div>
                        <div class="form-group">
                            <label>{{'Nombre de '+data.unite}}</label>
                            <input type="number" required class="form-control" :placeholder="'Nombre de '+data.unite"
                                  v-model="data.duree"
                                  v-if="data.unite != null"/></div>
                        <div class="form-group" v-if="custom"><label class="text-bold">Fonctionnalités</label>

                            <template v-for="( feature, index) in features " :key="index">
                                <div class="q-ma-md"><label class="q-mr-lg">{{ feature.public_name }}</label>
                                    <input type="checkbox" v-model="data.features" :value="feature.constant_name"/>
                                </div>
                            </template>
                        </div>


                        <q-btn color="primary" type="submit">Valider</q-btn>
                    </q-form>
                </q-card-section>
            </div>
        </q-card>
    </div>
</template>

<script>

import AlertError from "./AlertError.vue";
import {isTemplateNode} from "@vue/compiler-core";
import {ref} from "vue";


export default {
        name: "CreateCompanyAbonnement",
    props: {
            type_abonnement: String,
        type: {


        },
        company_prop: String|Object,
        list_of_formules: String|Array,
        list_of_features: String|Array,
    },
    components: {AlertError},
        mounted() {
            try {
                this.custom = this.type_abonnement === "custom"
                this.formules = JSON.parse(this.list_of_formules)
                this.features = JSON.parse(this.list_of_features)
                this.company = JSON.parse(this.company_prop)
            } finally {
                console.log("Error parsing props")
            }
        },
        setup () {
            return {
                selection: ref([ 'teal', 'red' ])
            }
        },
        data() {
            return {
                company: null,
                error: null,
                formules: [],
                features: [],
                custom: false,
                data: {
                    nom:null,
                    formule_id: null,
                    formule: null,

                    prix: null,
                    duree: null,
                    unite: null,
                    nombre: null,
                    limite: null,
                    features:[],
                }
            }
        },
    watch:{
            'data.formule': function (val) {
                // this.data.formule_id = val
                this.data.formule_id = val.id
                this.data.unite = val.unite
                this.data.prix = val.prix
                this.data.limite = val.limite
            },

    },
        methods:{
            submitRequest(){
                this.error = null
                this.data.custom = this.custom
                window.axios.post("abonnements/"+this.company.id+"/create_custom_abonnement",this.data)
                    .then(r=>{
                        this.showAlertSuccess("Abonnement crée avec succès")

                    }).catch(e=>{
                    this.error = e.data.message
                })
            },

        },

    }
</script>
