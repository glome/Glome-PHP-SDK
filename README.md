# Glome SDK for PHP

Simple SDK for Glome API usage with modern PHP (tested with 5.5, should work with 5.4 also, due to short array syntax does not work with 5.3).

## Install
```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
cp config/config.json.dist config/config.json
```
Then choose your favorite text editor and fill in the Glome api-uid and api-key, buy them online (https://sites.fastspring.com/glome/instant/api_credentials) or ask for development account (contact@glome.me).

## Test
```
php test/test.php
```
If there is a mistake in your configuration file, an uncaught GlomeException should be thrown.

On success, two synced Glome Users should be created and paired and var_dump should provide your console with similar responses of steps 5 and 6 as provided in this tutorial (https://devland.glome.me/getting_started.html#p1)

Use GitHub Issue Tickets for comments, feature suggestions and bug reports!

Thank you for your time and happy Gloming!
