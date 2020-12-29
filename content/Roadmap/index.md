# Road map
<mark>Note, this roadmap is subject to change.</mark>

### [December 2020](#december-2020)
Still work in progress for the first version of WikiPeep, which will be <mark>1.0</mark>.
When will reach the January tasks will boost the version to 1.5

##### Core Features
- [x] Markdown parser, with a builtin version of [Parsedown](https://github.com/erusev/parsedown)
- [x] Flat file [Flywheel](https://github.com/jamesmoss/flywheel) JSON Database
- [x] Generate and build WikiPeep contents with <mark>artisan</mark> via [Symfony Console](https://github.com/symfony/console)
- [x] Router & Canonical URLs
- [x] Auto-generated aside navigation when building contents.
- [x] Auto-generated index of the search when building contents.
- [x] Auto-generated <strong>Summary Contents</strong> based on Anchor URLs provided in the article.
- [x] Theme support 😏
- [x] Configurations via <code>.env</code> and <code>ArrayAccess</code> Config in <strong>Laravel</strong> style
- [x] MVC Pattern w/ Model (where the actual Model is provided by <strong>Flywheel</strong>)

##### Front-end Features
- [x] Whitelabel
- [x] Search support with Autocomplete
- [x] Boost up performances of the Search Results by storing data via IndexedDB 
- [x] Code Syntax Support with [Rainbow JS](https://github.com/ccampbell/rainbow). Check [currently supported languages](https://github.com/ccampbell/rainbow#supported-languages).
- [x] Infobox Support for <strong>Article</strong> screen on various areas
- [x] Secure by default (There is no dashboard admin, at least not for now)
- [ ] Breadcrumb navigation
- [ ] Default theme Light & Dark (Manual switcher and based on user's OS preferences)

#### Parser Features
- [x] Tasks List [See reference](https://www.markdownguide.org/extended-syntax/#task-lists)
- [x] Anchor URLs [See reference](https://www.markdownguide.org/extended-syntax/#linking-to-heading-ids)

### API Features
- [ ] Create API Endpoint for accessing the search results

##### Other Features
- [ ] SEO ready
- [x] Composer ready

##### Bugfixes & Enhancements
- [ ] Overall bugfixing
- [ ] UI & UX improvements

### [January 2021](#january-2021)
- [ ] **Offline Mode Feature by Service Workers**
- [ ] **i18n** Internationalization
- [ ] Private Wiki Support (Basic Auth based on a common password provided via <code>.env</code> file)
- [ ] Support Channels area (Slack, Socials, Forum, website)
- [ ] Building/Rebuilding Enhancements (So it can build only new and modified contents)
- [ ] UI Improvements & Bugfixes

##### Parsedown Features
- [ ] Adding Support for Footnotes [See reference](https://www.markdownguide.org/extended-syntax/#footnotes)
- [ ] Adding Support for Headings IDs [See reference](https://www.markdownguide.org/extended-syntax/#heading-ids)

### [February 2021](#february-2021)
- [ ] Git Integration
- [ ] _Dashboard Integration?_
