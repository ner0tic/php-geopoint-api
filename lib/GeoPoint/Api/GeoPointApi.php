<?php
namespace GeoPoint\Api;

use Core\Api\AbstractApi,
    GeoPoint\Client;

class GeoPointApi extends AbstractApi
{
    /**
     *
     * @var GeoPoint\Client $client 
     */
    protected $client;
    
    /**
     * 
     * @param \GeoPoint\Client $client
     */
    public function __construct( Client $client = null ) 
    {
        $this->client = $client instanceof Client ? $client : new Client();

        $this->setUrl( 'http://api.neustar.biz/ipi/std/v1/:path' );
                              
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
    
    public function get($path, array $params = array(), $requestOptions = array()) {
        return $this->client->get( 'ipinfo/' . $path, $params, $requestOptions);
    }
    
    public function api( $api )
    {
        return $this->client->api( $api );
    }
}
