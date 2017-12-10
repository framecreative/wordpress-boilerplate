# F/R/A/M/E Boilerplate

A starting point for modern WordPress sites, designed to be used in conjunction with Frame Creative's Hosting environment and deployment pipeline

**Features - WordPress**

- :tada: [Composer support](https://getcomposer.org/) for plugins, themes and packages
- :tada: Autoloader support and default theme namespace autoloader via Library folder
- :tada: MU plugins autoloader [from Roots/Bedrock](https://roots.io/bedrock/docs/mu-plugins-autoloader/)
- :tada: Dot Env for environment management
- :tada: [Twig Templating](https://twig.symfony.com/doc/2.x/)
- :tada: Basic MVC-esque theme organisation ( not true MVC, more helps with code organisation )
- :tada: [Timber library](https://www.upstatement.com/timber/) for vastly improved OOP WP experience
- :tada: Extensibles models per post type via [Timber's class_map](site/content/themes/frame-custom/library/Setup/Structure#L24-L33)
- :tada: Virtual page templates to use via router functions

**Features - Front End**

- :tada: NPM / Yarn support (yarn preferred)
- :tada: Browsersync & hot reloading via `npm start` / `yarn start`
- :tada: Support for ES-6 / ES-2016 via Webpack & Babel
- :tada: Support for ES-6 Modules & `import` statments
- :tada: Support for SASS / SCSS via node-sass
- :tada: Auto generation of source maps ( js & css )
- :tada: Auto hard asset-reving for cache invalidation in production builds (js & css)
- :tada: Auto removal of console.log statements in production builds
- :tada: CSS autoprefixer and minification on production builds
- :tada: SVG spritesheet generation, minification and lazyloading
- :tada: Automatic modernizer builds, via scanning the css & js files to determine required testshomestead up



---


## First Run

A decent amount of work has gone into first run optimisation - the project works best when using in conjunction with
[Laravel's Homestead virtual environment](https://laravel.com/docs/5.5/homestead), installed globally and [made available globally on the CLI](https://laravel.com/docs/5.5/homestead#accessing-homestead-globally) via the bash alias

### Naming conventions

The setup script can take care of a LOT for you if you commit to some naming convetions.
It's all based around a "project name", which is ideally a single word, lowercase, no spaces.

```bash
# Example project name
mycoolwebsite
```

you should clone this repo into a folder of the same name

```bash
# Example git clone
git clone https://github.com/framedigital/wordpress-boilerplate.git mycoolwebsite
```

Enter the project name into the [setup.sh script](#setup--first-run-helper-script) when prompted

When configuring homestead or your dev environment you should aim for the project name
as the website url and db name - `mycooolwebsite.dev` and `mycoolwebsite` respectively.

If you deviate from this naming convention then please check the following files to ensure the details are correct

`package.json`

`wp-cli.yml`

`.env`

### Pre-requisites

Homestead has everything we need to serve the site, for dev locally you will need

- `php 5.6+`
- `composer`
- `node`
- `yarn`

### Setup / First Run helper script

```bash
#Example first run
cd ${path-to-this-project} && bash ./setup.sh

# The script will prompt you for a project name before beginning
```

---


## Development


### Installing Plugins

Plugins from the WordPress repository are available via the `wpackagist-plugin` vendor - eg: `composer require wpackagist-plugin/placekitten`

For paid 3rd party plugins avialable via Frame's hosted composer repositories please see [our included list](frame-composer-plugins.txt)

You will need an auth.json file to access this password protected repository - Frame Creative will provide you with these credentials if necessary - please avoid checking them into any public repository

We recommend ACF Pro for custom fields / content, and Gravity Forms for form display and processing, both of which are available via frame-plugins


### Installing JS Dependencies

Anything you can install with Yarn / NPM is up for grabs!

Webpack will create a minified bundle for any JS file in the root `scripts` directory of the theme, so if you want to split your code into multiple bundles then create multiple files, only `import` what you need, and enqueue them in wordpress accordingly.

When enqueueing assets, be sure to use the [assets helper class when enqueueing](site/content/themes/frame-custom/library/Setup/Frontend.php#L57-L69) to take advantage of the hard asset-revving for cache busting.

Because this uses manifest.json and file name based versioning, it's safe to set really long expire headers on your assets, perfect if you're serving them via a CDN like cloudfront as you don't need to bother with invalidating the old file :boom:

### Live reload / Browsersync / General Dev kick off

Navigate to the project root in your CLI and run

```bash
yarn start
```

This will kick off the watch / rebuild process, and start a proxied browsersync connection to whatever url is set in package.json

Visit `http://localhost:3000` to access the site and use browser sync


### Renaming the theme / changing themes

Feel free to rename the theme, or swap it out for another starter, the following paths may need to be edited, or you can bail on our front-end build processes if you want - I'm not your supervisor :information_desk_person:

`package.json`

  - assetSource
  - assetDest
  - themeFolder

`wp-config.php`

  - WP_DEFAULT_THEME

`composer.json`

  - autoload config


### Homestead and WP CLI

If you have homestead installed globally then you can take advantage of WP CLI's aliases in a very easy manner

Run the following command to generate a SSH config

```bash
homestead ssh-config --host homestead.dev >> ~/.ssh/config
```

If you have changed your Homestead install's `folders` property in Homestead.yaml, then please edit the @dev alias in wp-cli.yml to relect the correct path

If you have yet to install WP CLI on homestead then this will take care of it..

```bash
# One liner for global Homestead users, I gotchu fam.
homestead ssh -- -t 'curl -o wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp && sudo mv wp /usr/local/bin/wp'
```

Then you can execute WP CLI commands from your machine using the aliases

```bash
# Good test example
wp @dev plugin list
```


### Using Typescript

If using TypeScript, rename app.js to app.ts. The TypeScript compiler (tsc) will then handle the file and then pipe through the standard js pipeline (Babel, Uglify etc).

To take advantage of TypeScript autocomplete + checking with various libraries, install the corresponding TypeScript type definition file by running one of the following:

`npm install -D @types/jquery`
`npm install -D @types/lodash`
`npm install -D @types/underscore`

Many type definitions are available. See them all at https://github.com/DefinitelyTyped/DefinitelyTyped .





