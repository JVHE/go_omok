var io = require('socket.io').listen(8888);
var mysql = require('mysql');
console.log("시작됨");
// 디비 연결
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root_',
    password: 'zxc123',
    port: 3306,
    database: 'game'
});
connection.connect();


var color = 'black';


// 서버와 클라이언트가 연결되었을 때
io.sockets.on('connection', function (socket) {

    // 방번호 저장 변수
    var room;
    var name;
    var id;
    // var is_chief;
    // 방번호 입력
    socket.on('joinRoom', function (data) {
        // socket.leave(room);
        // 새로운 채팅방 입장
        room = data.room;
        name = data.name;
        id = data.id;
        // is_chief = data.is_chief;
        socket.join(room);
        console.log('조인', data.room + "번방 입장");
        // var room2 = io.sockets.adapter.rooms[data.room];
        // console.log('이방 접속 인원', room2.length);

        io.to(room).emit("roomIn", data);

        // if (room === -1) {
        //     showRooms();
        // }
    });

    // socket.on('showt', function (data) {
    //     console.log('로그', 'showt들어옴.');
    //     var room2 = io.sockets.adapter.rooms[data.room];
    //     // console.log('이방 접속 인원', room2.length);
    //     var query = "SELECT * FROM room INNER JOIN user WHERE room.chief_id = user.id";
    //     connection.query(query, function (err, rows, fields) {
    //         if (!err)
    //         // console.log('The solution is: ', rows);
    //             console.log('success!! Query is ', query);
    //         else
    //             console.log('Error while performing Query.', err);
    //
    //         //row로 값 다 받아옴. row의 id를 조회 후 사람 수에 따라 다른 결과값을 출력한다.
    //         for (var i = 0; i < rows.length; i++) {
    //             var row = rows[i];
    //             console.log('룸id', row.room_id);
    //             // console.log('data. room ', data.room);
    //             var room3 = io.sockets.adapter.rooms[row.room_id];
    //             if (room3 !== undefined) {
    //                 console.log('이방 접속 인원', room3.length);
    //             }
    //
    //             // if (io.sockets.clients(row.room_id) === 0) {
    //             //     let query = "DELETE FROM room WHERE room_id = " + row.room_id;
    //             //     connection.query(query, function (err, rows, fields) {
    //             //         if (!err)
    //             //         // console.log('The solution is: ', rows);
    //             //             console.log('success!! Query is ', query);
    //             //         else
    //             //             console.log('Error while performing Query.', err);
    //             //     });
    //             // } else if (io.sockets.clients(row.room_id) === 1) {
    //             //     rooms +='<tr class="table-dark" onclick="document.location = \'omok_room?room_id='+row.room_id+'\'"><td>'+row.room_id+'</td><td>'+row.title+'</td><td>'+row.nickname+'</td><td>오목</td><td>1</td><td>대기중</td><tr></tr>';
    //             // // <tr class="table-dark">
    //             // //         <td>1</td>
    //             // //         <td>테스트방제목1</td>
    //             // //         <td>방장1</td>
    //             // //         <td>오목</td>
    //             // //         <td>1</td>
    //             // //         <td>대기중</td>
    //             // //         </tr>
    //             //
    //             // } else {
    //             //
    //             // }
    //
    //         }
    //     });
    //
    // });
    // console.log('숫자',io.sockets.adapter.roomClients[socket.id]);

    // 돌 받기
    socket.on('stoneIn', function (data) {
        // 돌 받은거 로그찍음
        console.log('돌 입력', data.name + "(id: " + data.uid + ")가 " + data.room + "번 방에서 (" + data.row + ", " + data.col + ")에 돌을 두었다.");
        // 디비에 데이터 저장
        var query = "INSERT INTO record_omok VALUES (null, " + data.room + ", " + data.uid + ", " + data.row + ", " + data.col + ", '" + color + "')";
        connection.query(query, function (err, rows, fields) {
            if (!err)
            // console.log('The solution is: ', rows);
                console.log('success!! Query is ', query);
            else
                console.log('Error while performing Query.', err);
        });
        data.color = color;
        data.state = (color === 'black') ? '2' : '1';
        io.to(room).emit("stoneOut", data);
        (color === 'black') ? color = 'white' : color = 'black';
    });
    // 채팅 받기
    socket.on('chatIn', function (data) {
        //채팅 받은거 로그 찍음
        console.log('채팅 입력', data.room + "번 방에 " + data.name + "(id: " + data.uid + ")가 " + data.msg + "를 보냄");
        var query = "INSERT INTO message VALUES (null, " + data.room + ", " + data.uid + ", '" + data.msg + "', NOW(), " + data.type + ", 'tt " + data.whisper + "', " + data.clan + ")";
        connection.query(query, function (err, rows, fields) {
            if (!err)
            // console.log('The solution is: ', rows);
                console.log('success!! Query is ', query);
            else
                console.log('Error while performing Query.', err);
        });
        // if (data.room === -1) {
        io.to(data.room).emit("chatOut", data);
        console.log('룸 확인', data.room + '번 방으로 메세지 보냄');
        // }
    });
    socket.on('disconnect', function () {

        if (room !== -1) {
            var chief_id = -1;
            var query = "SELECT chief_id FROM room WHERE room_id = " + room;
            connection.query(query, function (err, rows, fields) {
                if (!err) {
                    // console.log('The solution is: ', rows);
                    console.log('success!! Query is ', query);
                    var row = rows[0];
                    chief_id = row.chief_id;

                    if (chief_id === id) {
                        var query = "UPDATE room SET chief_id = opponent_id, opponent_id = -1 WHERE room_id = " + room;
                        connection.query(query, function (err, rows, fields) {
                            if (!err)
                            // console.log('The solution is: ', rows);
                                console.log('success!! Query is ', query);
                            else
                                console.log('Error while performing Query.', err);
                        });
                    }
                }
                else
                    console.log('Error while performing Query.', err);

            });

            console.log("chief_id = " + chief_id + " 아이디: " + id);

            // if (chief_id === id) {
            //     var query = "UPDATE room SET chief_id = opponent_id, opponent_id = -1 WHERE room_id = " + room;
            //     connection.query(query, function (err, rows, fields) {
            //         if (!err)
            //         // console.log('The solution is: ', rows);
            //             console.log('success!! Query is ', query);
            //         else
            //             console.log('Error while performing Query.', err);
            //     });
            // }
        }

        console.log('NOT USER DISCONNECT : ', socket.id);
        io.to(room).emit("roomOut", {
            name: name
        })
    });

    // 강퇴하기
    socket.on('kick', function () {
        io.to(room).emit("kick", {
            id: id
        });
    });

    socket.on('ready', function (data) {
        var state = data.state;
        io.to(room).emit("ready", {
            id: id,
            state: state
        })
    });

    // for (room in ) {
    //     console.log('룸체크',room);
    // }
    // console.log('룸들체크',io.sockets.adapter.rooms[room].sockets);

    // // 채팅 메시지, 룸으로(to) 전송
    // socket.on('chatToRoom',function(data){
    //     //채팅 받은거 로그 찍음
    //     console.log('채팅 입력', data.room + "번 방에 " + data.name + "(id: " + data.uid + ")가 " + data.msg + "를 보냄");
    //     io.to(room).emit('chatMessage',chat);
    // });
});
//
// uid: <?=$_SESSION['id'];?>,
// name: <?=$_SESSION['nickname'];?>,
// room: -1,
//     color: color,
//     row: row,
//     col: col

