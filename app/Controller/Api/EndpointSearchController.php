<?php

namespace App\Controller\Api;

class EndpointSearchController
{
    /**
     * The GET method for retrieving the search results
     * 
     * @return Response JSON Endpoint
     */
    public function get()
    {
        if( $output = flywheel()->getById('__search-results', '__search', null) )  {
            return response()->json($output->results);
        }
        
        return print response()->json(['status' => '404']);
    }
}