# Why Summary Contents sidebar is not showing?
In order to make Summary Contents available in one of your article screen, first you will need to have some URL anchors declared in your markdown content.

So, instead of having a simple headline like
```
# Happy New Year, Peep!
Open source is great - This winter we did something very niice.
```

You can turn on the summary contents by adding an anchor like
```
# [Happy New Year, Peep!](#happy-new-year-peep)
Open source is great - This winter we did something very niice.
```

Now, let's build the edits using the <code>command</code>
```
artisan build:edits
```

Summary contents sidebar should be now visible in your article screen. 🙌
