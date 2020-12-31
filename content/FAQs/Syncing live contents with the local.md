# Syncing your live contents with the local
Well, the best solution is to add your <code>/content</code> directory to a git repository for versioning, so you can have it separately from WikiPeep instance.

Once you're on git, you can just <code>ssh</code> to your live machine and <code>git pull</code> from there and also <code>artisan build:all</code>.

## On shared hosting
Probably the only solution is to delete the <code>/storage/database</code>  directory and upload it back the updated <code>database</code> from your local machine.