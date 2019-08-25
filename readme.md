Nette 3.0 Sandbox with apitte 0.6.0, Symfony console and Doctrine2 in docker
=============

Because there is lack of implemantation of these "must have" technologies to nette I made this.

Installation
------------

1. in docker folder run `docker-compose up`
2. `docker exec -it docker_web_1 /bin/bash`
3. inside docker (docker_web_1) run `composer update`
4. Now you should have working web on 127.0.0.1:8080
5. To run console: `php ./bin/console.php`

How to
------------
generate entities from db
probably you will have to install driver for you db
example for mysql
```bash
apt-update
apt install php7.3-mysql
```

then run command inside container for generating doctrine entities:
`php bin/console.php orm:convert-mapping --namespace="" --from-database annotation ./app/Entity/Database/`

then run this for creating database schema stuff

`php ./bin/console.php orm:schema-tool:update --force`
