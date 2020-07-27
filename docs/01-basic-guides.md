### List of requirements
- Docker & Docker Compose (https://docs.docker.com/get-docker/ & https://docs.docker.com/compose/install/)
- Internet connection :P

### Installation
- Clone project then change directory to that folder
```shell script
git clone https://github.com/npbtrac/test-inpsyde-plugin test-inpsyde-plugin
cd test-inpsyde-plugin
```
- Copy `.env.example` -> `.env`
```shell script
cp .env.example .env
```

- Run below command to set up docker and WordPress
```shell script
docker-compose run --rm composer composer install
docker-compose up -d --build
docker-compose exec php /opt/wp-install.sh
docker-compose run --rm node npm install --save-dev
docker-compose run --rm node npm run dev
```

- Make domain `test-inpsyde-plugin.docker` point to your docker desktop or docker machine
```
127.0.0.1 test-inpsyde-plugin.docker
```

- Custom endpoint works here http://test-inpsyde-plugin.docker/?pagename=custom-inpsyde

#### Running other tasks
- PHPCS (using Inpsyde rules, defined [here](phpcd.xml.dist)
```shell script
docker-compose exec php bash -c "cd /var/www/html/wp-content/plugins/test-inpsyde-plugin; ./vendor/bin/phpcs"
```
- Tests with Codeception (built on top of PhpUnit) and with only Unit Test Suite in action
```shell script
docker-compose exec php bash -c "cd /var/www/html/wp-content/plugins/test-inpsyde-plugin; php ./vendor/bin/codecept run --coverage"
```
