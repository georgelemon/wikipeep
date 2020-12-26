<?php

namespace App\Core\Http;

class Uri extends UriGenerator
{
    /**
     * Call function for Class
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (empty($parameters)) {
            array_push($parameters, '');
        }

        if (strpos($method, 'secure') !== 0) {
            return call_user_func_array([$this, $method], $parameters);
        }

        array_push($parameters, true);
        $methodName = strtolower(str_replace('secure', '', $method));
        return call_user_func_array([$this, $methodName], $parameters);
    }
}