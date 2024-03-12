import express from 'express';
import http from 'http';
import { Server } from 'socket.io';
import Redis from 'ioredis';
import cors from 'cors';

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
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
    redis.publish('new-message--', JSON.stringify({ message: msg }));
        console.log("new message ---:" ,msg);
    });
    redis.psubscribe('*');
    redis.on('pmessage', (pattern, channel, message) => {
        console.log("pattern:",pattern,"channel:", channel,"message:", message)
        Server.emit('redis_message', { channel, message });
    });


  // Event listeners for socket communication
  Server.on('disconnect', () => {
    console.log('User disconnected');
    });
    });

redis.on('connect', () => {
  console.log('Connected to Redis');
});

server.listen(6001, () => {
  console.log('Socket.IO server running on port 6001');
});




