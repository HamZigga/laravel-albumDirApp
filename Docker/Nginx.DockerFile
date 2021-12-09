FROM nginx

ADD Docker/conf/vhost.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/albumMusicApp
