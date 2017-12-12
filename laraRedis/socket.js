var http = require('http').Server();

var io = require('socket.io')(http);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('private-test-channel');

redis.on('message', function(channel, message) {
	message = JSON.parse(message);

    io.emit(channel + ':' + message.event, message.data);
    // test-channel:UserSignedUp
});

http.listen(3000);
