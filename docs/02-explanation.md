## Checklist from the requirements

> We ask you to write a WordPress plugin.
    
Repo is a WordPress plugin, to be honest, I found this https://github.com/inpsyde/paypal-plus-plugin from Inpsyde so I decided to learn from it. I include several docker containers in this plugin source code.

From https://github.com/npbtrac/test-inpsyde-plugin/blob/master/docker-compose.yml here
- **mariadb**: is containter for database
- **php**: for php-fpm instance, we mount the WordPress code and this plugin source code to it's plugin folder (this is a great idea, because previously, I created another repo to use composer to put this plugin to that folder, then I had to re-do my docker stuff following this wise approach).
- **nginx**: for webserver
- **composer**: for running composer stuff (because **php-fpm** has xdebug which make composer crazily slow).
- **node**: for handling npm stuff to server task runners for producing css and js files.
- **traefik**: this is new to me, I just copied from **Paypal Plus** plugin (will learn about that later).

Commands:
- `docker-compose run --rm composer composer install --dev` for using composer instance to get all packages
- `docker-compose exec php /opt/wp-install.sh` for install a fress WordPress instance
- `docker-compose run --rm node npm install --save-dev` for installing all packages from npm to be able to use Webpack
- `docker-compose run --rm node npm run dev` to produce js and css files.
  
>- When installed, the plugin has to make available a custom endpoint on the WordPress site. With “custom endpoint” we mean an arbitrary URL not recognized by WP as a standard URL, like a permalink or so.
>
> Note that this is not a REST endpoint.
>
> - When a visitor navigates to that endpoint, the plugin has to send an HTTP request to a REST API endpoint. The API is available at https://jsonplaceholder.typicode.com and the endpoint to call is /users (https://jsonplaceholder.typicode.com/users) - **Done**
>
> - The plugin will parse the JSON response and will use it to build and display an HTML table.
  If you want you can call this endpoint using AJAX, but that is optional.
 
After running needed commands, user can navigate to http://test-inpsyde-plugin.docker/?pagename=custom-inpsyde

- When access this URL (a custom endpoint) http://test-inpsyde-plugin.docker/?pagename=custom-inpsyde, a list of records taken from https://jsonplaceholder.typicode.com/users (as json) would be pulled and appears for user to see. (not using ajax)
- I use a class as a service to retrieve remote data https://github.com/npbtrac/test-inpsyde-plugin/blob/master/src/Services/UserRemoteJsonService.php#L46
- This plugin use Laravel DI container https://github.com/npbtrac/test-inpsyde-plugin/blob/master/composer.json#L20 to store all needed services (for rendering, for getting remote data from json format).
- The goal of using DI container is to have ability to access the instance for this Plugin anywhere (after plugins loaded) by using `\TestInpsyde\Wp\Plugin\TestInpsyde::getInstance()` as a global instance. Therefore, you can access that instance and dependent services to get their attributes, methods or simply remove some hooks.
- The reason why I didn't use ajax for this is because this is the main endpoint, and it needs to show all needed data for SEO purpose.

>- Each row in the HTML table will show the details for a user. The column's id, name, and username are mandatory, but you can show more details if you want.
> 
> The content of three mandatory columns must be a link (<a> tag). When a visitor clicks any of these links, the details of that user must be shown. For that, the plugin will do another API request to the user-details endpoint.
>  
> See https://jsonplaceholder.typicode.com/guide.html for documentation.
>
> We don’t mind you to use any JavaScript, including 3rd party libraries, to improve the table look and feel. Things like client-side ordering and filtering, for example, are ok but not required.
>
> These details fetching requests must be asynchronous (AJAX) and the user details will be shown without reloading the page.
  At any time, the page will show details for at max one user. In fact, at every link click, a new user detail will load, replacing the one currently shown.
>
> This feature requires JavaScript, of course. You have the choice of technology to use. To make some examples, the code could be written in vanilla ES5 code, using 3rd party libraries like jQuery or whatnot, or implemented with vanilla modern JS, or TypeScript, React, Svelte, etc...

Each row in the HTML table will show the details for a user. The column's id, name, and username are mandatory and display there.
![Showing list of users with id, name, and username on each item](img/user-list.png)

- Clicking on link of ID, Name, Username, it would fire an ajax action to get details of thank clicked user. Ajax URL http://test-inpsyde-plugin.docker/wp-admin/admin-ajax.php?action=get_single_user&id=1 would use `admin-ajax.php`. I don't use `check_ajax_referer` because the ajax URL is a simple one for showing data, no special activities, so I skip the check referrer.

> - We expect some kind of cache for HTTP requests. The rationale behind it is up to you, please make a decision and document it in the README.

