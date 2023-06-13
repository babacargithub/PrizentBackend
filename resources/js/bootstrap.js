import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import {Loading, Notify} from "quasar";
let requestsPending = 0;

const req = {
    pending: () => {
        requestsPending++;
        Loading.show({
            message: 'Chargement....',
            // boxClass: 'bg-grey-2 text-grey-9',
            spinnerColor: 'primary'
        })

    },
    done: () => {
        requestsPending--;
        if (requestsPending <= 0) {
            Loading.hide()
        }
    }
};
axios.interceptors.request.use(
    config => {
        if (typeof config.shouldNotShowLoadingIndicator === 'undefined' &&  !config.shouldNotShowLoadingIndicator){
            req.pending();
        }

        return config;
    },
    error => {
        requestsPending--;
        req.done();
        return Promise.reject(error);
    }
);
axios.interceptors.response.use(
    (response) => {
        req.done();
        return Promise.resolve(response);
    },
    error => {
        req.done();
        if(error.response.status === 500) {
            Notify.create({
                message: `Une erreur s'est produite au niveau du serveur, la requête n'a pas abouti`,
                icon: "error",
                color: 'red',
                position:"center",
                textColor: "white",
                timeout: 1500
            })

        }

        return Promise.reject(error.response);
    }
);
window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
