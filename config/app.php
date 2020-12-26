<?php


return [

    'name' => 'WikiPeep',
    'logo' => '',
    'meta_name' => 'WikiPeep - A simple markdown wiki for busy devs',
    'meta_description' => '',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', ''),
    'cipher' => 'AES-256-CBC',
];

