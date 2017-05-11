#!/usr/bin/env bash
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "create database articles" && \
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "create user 'local_user'@'%' identified by 'bdtEjOagWZsY'"
mysql -h 127.0.0.1 -P 3307 -u root -p'o4Q4PV1TOvbPpgpg7Wuo' -e "grant all on articles.* to 'local_user'@'%'"