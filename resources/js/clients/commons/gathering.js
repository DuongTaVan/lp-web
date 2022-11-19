import firebase from "firebase";

let userFirebase = null;

firebase.auth().onAuthStateChanged(user => {
    if (user) {
        userFirebase = user;
    }
});

const Gathering = (function () {

    let randomName = function () {
        return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5);
    };

    function Gathering(databaseReference, courseScheduleId) {

        this.db = databaseReference;
        this.roomName = courseScheduleId || 'global';

        this.room = this.db.ref("live-streams/" + this.roomName);
        this.myName = '';
        this.user = null;
        this.userMinute = null;
        this.userOptions = null;
        this.userGift = null;

        this.join = function (role, displayName) {
            if (this.user) {
                return false;
            }

            this.myName = displayName || randomName();
            // this.user = uid ? this.room.child(uid) : this.room.push();
            this.user = this.room.child(userFirebase.uid);

            // Add user to presence list when online.
            this.db.ref(".info/connected")
                .on("value", (snap) => {
                    if (!snap.val()) {
                        return;
                    }
                    this.user.set({
                        displayName: this.myName,
                        role: role,
                    });
                    if (role === 'TEACHER') {
                        this.user.onDisconnect().set({
                            lastOnline: firebase.database.ServerValue.TIMESTAMP
                        });
                    } else {
                        this.user.onDisconnect().remove();
                    }
                });

            return this.myName;
        };

        this.purchaseExtendSuccess = function (data) {
            this.userMinute = this.room.child('PURCHASE_OPTION-SUCCESS');
            this.db.ref(".info/connected")
                .on("value", (snap) => {
                    if (!snap.val()) {
                        return;
                    }
                    this.userMinute.set(data);
                    this.userMinute.onDisconnect().remove();
                    this.clearAddMinute();
                });
        }

        // this.addOptionPurchased = function (optionIds) {
        //     this.userOptions = this.room.child('PURCHASED-OPTION');
        //     this.db.ref(".info/connected")
        //         .on("value", (snap) => {
        //             if (!snap.val()) {
        //                 return;
        //             }
        //             this.userOptions.set(optionIds);
        //             this.userOptions.onDisconnect().remove();
        //             this.clearPurchasedOption();
        //         });
        // }

        this.addGift = function (giftId, user) {
            this.userGift = this.room.child('PURCHASED-GIFT');
            this.db.ref(".info/connected")
                .on("value", (snap) => {
                    if (!snap.val()) {
                        return;
                    }
                    this.userGift.set({giftId: giftId, user: user});
                    this.userGift.onDisconnect().remove();
                    this.clearPurchasedGift();
                });
        }

        this.clearAddMinute = function () {
            setTimeout(() => {
                this.userMinute.remove();
            }, 100);
        }

        this.clearPurchasedOption = function () {
            setTimeout(() => {
                this.userOptions.remove();
            }, 100);
        }

        this.clearPurchasedGift = function () {
            setTimeout(() => {
                this.userGift.remove();
            }, 100);
        }

        this.leave = function () {
            if (this.user) {
                this.user.remove();
            }
            if (this.userGift) {
                this.userGift.remove();
            }
            if (this.userMinute) {
                this.userMinute.remove();
            }
            if (this.userOptions) {
                this.userOptions.remove();
            }
            this.myName = '';
            this.over();
        };

        this.over = function () {
            this.room.remove();
        };

        this.onUpdated = function (callback) {
            if ('function' == typeof callback) {
                this.room.on("value", function (snap) {
                    callback(snap.numChildren() - 1, snap.val());
                });
            } else {
                console.error('You have to pass a callback function to onUpdated(). That function will be called (with user count and hash of users as param) every time the user list changed.');
            }
        };
    }

    return Gathering;
})();

export default Gathering;
