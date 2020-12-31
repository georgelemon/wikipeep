**WikiPeep is still in heavy development. Wait for the first official release.**

![Landing page of WikiPeep](.github/wikipeep_screen.png)

# Installing

You will need PHP 7.4 or newer. Since WikiPeep is a flat file database you don't have to setup a database.
The [Flywheel](https://github.com/jamesmoss/flywheel) will be triggered while building the content via console.

```bash
git clone https://github.com/georgelemon/wikipeep.git
composer install
```

_NOTE: WikiPeep is not made with Laravel or Symfony. It just use some components like Symfony Console, HttpFoundation, Illuminate Filesystem, Support and so on._

### Running on local
As I said, WikiPeep does not require a database or any complex setup. In fact, you can use it with your built-in PHP and run it with [the built-in web server](https://www.php.net/manual/en/features.commandline.webserver.php) by running the following command (with whatever port you want):
```
php -S localhost:7575
# [Thu Dec 31 17:15:34 2020] PHP 8.0.0 Development Server (http://localhost:7575) started
```

#### Debugging and Error Handlers
WikiPeep comes with a minimal built-in Error Handler, you can see it in action by accesing the following [http://localhost:7575/error-handler](http://localhost:7575/error-handler) page made for error showcase. Here is the screenshot.

For more tips & things, [go and read WikiPeep documentation](https://georgelemon.com/wikipeep) which is also the best demo and showcase.

**WikiPeep is still in heavy development. Wait for the first official release.**