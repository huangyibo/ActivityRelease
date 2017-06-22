#!/bin/bash 
 php artisan down 
# git pull
 composer clearcache && composer dumpautoload
 sudo chown -R sakura:sakura storage/
 rm -rf storage/framework/views/*
 gulp --production
 php artisan clear-compiled
# php artisan config:cache 
 php artisan optimize
 php artisan up
