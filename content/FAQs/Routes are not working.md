# Got stuck with routes?
Most probably this is because you didn't setup your machine correctly. First, if you haven't done this before then let's go through it and solve it. It's kinda simple.

# Running on Apache?

By default WikiPeep comes with a <code>.htaccess</code> file located in <code>public</code>  directory of the app. If, for some reasons that file is missing from your instance then you can create one and past the following rules:
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php [L]
```

### Running on NGINX
On NGINX things are minimal but you will need to have <code>SSH</code> access to your server. If you run WikiPeep on a shared hosting then contact your hosting provider and tell them to add the following directive to your domain.
```
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

[Trying to run WikiPeep on a (limited) shared hosting?](faqs/wikipeep-on-shared-hosting)
