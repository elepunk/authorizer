<?php namespace Elepunk\Authorizer\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Scope extends Eloquent
{
    protected $table = 'oauth2_scopes';

    public function clients()
    {
        return $this->belongsToMany('Elepunk\Authorizer\Model\Client', 'client_scope');
    }
}
