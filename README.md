NewsBlock application
================================

NewsBlock application provides news aggregation display on page as a list, and
specially provide API access for receiving news in light way.

Based on Yii 2 Basic Application Template

Installation guide
================================

On server you required to have:

* Web server Apache2 (for .htaccess) or other that could be configured with path rewrite
* php5.5
* postgresql
* Database and database user
* yyi2 requirements: GD or ImageMagic, mcrypt

Get composer:

    curl -s http://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

Install composer plugin for npm assets:

    composer global require "fxp/composer-asset-plugin:1.0.0"

Install project using composer:

    composer create-project -s dev --prefer-dist indomian/news-block somepath

Configure DB connection in file /config/db.php

Run DB migration:

    ./yii migrate

If everything ok your application should be available to connect and work with.

