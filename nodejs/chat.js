var http = require('http');
// var bodyParser = require('body-parser');
// app.use(bodyParser.json());
// app.use(bodyParser.urlencoded({extended : true}));
// app.post('/send_email', function(req,res){
//     console.log("email :", req.body.email);
//     res.send("<h1>WELCOME<h1>");
// });
function onRequest(request, response) {
    console.log('요청됨');
    // response.writeHead(200, {'Content-Type' : 'text/plain'});

    response.write('Hello');

    response.end();
}

http.createServer(onRequest).listen(8888);
console.log("서버 시작됨");