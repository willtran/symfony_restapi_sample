#!/usr/bin/env bash
docker exec -i -t symfonyrestapisample_phpfpm_1 /data/utils/composer.phar --working-dir=/data/article_crud $*
