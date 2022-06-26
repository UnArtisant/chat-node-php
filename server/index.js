require('dotenv').config();
const express = require("express")
const routes = require('./src/startup/routes');
const sockets = require('./src/startup/socket')
const {app, server} = require("./src/startup/server")

//middleware
app.use(express.json());

//routes
app.use("/", routes)

//initialize sockets
sockets.start()

const PORT = process.env.PORT || 8080

server.listen(PORT, () => {
    console.log(`server running at port ${PORT}`);
});