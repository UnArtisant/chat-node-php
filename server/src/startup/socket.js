const chat = require('../sockets/chat')

function start() {
    chat.init()
}

module.exports = {start}