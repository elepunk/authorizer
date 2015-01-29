<?php namespace Elepunk\OAuth2\Storage;

use Illuminate\Database\Eloquent\Builder;
use League\OAuth2\Server\Entity\SessionEntity;
use Elepunk\Authorizer\Entity\Client as ClientEntity;
use Illuminate\Database\Eloquent\Model as Eloquent;
use League\OAuth2\Server\Storage\ClientInterface;
use Elepunk\Authorizer\Model\Client as ClientEloquent;
use League\OAuth2\Server\Storage\AbstractStorage;

class Client extends AbstractStorage implements ClientInterface
{
     /**
     * {@inheritdoc}
     */
    public function get($clientKey, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        $eloquent = ClientEloquent::where('client_key', $clientKey)
            ->where('client_secret', $clientSecret)
            ->first();

        return $this->createClientEntity($eloquent);
    }

    /**
     * {@inheritdoc}
     */
    public function getBySession(SessionEntity $session)
    {
        $eloquent = ClientEloquent::whereHas('session', function (Builder $q) use ($session) {
            $q->where('id', $session->getId());
        })->first();

       return $this->createClientEntity($eloquent);
    }

    /**
     * Create new client entity
     * 
     * @param  \Illuminate\Database\Eloquent\Model     $eloquent
     * @return \League\OAuth2\Server\Entity\ClientEntity
     */
    protected function createClientEntity(Eloquent $eloquent)
    {
        if ( ! is_null($eloquent)) {
            $client = new ClientEntity($this->server);
            $client = $client->hydrate([
                'id' => $eloquent->id,
                'name' => $eloquent->name,
                'key' => $eloquent->client_key,
                'secret' => $eloquent->client_secret,
                'redirectUri' => $eloquent->redirect_uri
            ]);

            return $client;
        }

        return;
    }
}
