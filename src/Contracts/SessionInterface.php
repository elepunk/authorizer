<?php namespace Elepunk\Authorizer\Contracts;

use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface as BaseInterface;

interface SessionInterface extends BaseInterface
{
    /** 
     * Delete an existing session
     * 
     * @param  \League\OAuth2\Server\Entity\SessionEntity $entity
     * @return void
     */
    public function delete(SessionEntity $entity);
}
