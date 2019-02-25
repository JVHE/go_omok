<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
<script>
    var socket= io.connect("http://192.168.122.138:8888");

    socket.on("hello", function (data) {
        alert(data);
    })
</script>