<template>
    <q-card class="q-ma-lg">
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
    <h4>Générer un lot d'images</h4>
    <q-card class="">
        <div class="col-md-8">
            <div class="card">
                <AlertError v-if="error != null">{{error}}</AlertError>
                <q-form @submit.prevent="submitRequest">
                    <q-input label="Nombre à générer" required v-model.number="quantity"></q-input>
                    <q-btn type="submit" color="primary">Générer</q-btn>
                </q-form>
            </div>
        </div>
    </q-card>
    <q-btn @click="renderImages">Render images</q-btn>



    <div ref="images">
        <template v-if="badges.length > 0">
            <div :key="index" v-for="(badge,index) in badges" :ref="'qr_code_'+index" class="q-card bg-primary row full-width  " style="height: 300px; border-radius: 2%">
                <div class="col-12 text-center q-pt-lg"><span class="title-medium text-white">Badge Prizent</span></div>
                <div class="col-5 text-center q-pt-lg">
                    <div class="flex flex-center text-white"><img class="col-4"
                                                                  alt="Prizent logo"
                                                                  src="../../../public/logo-prizent-round.png"
                                                                  style="width: 100px; height: 100px"
                    />
                    </div>
                    <br>
                    <h6 class="text-white" style="display: inline">{{badge.number}}</h6>
                    <br>
                </div>
                <div class="col-5  flex flex-center q-pa-md bg-white q-ma-lg " style="border-radius: 20px">
                    <q-img style="max-height: 150px; max-width: 150px" class=" q-pa-lg rounded-borders"
                           :src="badge.qr_code"
                    />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import {Loading} from "quasar";
import Swal from "sweetalert2";
import AlertError from "./AlertError.vue";
import html2canvas from "html2canvas";
import QRCode from "qrcode";

export default {
    name: "GenerateBadge",
    components: {AlertError},
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            qrCodeUrl: "",
            badge_numbers:[11112,11113,11114,11115],
            error: null,
            quantity: 0,
            badges:[],
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
        },
        save(element) {

            const options = {
                type: "dataURL",
            };
            html2canvas(element, options).then(canvas=>{
                // const link = document.createElement("a");
               return  canvas
                    .toDataURL("image/png")

                /* link.setAttribute("download", "badge_"+this.employe.fullName +".png");
                 link.setAttribute(
                     "href",
                     canvas
                         .toDataURL("image/png")
                         .replace("image/png", "image/octet-stream")
                 );*/
                // link.click();
            });


        },
        renderImages(){
            let imagesContainer = this.$refs.images
            let tempArray = [];
            for (let i = 0; i < this.badge_numbers.length; i++) {
                let number = this.badge_numbers[i];
                this.renderQrCode(String(number)).then(value=>{

                   let badge = {number: number, qr_code: value}
                    tempArray.push(badge)
                })
            }
            this.badges = tempArray
        },
        renderQrCode(value){
            return new Promise((resolve,reject)=>{
                QRCode.toDataURL(value, { errorCorrectionLevel: 'L' },  (err, url) =>{
                    if (err) throw  err
                    resolve(url)
                    // this.$refs.qrcode.src = url
                })

            })

        }
    }
}
</script>
