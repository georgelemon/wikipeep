# How to build cache?
Caching can be done via <code>terminal</code> by running the following command:

```
artisan build:cache
```

Once your caching process is done you will get:
1. 😱 **All routes fully cached** so there will not be any background verifications for validating the routes.
2. 😵 **Flywheel APC Cache** if APC is available on your machine

**Hey, what about caching the search results?**<br>
The search results are by default cached directly in user's browser via **Indexed DB**.

**What about invalidating/refreshing the IndexedDB search results?**<br>
This is related to <code>build:all</code> command. [Check this page for more details](not-yet)