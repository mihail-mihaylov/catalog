var socketIoApp = require('express')();
var http = require('http').Server(socketIoApp);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('enacted-channel', function(err, count) {});

io.sockets.on('connection', function(socket) {
    socket.on('room', function(room) {
        socket.join(room);
        console.log(room);
    });
});

redis.on('message', function(channel, message) {
    console.log('Message Recieved: ' + message);
    message = JSON.parse(message);

    // Loop all users and send message to their room
    for (var x in message.data.information.users_ids) {
        // Configure room name
        var room = channel + '-' + message.data.information.users_ids[x];
        // Send message to the room
        io.sockets.in(room).emit('message', {
                type: message.data.information.type,
                date_time: message.data.information.date_time
            });
    }
});

http.listen(3000, function(){
    console.log('Listening on Port 3000');
});


//# sourceMappingURL=socket.js.map
