<?php

return [
    'report' => true,
    'log'    => function ($e) {
        $data = [
            'date'    => date("Y-m-d H:i:s"),
            'message' => $e->getMessage(),
            'trace'   => $e->getTrace(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile()
        ];

        file_put_contents(STORAGE_PATH . '/logs/errors.log', json_encode($data) . "\n", FILE_APPEND | LOCK_EX);
        
        echo '<pre>';
        echo $e->getMessage() . "\n";
        echo 'The error has been logged in /storage/logs/errors.log';
        echo '</pre>';
    }
];
