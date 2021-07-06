<p align="center"><img src="https://github.com/georgelemon/wikipeep/blob/node/.github/wikipeep.png" width="255px" alt="Wikipeep"><br><strong>(WIP) Wikipeep is a high performant platform for creating fast and beautiful wiki documentations for your projects.</strong></p>

**This branch represents the new direction of Wikipeep.** Currently in heavy development. This is a monorepo containing code sources for backend, frontend and the command line interface.

_Previously Wikipeep started as a PHP project and currently rewritten in Nim and vanilla JavaScript._

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
- [ ] SEO Botland (Text/Markup only renderer for SEO bots)
- [x] Open Source under GPLv3


### Backend
Wikipeep backend is a REST API and server written in Nim, powered by Jester framework. It is also used for frontend routing and as a Botland for rendering Text/Markup only contents for SEO bots.

Once we have a stable release for Wikipeep you can get the backend as a one-file binary package. For more details about running on a live server [jump to Production](#production).

### Frontend
The frontend is fast and fully made with Vanilla JavaScript, packed & minified with Rollup.js.

### CLI
From command line interface you can control your Wikipeep instance. Is written in Nim, powered by Klymene and provides full access to your Wikipeep contents and UI settings.

## Compile it yourself
If you want to compile the `backend` and `cli` from sources you will need the following:
- Nim & Nimble (latest versions)
- Clang (latest version)
- SQLite or PostgreSQL (SQLite is recommended for small Wikipeep instances)
- NodeJS (required only for client side changes)

## Production
For intalling Wikipeep on a server is highly recommended to use NGINX as a reverse proxy for Wikipeep application.

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