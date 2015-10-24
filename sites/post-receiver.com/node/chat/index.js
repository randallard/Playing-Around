var http = require('http');

http.createServer(function (req, res) {
  if (req.method == 'POST') { 
    req.on('data', function(chunk) { 
      console.log(chunk.toString()); 
    }); 
  } else { 
    console.log(req.url); 
  } 
  res.writeHead(200);
  res.end('connected to post-receiver.com');
}).listen(3002, function(){
        console.log('listening for post-receiver.com on port 3002');
});
