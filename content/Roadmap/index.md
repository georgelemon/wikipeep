# Road map
<mark>Note, this roadmap is subject to change.</mark>

#### [December 2020](#december-2020)
- [x] Markdown parser, with a builtin version of [Parsedown](https://github.com/erusev/parsedown)
- [x] Flat file [Flywheel](https://github.com/jamesmoss/flywheel) JSON Database
- [x] Generate and build WikiPeep contents with <mark>artisan</mark> via [Symfony Console](https://github.com/symfony/console)
- [x] Automatically build the Aside Navigation when creating contents with <mark>artisan</mark>
- [x] Search support with Autocomplete
- [x] Automatically build the index of the search when building contents.
- [x] Code Syntax support with [Rainbow JS](https://github.com/ccampbell/rainbow). Check [currently supported languages](https://github.com/ccampbell/rainbow#supported-languages).
- [x] Theme support
- [x] Default theme Light & Dark (Manual switcher and based on user's OS preferences)
- [x] Whitelabel
- [x] Anchor URLs Support via <strong>Article</strong> screen
- [x] Summary Contents based on Anchor URLs via <strong>Article</strong> screen
- [x] Infobox Support for <strong>Article</strong> screen on various areas
- [x] Secure by default (There is no dashboard admin, at least not for now)
- [x] Composer ready
- [x] Router & Canonical URLs
- [x] SEO ready
- [x] MVC Pattern w/ Model (where the actual Model is provided by <strong>Flywheel</strong>)
- [x] Configurations via <code>.env</code> and <code>ArrayAccess</code> Config in <strong>Laravel</strong> style


#### [January 2021](#january-2021)
- [ ] PouchDB support to store data locally to boost performance
- [ ] Internationalization
- [ ] Breadcrumb navigation
- [ ] Support for private Wiki (Basic auth based on a common password provided via <code>.env</code> file)
- [ ] Support Channels area (Slack, Socials, Forum, website)
- [ ] Building/Rebuilding Enhancements (So it can build only new and modified contents)
- [ ] UI Improvements & Bugfixes

#### [February 2021](#february-2021)
- [ ] Git Integration
- [ ] _Dashboard Integration?_
