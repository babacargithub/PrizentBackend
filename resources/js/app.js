/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

import { Quasar } from 'quasar'
import { Dialog } from 'quasar'
import { Loading } from 'quasar'

// Import icon libraries
import '@quasar/extras/roboto-font-latin-ext/roboto-font-latin-ext.css'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import '@quasar/extras/material-icons-round/material-icons-round.css'
import '@quasar/extras/material-icons-sharp/material-icons-sharp.css'

// A few examples for animations from Animate.css:
// import @quasar/extras/animate/fadeIn.css
// import @quasar/extras/animate/fadeOut.css

// Import Quasar css
import 'quasar/src/css/index.sass'

// Assumes your root component is App.vue
// and placed in same folder as main.js


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import BadgesIndex from './components/BadgesIndex.vue';
import GenerateQrCode from './components/GenerateQRCodeBatch.vue';
import QRCodesIndex from './components/QrCodeIndex.vue';
import GenerateBadge from './components/GenerateBatch.vue';
import Swal from "sweetalert2";
app.component('badges-index', BadgesIndex);
app.component('qr-codes-index', QRCodesIndex);
app.component('generate-badge', GenerateBadge);
app.component('generate-qrcode', GenerateQrCode);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.mixin({
    methods: {
        showAlertSuccess(message, onClose){
            Swal.fire({
                icon: "success",
                text: message
            }).then(value=>{
                if (typeof onClose === "function"){
                    onClose()
                }
            })
        },
        showAlertError(message, onClose){
            Swal.fire({
                icon: "error",
                text: message
            }).then(value=>{
                if (typeof onClose === "function"){
                    onClose()
                }
            })
        },
        showLoading(){
            Loading.show({
                message: "Chargement",
                spinnerColor: "green",
            })
        } , hideLoading(){
            Loading.hide()
        }
    }
})
app
.use(Quasar, {
    plugins: {Loading, Dialog}, // import Quasar plugins and add here
}).mount('#app');
