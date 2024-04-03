// /**
//  * We'll load the axios HTTP library which allows us to easily issue requests
//  * to our Laravel back-end. This library automatically handles sending the
//  * CSRF token as a header based on the value of the "XSRF" token cookie.
//  */

// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// /**
//  * Echo exposes an expressive API for subscribing to channels and listening
//  * for events that are broadcast by Laravel. Echo and event broadcasting
//  * allows your team to easily build robust real-time web applications.
//  */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;


// const options = {
//     broadcaster: 'pusher',
//     key: 'your-pusher-channels-key'
// }
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
//     client: new Pusher()
// });

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Importing Laravel Echo and Socket.io client
import Echo from 'laravel-echo';
import io from 'socket.io-client';

// // Assuming you have set SOCKET_IO_HOST and SOCKET_IO_PORT in your .env file
// // and have used Vite's import.meta.env to access them in your frontend code
const options = {
    broadcaster: 'socket.io',
    host: 'https://dartscars:6001',//`${import.meta.env.VITE_SOCKET_IO_HOST}:${import.meta.env.VITE_SOCKET_IO_PORT}`, // Example: 'http://localhost:6001'
    client: io
};

window.Echo = new Echo(options);


// import Echo from 'laravel-echo';
// import io from 'socket.io-client';

// window.io = require('socket.io-client');

// Assuming SOCKET_IO_SERVER is the URL of your Socket.io server
// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: window.location.hostname + ':6001' // Adjust the port as needed
// });
