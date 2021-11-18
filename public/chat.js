const socket=io()


let message=document.getElementById('message');
let username=document.getElementById('username');
let btn=document.getElementById('send');
let output=document.getElementById('output');
let actions=document.getElementById('actions');

btn.addEventListener('click', function(){
    socket.emit('chat:message',{
        message: message.ariaValueMax,
        username: username.value
    });
});
socket.on('chat:message',function(data){
    output.innerHTML +=`<p>
    <strong>${data.username}</strong>
    </p>`
});