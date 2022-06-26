const express = require("express")

const app = express();
const server = require('http').createServer(app);

const io = require('socket.io')(server, {
    cors: {
        origin: "https://localhost:8000",
        methods: ["GET", "POST"],
    }
});

module.exports = {
    io,
    app,
    server
}