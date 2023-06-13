<template>
    <div class="card">
        <div class="card-body row">
            <div class="card-header"><h4>Générer un lot de Qr Code</h4></div>
            <AlertError v-if="error != null">{{error}}</AlertError>
            <form  @submit.prevent="submitRequest">
                <div class="form-group col-sm-12 required" element="div" bp-field-wrapper="true" bp-field-name="name"
                     bp-field-type="text">
                    <label>Nombre à générer</label>
                    <input type="text" name="quantity"  class="form-control" v-model.number="quantity">
                    <label>Type de QR code à générer</label>

                    <input type="text" name="type"  class="form-control" v-model.number="type">
                    <input type="submit" value="Valider" class="btn btn-success"/>
                </div>
            </form>
<!--
            <q-card class="q-ma-lg">
                <div class="col-md-8">
                    <div class="card">
                        <q-form @submit.prevent="submitRequest">
                            <q-input label="Nombre à générer" required v-model.number="quantity"></q-input>
                            <q-btn type="submit" color="primary">Générer</q-btn>
                        </q-form>
                    </div>
                </div>
            </q-card>


-->







        </div>
    </div>

 <div class="card">
        <div class="card-body row">
            <h4>Générer un lot d'images de QR Code</h4>

            <div class="card-header">Générer un lot d'images de badges à imprimer</div>
            <AlertError v-if="error != null">{{error}}</AlertError>
            <form  @submit.prevent="getUnusedBadges(unUsedQuantity)">
                <div class="form-group col-sm-12 required" >
                    <label>Nombre à générer</label>
                    <input type="number" name="unUsedQuantity"  class="form-control" v-model.number="unUsedQuantity">
                    <label>Type de QR Code</label>
                    <input type="number" name="type"  class="form-control" v-model.number="type">
                    <input type="submit" value="Valider" class="btn btn-success"/>
                </div>
            </form>

<!--            <q-card class="">
                <div class="col-md-8">
                    <div class="card">
                        <AlertError v-if="error != null">{{error}}</AlertError>
                        <q-form @submit.prevent="getUnusedBadges(unUsedQuantity)">
                            <q-input label="Nombre à générer" required v-model.number="unUsedQuantity"></q-input>
                            <q-btn type="submit" color="primary">Générer images</q-btn>
                        </q-form>
                    </div>
                </div>
            </q-card>-->
<!--            <q-btn @click="renderImages">Render images</q-btn>-->
            <button class="btn btn-danger col-md-2 col-sm-12" @click="save">Zip les images</button>

            <div ref="images" class="q-gutter-lg">
                <template v-if="badges.length > 0">
                    <div :key="index" v-for="(badge,index) in badges" :ref="'qr_code_'+index" :id="'qr_code_'+index" class="q-card  row full-width  " style="min-height: 700px; background-image: linear-gradient(
    45deg,
    #04673FFF,
    #039a5c 20px,
    #039a5c 40px,
    #04673FFF 20px
  );">
                        <div class="col-12 text-center q-pt-lg">
                            <div class="flex flex-center  text-white" >
                                <img class=""
                                     alt="Prizent logo"
                                     src="data:image/png;base64,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"
                                     style="width: 150px; height: 150px"
                                />
                              </div><br>
                            <h3 class="text-white" style="display: inline; font-weight: bold">QR CODE PRIZENT</h3>
                            <br>
                            <br>
                            <span class="text-white text-bold text-center" style="display: inline; font-size: 28px">Scanner pour pointer</span><br>
                            <h6 class="text-white text-center" style="display: inline">{{badge.type == 1 ?"QR Code d'entrée": "QR Code de sortie"}}</h6>
                        </div>
                        <br>

                        <div class="col-10 offset-1 flex flex-center  q-mb-lg " >
                            <q-img ref="qrcode" class="rounded-borders" style="border-radius: 10%"
                                    :src="badge.qr_code"
                            />
                        </div>
                        <div class="col-4 offset-4 text-center bg-white q-mb-lg text-bold">{{badge.number}}</div>
                    </div>

                </template>
            </div>


        </div>
    </div>

</template>

<script>
import {Loading} from "quasar";
import Swal from "sweetalert2";
import AlertError from "./AlertError.vue";
import html2canvas from "html2canvas";
import QRCode from "qrcode";
import JSZip from "jszip";
import { saveAs } from 'file-saver';
export default {
    name: "GenerateBadge",
    components: {AlertError},
    mounted() {
        console.log('Qr code generate Component mounted.')
    },
    data() {
        return {
            qrCodeUrl: "",
            unUsedQuantity: 0,
            badge_numbers:[],
            error: null,
            quantity: 0,
            type: 0,
            badges:[],
        }
    },
    methods:{
        submitRequest(){
            Loading.show({message: "Chargement"})
            this.error = null
            window.axios.post("generate", {quantity:this.quantity, type: this.type})
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
        save() {
            let promises = [];
            for(let i = 0; i < this.badges.length; i++) {
                let badge_number = this.badges[i].number
                let element = document.getElementById('qr_code_'+i);
                const options = {
                    type: "dataURL",
                };

                promises.push( html2canvas(element, options))

            }
            Promise.allSettled(promises).then(results=>{
                console.log("badge_"+(this.badges[0].number??'')+".png")
                let zip = new JSZip();
                let img = zip.folder("images");
                for (let i = 0; i < results.length; i++) {
                 let imgData = results[i].value.toDataURL("image/png").replace("data:image/png;base64,", "");

                img.file("badge-"+i+".png", imgData, {base64: true});

               }

                zip.generateAsync({type:"blob"})
                    .then(function(content) {
                        // see FileSaver.js
                        saveAs(content, "example.zip");
                    });


               /* html2canvas(element, options).then(canvas => {
                    // const link = document.createElement("a");
                    let fileContent = canvas
                        .toDataURL("image/png").replace("data:image/png;base64,", "")
                    zipImages(fileContent, "badge_"+badge_number+".png");
                });*/
            })


        },
        renderImages(){
            let tempArray = [];
            for (let i = 0; i < this.badge_numbers.length; i++) {
                let number = this.badge_numbers[i];
                this.renderQrCode(String(number)).then(value=>{

                   let badge = {number: number, qr_code: value, type: this.type}
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

        },
        getUnusedBadges(quantity){

            this.error = null
            window.axios.get("unused_qr_codes/"+quantity)
                .then(r => {
                    this.badge_numbers = r.data
                    this.renderImages();
                }).catch(e => {
                console.log(e)
            })
        }

    }
}
</script>
