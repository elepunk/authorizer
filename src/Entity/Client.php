<?php namespace Elepunk\Authorizer\Entity;

use League\OAuth2\Server\Entity\ClientEntity;

class Client extends ClientEntity
{
    /**
     * Client key
     * 
     * @var string
     */
    protected $key = null;

    /**
     * Return the client key
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
