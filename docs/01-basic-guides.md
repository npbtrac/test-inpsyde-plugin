### List of requirements
- PHP 7.2+
- Composer
- Internet connection :P

### Installation
- Make domain `test-inpsyde-plugin.docker` point to your docker desktop or docker machine
```shell script
git clone git@github.com:npbtrac/test-inpsyde-plugin.git
cd test-inpsyde-plugin
docker-compose run --rm composer composer install --dev
docker-compose up --build -d
docker-compose exec php /opt/wp-install.sh
docker-compose run --rm node npm install --save-dev
docker-compose run --rm node npm run dev
```
- Custom endpoint works here http://test-inpsyde-plugin.docker/?pagename=custom-inpsyde
