<?php

namespace App\Core\Kernel;

use App\Core\Encryption\Encrypter;

class AppKeyGenerator {

    /**
     * Return a generated key
     */
    protected function generateSecuredKey(string $cipher)
    {
        $cipher = app()->config()->get('app.cipher');
        return 'base64:' . base64_encode(Encrypter::generateKey($cipher));
    }

    /**
     * Callable method that will create the APP key during the installation
     */
    public function create()
    {
        $config = app()->config();

        /**
         * Prevent regenerating  key once the application is installed.
         *
         * IMPORTANT! In case you lost your key and stuff cannot be decrypted:
         *
         * There is a secondary dot file located in root of the project,
         * called ".archived" and contains all your APP Keys
         */
        if( $config->get('app.installed')) {
            return false;
        }

        $key = $this->generateSecuredKey( $config->get('app.cipher') );
    }

}