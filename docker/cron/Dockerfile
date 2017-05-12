# TODO: Given that phpfpm56, cron and websockets are almost identical images,
# there's probably scope to build a common image that all three can inherit.
FROM centos:6

RUN yum -y update && \
    yum install -y xz wget iproute && \
    yum clean all

RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm && \
    rpm -Uvh https://centos6.iuscommunity.org/ius-release.rpm && \
    yum -y install php56u-gd php56u-cli php56u-mbstring php56u-mcrypt php56u-xml php56u-soap php56u-tidy php56u-opcache php56u-pdo php56u-mysqlnd php56u-pecl-xdebug php56u-intl  && \
    yum clean all

ADD config/99-custom.ini /etc/php.d/99-custom.ini

RUN sed -e "s/%XDEBUG_REMOTE_HOST%/`/sbin/ip route|awk '/default/ { print $3 }'`/" \
        -i /etc/php.d/99-custom.ini && \
    touch /var/log/xdebug_remote_log && \
    chmod 777 /var/log/xdebug_remote_log

RUN yum install -y cronie && \
    yum clean all


ADD config/crontab /etc/cron.d/db-backup-cron

RUN chmod 0644 /etc/cron.d/db-backup-cron && \
    touch /var/log/cron.log && \
    /usr/bin/crontab /etc/cron.d/db-backup-cron

# Run the command on container startup
CMD crond  && tail -f /var/log/cron.log