<?php namespace Elepunk\Authorizer;

use Illuminate\Support\Manager;
use League\Authorizer\Server\Grant\PasswordGrant;
use League\Authorizer\Server\Grant\AuthCodeGrant;
use Elepunk\Authorizer\Model\Client as ClientEloquent;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GrantManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']->get('oauth2.grant', 'authorization');
    }

    /**
     * Create Authorizer authorization code grant type
     * 
     * @return \League\Authorizer\Server\Grant\AuthCodeGrant
     */
    protected function createAuthorizationDriver()
    {
        $grant = new AuthCodeGrant;

        return $grant;
    }

    /**
     * Create Authorizer password grant type
     * 
     * @return \League\Authorizer\Server\Grant\PasswordGrant
     */
    protected function createPasswordDriver()
    {
        $grant = new PasswordGrant;
        $grant->setVerifyCredentialsCallback(function( $clientId, $clientSecret) {
            try {
                $client = ClientEloquent::where('client_id', $clientId)
                    ->where('client_secret', $clientSecret)
                    ->firstOrFail();

                return $client;
            } catch (ModelNotFoundException $e) {
                return false;
            }
        });

        return $grant;
    }
}