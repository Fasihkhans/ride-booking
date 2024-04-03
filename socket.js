import express from 'express';
import http from 'http';
import https from 'https';
import { readFileSync } from 'fs';
import { Server } from 'socket.io';
import Redis from 'ioredis';
import cors from 'cors';



const privateKey = readFileSync('/etc/letsencrypt/live/dartscars.com/privkey.pem', 'utf8');
const certificate = readFileSync('/etc/letsencrypt/live/dartscars.com/fullchain.pem', 'utf8');
const credentials = { key: privateKey, cert: certificate };

const app = express();
const httpServer = http.createServer(app);
const httpsServer = https.createServer(credentials, app);

const io = new Server();
// const io = new Server(server, {
//     cors: {
//         origin: process.env.CORS_ORIGIN || "*", // Use environment variable or allow all origins
//         methods: ["GET", "POST"]
//     },
//     pingTimeout: 30000,
//     pingInterval: 30000
// });

io.attach(httpServer, {
    cors: {
        origin: process.env.CORS_ORIGIN || "*", // Use environment variable or allow all origins
        methods: ["GET", "POST"]
    }
});
io.attach(httpsServer, {
    cors: {
        origin: process.env.CORS_ORIGIN || "*", // Use environment variable or allow all origins
        methods: ["GET", "POST"]
    }
});
app.use(cors());

// -------------Redis ---------------/
const redis = new Redis({
      host: '127.0.0.1',
      port: 3001,
      password: process.env.REDIS_PASSWORD || null, // Change to your Redis password
    });

io.on('connection', (Server) => {
  console.log('A user connected');

    Server.on('message', (msg) => {
        // Broadcast message to all connected clients via Redis
        // redis.publish('new-message--', JSON.stringify({ message: msg }));
            console.log("new message ---:" ,msg);
            Server.broadcast.emit('message', { msg });
    });
    Server.on('drivers', (dati) => {
        let data = JSON.parse(dati);
        Server.broadcast.emit('driver-location.'+data.driverId, { data });
    });



    redis.psubscribe('*');
    redis.on('pmessage', (pattern, channel, message) => {
        console.log("pattern:",pattern,"channel:", channel,"message:", message)
        Server.emit('redis_message', { channel, message });
        let channelName = channel;
        let parts = channelName.split(".");
        if(parts[0]=='dartscars_database_booking'){
            let jsonData = JSON.parse(message);
            let bookingData = jsonData.data.data;
            Server.emit('booking.'+parts[1], { bookingData });

        }

        if(parts[0]=='dartscars_database_private-driver-booking'){
            let jsonData = JSON.parse(message);
            let bookingData = jsonData.data;
            Server.emit('driver-booking.'+parts[1], { bookingData });
        }

    });


  // Event listeners for socket communication
  Server.on('disconnect', () => {
         console.log('User disconnected');
        });
    });

redis.on('connect', () => {
  console.log('Connected to Redis');
});

httpServer.listen(6001, () => {
  console.log('Socket.IO server running on port 6001');
});

httpsServer.listen(8443, () => {
    console.log('HTTPS server running on port 8443');
});



