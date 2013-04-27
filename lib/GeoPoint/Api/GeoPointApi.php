<?php
namespace GeoPoint\Api;

use GeoPoint\Client;

class GeoPointApi extends Client
{
    protected $client = null;
    
    public function __construct( Client $client = null ) 
    {
        $this->client = $client instanceof Client ? $client : new Client();

        $this->client->setUrl( 'api.neustar.biz/ipi/std/:path' );
        $this->client->setOption( 'protocol', 'http' );               
        
    }
    
    
}