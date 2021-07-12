<p align="center"><img src="https://github.com/georgelemon/wikipeep/blob/node/.github/wikipeep.png" width="200px" alt="Wikipeep"><br><strong>Wikipeep is a high performant platform<br> for creating fast & beautiful wiki documentations for your projects (WIP)</strong></p>

**Currently, in heavy development.** Most of these are simple beautiful notes, not implemented yet.<br>This is a monorepo containing the source code for `backend`, `frontend` and `command line interface`.

# Key features
- [x] Command Line Interface
- [x] PostgreSQL via Enimsql ORM
- [x] Secured by default (no dashboard interface)
- [x] High Performant based on **Jester**, written in **Nim**
- [ ] **IndexedDB Storage**
- [ ] UI Dark & Light theme
- [ ] UI Search w/ Autocomplete
- [x] UI Manual theme switcher
- [x] UI Responsive Layout
- [x] UI Based on latest Bootstrap (SCSS only)
- [x] UI Code syntax 
- [ ] UI HighCharts and dynamic stats
- [ ] Powerful Search w/ **Typesense** (See the Advanced Setup chapter)
- [ ] Offline Support (based on `IndexedDB` and `Web Workers`)
- [x] SEO `Botland` (Server side text-only & markup renderer for SEO bots)
- [x] Open Source under GPLv3

### Backend
Wikipeep backend is a REST API and a server at the same time - written in Nim, powered by Jester framework. It is also used for frontend routing and as a Botland handler for rendering text/markup contents for SEO bots.

The Backend provides only GET routes, and is wired to Norm ORM for read-only access from an SQLite or PostgreSQL database.

Once we have a stable release for Wikipeep you'll be able to get the backend as a one-file binary package. For more details about running on a live server [jump to Production](#production).

### CLI
From `command line interface` you will be able to control your Wikipeep instance. Is written in Nim, powered by Klymene and provides full access to your Wikipeep contents and UI settings.

The CLI is wired to Norm ORM with full `read/write` access to your SQLite or PostgreSQL database instance. **The command line interface is separated from backend,** and is also available as a small binary package ready for symlinking to your `PATH`.

**Available Wikipeep CLI commands**
```
Wikipeep 🤟 Open Source Wiki for Busy Devs

Usage:
    wikipeep status                       Determine if there are any unpublished changes
    wikipeep publish <status>             Compile markdown contents and publish changes
    wikipeep set [--visibility] [--port]  Modify ENV configuration file via command line
                 [--name] [--contents]
    wikipeep reload                       Reload Wikipeep server
    wikipeep (-h | --help)
    wikipeep (-v | --version)

Options:
    -h --help        Show this screen.
    -v --version     Show version.
```

For setting your Wikipeep private or other `set` flags 
```bash
# change the visibility of your Wikipeep
wikipeep set --visibility=true

# set the contents path
wikipeep set --contents=/var/home/www/wikipeep/contents

# set port for Wikipeep server
wikipeep set --port=51050

# set Wikipeep display name
wikipeep set --name="Project Documentation"

# Hidden Service Gems

# All services are separated by flags expecting a boolean value,
# it can be either 'true', 'false' or '1', '0'.
# Also accepted 'yes' and 'no', lowercase/uppercase

# Enable Typesense implementation.
wikipeep service --typesense=true

# Enable offline mode via Web Workers API
wikipeep service --webworker=true

# Enable IndexedDB API
wikipeep service --indexeddb=true

# Enable the Redis-like service
# For using Renims, first you will need to boot Renims instance
wikipeep service --renims=true

# Enable the UI controller for theme switcher
wikipeep service --themeswitch=true

```

Once set, next time when you'll access your Wikipeep it will prompt a password screen.<br>
**Note that the password protection is a simple middleware-like cookie-session based authentication.**

### Frontend
Wikipeep frontend is fully made with Vanilla JavaScript, packed & minified with Rollup.js.

At this moment the entire User Interface is dynamically created using Élo, an template engine written in pure JavaScript.

The contents are retrieved via a transparent REST API with CORS policy and backed by Nim. This is the best approach since we make use of IndexedDB for storing locally the database directly in browser and also to make Wikipeep available in offline mode through Web Workers API.

The style sources of the default theme are available as SCSS and minified using Dart Sass. So, there are no direct dependencies via Node.


# Wikipeep - Hidden Gems

## ORM
Wikipeep ORM is powered by Enimsql working with PostgreSQL.

Here are some optional things that may be helpful if you plan to run an Wikipeep instance with large data sets and heavy documentations.

**Here are some interesting thigns if you plan to run Wikipeep with large documentation pages and expect a heavy traffic**

1. **Enable the Lightning-fast Instant Search with Typesense**
Written in C++, Typesense is an open source alternative to Algolia. Also, a better and easier to install/use ElasticSearch alternative.

2. **Enable IndexedDB**
IndexedDB is a powerful transparent key/value database handled by modern Browsers. With IndexedDB we can store a copy of the entire Wikipeep and make it available to user directly from its Browser.

3. **Enable Offline mode with Web Workers**
By default, disabled, the Offline mode can help your readers to keep a copy of your entire Wikipeep while they are offline.

4. **Enable Renims**
Renims is a built-in module implementation inspired by Redis and written in Nim. Renims is a separate server and can store `key/value` data, serving as an external cache manager.

