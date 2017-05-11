# TODO: Given that phpfpm56, cron and websockets are almost identical images,
# there's probably scope to build a common image that all three can inherit.
FROM centos:6

RUN yum -y update && \
    yum install -y xz wget iproute && \
    yum clean all

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm && \
    rpm -Uvh https://centos6.iuscommunity.org/ius-release.rpm && \
    yum -y install php56u-fpm php56u-gd php56u-cli php56u-mbstring php56u-mcrypt php56u-xml php56u-soap php56u-tidy php56u-opcache php56u-pdo php56u-mysqlnd php56u-pecl-xdebug php56u-intl  && \
    yum clean all

RUN sed -e 's/127.0.0.1:9000/9000/' \
        -e '/allowed_clients/d' \
        -e '/catch_workers_output/s/^;//' \
        -e '/error_log/d' \
        -i /etc/php-fpm.d/www.conf

ADD config/99-custom.ini /etc/php.d/99-custom.ini

RUN sed -e "s/%XDEBUG_REMOTE_HOST%/`/sbin/ip route|awk '/default/ { print $3 }'`/" \
        -i /etc/php.d/99-custom.ini && \
    touch /var/log/xdebug_remote_log && \
    chmod 777 /var/log/xdebug_remote_log


# gpg keys listed at https://github.com/nodejs/node
RUN set -ex \
  && for key in \
    9554F04D7259F04124DE6B476D5A82AC7E37093B \
    94AE36675C464D64BAFA68DD7434390BDBE9B9C5 \
    0034A06D9D9B0064CE8ADF6BF1747F4AD2306D93 \
    FD3A5288F042B6850C66B31F09FE44734EB7990E \
    71DCFD284A79C3B38668286BC97EC7A07EDE3FC1 \
    DD8F2338BAE7501E3DD5AC78C273792F7D83545D \
    B9AE9905FFD7803F25714661B63B535A4C206CA9 \
    C4F0DFFF4E8C1A8236409D08E73BC641CC11F4C8 \
  ; do \
    gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key"; \
  done

ENV NPM_CONFIG_LOGLEVEL info
ENV NODE_VERSION 6.9.1

RUN curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz" \
  && curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/SHASUMS256.txt.asc" \
  && gpg --batch --decrypt --output SHASUMS256.txt SHASUMS256.txt.asc \
  && grep " node-v$NODE_VERSION-linux-x64.tar.xz\$" SHASUMS256.txt | sha256sum -c - \
  && tar -xJf "node-v$NODE_VERSION-linux-x64.tar.xz" -C /usr/local --strip-components=1 \
  && rm "node-v$NODE_VERSION-linux-x64.tar.xz" SHASUMS256.txt.asc SHASUMS256.txt \
  && ln -s /usr/local/bin/node /usr/local/bin/nodejs

EXPOSE 9000
ENTRYPOINT /usr/sbin/php-fpm --nodaemonize