- Because clicking on ID, Name, Username would request to a same URL, so I use a variable to store the remote response to avoid making repeated remote requests to make things work faster (https://github.com/npbtrac/test-inpsyde-plugin/blob/master/assets/src/js/_custom-page.js#L28). You can see the clicked item is the one with underline
![Clicked item](img/clicked-item.png)
- Besides, I use server side caching (using transient) to avoid requesting too many times to remote data. (https://github.com/npbtrac/test-inpsyde-plugin/blob/master/src/Services/UserRemoteJsonService.php#L85)

>- Error handling for the external HTTP requests is also required: navigation must not be disrupted if a request fails.

I turn my internet off to simulate the case when remote server down or connection unstable, it will show errors from curl because we are in Debug mode
![Error on list](img/error-handling-list.png)
![Error on details](img/error-handling-detail.png)

Code here https://github.com/npbtrac/test-inpsyde-plugin/blob/877139fb4da641e46df794455a4fd602a40291b5/src/TestInpsyde.php#L275, if not in DEBUG mode, general message would appear.

> Full Composer support

Yes, library loaded via composer (not included in plugin source code). I saw `mozart` package there but I've never used that so I will learn that later.

> A README, in English, in Markdown-Formatting, explaining plugin usage and decisions behind implementation

This file you are reading :)

> Code to be compliant with Inpsyde code style

PHPCS file here https://github.com/npbtrac/test-inpsyde-plugin/blob/master/phpcs.xml.dist#L15 (I copy it from Paypal Plus plugin). It excludes several Inpsyde rules therefore, my code is not 100% Inpsyde qualified but it's still Inpsyde one :) (it's from Inpsyde's plugin).

> Automated tests (more on this topic will follow below)

I use Codeception framework and apply Unit Test only
```shell script
docker-compose exec php bash -c "cd /var/www/html/wp-content/plugins/test-inpsyde-plugin; php ./vendor/bin/codecept run --coverage"
```

- I make Unit Test to verify that a custom endpoint should be created.
- And remote data should be pulled correctly (including exception handlers).

>  A license, preferably in a LICENSE file in the repository root. We don't require any specific license, nor we will ever share your work without your permission. The license should at a very minimum allow us to access and store your work. If you want to use an OS license, feel free to do so.

https://github.com/npbtrac/test-inpsyde-plugin/blob/master/LICENSE. **Everyone is permitted to copy and distribute verbatim copies
 of this license document, but changing it is not allowed.**, so please feel free to access, store and share it :).
 
> You can ship more if you desire. But we prefer if your extra effort, if any, will focus on the server-side, being the role back-end focused.

I tried to use DI container for this plugin (not a usual way people do with WordPress but this approach is the one I want to work with). Not sure is this can be considered as **more feature** :)

> Some ideas: make the endpoint customizable via options, make the plugin extensible/customizable via hooks, allow customization of the rendered page via template override in themes... etc. 

- Settings page: http://test-inpsyde-plugin.docker/wp-admin/options-general.php?page=test-inpsyde-settings (it's quite ugly :S )
- Rendering with theming support here https://github.com/npbtrac/test-inpsyde-plugin/blob/master/src/Services/ViewService.php
    - A view file can be rendered with theme overriding one
    - Or, by its absolute path.
- Actions for prepend HTML https://github.com/npbtrac/test-inpsyde-plugin/blob/master/views/page/users.php#L23 
- Filters for adjusting values of a single user https://github.com/npbtrac/test-inpsyde-plugin/blob/master/views/page/users.php#L55

> - About automated tests
>    
>    Unit tests have to be provided. When we say “unit tests” we mean tests that run without loading WordPress nor the external API.
>    Inpsyde employee Giuseppe wrote an answer on WordPress Stack Exchange about this topic. We also suggest having a look at Brain Monkey, a tool to write unit tests for WordPress.
>
>    Note that using this tool is a suggestion and it is not required at all.
>    
>    We do not expect 100% code coverage. We want you to write tests as a means to verify either your experience with the topic or the way you handle demand on a topic you have no experience with.
>    
>    Other kinds of tests, for example, tests that load WordPress and/or the external API are not required. You can write those if you wish, but make sure they pass if you do.

- I use Codeception because I'm familiar with it more. I do not create Functionnal Tests (needs to load WordPress) but I have been working on the Test for ~ 4 weeks so I would like to complete required things.

- Simply run 
```shell script
docker-compose exec php bash -c "cd /var/www/html/wp-content/plugins/test-inpsyde-plugin; php ./vendor/bin/codecept run --coverage"
```

- I created tests for our main scenarios:
    + A custom endpoint should be there (with Functional Tests, it would be better).
    + Tests remote json service (data found and exceptions found).
    
> - About Composer dependencies
>    
>    Composer support is mandatory, and pulling packages via Composer is an allowed practice. And between tests and code style checks development dependencies will likely be there.
>    
>    It is also allowed to use dependencies for production code. That said, we appreciate it when dependencies are kept to the very essential. Please use the README to briefly explain why a Composer package has been added.
>    
>    At Inpsyde, we use Composer to manage the whole website code. We use it to install WordPress itself, alongside all plugins and themes, and we load Composer autoload in wp-config.php. We will appreciate it if the delivered plugin will be compliant with this workflow.

- I don't include vendor to repo so to have them, we need to install them using composer. I use composer docker container to avoid instally composer to local machine
```shell script
docker-compose run --rm composer composer install
```

- More details on packages can be found [here](02-01-compose-explanations.md) 

> - About installation steps
>  
>  We expect that cloning your repository and running composer update, is all we need to get your plugin ready to be added to WordPress.
>  In that’s not the case, or if extra steps are necessary (e.g. to compile frontend assets), you need to document installation steps in the README.
  
>  Note: to ship “compiled” frontend assets in version control is an allowed practice for this assignment.
  A “distribution plugin package” ready to be installed in WordPress (including Composer vendor files, autoload, compiled assets...) is not required. If you decide to ship it, make it available in the “Releases” section of the GitHub repository.

- Previously, I use this repo https://github.com/npbtrac/test-inpsyde-wp to have WP and include the plugin to it.
- Later, I found the Paypal Plus approach and I see that a better approach so I use the latter to make things more simpler.
- I put everything needed to make the website run here
```shell script
docker-compose run --rm composer composer install
docker-compose up -d --build
docker-compose exec php /opt/wp-install.sh
docker-compose run --rm node npm install --save-dev
docker-compose run --rm node npm run dev
```

> - Is everything ready?

- Yes, I test this hundred times. Hopefully things will go smoothly your end.