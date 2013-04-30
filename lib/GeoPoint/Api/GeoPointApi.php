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

        $this->setUrl( ':protocol://api.neustar.biz/ipi/std/v1/:path' );
        $this->setOption( 'protocol', 'http' );                       
    }    
    
    public function getClient()
    {
        return $this->client;
    }
    
    public function setUrl( $url ) 
    {
        return $this->client->setUrl( $url );
    }
    
    public function setOption( $k, $v )
    {
        return $this->client->setOption( $k, $v );
    }
    
    public function get($path, array $parameters = array(), $requestOptions = array()) {
        return parent::get( 'ipinfo/' . $path, $parameters, $requestOptions);
    }
}
