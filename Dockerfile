#Download base image ubuntu 16.04
FROM ubuntu:16.04
#RUN apt-get install -y python-software-properties

RUN apt-get update -yqq \
    && apt-get install -yqq \
	ca-certificates \
    git \
    gcc \
    make \
    wget \
    mc \
    curl \
    sendmail

RUN DEBIAN_FRONTEND=noninteractive apt-get -y dist-upgrade
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install python-software-properties
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common
RUN DEBIAN_FRONTEND=noninteractive LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

## Install php7.1 extension
RUN apt-get update -yqq \
    && apt-get install -yqq \
    php7.1-pgsql \
	php7.1-mysql \
	php7.1-opcache \
	php7.1-common \
	php7.1-mbstring \
	php7.1-mcrypt \
	php7.1-soap \
	php7.1-cli \
	php7.1-intl \
	php7.1-json \
	php7.1-xsl \
	php7.1-imap \
	php7.1-ldap \
	php7.1-curl \
	php7.1-gd  \
	php7.1-dev \
    php7.1-fpm \
    && apt-get install -y -q --no-install-recommends \
       ssmtp


# Install nginx, php-fpm and supervisord from ubuntu repository
RUN apt-get install -y nginx php7.1-fpm supervisor && \
    rm -rf /var/lib/apt/lists/*
#Define the ENV variable
ENV nginx_vhost /etc/nginx/sites-available/default
ENV php_conf /etc/php/7.1/fpm/php.ini
ENV nginx_conf /etc/nginx/nginx.conf
ENV supervisor_conf /etc/supervisor/supervisord.conf

# Enable php-fpm on nginx virtualhost configuration
COPY default ${nginx_vhost}
RUN sed -i -e 's/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g' ${php_conf} && \
    echo "\ndaemon off;" >> ${nginx_conf}

#Copy supervisor configuration
COPY supervisord.conf ${supervisor_conf}

RUN mkdir -p /run/php && \
    chown -R www-data:www-data /var/www/html && \
    chown -R www-data:www-data /run/php

# Volume configuration
VOLUME ["/etc/nginx/sites-enabled", "/etc/nginx/certs", "/etc/nginx/conf.d", "/var/log/nginx", "/var/www/html"]

# Configure Services and Port
COPY start.sh /start.sh
CMD ["./start.sh"]

EXPOSE 80 443







