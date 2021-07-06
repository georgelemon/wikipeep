<p align="center"><img src="https://github.com/georgelemon/wikipeep/blob/node/.github/wikipeep.png" width="255px" alt="Wikipeep"><br><strong>Wikipeep is a high performant platform<br> for creatingfast & beautiful wiki documentations for your projects (WIP)</strong></p>

Currently in heavy development. This is a monorepo containing code sources for `backend`, `frontend` and the `command line interface`.

# Key features
- [ ] SQLite or PostgreSQL
- [ ] Command Line Interface
- [x] Secured by default (no dashboard interface)
- [x] High Performant based on **Jester**, written in **Nim**
- [ ] **IndexedDB Storage**
- [ ] UI Dark & Light theme
- [ ] UI Search w/ autocomplete
- [ ] Fast search w/ **Typesense**
- [ ] Offline Support (based on `IndexedDB` and `Web Workers`)
- [ ] SEO `Botland` (Server side text/markup renderer for SEO bots)
- [x] Open Source under GPLv3


### Backend
Wikipeep backend is a REST API and a server at the same time - written in Nim, powered by Jester framework. It is also used for frontend routing and as a Botland for rendering text/markup contents for SEO bots.

The Backend provides only GET routes, and is wired to Norm ORM for read-only access from an SQLite or PostgreSQL database.

Once we have a stable release for Wikipeep you'll be able to get the backend as a one-file binary package. For more details about running on a live server [jump to Production](#production).

### CLI
From `command line interface` you will be able to control your Wikipeep instance. Is written in Nim, powered by Klymene and provides full access to your Wikipeep contents and UI settings.

The CLI is wired to Norm ORM with full `read/write` access to your SQLite or PostgreSQL database instance. **The command line interface is separated from backend,** and is also available as a small binary package which can be easily symlinked to your `PATH`.

**Available Wikipeep CLI commands**
```
Wikipeep 🤟 Open Source Wiki for Busy Devs

Usage:
    wikipeep status                       Determine if there are any unpublished changes
    wikipeep publish <status>             Compile markdown contents and publish changes
    wikipeep make <visibility>            Make your Wikipeep instance "private" or "public"
    wikipeep (-h | --help)
    wikipeep (-v | --version)

Options:
    -h --help        Show this screen.
    -v --version     Show version.
```

**Wikipeep visibility**
For making your Wikipeep private is enough to run the following command
```bash
wikipeep make private
```

Once set, next time when you'll access your Wikipeep it will prompt a password screen.<br>
**Note that the password protection is a simple middleware-like cookie-session based authentication.**

### Frontend
Wikipeep frontend is fully made with Vanilla JavaScript, packed & minified with Rollup.js. The style sources of the default theme are available as SCSS and minified using Dart Sass. So, there are no direct dependencies via Node.

The frontend provides some minimal kick-ass features like
- [ ] Dark & Light theme
- [ ] Manual theme switcher
- [ ] Search w/ Autocomplete
- [ ] Responsive Layout
- [ ] Based on latest Bootstrap (SCSS only)
- [ ] Code syntax 

## Compile it yourself
If you want to compile the `backend` and `cli` from sources you will need the following:
- Nim & Nimble (latest versions)
- Clang (latest version)
- SQLite or PostgreSQL (SQLite is recommended for small Wikipeep instances)
- NodeJS (required only for client side changes)
- DartSass

Both `backend` and `cli` share the same Nimble project. When compiling the output will create 2 different binary packages. One for `backend`, one for `cli` and will be placed under `/bin` directory.

```
cd backend && nimble build
cd ../bin && ./server
```

If you want to turn off the command line logging, you can compile Wikipeep with `release` flag.
```
nimble build -d:release
```

## ORM
Wikipeep ORM is powered by Norm which supports SQLite and PostgreSQL.


## Production
**First off, I would not recommend you Docker.** If you want to use Wikipeep in a container, you can definitely try look at [Linux Containers | LXD | LXC](https://linuxcontainers.org/).

Note: Wikipeep binaries comes in very small sizes, can run very well on low resources and can be used on any VPS / Linux-based operating system.

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

_New to Nim? Nim is a statically typed compiled systems programming language. It combines successful concepts from mature languages like Python, Ada and Modula. [Find out more about Nim, and Nimble](https://nim-lang.org/)_

## License
Wikipeep is developed & maintained by George Lemon | Released under GPLv3 license. Wikipeep is written in [Nim language](https://nim-lang.org/) 💛 powered by [Jester framework](https://github.com/dom96/jester).