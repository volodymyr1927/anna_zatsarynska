FROM phpdockerio/php80-fpm:latest
WORKDIR "/var/www"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update
RUN apt-get -y install \
      php-memcached \
      php8.1-mysql \
      php8.0-mysql \
      php-xdebug \
      php-xml \
      php-gd \
      php-curl \
      php-mbstring \
      php-psr \
      ssh \
      git \
      yarn \
      npm \
      telnet \
      apt-utils


RUN npm install --force
RUN echo 'eval `ssh-agent`' >> ~/.bashrc

RUN ln -s /usr/bin/php /usr/local/bin/php

RUN apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*