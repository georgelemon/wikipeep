**WikiPeep is still in heavy development. The UI is still buggy and basic functionalities needs more tests**<br>
**Wait for the first official release prepared for mid-January.**

![Landing page of WikiPeep](.github/wikipeep_screen.png)

**[Demo: WikiPeep 1.0 in action](https://georgelemon.com/wikipeep/)**

# Installing

You will need PHP 7.4 (**recommended ^8.0**). Since **WikiPeep** is a flat file database you don't have to setup any kind of database. Instead, we use [Flywheel](https://github.com/jamesmoss/flywheel) to read/write data and serve JSON file based.

```bash
git clone https://github.com/georgelemon/wikipeep.git
composer install
```

When clonning, by default there is no content inside <code>content</code> directory. If you want to have a content starter you can clone the official WikiPeep documentation repo inside of <code>content</code> directory. Be sure

```
rm -rf content
git clone https://github.com/georgelemon/wikipeep-contents.git content
```

Once you got the contents you can make your first build via <code>cli</code> using artisan <3
```
php artisan publish:all
```

Check available commands by running
```
php artisan
```

**[Full documentation, of course, available on WikiPeep](https://georgelemon.com/wikipeep/)**

_NOTE: WikiPeep is not made with Laravel or Symfony. It just use some components like Symfony Console, HttpFoundation, Illuminate Filesystem, Support and so on._

### Running on local
As I said, WikiPeep does not require a database or any complex setup. In fact, you can use it directly on your local and run it with [the built-in PHP web server](https://www.php.net/manual/en/features.commandline.webserver.php) - with whatever port you want:
```
php -S localhost:7575
# [Thu Dec 31 17:15:34 2020] PHP 8.0.0 Development Server (http://localhost:7575) started
```

#### Debugging and Error Handlers
By default, WikiPeep comes with a minimal and nice Error Handler that gets triggered when you're in development environment.

For more tips & things - [Go & read WikiPeep documentation](https://georgelemon.com/wikipeep) which is also the best demo and showcase.

**WikiPeep is still in heavy development. Wait for the first official release.**