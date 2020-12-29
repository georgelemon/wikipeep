# [Installation](#Installation)

The current version of WikiPeep is <code>1.0.0</code>. Get it from latest release, or you may want to try the unstable version directly from main [repository](https://github.com/georgelemon/wikipeep)
```
# stable version
https://github.com/georgelemon/wikipeep.git

# development version
https://github.com/georgelemon/wikipeep.git
```

Install all Composer dependencies, but first, be sure your machine runs PHP 7.4, 8.0 or newer.

```
composer install
```

Once you're done with installing packages you will get
```
    "symfony/http-foundation": "^5.2@dev",
    "illuminate/support": "^9.0@dev",
    "illuminate/filesystem": "^9.0@dev",
    "vlucas/phpdotenv": "^5.1@dev",
    "nyholm/psr7": "^1.0@dev",
    "symfony/yaml": "5.x-dev",
    "georgelemon/dessert": "dev-master",
    "symfony/console": "5.x-dev",
    "jamesmoss/flywheel": "dev-master"
```

### Okay, but what's Dessert?
Now, most probably you've already heard about all packages listed above. The one called <strong>Dessert</strong> is made by me, and replaces the use of Webfonts or JavaScript for showing icons on front-end, by creating PHP arrays with all collected SVG icons from your preferred Icons Library. [Check the repository of Dessert](https://github.com/georgelemon/dessert) and how can solve the loading gaps of Webfonts or JavaScript libs by simply using SVGs code (which are simply XML) and inserting the code directly using CPU/RAM of your server, instead of client's browser.

___
**@todo** Implement a WikiPeep instance for Dessert Library 🧐
___


## [Development](#development)
### Yo, where are Webpack, Grunt, Twig all the boys?
Well, they're gone! The main principle of this project is to keep things as minimal as possible.
The recommended way for UI development is to use [Dart Sass](https://sass-lang.com/dart-sass) or anything from [LibSass](https://sass-lang.com/libsass).

At the same time, the JavaScript that is shipped with default <code>twentytwentyone</code> theme is pure Vanilla. Its dependencies consist in
1. **AutoComplete.js** - <mark>Required for implementing search functionality</mark>
2. **Dexie.js** <mark>Optional. By default used for storing all search results in IndexedDB of the browser</mark>
3. **Cookie.js** Optional. By default used by Theme Switcher


## [Demo Contents](#demo-contents)
By default, WikiPeep comes with its official documentation as demo, so you can have a better image of what WikiPeep can do. The demo content is available as Markdown files and can be found in <code>/contents</code>, and the compiled things take place under <code>/storage/database</code> directory.


