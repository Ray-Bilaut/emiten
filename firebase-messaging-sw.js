// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.2.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object


self.addEventListener('notificationclick', function(event) {
    var json = JSON.parse(event.notification.data.fcm_msg.data.notification);
    let url = json.url;
    event.notification.close();
    event.waitUntil(
        clients.matchAll({type: 'window'}).then( windowClients => {
            // Check if there is already a window/tab open with the target URL
            for (var i = 0; i < windowClients.length; i++) {
                var client = windowClients[i];
                // If so, just focus it.
                if (client.url === url && 'focus' in client) {
                    return client.focus();
                }
            }
            // If not, then open the target URL in a new window/tab.
            if (clients.openWindow) {
                return clients.openWindow(url);
            }
        })
    );
    console.log(
        "ini notif",
        event
    );
});


var locationHref = self.location.origin;

if (locationHref.includes('localhost') || locationHref.includes('serantang.online')) {
    console.log("dev location");
    firebase.initializeApp({
        apiKey: "AIzaSyA2w6BSGFK4sohQ8vLzUWlxBib6LsOUT4U",
        authDomain: "emiten-web.firebaseapp.com",
        projectId: "emiten-web",
        storageBucket: "emiten-web.appspot.com",
        messagingSenderId: "310041727572",
        appId: "1:310041727572:web:b293a1af7ac87a130fd3c1",
        measurementId: "G-4JY0HNNLTM"
      });
} else {
    console.log("prod loc");
    firebase.initializeApp({
        apiKey: "AIzaSyD6hhE_u1KoaQKRu8opAXTrbag6beqW9M8",
        authDomain: "emiten-news.firebaseapp.com",
        projectId: "emiten-news",
        storageBucket: "emiten-news.appspot.com",
        messagingSenderId: "846015694748",
        appId: "1:846015694748:web:7997d4b531d83a1f37ea59",
        measurementId: "G-FB36XXPK2E"
      });
}

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background messagess ",
        payload,
    );

    var json = JSON.parse(payload.data.notification);

    // Customize notification here
    const notificationTitle = json.title;
    const notificationOptions = {
        body: json.body,
        icon: json.icon,
        image: json.icon,
        data: {
            url: json.url
        }
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});