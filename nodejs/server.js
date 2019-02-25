var io = require('socket.io').listen(8888);
console.log("시작됨");
io.sockets.on('connection', function (socket){
    socket.on('msgIn',function(msg){
        console.log('Msg In : ',msg);
        io.emit("hello", msg);
    });
    socket.on('disconnect', function(){
        console.log('NOT USER DISCONNECT : ', socket.id);
    });
});
/*
* debug
* Msg In : [ 'data1', 'data2' ]
* NOT USER DISCONNECT : NPmXDQpuVM9OFYl0AAAA
*/
