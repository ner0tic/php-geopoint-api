<?php
namespace GeoPoint;

use Core\Client as BaseClient;

class Client extends BaseClient
{
    protected $key = false;
    
    protected $secret = false;
    
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
    
    private function generateSig()
    {
        if( !$this->login )
            throw new \Exception( 'Must supply an api key' );
        if( !$this->secrect )
            throw new \Exception ( 'Must supply an api secret' );
        
        return md5( $this->login, $this->secret, gmdate( 'U' ) );
    }
    
    public function setApiKey( $key )
    {
        $this->key = $key;
        
        return $this;
    }
    
    public function setSecret( $secret )
    {
        $this->secret = $secret;
        
        return $this;
    }
    
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