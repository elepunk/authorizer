<?php namespace Elepunk\Authorizer\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Client extends Eloquent
{
    protected $table = 'oauth2_clients';

    /**
     * [scopes description]
     * @return [type] [description]
     */
    public function scopes()
    {
        return $this->belongsToMany('Elepunk\Authorizer\Model\Scope', 'client_scope');
    }

    /**
     * Assign scopes to Authorizer client
     * 
     * @param  int|array $scopes
     * @return void
     */
    public function attachScopes($scopes)
    {
        $this->scopes->sync((array) $scopes, false);
    }

    /**
     * Un-assign scopes from Authorizer client
     * 
     * @param  int|array $scopes
     * @return void
     */
    public function detachScopes($scopes)
    {
        $this->scopes()->detach((array) $scopes);
    }
}
