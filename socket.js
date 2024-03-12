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

    redis.subscribe('dartscars_database_booking.279'); // Substitute 279 with the appropriate booking ID

    redis.on('message', (channel, message) => {
        console.log('Received message on channel:', channel);
        console.log('Raw message:', message);

        try {
            const event = JSON.parse(message);
            console.log('Parsed event:', event);

            switch (event.type) {
                case 'BookingStatus':
                    console.log('Booking status changed:', event.data);
                    // Handle the event as needed
                    break;
                default:
                    console.log('Unhandled event type:', event.type);
            }
        } catch (error) {
            console.error('Error parsing message:', error);
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

// redis.on('error', (error) => {
//   console.error('Redis error:', error);
// });

redis.subscribe('laravel-events', (err, count) => {
  if (err) {
    console.error('Error subscribing to Redis channel:', err);
  } else {
    console.log('Subscribed to Redis channel');
  }
});
server.listen(3000, () => {
  console.log('Socket.IO server running on port 3000');
});

// const redis = new Redis({
//   host: process.env.REDIS_HOST || 'localhost',
//   port: process.env.REDIS_PORT || 3001,
//   password: process.env.REDIS_PASSWORD || null, // Change to your Redis password
// });


// redis.on('message', (channel, message) => {
//   console.log('Message Received:', message);
//   try {
//     const parsedMessage = JSON.parse(message);
//     io.emit(`${channel}:${parsedMessage.event}`, parsedMessage.data);
//   } catch (error) {
//     console.error('Error parsing message:', error);
//   }
// });

// const PORT = process.env.PORT || 3000;
// server.listen(PORT, () => {
//   console.log(`Server listening on port ${PORT}`);
// });



