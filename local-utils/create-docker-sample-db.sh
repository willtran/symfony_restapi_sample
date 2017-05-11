#!/usr/bin/env bash
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "create database app" && \
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "create user 'app'@'%' identified by 'Gadu1sag82AD'" && \
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "grant all on app.* to 'app'@'%'" && \
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "flush privileges"