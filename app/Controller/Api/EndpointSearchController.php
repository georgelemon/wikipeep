<?php

namespace App\Controller\Api;

class EndpointSearchController
{
    /**
     * The GET method for retrieving the search results from
     * compiled flat file JSON and create an API endpoint
     * so it can be used for search & autocomplete feature.
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