<?php namespace Elepunk\Authorizer\Storage;

use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Elepunk\Authorizer\Contracts\SessionInterface;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Storage\AbstractStorage;
use Elepunk\Authorizer\Model\Session as SessionEloquent;

class Session extends AbstractStorage implements SessionInterface
{
    /**
     * OAuth2 client type
     */
    const OWNERTYPE = 'client';

     /**
     * {@inheritdoc}
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $eloquent = SessionEloquent::whereHas('accessToken', function (Builder $q) use ($accessToken) {
            $q->where('access_token', $accessToken->getId());
        })->first();

        return $this->createSessionEntity($eloquent);
    }

    /**
     * {@inheritdoc}
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getScopes(SessionEntity $session)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $session = new SessionEloquent;
        $session->setAttribute('client_id', $clientId);
        $session->save();

        return $session->id;
    }

    /**
     * {@inheritdoc}
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function delete(SessionEntity $entity)
    {
        SessionEloquent::delete($entity->getId());
    }

     /**
     * Create new session entity
     * 
     * @param  \Illuminate\Database\Eloquent\Model     $eloquent
     * @return \League\OAuth2\Server\Entity\SessionEntity
     */
    protected function createSessionEntity(Eloquent $eloquent)
    {
        if ( ! is_null($eloquent)) {
            $session = new SessionEntity($this->server);
            $session->setId($eloquent->id)
                ->setOwner(self::OWNERTYPE, $eloquent->client->id);

            return $session;
        }

        return;
    }
}