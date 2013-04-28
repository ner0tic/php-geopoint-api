<?php
namespace GeoPoint;

use Core\Client as BaseClient;

class Client extends BaseClient
{
    /**
     *
     * @var string $key 
     */
    protected $key = null;
    
    /**
     *
     * @var string $secret 
     */
    protected $secret = null;
    
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
        if( !$this->key )
            throw new \Exception( 'Must supply an api key' );
        if( !$this->secrect )
            throw new \Exception ( 'Must supply an api secret' );
        
        return md5( $this->login, $this->secret, gmdate( 'U' ) );
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
                    'apikey'    =>  $this->key
        ) );
        
        return parent::get( $path, $parameters, $requestOptions );
    }
}