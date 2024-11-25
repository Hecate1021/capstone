// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// // Request permission for notifications
// if (Notification.permission !== "granted") {
//     Notification.requestPermission();
// }

// // Listen for new messages on the chat channel
// const userId = window.authUserId; // Ensure this is set to the authenticated user's ID

// window.Echo.private(`chat-channel.${userId}`)
//     .listen('MessageSendEvent', (e) => {
//         console.log("Received event: ", e);
//         console.log(`Current User ID: ${userId}`);

//         // Check if the receiver ID matches the user ID
//         if (Notification.permission === "granted" && String(e.message.receiver_id) === String(userId)) {
//             console.log("Displaying notification...");
//             new Notification(`New message from ${e.sender}`, {
//                 body: e.message.message,
//                 icon: '/path/to/icon.png' // Ensure this path is correct
//             });
//         } else {
//             console.warn("Notification permission denied or receiver ID does not match.");
//         }

//         // Emit Livewire event to update the UI if necessary
//         Livewire.emit('newMessageReceived', e.message);
//     });
import Push from 'push.js';
