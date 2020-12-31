# Composer Dependencies
Composer is great! While in version <code>1.0.0</code>, WikiPeep composer dependencies are the following
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


**Symfony\HttpFoundation** is used in order for using their awesome Session / Request / Response functionality, while **Flywheel** is used for storing all contents data parsed by a built in Parsedown that knows how to Parse Markdown data to a valid HTML code syntax.

Also, **Illuminate\Filsystem** is used to centralize all operations related to writing, checking anything related to additional files an directories. **Illuminate\Support** is a helpful utility suite that can easily work with Arrays, Strings and so on.

**Symfony\Console** represents the beautiful part where you can build your contents, cache and routes via <code>terminal</code>, and **Georgelemon\Dessert** gives an unique way of adding svg icons on the web, without dealing with JavaScript libraries or Webfonts.

In the end, **Vlucas\PHPDotEnv** is used by a basic feature of WikiPeep to make your wiki private by using an <code>.env</code> file where you can store a simple password and share with your team in order to get access to your WikiPeep instance.