<?php

/**
 * This is the page where you can add as many custom routes you want.
 * The WikiPeep base routes are living in app.php
 */


route()->get('error-showcase', function() {
    print $whatsWrongPeep;
});