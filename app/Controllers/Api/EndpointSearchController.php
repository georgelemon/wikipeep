<?php

namespace App\Controllers\Api;

class EndpointSearchController
{
    /**
     * The GET method for retrieving the search results
     * 
     * @return Response JSON Endpoint
     */
    public function get()
    {
        if( $output = app()->filesystem()->get(STORAGE_PATH . DS . '/search-results.json') )  {
            $tesst = json_decode($output);
            return print response()->json($tesst);
        }
        
        return print response()->json(['status' => '404']);
    }
}