/*
* debug
* Msg In : [ 'data1', 'data2' ]
* NOT USER DISCONNECT : NPmXDQpuVM9OFYl0AAAA
*/

var i = 0, howManyTimes = 100;
var j = 0;

function showRooms() {
    var rooms = "";
    var query = "SELECT * FROM room INNER JOIN user WHERE room.chief_id = user.id";
    connection.query(query, function (err, rows, fields) {
        if (!err) {
            // console.log('The solution is: ', rows);


            // console.log('success!! Query is ', query);


            // console.log('111111111111111111111111');
            //row로 값 다 받아옴. row의 id를 조회 후 사람 수에 따라 다른 결과값을 출력한다.

            // var cnt;
            for (var i in rows) {
                var row = rows[i];
                // console.log('룸id', row.room_id);
                var room = io.sockets.adapter.rooms[row.room_id];
                // console.log('이방 접속 인원', room.length);
                if (room === undefined) {
                    // console.log('66666666666');
                    // let query = "DELETE FROM room WHERE room_id = " + row.room_id;
                    // connection.query(query, function (err, rows, fields) {
                    //     if (!err)
                    //         console.log('success!! Query is ', query);
                    //     else
                    //         console.log('Error while performing Query.', err);
                    // });
                    // console.log('이방 접속 인원000000', room);
                } else if (room.length === 1) {

                    if (row.is_public === 1) {
                        rooms += '<tr class="table-dark" onclick="document.location = \'omok_room.php?room_id=' + row.room_id + '\'"><td>' + row.room_id + '</td><td>' + row.title + '</td><td>' + row.nickname + '</td><td>' + ((row.is_public === 1) ? "공개" : "비공개") + '</td><td>1/2</td><td>대기중</td><tr></tr>';
                    }
                    else {
                        rooms += '<tr class="table-dark" data-toggle="modal" data-backdrop="false" data-target="#pwCheck" onclick="roomPw(' + row.room_id + ')"><td>' + row.room_id + '</td><td>' + row.title + '</td><td>' + row.nickname + '</td><td>' + ((row.is_public === 1) ? "공개" : "비공개") + '</td><td>1/2</td><td>대기중</td><tr></tr>';
                    }

                    console.log('이방 접속 인원111111', room.length);
                } else {

                    rooms += '<tr class="table-dark" ><td>' + row.room_id + '</td><td>' + row.title + '</td><td>' + row.nickname + '</td><td>' + ((row.is_public === 1) ? "공개" : "비공개") + '</td><td>2/2</td><td>준비중</td><tr></tr>';
                    console.log('이방 접속 인원222222', room.length);
                }
                // cnt = i;
            }
            // while (cnt <= 5) {
            //     rooms += '<tr class="table-dark" data-toggle="modal" data-backdrop="false" data-target="#pwCheck" ><td></td><td></td><td></td><td></td><td></td><td></td><tr></tr>';
            //     cnt ++;
            //     console.log('cnt up '.cnt);
            // }

        }

        else {
            console.log('Error while performing Query.', err);
        }
        io.emit("showRooms", {rooms});
        // console.log(rooms);

    });
    if (i < howManyTimes) {
        setTimeout(showRooms, 1000);
        // console.log('j: ', j++);
    }
}

showRooms();