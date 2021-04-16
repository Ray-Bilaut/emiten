# Mitra Gambut

## build

*	cat assets/css/style.css assets/css/style-mobile.css > assets/css/style.all.css
*	uglifycss assets/css/style.css --output assets/css/style.min.css
*	html-minifier --collapse-whitespace --remove-comments --remove-tag-whitespace --minify-css true --minify-js true --input-dir app/views/frontend/ --output-dir app/views/frontend-min/
*	uglifyjs --compress --output assets/js/script.min.js assets/js/script.js
*   uglifyjs --compress --output assets/js/fcm.min.js assets/js/fcm.js
*   uglifyjs --compress --output assets/js/firebase-setup-prod.min.js assets/js/firebase-setup-prod.js
*   change .env APP_VERSION to APP_VERSION+1


## persiapan test

*	cd app/
*	composer install

## test

*	cd app/
*	./vendor/bin/phpcbf --standard=ruleset.xml controllers/
*	./vendor/bin/phpcs --standard=ruleset.xml controllers/
*	fix errors found
*	./vendor/bin/phpmd controllers/ text unusedcode
*	fix errors found
*	./vendor/bin/phpmd controllers/ text naming
*	fix errors found
*	./vendor/bin/phpcpd controllers/
*	fix errors found

## Deployment

#### Local

*	Inside app folder, run: composer install
*	Set app/.env file
*	Create database and create table 'sessions'
*	Run migrate: baseurl/migrate/index/token/1

#### Production

*	Inside app folder, run: composer install --no-dev
*	Set app/.env file
*	Create database and create table 'sessions'
*	Run migrate: baseurl/migrate/index/token/1

*You can upload manualy via FTP/SFTP folder app/vendor to server*

#### Table sessions

    CREATE TABLE mg_sessions (  
        id varchar(128) COLLATE utf8_unicode_ci NOT NULL,  
        ip_address varchar(45) COLLATE utf8_unicode_ci NOT NULL,  
        timestamp int(10) unsigned NOT NULL DEFAULT '0',  
        data blob NOT NULL,  
        PRIMARY KEY (id),  
        KEY ci_sessions_timestamp (timestamp)  
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

## Log