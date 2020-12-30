# Does WikiPeep works on a Shared hosting?
Well, depends on what you got. In this world full with shared hostings most probably you will not have <code>SSH</code> access. Anyway, even without root access you can still use WikiPeep but this requires some extra steps.


##### Still, looking to change your hosting?
I highly recommend you [Hetzner VPS Clouds](https://www.hetzner.com/cloud). They're around from 1994, so they "know how to roll a joint". Maybe you will ask _what about DigitalOcean, Vultr_? They're good too, but their resources are too low and prices to high. Keep it real, go with Hetzner (They got servers in Germany & Finland).


## Back to your shared hosting
While you're still on your local environment, you will need to optimize your Composer autoloader.<br>
[You can read here more about it](https://getcomposer.org/doc/articles/autoloader-optimization.md)

## Be sure your content is what you expect
Since you will not be able to run terminal commands on your shared hosting, you will need to be sure your content is as you expected.


## FTP. The classic way
Using your FTP credentials you can upload the entire WikiPeep application. Assuming your first directory access starts with <code>/var</code>, and continues with <code>/www/public_html/</code>, you will have to upload the entire project under a directory name, name it <code>wikipeep</code> and place it under <code>/www/</code>.

## Public to public (only)
If you're coming from Wordpress-style environments I must say that WikiPeep structure is a bit different.
So, after your WikiPeep instance is uploaded on FTP, go to <code>wikipeep/public</code>, edit the <code>index.php</code> and change its path to something like this

```php
require __DIR__ . DIRECTORY_SEPARATOR . '../wikipeep/bootstrap.php';
```

By doing this, you make <code>index.php</code> to find the real autoloader of WikiPeep, <code>bootstrap.php</code>. Now we made this change, you can grab all the contents (including .htaccess) from public and move to your <code>public_html</code>. If you already host something in your public_path and you don't want WikiPeep to be loaded when accesing <code>domain.tld</code>, then, move all contents from WikiPeep <code>public</code> directory to a subdirectory from <code>public_path</code>, call it... let's say it <code>docs</code>, so when you'll access in browser <code>domain.tld/docs</code> you will have WikiPeep running it.

**By moving to a subdirectory you will have to update again the <code>index.php</code> of WikiPeep so you will have**

```php
require __DIR__ . DIRECTORY_SEPARATOR . '../../wikipeep/bootstrap.php';
```
**So, for each deep level you will have to go out one more time in order to make <code>index.php</code> reach <code>bootstrap.php</code> **

[Read about .htaccess and rewrite rules](/faqs/routes-are-not-working)