# Open Source Wiki for Busy Devs (WIP)


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

## Roadmap
- [ ] Main Sidebar with the main directories
- [ ] Search support with Autocomplete (provided by a JSON created during the content building
- [ ] PouchDB support to store data locally to boost performance
- [ ] Breadcrumb navigation
- [ ] Support for private Wiki (Basic auth based on a common password provided via <code>.env</code> file)
- [ ] Theme support

## Known Bugs
Right now, there is no possible to create nesting directories in order to achive complex URLs.
