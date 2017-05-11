#!/usr/bin/env bash
mysqldump -h 127.0.0.1 -P 3307 -u app -p'Gadu1sag82AD' app > /opt/backups/database/daily_app_backup.sql
