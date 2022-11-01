https://www.youtube.com/watch?v=sHNJxx0L9r0

https://www.youtube.com/watch?v=DDH6IsSEpQM&t=227s

9. chmod 755 default for fort3/sites/default

10. composer require 'drupal/webprofiler:^9.0'

11. lando drush ws

12. composer require 'drupal/devel:^5.0'

13. composer require guzzlehttp/guzzle:^6.5

php -r 'echo curl_version()["version"];'

4. lando drush site:install --db-url=mysql://drupal9:drupal9@database/drupal9 -y

5. lando composer require drush/drush

6. lando start

7. mkdir fort3 && cd fort3 && lando init --source remote --remote-url https://www.drupal.org/download-latest/tar.gz --remote-options="--strip-components 1" --recipe drupal9 --webroot . --name fort3

---

https://www.themoviedb.org/documentation/api/discover

https://www.drupal.org/node/2932520
https://curl.se/libcurl/c/libcurl-errors.html
https://drupal.stackexchange.com/questions/18862/is-there-a-function-to-clear-the-watchdog-log-inside-a-module

https://docs.lando.dev/guides/lando-phpstorm.html
https://www.fourkitchens.com/blog/development/xdebug-lando-phpstorm-mac/
https://www.austinprogressivecalendar.com/blog/debugging-drupal8-phpstorm-and-lando-your-mac
https://www.jetbrains.com/help/phpstorm/2022.2/servers.html
https://www.drupal.org/docs/develop/development-tools/editors-and-ides/configuring-phpstorm
