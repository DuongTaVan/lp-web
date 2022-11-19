import firebase from "firebase";
import "firebase/firebase-messaging";

const firebaseConfig = {
    apiKey: process.env.MIX_FIREBASE_API_KEY,
    databaseURL: process.env.MIX_FIREBASE_DATABASE_URL,
    authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
    projectId: process.env.MIX_FIREBASE_PROJECT_ID,
    storageBucket: process.env.MIX_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
    appId: process.env.MIX_FIREBASE_APP_ID
};

const firebaseApp = firebase.initializeApp(firebaseConfig);
// const email = process.env.MIX_FIREBASE_USER_EMAIL;
// const password = process.env.MIX_FIREBASE_USER_PASSWORD;

// if (email && password) {
//     firebaseApp.auth().signInWithEmailAndPassword(email, password)
//         .then(() => {
//             // Signed in..
//         })
//         .catch((error) => {
//             let errorCode = error.code;
//             let errorMessage = error.message;
//             // ...
//         });
// } else {
    firebaseApp.auth().signInAnonymously()
        .then(() => {
            // Signed in..
        })
        .catch((error) => {
            // ...
        });
// }

const db = firebaseApp.firestore();
const database = firebaseApp.database();
const storage = firebaseApp.storage();
let messaging = null;

const userAgentString = navigator.userAgent;
const chromeAgent = userAgentString.indexOf("Chrome") > -1;
let isSafariBrowser = userAgentString.indexOf("Safari") > -1;
if (chromeAgent && isSafariBrowser) {
    isSafariBrowser = false;
}
if (!isSafariBrowser) {
    messaging = firebaseApp.messaging();
    // Handle incoming messages. Called when:
    // - a message is received while the app has focus
    // - the user clicks on an app notification created by a service worker
    //   `messaging.onBackgroundMessage` handler.
}

export default { db, database, messaging, storage };
