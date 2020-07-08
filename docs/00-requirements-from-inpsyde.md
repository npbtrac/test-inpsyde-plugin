## Task Requirements from Inpsyde
- **The golden rules for your assignment are: keep it simple, make it work, explain why, care of details.**
- Supporting several latest WordPress version, ideally 5.0+
- Available with PHP 7.2+
- Submit code to GitHub. When you will submit it for review, make sure the user jobs@inpsyde.com has read access to it.

### Task Description
- We ask you to write a WordPress plugin.
  
  When installed, the plugin has to make available a custom endpoint on the WordPress site. With “custom endpoint” we mean an arbitrary URL not recognized by WP as a standard URL, like a permalink or so.
  
  __**Note that this is not a REST endpoint.**__

- When a visitor navigates to that endpoint, the plugin has to send an HTTP request to a REST API endpoint. The API is available at https://jsonplaceholder.typicode.com and the endpoint to call is /users (https://jsonplaceholder.typicode.com/users)

- The plugin will parse the JSON response and will use it to build and display an HTML table.
  If you want you can call this endpoint using AJAX, but that is optional.
 
- Each row in the HTML table will show the details for a user. The column's id, name, and username are mandatory, but you can show more details if you want.
 
  The content of three mandatory columns must be a link (<a> tag). When a visitor clicks any of these links, the details of that user must be shown. For that, the plugin will do another API request to the user-details endpoint.
  
  See https://jsonplaceholder.typicode.com/guide.html for documentation.
  
  We don’t mind you to use any JavaScript, including 3rd party libraries, to improve the table look and feel. Things like client-side ordering and filtering, for example, are ok but not required.
  
- These details fetching requests must be asynchronous (AJAX) and the user details will be shown without reloading the page.
  At any time, the page will show details for at max one user. In fact, at every link click, a new user detail will load, replacing the one currently shown.
  
  This feature requires JavaScript, of course. You have the choice of technology to use. To make some examples, the code could be written in vanilla ES5 code, using 3rd party libraries like jQuery or whatnot, or implemented with vanilla modern JS, or TypeScript, React, Svelte, etc...
  
- The styling (CSS) is also up to you, you could even add no style at all. Responsiveness is not required but appreciated. The technology choice for styling is once again up to you. Plain old CSS, SASS, Less, Stylus, PostCSS, etc... are all valid choices.

- We expect some kind of cache for HTTP requests. The rationale behind it is up to you, please make a decision and document it in the README.

- Error handling for the external HTTP requests is also required: navigation must not be disrupted if a request fails.

- Additionally, the following features are mandatory:
  
  Full Composer support
  A README, in English, in Markdown-Formatting, explaining plugin usage and decisions behind implementation
  Code to be compliant with Inpsyde code style
  Automated tests (more on this topic will follow below)
  A license, preferably in a LICENSE file in the repository root. We don't require any specific license, nor we will ever share your work without your permission. The license should at a very minimum allow us to access and store your work. If you want to use an OS license, feel free to do so.
  You can ship more if you desire. But we prefer if your extra effort, if any, will focus on the server-side, being the role back-end focused.
  Some ideas: make the endpoint customizable via options, make the plugin extensible/customizable via hooks, allow customization of the rendered page via template override in theme... etc.
  
  The lack of optional features will not generate a negative evaluation. But truth to be told, we can’t say the same about poorly implemented optional features.
  
- About automated tests
  
  Unit tests have to be provided. When we say “unit tests” we mean tests that run without loading WordPress nor the external API.
  Inpsyde employee Giuseppe wrote an answer on WordPress Stack Exchange about this topic. We also suggest having a look at Brain Monkey, a tool to write unit tests for WordPress.
  
  Note that using this tool is a suggestion and it is not required at all.
  
  We do not expect 100% code coverage. We want you to write tests as a means to verify either your experience with the topic or the way you handle demand on a topic you have no experience with.
  
  Other kinds of tests, for example, tests that load WordPress and/or the external API are not required. You can write those if you wish, but make sure they pass if you do.
  
- About Composer dependencies
  
  Composer support is mandatory, and pulling packages via Composer is an allowed practice. And between tests and code style checks development dependencies will likely be there.
  
  It is also allowed to use dependencies for production code. That said, we appreciate it when dependencies are kept to the very essential. Please use the README to briefly explain why a Composer package has been added.
  
  At Inpsyde, we use Composer to manage the whole website code. We use it to install WordPress itself, alongside all plugins and themes, and we load Composer autoload in wp-config.php. We will appreciate it if the delivered plugin will be compliant with this workflow.
  
- About installation steps
  
  We expect that cloning your repository and running composer update, is all we need to get your plugin ready to be added to WordPress.
  In that’s not the case, or if extra steps are necessary (e.g. to compile frontend assets), you need to document installation steps in the README.
  
  Note: to ship “compiled” frontend assets in version control is an allowed practice for this assignment.
  A “distribution plugin package” ready to be installed in WordPress (including Composer vendor files, autoload, compiled assets...) is not required. If you decide to ship it, make it available in the “Releases” section of the GitHub repository.
  
- Is everything ready?

  For your convenience find here a checklist that might help you to make sure you’re ready to submit your code for review:

  The plugin has all required features, and you’ve tested them in a browser using a real WP installation
the custom endpoint is available
a table with users’ details is visible when visiting the endpoint

  Clicking a user name/username/id in the table loads that user details via AJAX and print them in the page
unit tests are available and it is possible to run them and all pass with no errors

  PHPCS checks pass with no errors/warnings (you can exclude tests files from check if you wish)
 
  The README is complete with:
  - Writing in Markdown format
  - List of requirements
  - Installation and usage instructions
  - Explanations behind non-obvious implementation choices
  - Your composer.json is valid and complete, and running composer install makes the plugin ready to be used.
  - The work has a license.
  - There are no /** TODO **/ leftover
  - The latest version of all the code has been committed to GitHub in a private repository
  - The user jobs@inpsyde.com has read access to the repository
