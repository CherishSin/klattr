server {
  listen         80;
  server_name    klattr.com;
  rewrite        ^ https://$server_name$request_uri? permanent;
}

server {
  listen	80;
  server_name	www.klattr.com klattr.info klattr.co.uk klattr.net www.klattr.info www.klattr.co.uk www.klattr.net klattr.org www.klattr.org;
  rewrite        ^ https://klattr.com$request_uri? permanent;
}

server {
  listen         443;
  server_name    klattr.com;
  ssl on;

  ssl_certificate      /etc/letsencrypt/live/klattr.com/fullchain.pem;
  ssl_certificate_key  /etc/letsencrypt/live/klattr.com/privkey.pem;
  client_max_body_size 11M;

  root /data/klattr.com/www/ht_docs;

  location = / {
    #Block list
    deny 70.128.119.253;
    deny 201.161.37.93;
    deny 50.23.254.99;
    deny 189.36.199.70;
    deny 113.111.202.206;
    deny 94.102.49.37;
    deny 173.201.45.104;
    deny 117.14.148.173;
    deny 188.165.192.91;
    
    index index.php;
    try_files $uri $uri/ /index.php?q=$request_uri;
  }

  location ~ .php$ {
    fastcgi_pass   localhost:9000;  # port where FastCGI processes were spawned
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME    /data/klattr.com/www/ht_docs/$fastcgi_script_name;  # same path as above
    fastcgi_param PATH_INFO               $fastcgi_script_name;
    include /etc/nginx/fastcgi_params;
  }

  location /in {
    fastcgi_pass   localhost:9000;  # port where FastCGI processes were spawned
    fastcgi_index  index.php;
    fastcgi_param  SCRIPT_FILENAME    /data/klattr.com/www/ht_docs/$fastcgi_script_name;  # same path as above
    fastcgi_param PATH_INFO               $fastcgi_script_name;
    include /etc/nginx/fastcgi_params;

  }

  location /out {
    fastcgi_pass   localhost:9000;  # port where FastCGI processes were spawned
    fastcgi_index  index.php;
    fastcgi_param REMOTE_ADDR $http_x_real_ip;
    fastcgi_param  SCRIPT_FILENAME    /data/klattr.com/www/ht_docs/$fastcgi_script_name;  # same path as above
    fastcgi_param PATH_INFO               $fastcgi_script_name;
    include /etc/nginx/fastcgi_params;

  } 


  location ~ .css$ {
  }

  location ~ .gif$ {
  }

  location ~ .png$ {
  }

  location ~ .ico$ {
  }

  location ~ .eot$ {
  }

  location ~ .ttf$ {
  }

  location ~ .cur$ {
  }

  location ~ .js$ {
  }


  location / {
    resolver 8.8.4.4;
    proxy_set_header        X-Real-IP       $remote_addr;
    proxy_pass https://klattr.com/user.php?uname=$request_uri;
  }

  location ~ .jpeg$ {
    resolver 8.8.4.4;
    proxy_set_header        X-Real-IP       $remote_addr;
    proxy_pass https://klattr.com/show_jpg.php?jpeg=$request_uri;
  } 

  location ~ .ogg$ {
    resolver 8.8.4.4;
    proxy_set_header        X-Real-IP       $remote_addr;
    proxy_pass https://klattr.com/play_sound.php?sound=$request_uri;
  }

  location ~ .mp3$ {
    resolver 8.8.4.4;
    proxy_set_header        X-Real-IP       $remote_addr;
    proxy_pass https://klattr.com/play_sound.php?sound=$request_uri;
  } 
}
