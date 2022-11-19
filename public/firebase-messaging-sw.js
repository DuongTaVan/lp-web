// eslint-disable-next-line no-undef
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js");
// eslint-disable-next-line no-undef
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js");
// eslint-disable-next-line no-undef
importScripts("https://www.gstatic.com/firebasejs/8.6.1/firebase-analytics.js");

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
    apiKey: "AIzaSyCz_EnX4F1fV0Iuj8RGf_Ln5Jbezkop1a4",
    authDomain: "lappi-a45a0.firebaseapp.com",
    projectId: "lappi-a45a0",
    storageBucket: "lappi-a45a0.appspot.com",
    messagingSenderId: "847052068112",
    appId: "1:847052068112:web:6d1c5a7f46560479cb4195"
};
// Initialize Firebase
// eslint-disable-next-line no-undef
firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);

    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };

    return self.registration.showNotification(
        title,
        options,
    );
});

self.addEventListener("notificationclick", function(event) {
    event.notification.close();
    if (event.notification.data.click_action)
        self.clients.openWindow(event.notification.data.click_action);
});

self.addEventListener("push", function(event) {
    let data = {};
    if (event.data) {
        data = event.data.json();
    }
    const title = data.notification.title;
    const options = {
        body: data.notification.body,
        data: data.data
    };

    event.waitUntil(self.registration.showNotification(title, options));
});
