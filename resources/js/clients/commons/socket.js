import {io} from "socket.io-client";

const SocketClient = (function () {
    function SocketClient(courseScheduleId) {
        const host = `${process.env.MIX_SOCKET_DOMAIN}:${process.env.MIX_SOCKET_PORT}`;
        let socket = null;
        const room = 'schedule_' + courseScheduleId;

        this.join = function(role) {
            if (socket) {
                return false;
            }
            socket = io(host, { transports: ["websocket"] });

            socket.on("connect", () => {
                console.log(socket.id);
                // join room
                const roomInfo = {
                    role: role, //host or audience
                    room
                };
                setTimeout(function () {
                    socket.emit('join-room', roomInfo);
                }, 100);
            });
        };

        this.addGift = function (giftId, user) {
            if (!socket) {
                return false;
            }
            socket.emit('send-gift', {giftId: giftId, user: user});
        }

        this.onUpdated = function (callback) {
            if ('function' == typeof callback) {
                socket.on('fetch-data', function (data) {
                    callback(data);
                });
            } else {
                console.error('You have to pass a callback function to onUpdated(). That function will be called (with user count and hash of users as param) every time the user list changed.');
            }
        };

        this.leave = function () {
            socket.disconnect();
        };
    }

    return SocketClient;
})();

export default SocketClient;
