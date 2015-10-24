'use strict';

var redis = require('redis'),
    client = redis.createClient(6379, 'localhost',{no_ready_check: true});

client.on('connect', function() {
    console.log('connected to redis on ' + client.host + ':' + client.port);
});
client.on('error', function (err) {
    console.log('error event - ' + client.host + ':' + client.port + ' - ' + err);
});

client.rpush('postbackQueue','test',redis.print);
client.blpop('postbackQueue',0,redis.print);
client.lrange('postbackQueue',0,-1,redis.print);

client.set('string key', 'string val', redis.print);
client.hset('hash key', 'hashtest 1', 'some value', redis.print);
client.hset(['hash key', 'hashtest 2', 'some other value'], redis.print);
client.hkeys('hash key', function (err, replies) {
    if (err) {
        return console.error('error response - ' + err);
    }

    console.log(replies.length + ' replies:');
    replies.forEach(function (reply, i) {
        console.log('    ' + i + ': ' + reply);
    });
});

client.quit(function (err, res) {
    console.log('Exiting from quit command.');
});
/*
var request = require("request")
  , redis = require("redis")
  , client = redis.createClient();

client.on('connect', function() {
    console.log('connected to redis on ' + client.host + ':' + client.port);
});

client.on('error', function (err) {
    console.log('error event - ' + client.host + ':' + client.port + ' - ' + err);
});

getData();

function getData() {
  client.blpop('postbackQueue', 0, function(err, data) {
//    postbackData = data[0];
     postbackData = JSON.parse(data);
     console.log('got postbackData:'+postbackData);
//    if (postbackData.method == "POST") {
      request({
        uri: postbackData.url,
        method: postbackData.method,
  	form: postbackData.data,
        timeout: 10000,
        followRedirect: true,
        maxRedirects: 10
      }, function(error, response, body) {
        console.log(body);
      });    
//    }  
  });
  process.nextTick(getData);
}
*/
