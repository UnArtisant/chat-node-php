const {io} = require('../startup/server')

const init = () => {

  io.on('connection', (socket) => {
    console.log('a user connected');
  });

}

module.exports = {init}