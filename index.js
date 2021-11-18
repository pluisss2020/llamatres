const path=require('path');
const express = require('express');
const app = express();

app.set('port', process.env.PORT || 3040);


app.use(express.static(path.join(__dirname, 'public')))

const server= app.listen(app.get('port'), () =>{
    console.log('server on port', app.get('port'));
}
);

const socketio= require('socket.io');

const io=socketio(server);

io.on('connection',()=>{
    console.log('new connection',socket.io);

    socket.on('chat:message', (data) =>{
        io.sockets.emit('chat:message', data);
    });
})
;

