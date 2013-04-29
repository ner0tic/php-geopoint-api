<?php
namespace GeoPoint;

use Core\Client as BaseClient;

class Client extends BaseClient
{
    /**
     *
     * @var string $key 
     */
    protected $key;
    
    /**
     *
     * @var string $secret 
     */
    protected $secret;
    
    /**
     * 
     * @param string $name
     * @return GeoPoint\Api
     */
    public function api( $name )
    {
        if( !isset( $this->apis[ $name ] ) )
        {
            switch( $name )
            {
                case 'location':
                case 'Location':
                    $api = new Api\Location( $this );
                    break;
                case 'network':
                case 'Network':
                    $api = new Api\Network( $this );
                    break;
                default:
                    $api = new Api\IpInfo( $this );
                    break;
            }
            $this->apis[ $name ] = $api;            
        }
        
        return $this->apis[ $name ];
    }
    
    /**
     * 
     * @return string
     * @throws \Exception missing login
     * @throws \Exception missing secret
     */
    private function generateSig()
    {
        if( is_null( $this->getApiKey() ) )
            throw new \Exception( 'Must supply an api key' );
        if( is_null( $this->getSecret() ) )
            throw new \Exception ( 'Must supply an api secret' );
        
        return md5( $this->getApiKey() . $this->getSecret() . gmdate( 'U' ) );
    }
    
    /**
     * 
     * @param string $key
     * @return \GeoPoint\Client
     */
    public function setApiKey( $key )
    {
        $this->key = $key;
        
        return $this;
    }
    
    /**
     * 
     * @return string $key
     */
    public function getApiKey()
    {
        return $this->key;
    }
    
    /**
     * 
     * @param string $secret
     * @return \GeoPoint\Client
     */
    public function setSecret( $secret )
    {
        $this->secret = $secret;
        
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }
    
    /**
     * 
     * @param string $path
     * @param array $parameters
     * @param array $requestOptions
     * @return type
     */
    public function get( $path, array $parameters = array(), $requestOptions = array() )
    {
        $parameters = array_merge( 
                $parameters,
                array(
                    'format'    =>  'json',
                    'sig'       =>  $this->generateSig(),
                    'apikey'    =>  $this->getApiKey()
        ) );
        
        return parent::get( $path, $parameters, $requestOptions );
    }
}