import firebase from "./firebase";

const messaging = firebase.messaging;

function initFirebaseMessagingRegistration() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            console.log(token);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/firebase-save-token',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    alert('Token saved successfully.');
                },
                error: function (err) {
                    console.log('User Chat Token Error'+ err);
                },
            });

        }).catch(function (err) {
        console.log('User Chat Token Error'+ err);
    });
}

messaging.onMessage(payload => {
    console.log("Message received. ", payload);
    // ...
});

// initFirebaseMessagingRegistration();