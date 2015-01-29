<?php namespace Elepunk\Authorizer;

use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;

class AuthorizerServiceProvider extends ServiceProvider
{
    /**
     * [boot description]
     * @return [type] [description]
     */
    public function boot()
    {

    }
    
    /**
     * [register description]
     * @return [type] [description]
     */
    public function register()
    {
        $this->registerAuthorizationServer();
    }

    protected function registerAuthorizationServer()
    {
        $this->app->singleton('elepunk.authorizer', function () {
            $server = new AuthorizationServer;
            $server->setRequest($this->app['request']);
            $server->setClientStorage(new Storage\Client);

            return $server;
        });
    }
}