## Compile it yourself
If you want to compile the `backend` and `cli` from sources you will need the following:
- Nim & Nimble (latest versions)
- Clang (latest version)
- PostgreSQL
- NodeJS (required only for client side changes)
- DartSass

Both `backend` and `cli` share the same Nimble project. When compiling, the output will create 2 different binary packages. One for `backend`, one for `cli` and will be placed under `/bin` directory.

For starting the server, go to `/bin` directory and call `./wikipeep` binary
```
cd backend && nimble build
cd ../bin && ./wikipeep
```

If you want to turn off the CLI logging, you can compile Wikipeep with `release` flag.
```
nimble build -d:release
```

For setting the CLI binary to your `PATH` is enough to create a symlink and place in `/etc/usr/local`
```
ln -s /path/to/wikipeep/bin/cli /etc/usr/local/wikipeep
```

### Environment
Wikipeep requires a `.env` file placed under `/app` directory. The `ENV` file contains the following keys
```bash
YAML_PATH           # Absolute path to wikipeep.yaml file
DB_DRIVE            # Choose the database driver, it can be 'pgsql', 'sqlite', 'json'
                    # The following are required only for PostgreSQL connections
DB_HOST             # DATABASE hostname or IP address
DB_NAME             # DATABSE name
DB_USER             # DATABSE username
DB_PASS             # DATABSE password for given username
```

At the same time, there is a `wikipeep.yaml` in the root of the source project. This YAML is a human-readable settings interface for Wikipeep instance that is loaded by Wikipeep on boot time.

## Contents
Your Wikipeep `contents` directory can be placed anywhere. For linking the `contents` dir to your Wikipeep instance is enough to open `wikipeep.yaml` and change the path.

Contents structure is simple. Let's take the following example to understand how Wikipeep creates the website tree, sections and pages and the URLs.

```bash
contents                        # the root point - everything inside will get validated and indexed.
    _settings.yaml              # the overall YAML Configuration file
    Getting Started             # folder used for creating a '/getting-started/' section
        Getting Started.md      # the main markdown page used as index of 'getting-started' section
        Installation.md         # more markdown files
        ...
        _settings.yaml          # YAML Configuration file for current section
    Development                 # another folder for creating '/development' section
        Local Environment.md
        ...
    ...
```

_Currently, Wikipeep does not support a deeper directory structure more than one level. So if you have another directory with markdown files inside of `Getting Started`, it will automatically map the markdown files to their root parent directory._

The built-in Markdown parser currently supports the following:
- [x] Links
- [x] Images
- [x] Headings (auto anchors)
- [x] Unordered Lists
- [x] Ordered Lists
- [ ] Check/Uncheck Lists
- [ ] Code syntax
- [ ] Tables

## Production
**First off, I would not recommend you Docker.** If you want to use Wikipeep in a container, you can definitely try give a look at [Linux Containers | LXD | LXC](https://linuxcontainers.org/).

Note: Wikipeep binaries have a very small size, can run very well on low resources and can be used on any VPS / Linux-based operating system.

Is highly recommended to use NGINX as a reverse proxy for your Wikipeep application.

Once you have NGINX installed on your server, you will need to configure it. Create a wiki.website.com file (replace the hostname with your wikipeep hostname) inside /etc/nginx/sites-available/.
<details>
    <summary>NGINX Configuration</summary>

```bash
server {
        server_name wiki.website.com;
        autoindex off;

        location / {
                proxy_pass http://127.0.0.1:6533;
                proxy_set_header Host $host;
                proxy_set_header X-Real_IP $remote_addr;
        }
}
```

For activating the NGINX server block create a symlink and place it in `sites-enabled` directory.
```bash
ln -s /etc/nginx/sites-avilable/wiki.website.com /etc/nginx/sites-enabled/wiki.website.com
```

Once symlinked, you can restart NGINX service
```bash
service nginx restart
# or try with sudo
sudo service nginx restart
# or if you have nginx cli installed
sudo nginx -s reload
```
</details>

<details>
<summary>Systemd Service Configuration</summary>

For keeping your Wikipeep instance always live after a crash or a server boot, you'll need to create a `systemd` service for it.

```bash
[Unit]
Description=wikipeep
After=network.target httpd.service
Wants=network-online.target

[Service]
Type=simple
# Change paths to correspond with your Wikipeep path
WorkingDirectory=/home/<user>/wikipeep/
ExecStart=/usr/bin/stdbuf -oL /home/<user>/wikipeep/server
# Restart when crashes.
Restart=always
RestartSec=1
# Create a limited user group or use www-data
User=<user>
# StandardOutput=syslog+console
# StandardError=syslog+console

[Install]
WantedBy=multi-user.target
```

After creating `systemd` service file you can enable and start the service
```bash
systemctl enable wikipeep
systemctl start wikipeep
```
For checking the service status
```bash
systemctl status wikipeep
```
</details>

## Notes
_New to Nim? Nim is a statically typed compiled systems programming language. It combines successful concepts from mature languages like Python, Ada and Modula. [Find out more about Nim, and Nimble](https://nim-lang.org/)_

## License
Wikipeep is developed & maintained by George Lemon. Released under GPLv3 license.<br>
Wikipeep is written in [Nim language](https://nim-lang.org/) 💛 powered by [Jester framework](https://github.com/dom96/jester).