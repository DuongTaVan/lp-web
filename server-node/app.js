import { readFileSync } from "fs";
import { createServer as httpServer } from "http";
import { createServer as httpsServer } from "https";
import { Server } from "socket.io";
import Imap from 'imap';

import * as dotenv from 'dotenv';
import redis from "redis";
dotenv.config();

let imapConnected = false;
const timeInterVal = 10000; // ms
let fnInterVal = null;
let imap = null;
const imapHost = process.env.IMAP_HOST || '';
const imapPort = process.env.IMAP_PORT || '';
const imapUserName = process.env.IMAP_USERNAME || '';
const imapPassword = process.env.IMAP_PASSWORD || '';

const server = process.env.PRODUCT ? httpServer() :
httpsServer({
    key: readFileSync(process.env.FILE_KEY),
    cert: readFileSync(process.env.FILE_CERT)
});

const option = {
    cors: {
        origin: process.env.ORIGIN,
        methods: ["GET", "POST"]
    }
};

const io = new Server(server, option);
const port = process.env.PORT || 3000;

io.on('connection', async function (socket) {
    const redisClient = redis.createClient();

    await redisClient.connect();

    await redisClient.subscribe('realtime', (message) => {
        socket.emit('message', message);
    });

    // verify admin
    socket.on('verify', async (data) => {
        socket.data.role = 'ADMIN';
        await countAdminOnline();
    });

    // join special room
    socket.on('join-room', async (arg) => {
        if (!arg.room || !arg.role) {
            return;
        }
        socket.data = arg;
        socket.join(arg.room);
        await countUserInRoom(arg.room)
    });

    socket.on('send-gift', (obj) => {
        const roomId = socket.data.room;
        if (!roomId) {
            return;
        }
        io.in(roomId).emit('fetch-data', {data: obj, type: 'SEND_GIFT'});
    })

    socket.on('disconnect', function () {
        redisClient.quit();
        if (socket.data && socket.data.room) {
            countUserInRoom(socket.data.room);
        }
        if (socket.data.role === 'ADMIN') {
            countAdminOnline();
        }
    });
});

server.listen(port, () =>
    console.log('Server is running: ' + port)
);

const countUserInRoom = async function (roomId) {
    await io
        .in(roomId)
        .fetchSockets()
        .then(data => {
            const count = data.filter(item => item.data.role === 'AUDIENCE').length;
            io.in(roomId).emit('fetch-data', {data: count ? count : 0, type: 'COUNT_USER'});
        });
}

const countAdminOnline = async function () {
    await io
        .fetchSockets()
        .then(data => {
            const count = data.filter(item => item.data.role === 'ADMIN').length;
            if (!count) {
                clearInterval(fnInterVal);
                imap.destroy();
                imap = null;
            }
            if (!imapConnected) {
                initImap();
            }
        });
}

// count unread gmail
const initImap = () => {
    if (!imap) {
        imap = new Imap({
            user: imapUserName,
            password: imapPassword,
            host: imapHost,
            port: imapPort,
            tls: true,
            tlsOptions: {rejectUnauthorized: false}
        });

        imap.once('ready', function () {
            imapConnected = true;
            getEmailUnread();
            fnInterVal = setInterval(function () {
                getEmailUnread();
            }, timeInterVal);
        });

        imap.once('end', function () {
            imapConnected = false;
        });

        imap.connect();
    }
}

const getEmailUnread = () => {
    openInbox(function (err, box) {
        io.emit('new-email-unseen', box.messages);
    });
}

function openInbox(cb) {
    imap.status('INBOX', cb);
}
