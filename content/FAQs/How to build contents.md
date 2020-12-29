# How to build contents?
Okay, first, be sure your content is located under <code>content</code> directory. In order to make things working a valid structure of a section should look like this

```
- content
    - Getting Started
        - Things to read before anything.md
```

While building the structure listed above will become:
```
yourdocs.tld/getting-started/things-to-read-before-anything
```

Also, without providing an <code>index.md</code> inside your "Getting Started", the auto-generated index will contain a list with all available pages published under that directory/category. So, if you want to have a specific content when accessing <code>/getting-started/</code> just create an <code>index.md</code> and write your desired content.


## Available Commands
There are multiple commands for building content. If you want to rebuild the entire documentation, including new content, modified and unmodified markdown pages just run
```
artisan build:all
```

Otherwise, the recommended way is to run the build only for new markdown pages so is enough to run
```
artisan build:new
```

If you don't have any new files but you just made some changes to some previously published contents, then you can run
```
# building only previously published markdowns that contains unparsed changes
artisan build:edits

# if that's not that handy maybe you want
artisan build:changes

# or, if that's not for you maybe
artisan build:modifications

# all these three commands are doing the same thing, the only difference just the name they have.

```


