# "ported" by Adam Miller <maxamillion@fedoraproject.org> from
#   https://github.com/fedora-cloud/Fedora-Dockerfiles
#
# Originally written for Fedora-Dockerfiles by
#   "Scott Collier" <scollier@redhat.com>

FROM centos:centos6

RUN yum -y update && \
    yum clean all

RUN yum -y install httpd mod_ssl mod_fastcgi && \
    yum clean all

ADD config/vhost.conf /etc/httpd/conf.d/vhost.conf

EXPOSE 80

# Simple startup script to avoid some issues observed with container restart 
ADD run-httpd.sh /run-httpd.sh
RUN chmod -v +x /run-httpd.sh

CMD ["/run-httpd.sh"]
