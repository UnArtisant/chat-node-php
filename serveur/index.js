const app = require('express')();
const server = require('http').createServer(app);
const io = require('socket.io')(server);

require('dotenv').config();

const PORT = process.env.PORT || 8080

io.on('connection', (socket) => {
    console.log('a user connected');
});

app.get('/', (req, res) => {
    res.send('<h1>Hello world</h1>');
});

server.listen(PORT, () => {
    console.log(`server running at port ${PORT}`);
});