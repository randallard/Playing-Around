upstream socket_nodes {
    server get-receiver.com:3001;
}

server {
	server_name get-receiver get-receiver.com;

	location / {
	        proxy_set_header Upgrade $http_upgrade;
        	proxy_set_header Connection "upgrade";
        	proxy_http_version 1.1;
	        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
	        proxy_set_header Host $host;
	        proxy_pass http://socket_nodes;
	}
}
