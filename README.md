### Roadsurfer test task

* docker-composer up -d - run mariaDb docker 
* composer i 
* `php bin/console d:m:m -n` - table migrations
* `php bin/console d:f:l -n` - Fixture load
* `composer test` - Unit tests

Was not required but, I create a command to change order status from in_progress to done and update equipment on each 
location which is set as end station
