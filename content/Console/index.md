# Console Commands
If you're coming from Laravel & Symfony world then you already know about it - so you can skip.

Console gives WikiPeep the power to be controlled via a terminal, which makes everyting a pleasure.
Things like building contents based on their status, caching routes and managing the status of the application.
Without the Symfony Console API all these couldn't be possible without dealing with an dashboard admin interface, which we don't need it yet, and we don't have in plan to make one too soon.

## [Availalbe Commands](#available-commands)

You can find all available commands using
```
php artisan
```
You will get the following list
```
Available commands:
  help         Displays help for a command
  list         Lists commands
 build
  build:all         Builds the content of the application based on provided markdown.
  build:edits       Builds contents only for modified articles that are already published.
  build:new         Builds only new contents based on new markdown files.
 cache
  cache:routes      Cache all valid routes
 clear
  clear:routes      It clears all cache routes without creating a new cache instance
  clear:contents    Warning! It clears all contents stored in database repository,
                    including search results, categories, articles, navigation items.
                    This command has nothing to do with your Markdown contents.
  has
   has:edits        Determine if there are any unpublished edits,
                    in case you forgot what you wrote last night.

  put:private       Makes your WikiPeep instance private based on a basic password
                    that you can set via terminal and will be stored in .env file located in root of the app.
  put:public        Turns off the private mode without deleting the previously password.
  put:down          Puts the enitre application down for maintenance, showing a nice 500 error page.
  put:up            Brings the application back online from maintenance.
   
```

## Todos
Future commands to be added are the following.

Show which markdown files have been edited without being published with
```
artisan show:edits
```