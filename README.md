# Open Source Wiki for Busy Devs (WIP)
**WikiPeep is still in heavy development. Wait for the first official release.**

![Landing page of WikiPeep](.github/wikipeep_screen.jpg)

## Features
- [x] Markdown parser, thanks to [Parsedown](https://github.com/erusev/parsedown)
- [x] Flat file, with [Flywheel](https://github.com/jamesmoss/flywheel) JSON Database
- [x] Console via [Symfony Console](https://github.com/symfony/console)
- [x] Fast and lightweight
- [x] Minimal UI
- [x] Whitelabel 
- [x] Anchor URLs Support
- [x] Summary Contents based on Anchor URLs
- [x] Secure by default (There is no dashboard admin, at least not for now)
- [x] Composer ready
- [x] Router Functionality
- [x] Controller Functionality
- [x] MVC Pattern w/ Model (where the actual Model is provided by Flywheel)
- [x] Configurations via <code>.env</code> and <code>ArrayAccess</code> Config in Laravel style


# Usage

You will need PHP 7.4 or newer. Since WikiPeep is a flat file database you don't have to setup a database.
The [Flywheel](https://github.com/jamesmoss/flywheel) will be triggered while building the content via console.

```bash
git clone https://github.com/georgelemon/wikipeep.git
composer install
```

### Building Content

By default, WikiPeep comes with some demo content, so you can make a better idea about what WikiPeep is and what can do. Building the content is made via [Symfony Console](https://github.com/symfony/console), so you will need to ssh to your virtual machine and run
```
artisan app:build
```

### Database structure

Building the JSON database will create a <code>database</code> directory inside <code>storage</code> which is located in the root of the app. All the contents are automatically created as <code>JSON</code> files. Each JSON represents an <code>markdown</code> article provided as a demo and located in <code>content</code> directory.

A JSON content has a dead simple structure, containing summary contents (when available) and the article body where will store the parsed content from markdown.

Also, by default, you have a creation date that will be used on front-end to display the "Last Updated" note. See [Configuration](#application-config) for updating date based on your timezone.
```json
{
    "summary": "An array with all Anchor links that will be used for generating the summary contents",
    "article": "The content of the article",
    "__update": "2020-12-26 07:33:33"
}
```


## Application Config
The base configuration of WikiPeep can be done via <code>.env</code>, but there is also some application related
configs that can be found under <code>config/</code> directory. There you have some basic settings that can influence the app functionality and appearance, like:

- Application name & logo
- SEO Meta Tags (title & description)
- Full namespaced controllers list (used for keeping routes clean)
- Icon Settings - By default WikiPeep comes with Dessert package (an SVG Renderer and Icon Library Manager that inserts SVG code directly, replacing the use of icon fonts or JavaScript icons) - Default Icon Library is [FeatherIcons](https://feathericons.com/)

## Roadmap
- [ ] Main Sidebar with the main directories
- [ ] Search support with Autocomplete (provided by a JSON created during the content building
- [ ] PouchDB support to store data locally to boost performance
- [ ] Breadcrumb navigation
- [ ] Support for private Wiki (Basic auth based on a common password provided via <code>.env</code> file)
- [ ] Theme support

## Known Bugs
Right now, there is no possible to create nesting directories in order to achive complex URLs.
