<?php
namespace GeoPoint\Api;

use GeoPoint\Client;

class GeoPointApi extends Client
{
    /**
     *
     * @var GeoPoint\Client $client 
     */
    protected $client = null;
    
    /**
     * 
     * @param \GeoPoint\Client $client
     */
    public function __construct( Client $client = null ) 
    {
        $this->client = $client instanceof Client ? $client : new Client();

        $this->client->setUrl( 'api.neustar.biz/ipi/std/:path' );
        $this->client->setOption( 'protocol', 'http' );                       
    }    
    
    public function getClient()
    {
        return $this->client;
    }
}
