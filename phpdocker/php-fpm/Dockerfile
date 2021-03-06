FROM phpdockerio/php74-fpm:latest
WORKDIR "/var/www"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update
RUN apt-get -y --no-install-recommends install \
      php7.4-memcached \
      php7.4-mysql \
      php7.4-xdebug \
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